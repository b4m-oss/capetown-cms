# ベースイメージの定義
FROM php:8.2-fpm

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# LaravelとPostgreSQLサポート用のパッケージをインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql

# 作業ディレクトリを定義
WORKDIR /var/www/html

# # composer.jsonをコピーしてインストール
# COPY ./dev/composer.json ./
# RUN composer install --prefer-dist --no-scripts --no-autoloader

# # ソースコードをコピー
# COPY ./dev .

# # 自動ロードを生成
# RUN composer dump-autoload

# # 環境設定ファイルを設定
# COPY ./dev/.env.example ./.env

# # 正しいディレクトリにいるか確認
# RUN ls -la /var/www/html
# RUN pwd

# # Laravel用の作業ディレクトリを設定
# WORKDIR /var/www/html/core/laravel

# # Laravelプロジェクトを作成（存在しない場合のみ）
# RUN if [ ! -d laravel-11.2.1 ]; then \
#         mkdir laravel-11.2.1 && \
#         cd laravel-11.2.1 && \
#         composer create-project --prefer-dist laravel/laravel .; \
#     fi

# # 新しいLaravelプロジェクトの作業ディレクトリに変更
# WORKDIR /var/www/html/core/laravel/laravel-11.2.1

# # アプリケーションキーを生成
# RUN php artisan key:generate

# # マイグレーションを実行
# RUN php artisan migrate --force

# # 最終ディレクトリのファイルをリスト表示（デバッグ用）
# RUN ls -la

# CMDはデフォルトでPHP-FPMを実行するように設定
CMD ["php-fpm"]
