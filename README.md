# EccubeMakerBundle

SymfonyのMakerBundleを拡張してEC-CUBE4に対応したEccubeMakerBundleプラグインです。  
インストールするとEC-CUBE4用のmakerコマンドが追加されます。  
makerコマンドで生成したファイルはapp/Customizeディレクトリに出力されます。

## インストール

app/Plugin内にcloneすれば多分動くはずです。  
動かなかったら以下のコマンドを実行して下さい。

```
bin/console eccube:plugin:install --code EccubeMakerBundle
```

## コマンド

このプラグインをインストールして追加されるコマンドは以下のとおりです。

```
eccube:make:controller  
eccube:make:entity
```

コマンドを実行するとウィザードが開始され、質問に答えていくとCustomizeディレクトに雛形のファイルが生成されます。

entityファイル作るときはゲッターセッターか書かなくて良いので便利です。

## SymfonyのMakerBundleについて

SymfonyのMakerBundleのmakeコマンドで生成したファイルもCustomizeディレクトリに出力されます。
