# individual-relationship-diagram
individual-relationship-diagram:  個人間の関係図 

    Copyright (c) 2015 Shinobu Komakine


**Notice**

デモが動作するためだけに記述しています。
コードの記述は参考にしないでください。
ここで書かれているコードより、より良い記述方法があるはずです。

**開発時の動作環境**

    httpd   : Apache/2.4.10
    MySQL   : 5.1.52 (DB Name: ivd | user : root | password : '')
    PHP     : 5.5.24

## 1. fuelphpのセットアップ

この手順は Linux または Mac 環境の手順です。

### 1-1. composerのセットアップ

    $ cd vendor
    $ curl -sS https://getcomposer.org/installer | php --

### 1-2. fuelphp 1.7のインストール

    $ php composer.phar update

## 2. mysql データベースのセットップ

### 2-1. データベースを作成

    $ mysql -uroot
    > CREATE DATABASE `ivd` DEFAULT CHARACTER SET utf8;

### 2-3. テーブル定義をimport

    $ mysql -uroot ivd < ivd.sql

## 3. apache configファイルの設定

    DocumentRootを /{your path}/public に指定

    AllowOverride ディレクティブ を yes に設定











