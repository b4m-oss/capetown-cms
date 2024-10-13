# Capetown CMS

**Capetown CMS**は、現代のウェブ制作のニーズを取り入れるために設計された、現代的でモジュラー設計のCMSです。

柔軟性と拡張性を念頭に置いて構築されており、開発者がコア機能を直接変更することなくカスタマイズできる強力なオーバーライドシステムを提供します。

Capetown CMSは、WordPressのコンテンツデータとの互換性確保を前提として開発されており、プラットフォーム間のシームレスな移行を可能にします。

[公式ドキュメントで詳細を見る](./docs/ja/index.md)

## はじめに

これらの手順に従って、開発およびテスト目的でプロジェクトをローカルマシンにコピーして実行することができます。

### 必要条件

ソフトウェアをインストールするために必要なもの

- Docker

## 開発のスタート

あなたのローカルマシンで、以下のコマンドを実行して下さい。

```shell
git clone https://github.com/kohki-shikata/capetown-cms.git
docker compose up -d
```

## テストの実行

検討中。

### エンドツーエンドテストへの分解

検討中。

E2EテストはLaravel Duskで提供される予定。

### コーディングスタイルテスト

検討中。

## 使用技術

* [Laravel](https://laravel.com/)
* [Composer](https://getcomposer.org/) - 依存関係管理

## コントリビューション

コードオブコンドクトやプルリクエストの提出プロセスについては、[CONTRIBUTING.md](./docs/ja/CONTRIBUTING.md)をお読みください。

## バージョニング

バージョニングには[SemVer](http://semver.org/)を使用しています。

利用可能なバージョンについては、このリポジトリの[タグ](https://github.com/kohki-shikata/captown-cms/tags)を参照してください。

## コア開発者

* **[Kohki SHIKATA](https://github.com/kohki-shikata)** 

## ライセンス

このプロジェクトはMITライセンスの下でライセンスされています。詳細は[LICENSE](./LICENSE)ファイルを参照してください。

## 謝辞

* [WordPress](https://wordpress.org/)
* [Concrete CMS](https://www.concretecms.org/)
* [Laravel](https://laravel.com/)
* [Ruby on Rails](https://rubyonrails.org/)
