# モジュール作成
php artisan module:make Blog

# モデル作成
php artisan module:make-model モデルクラス名 モジュール名

# モデル作成(マイグレーションファイルあり)
php artisan module:make-model -m モデルクラス名 モジュール名

# モジュールの有効化
php artisan module:tenant-enable --tenant={{tenant-id}}