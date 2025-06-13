FROM php:8.3-apache

#　Viteのポートを公開
EXPOSE 5173

# タイムゾーンの更新
RUN ln -sf  /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# ドキュメントのルートを変更
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Composerを使用
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 各種モジュール有効化
# 3行目のやつ入れんとビルドすらできん
RUN apt-get update \
    && apt-get install -y \
    libicu-dev pkgconf libcurl4-openssl-dev \
    git libfreetype6-dev libjpeg-dev libonig-dev libpng-dev libpq-dev libzip-dev msmtp msmtp-mta unzip vim wget zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install bcmath curl gd intl mysqli pdo_mysql

# php.iniをコピー
COPY ./php.ini /usr/local/etc/php/php.ini

# nodeをインストール
ENV NODE_VERSION=22.14.0
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version

# modRewrite有効化
RUN a2enmod rewrite

# サーバー証明書をコピー
COPY ./server.crt /etc/ssl/certs/
COPY ./server.key /etc/ssl/private/

# /etc/apache2/sites-available/default-ssl.confの設定を置換
RUN sed -i 's!/etc/ssl/certs/ssl-cert-snakeoil.pem!/etc/ssl/certs/server.crt!g' /etc/apache2/sites-available/default-ssl.conf \
    && sed -i 's!/etc/ssl/private/ssl-cert-snakeoil.key!/etc/ssl/private/server.key!g' /etc/apache2/sites-available/default-ssl.conf

# sslモジュール有効化
RUN a2enmod ssl \
    && a2ensite default-ssl

# コンテナログイン時のパス指定
WORKDIR /var/www

# php・nodeの依存関係のインストール、Apacheのフォアグラウンド起動
ENTRYPOINT ["bash", "-c", "composer install; npm install; exec /usr/sbin/apache2ctl -D FOREGROUND"]
