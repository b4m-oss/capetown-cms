#!/bin/bash

# スクリプトのディレクトリを取得
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"

# Laravelのバージョンを指定
LARAVEL_VERSION="11.2.1"
LARAVEL_DIR="$SCRIPT_DIR/core/laravel/laravel-$LARAVEL_VERSION"

# Composerの存在確認
if ! command -v composer &> /dev/null; then
    echo "Error: Composer is not installed. Please install Composer first."
    exit 1
fi

# Laravelを指定したディレクトリにインストール
if [ ! -d "$LARAVEL_DIR" ]; then
    echo "Creating Laravel project version $LARAVEL_VERSION in $LARAVEL_DIR..."

    # ローカルのComposerを使用してLaravelをインストール
    if ! composer create-project --prefer-dist laravel/laravel "$LARAVEL_DIR" "$LARAVEL_VERSION"; then
        echo "Error: Failed to create Laravel project."
        exit 1
    fi

    echo "Laravel installation complete."
else
    echo "Laravel version $LARAVEL_VERSION is already installed in $LARAVEL_DIR."
fi

# Laravelディレクトリに対してchmodを適用
echo "Setting permissions for Laravel directory..."

if ! chmod -R 755 "$LARAVEL_DIR"; then
    echo "Error: Failed to set permissions for $LARAVEL_DIR."
    exit 1
fi

# 作業ディレクトリを確認
echo "Checking the working directory..."

# ディレクトリの存在確認を行う
if ! ls -la "$LARAVEL_DIR"; then
    echo "Error: Failed to list directory contents."
    exit 1
fi

# 依存関係をインストール
echo "Installing dependencies with Composer..."

if ! (cd "$LARAVEL_DIR" && composer install); then
    echo "Error: Composer install failed."
    exit 1
fi

# アプリケーションキーの生成
echo "Generating application key..."

if ! (cd "$LARAVEL_DIR" && php artisan key:generate); then
    echo "Error: Failed to generate application key."
    exit 1
fi

echo "Application key generated successfully."
