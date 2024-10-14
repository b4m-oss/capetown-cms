<?php

// リクエストURIを取得
$requestUri = $_SERVER['REQUEST_URI'];

// オーバーライド用の関数
function loadFile($requestPath) {
    // 1. appディレクトリを確認
    $appPath = __DIR__ . '/app' . $requestPath;
    if (file_exists($appPath)) {
        return include $appPath;
    }

    // 2. Capetownディレクトリを確認
    $capetownPath = __DIR__ . '/core/capetown/capetown-0.1.0' . $requestPath;
    if (file_exists($capetownPath)) {
        return include $capetownPath;
    }

    // 3. Laravelコアを確認
    $laravelPath = __DIR__ . '/core/laravel/laravel-11.9' . $requestPath;
    if (file_exists($laravelPath)) {
        return include $laravelPath; // オーバーライドしないが、存在する場合は使用
    }

    throw new Exception('File not found');
}

// ファイルを読み込む
try {
    loadFile($requestUri);
} catch (Exception $e) {
    // エラーハンドリング
    http_response_code(404);
    echo "404 Not Found: " . $e->getMessage();
}
