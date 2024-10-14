#!/bin/bash

# スクリプトのディレクトリを取得
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"

# Laravelのバージョンを指定
LARAVEL_VERSION="11.2.1"
LARAVEL_DIR="$SCRIPT_DIR/core/laravel/laravel-$LARAVEL_VERSION"

# Laravelを指定したディレクトリにダウンロード
if [ ! -d "$LARAVEL_DIR" ]; then
    echo "Downloading Laravel version $LARAVEL_VERSION..."
    mkdir -p "$LARAVEL_DIR"

    # ダウンロード
    if curl -L "https://github.com/laravel/laravel/archive/refs/tags/v$LARAVEL_VERSION.zip" -o "$LARAVEL_DIR/laravel.zip"; then
        echo "Download complete. Extracting files..."

        # 解凍
        if unzip "$LARAVEL_DIR/laravel.zip" -d "$LARAVEL_DIR"; then
            # 解凍後のディレクトリを移動
            mv "$LARAVEL_DIR/laravel-$LARAVEL_VERSION/"* "$LARAVEL_DIR/"
            rm -rf "$LARAVEL_DIR/laravel-$LARAVEL_VERSION"
            rm "$LARAVEL_DIR/laravel.zip"
            echo "Laravel installation complete."
        else
            echo "Error: Failed to extract Laravel files."
            exit 1
        fi
    else
        echo "Error: Failed to download Laravel."
        exit 1
    fi
else
    echo "Laravel version $LARAVEL_VERSION is already installed in $LARAVEL_DIR."
fi

# Docker Composeを使用してComposerで依存関係をインストール
echo "Installing dependencies with Composer..."

# ここでdocker composeのサービス名を確認
if ! docker compose run --rm composer install; then
    echo "Error: Composer install failed."
    exit 1
fi

echo "Dependencies installed successfully."


