# Capetown CMS

**Capetown CMS**は、次世代のウェブ開発のニーズを取り入れるために設計された、現代的でモジュラーなCMSです。柔軟性と拡張性を念頭に置いて構築されており、開発者がコア機能を直接変更することなくカスタマイズできる強力なオーバーライドシステムを提供します。Capetownは、WordPressデータとの互換性を確保するために開発されており、プラットフォーム間のシームレスな移行と相互作用を可能にします。

[公式ドキュメントで詳細を見る](./docs/index.md)

## はじめに

これらの手順に従って、開発およびテスト目的でプロジェクトをローカルマシンにコピーして実行することができます。ライブシステムにプロジェクトをデプロイする方法については、デプロイメントのノートを参照してください。

### 必要条件

ソフトウェアをインストールするために必要なものとそのインストール方法

- Docker

## デプロイメント

```shell
git clone https://github.com/kohki-shikata/capetown-cms.git
docker compose up -d
```

## テストの実行

検討中。

### エンドツーエンドテストへの分解

検討中。

E2EテストはLaravel Duskで提供されます。

### コーディングスタイルテスト

検討中。

## 使用技術

* [Laravel](https://laravel.com/)
* [Composer](https://getcomposer.org/) - 依存関係管理

## コントリビューション

コードオブコンドクトやプルリクエストの提出プロセスについては、[CONTRIBUTING.md](./docs/CONTRIBUTING.md)をお読みください。

## バージョニング

バージョニングには[SemVer](http://semver.org/)を使用しています。利用可能なバージョンについては、このリポジトリの[タグ](https://github.com/kohki-shikata/captown-cms/tags)を参照してください。

## コア開発者

* **[Kohki SHIKATA](https://github.com/kohki-shikata)** 

## ライセンス

このプロジェクトはMITライセンスの下でライセンスされています。詳細は[LICENSE](./LICENSE)ファイルを参照してください。

## 謝辞

* [WordPress](https://wordpress.org/)
* [Concrete CMS](https://www.concretecms.org/)
* [Laravel](https://laravel.com/)
* [Ruby on Rails](https://rubyonrails.org/)