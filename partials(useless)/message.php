<?php if (isset($_SESSION['success_message'])): ?>
    <p style="color:green;"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
<?php endif; ?>
