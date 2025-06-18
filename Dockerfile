# 使用 PHP 8.3 的 Apache 映像
FROM php:8.3-apache

# 安裝必要依賴與工具
RUN apt-get update && apt-get install -y \
    gnupg2 \
    apt-transport-https \
    unzip \
    curl \
    libssl-dev \
    unixodbc-dev \
    gcc \
    g++ \
    make \
    autoconf \
    libc-dev \
    pkg-config \
    libxml2-dev \
    git \
    && rm -rf /var/lib/apt/lists/*

# 安裝 SQLSRV 與 PDO_SQLSRV 擴充（官方 Microsoft 驅動）
RUN pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv

# 複製你的 PHP 專案程式碼進 Apache 路徑
COPY . /var/www/html/

# 啟用 Apache Rewrite 模組（如果你有使用 .htaccess 或 Laravel 等）
RUN a2enmod rewrite
