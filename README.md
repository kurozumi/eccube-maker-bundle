# EccubeMakerBundle

SymfonyのMakerBundleを拡張してEC-CUBE4に対応したEccubeMakerBundleプラグインです。  
インストールするとEC-CUBE4用のmakerコマンドが追加されます。  
makerコマンドで生成したファイルはapp/Customizeディレクトリに出力されます。

## インストール

```shell
cd app/Plugin
git clone https://github.com/kurozumi/eccube-maker-bundle EccubeMakerBundle
```

## コマンド

このプラグインをインストールして追加されるコマンドは以下のとおりです。

```
bin/console eccube:make:entity
bin/console eccube:make:test
```

コマンドを実行するとウィザードが開始され、質問に答えていくとCustomizeディレクトに雛形ファイルが自動生成されます。

## SymfonyのMakerBundleについて

SymfonyのMakerBundleのmakerコマンドで生成したファイルもCustomizeディレクトリに出力されます。

```
bin/console make:subscriber
```

## 出力場所を指定する方法

開発しているプラグインでeccube-maker-bundleのコマンドを使用したい場合はservices_dev.ymlのroot_namespaceを変更して下さい。

services.ymlの場所

```
EccubeMakerBundle/Resource/config/services_dev.yml
```

プラグインコードがSampleの場合

```
maker:
    root_namespace: 'Plugin\Sample'
```
