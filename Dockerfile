# 使用 PHP 8.3 + Apache
FROM php:8.3-apache

# 安裝工具與依賴
RUN apt-get update && apt-get install -y \
    gnupg2 \
    curl \
    apt-transport-https \
    lsb-release \
    ca-certificates \
    unixodbc-dev \
    gcc \
    g++ \
    make \
    autoconf \
    libc-dev \
    pkg-config \
    libxml2-dev \
    software-properties-common \
    unzip

# ✅ 安裝 Microsoft ODBC Driver 18（修正版）
RUN curl -sSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /etc/apt/trusted.gpg.d/microsoft.gpg && \
    echo "deb [arch=amd64 signed-by=/etc/apt/trusted.gpg.d/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18

# 安裝 PHP SQLSRV 擴充
RUN pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv

# 啟用 Apache rewrite 模組
RUN a2enmod rewrite

# 複製網站程式碼
COPY . /var/www/html/
