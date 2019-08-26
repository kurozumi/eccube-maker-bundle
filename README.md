# EccubeMakerBundle

SymfonyのMakerBundleを拡張してEC-CUBE4に対応したEccubeMakerBundleプラグインです。  
インストールするとEC-CUBE4用のmakerコマンドが追加されます。  
makerコマンドで生成したファイルはapp/Customizeディレクトリに出力されます。

## インストール

app/Plugin内にcloneすれば多分動くはずです。  
動かなかったら以下のコマンドを実行して下さい。

```
bin/console eccube:plugin:install --code EccubeMakerBundle
bin/console eccube:plugin:enable --code EccubeMakerBundle
```

## コマンド

このプラグインをインストールして追加されるコマンドは以下のとおりです。

```
bin/console eccube:make:controller  
bin/console eccube:make:entity
bin/console eccube:make:trait
bin/console eccube:make:form-extension
```

コマンドを実行するとウィザードが開始され、質問に答えていくとCustomizeディレクトに雛形のファイルが生成されます。

Entityファイル作るときはゲッターセッターを書かなくて良いので便利です。

## Eccube4のEntityを拡張出来るTraitの自動生成

```
bin/console eccube:make:trait

or

bin/console eccube:make:trait Eccube\Entity\Product
```

上記コマンドを実行するとEntityファイルを生成するときと同様の手順でEccube4のEntity拡張用のTraitを自動生成できます。

## Eccube4のフォームを拡張できるFormExtensionの自動生成

```
bin/console eccube:make:form-extension
```

上記のコマンドと実行するとEccube4のフォームを拡張できるFormExtensionを自動生成できます。
ウィザードに従って拡張したいFormTypeを入力または選択して下さい。

## SymfonyのMakerBundleについて

SymfonyのMakerBundleのmakerコマンドで生成したファイルもCustomizeディレクトリに出力されます。


個人的にはSubscriberを多用するので、以下のコマンドも便利かと思います。

```
bin/console make:subscriber
```

## 出力場所を指定する方法

開発しているプラグインでmakerコマンドを使用したい場合はservices.ymlのroot_namespaceを変更して下さい。

services.ymlの場所

```
EccubeMakerBundle/Resource/config/services.yml
```

プラグインコードがSampleの場合

```
maker:
    root_namespace: 'Plugin\Sample'
```

## 本番環境でのエラー

本番環境ではmakerバンドルが適用されないのでエラーが発生します。  
本番環境へ切り替える場合は、プラグインに同梱されているservices.ymlに記述されている内容をコメントアウトして下さい。