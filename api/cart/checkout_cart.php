<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => '尚未登入']);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../vendor/autoload.php');

$userID = $_SESSION['user_id'];

try {
    // 1. 取出購物車所有項目
    $stmt = $conn->prepare("
        SELECT c.productID, c.quantity, p.price
        FROM cart c
        JOIN product p ON c.productID = p.productID
        WHERE c.userID = ?
    ");
    $stmt->execute([$userID]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cartItems) === 0) {
        echo json_encode(['success' => false, 'message' => '購物車為空']);
        exit;
    }

    // 2. 計算總金額
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // 3. 寫入 order 表
    $stmt = $conn->prepare("INSERT INTO [order] (userID, orderDate, totalAmount, status) VALUES (?, GETDATE(), ?, '處理中')");
    $stmt->execute([$userID, $total]);
    $orderID = $conn->lastInsertId();


    // 取得使用者 email
    $userStmt = $conn->prepare("SELECT email FROM [user] WHERE userID = ?");
    $userStmt->execute([$userID]);
    $userEmail = $userStmt->fetchColumn();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'xlin9857@gmail.com';
        $mail->Password = 'idlm ysol igqx hnmv'; // 注意：不是 Gmail 密碼，是 App Password！
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('xlin9857@gmail.com', '皮蝦雜貨店');
        $mail->addAddress($userEmail);

        $mail->isHTML(true);
        $mail->Subject = '訂單通知 - 感謝您的訂購！';
        $mail->Body    = "
            <h3>✅ 您的訂單已成功建立</h3>
            <p>訂單編號：{$orderID}</p>
            <p>總金額：NT$ {$total}</p>
            <p>我們會盡快為您處理出貨，感謝光臨！</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("寄信失敗: " . $mail->ErrorInfo);
        // 不中斷流程，只顯示錯誤日誌
    }


    // 4. 寫入 order_item
    $insertItem = $conn->prepare("INSERT INTO [order_item] (orderID, productID, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $insertItem->execute([$orderID, $item['productID'], $item['quantity'], $item['price']]);
    }

    // 5. 清空 cart
    $stmt = $conn->prepare("DELETE FROM [cart] WHERE userID = ?");
    $stmt->execute([$userID]);

    echo json_encode([
        'success' => true,
        'message' => '✅ 結帳成功！',
        'orderID' => $orderID,
        'totalAmount' => $total
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => '結帳失敗',
        'error' => $e->getMessage()
    ]);
}
