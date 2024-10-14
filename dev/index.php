<?php
// dev/index.php

// エラーレポートの設定
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ユーザー領域のインクルード
$userBootstrap = __DIR__ . '/user/bootstrap/app.php';
$capetownBootstrap = __DIR__ . '/core/capetown/capetowncms-0.1.0/bootstrap/app.php';
$laravelBootstrap = __DIR__ . '/core/laravel/laravel-11.2.1/bootstrap/app.php';
$laravelVendor = __DIR__ . '/core/laravel/laravel-11.2.1/vendor/autoload.php'; // Composerのオートローダー

// ユーザー領域が存在する場合に読み込む
if (file_exists($userBootstrap)) {
    require_once $userBootstrap; // ユーザー固有の処理や設定を読み込む
}

// CapetownCMS領域が存在する場合に読み込む
if (file_exists($capetownBootstrap)) {
    require_once $capetownBootstrap; // CapetownCMS固有の処理や設定を読み込む
}

// Composerのオートローダーを読み込む
if (file_exists($laravelVendor)) {
    require_once $laravelVendor; // Laravelの依存関係をオートロード
} else {
    die("Error: Composer autoload file not found.");
}

// リクエストをLaravelに渡すための準備
try {
    // Laravelのアプリケーションを起動
    $app = require_once $laravelBootstrap; // アプリケーションインスタンスを取得
} catch (Exception $e) {
    error_log($e->getMessage());
    die("An error occurred while starting the application.");
}

// リクエストの処理
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// レスポンスを返す
$response->send();
$kernel->terminate($request, $response);
