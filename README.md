# COACHTECH 確認テスト：お問い合わせフォーム

## 環境構築

### リポジトリのクローン
```bash
git clone https://github.com/mina-lu7/contact-form-test.git
cd contact-form-test
```

### Dockerビルド・起動
```bash
docker compose up -d --build
```

### Laravel環境構築
```bash
docker compose exec php composer install
cp src/.env.example src/.env
# 必要に応じて.envファイルの環境変数を変更
docker compose exec php php artisan key:generate
docker compose exec php php artisan migrate --seed
```

## 使用技術（実行環境）
- PHP：8.1.34
- Laravel：8.83.8
- データベース：MariaDB 11.8.3
- Webサーバー：Docker（nginx）
- 認証機能：Laravel Fortify

## ER図

![ER図](docs/contact-form-test.drawio.png)

## URL（開発環境）
- お問い合わせフォーム：http://localhost:8000
- 管理画面：http://localhost:8000/admin
- ユーザー登録：http://localhost:8000/register
- ログイン：http://localhost:8000/login
- phpMyAdmin：http://localhost:8080

## 要件シートとの相違点について
要件シート内に記載されている内容において一部相違する点があったため、コーチに確認の上、以下の通り対応しています。

### ① カラム名のタイポ（categry_id）
「category_id」が正しい表記と思われますが、テーブル仕様書の表記である「categry_id」にて実装しています。

### ② 管理画面一覧表示項目の相違
要件シート「機能要件」では一覧表示項目が「お問い合わせ内容」となっていましたが、
「デザインUI」では「お問い合わせの種類」と記載されていました。
本アプリケーションでは、機能要件に合わせて「お問い合わせ内容」を表示させています。

### ③ 性別入力UIの相違
要件シート「機能要件」では「チェックボックス」と記載されていましたが、
「デザインUI」では「ラジオボタン」となっていました。
本アプリケーションでは、デザインUIに合わせて「ラジオボタン」を採用しています。