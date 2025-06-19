# 使用 PHP 8.3 + Apache 官方映像
FROM php:8.3-apache

# 安裝基本依賴
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

# 加入 Microsoft ODBC Driver 的來源（Debian 12）
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - && \
    curl https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list

# 安裝 Microsoft ODBC Driver 18
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18

# 安裝 sqlsrv 與 pdo_sqlsrv PHP 擴充
RUN pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv

# 啟用 Apache rewrite 模組
RUN a2enmod rewrite

# 複製 PHP 專案到 Apache 根目錄
COPY . /var/www/html/
