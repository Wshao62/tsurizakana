# laradockを用いた環境構築
## URL構成
||develop→dockerのIP等|
|---|---|
|WEB| http://develop/ or https://develop/|
|Maildev| http://develop:1080/|
|PHPMyadmin| http://develop:8080/index.php|
|DB| データベース→default<br>default/secret|

## ファイル構成
```
/Works
├── laradock -- (dockerファイル陣)
└── tsurizakana -- (作業フォルダ laravelもこちらに配置)
```

## 事前準備
Dockerが使えるようにしておく必要がある。
Vagrantを用いて実行できるようにしても良いし、CentOS7などを自力で入れても良い、MacやWindowsに直接Dockerを入れても良い。
今回はVirtualboxにCentOS7を自力で立てた環境となっています。
（Vagrantでboxを建てる場合は[こちら](https://qiita.com/suzuesa/items/00afb144a03cb3a0d262)を参考にしたり、[こちら](https://app.vagrantup.com/williamyeh/boxes/centos7-docker)を利用しても良いかもしれない。

## 構築手順
ドキュメントはこちら → [laradock.io](http://laradock.io/)

作業ディレクトリを作成 + laradockをクローンする

```bash
#(各々の作業ディレクトリへ)
cd /Works
mkdir tsurizakana

git clone https://github.com/Laradock/laradock.git
cd laradock
```

Laradockの環境ファイルを作成

```bash
cp env-example .env
```

.env

```diff
- APP_CODE_PATH_HOST=../
+ APP_CODE_PATH_HOST=../tsurizakana

- WORKSPACE_INSTALL_IMAGEMAGICK=false
+ WORKSPACE_INSTALL_IMAGEMAGICK=true

- PHP_FPM_INSTALL_EXIF=false
+ PHP_FPM_INSTALL_EXIF=true

- APACHE_DOCUMENT_ROOT=/var/www/
+ APACHE_DOCUMENT_ROOT=/var/www/public

- MYSQL_VERSION=latest
+ MYSQL_VERSION=5.7
```

MySQLの設定は以下のように追記  
mysql/my.cnf
```diff
[mysqld]

+ ngram_token_size=1
+ innodb_ft_enable_stopword = OFF
```

また、テスト用のDBを作成するように以下を追加  
mysql/docker-entrypoint-initdb.d/createdb.sql

```SQL
CREATE DATABASE IF NOT EXISTS `tsurizakana_testing` COLLATE 'utf8_general_ci';

GRANT ALL ON `tsurizakana_testing`.* TO 'default’@‘%’;
FLUSH PRIVILEGES;
```

### Dockerfileに一部バグがあるので以下のように対応

10/03現在、mysqlのバージョンを指定できないバグ対応  
mysql/Dockerfile

```diff
- ARG MYSQL_VERSION=latest
+ ARG MYSQL_VERSION
```

11/12現在、workspaceにimagemagickをインストールしようとするとエラーが出て、dockerがbuildできない対応  
workspace/Dockerfile  line near:777

```diff
RUN if [ ${INSTALL_IMAGEMAGICK} = true ]; then \
+    apt-get update && \
     apt-get install -y imagemagick php-imagick \
 ;fi
```

---
Dockerを起動して、laravelをインストールする

```bash
#初回は以下のコマンドがとても長いので注意。1時間くらいかかることも。
docker-compose up -d apache2 mysql phpmyadmin maildev laravel-echo-server workspace

#起動したdockerに接続
docker-compose exec workspace bash
composer create-project --prefer-dist laravel/laravel ./
chmod -R 777 storage/

composer install
```


Laravelの環境ファイルは.env.exampleを.envとしてコピーし以下のように変更する  
.env

```bash
APP_URL=http://develop

DB_HOST=mysql
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret

MAIL_HOST=maildev
MAIL_PORT=25

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

// FACEBOOK APPは自分で登録してください
// https://developers.facebook.com/apps/
FB_CLIENT_ID=
FB_CLIENT_SECRET=
FB_URL=https://develop/login/facebook/callback

// 決済APIのSTRIPE APPも自分で登録してコードを取得してください
// https://dashboard.stripe.com/register
STRIPE_TOKEN=
STRIPE_SECRET_TOKEN=
```
