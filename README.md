## 如何安裝？

``` bash
mkdir -p ~/apps; cd ~/apps
git clone git@github.com:tomleesm/mini-programs.git
cd mini-programs
# 查看有哪些分支
git branch -a
# 例如切換到分支 blog-laravel
git checkout -b blog-laravel origin/blog-laravel
# 安裝 Laravel 程式庫
composer install
cp .env.example .env
# 產生 APP_KEY
php artisan key:generate
# 新增 MySQL 資料庫
sudo mariadb
# 或者用 MySQL root 帳號登入
mysql -u root -p
```

執行以下 SQL

``` sql
CREATE DATABASE mini_programs CHARACTER SET utf8mb4;
CREATE USER 'mini_programs'@'localhost' IDENTIFIED BY 'mini_programs';
GRANT ALL PRIVILEGES ON mini_programs.* TO 'mini_programs'@'localhost';
FLUSH PRIVILEGES;
exit
```

設定 Laravel 使用 MySQL

``` bash
vim .env
# 修改成以下這樣
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE='mini_programs'
DB_USERNAME='mini_programs'
DB_PASSWORD='mini_programs'
# 資料庫 migration 和 seeding
php artisan migrate --seed
# 安裝前端編譯工具
npm install 或 yarn install
# 編譯前端
npm run build
# 啟動測試伺服器
php artisan serve --host 0.0.0.0
```

瀏覽器開啟 http://192.168.56.10:8000/

設定 nginx

``` bash
sudo vim /etc/nginx/sites-available/mini-programs.conf
```

複製貼上以下設定
```
server {
  listen 7002;
  # Virtual Box host-only IP 設定為 192.168.56.10
  server_name 192.168.56.10;
  index index.php index.html;
  client_max_body_size 50M;
  error_log /home/tom/apps/logs/localhost/error.log;
  access_log /home/tom/apps/logs/localhost/access.log;
  root /home/tom/apps/mini-programs/public;
  location / {
    try_files $uri $uri/ /index.php$is_args$args;
  }
  location ~ \.php {
    try_files $uri = 404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param SCRIPT_NAME $fastcgi_script_name;
    fastcgi_index index.php;
    fastcgi_pass 127.0.0.1:9000;
  }
}
```

執行以下指令讓設定生效

``` bash
sudo ln -s /etc/nginx/sites-available/mini-programs.conf \
           /etc/nginx/sites-enabled/mini-programs.conf
sudo systemctl restart nginx
```

瀏覽器開啟 http://192.168.56.10:7002/
