# 使用 PHP 8.3 + Apache 官方映像
FROM php:8.3-apache

# 安裝必要套件與 Microsoft ODBC Driver 18
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
    gnupg \
    software-properties-common \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && a2enmod rewrite

# 複製你的 PHP 專案進入 Apache 路徑
COPY . /var/www/html/
