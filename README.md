# Aplikasi Kasir untuk Kedai Kopi menggunakan Laravel & React Js

Dalam memulis/membangun aplikasi kasir ini menggunakan 2 bahasa pemrograman yaitu php & javascript. serta di implementasikan pada framework yang berbeda pulak yaitu laravel serta libary reactjs dengan dibundle menggunakan vite js

ada beberapa hal sebelum kamu menggunakan aplikasi ini sebagi berikut:

1. php 8.0.2
2. node js 16.0.x
3. mysql/mariadb

langkah langkah untuk menjalankan aplikasi secara local sebagai berikut:

1. clone project ini
2. pastikan anda sudah terinstall composer
3. masuk ke dalam project cd name-project/
4. lakukan `composer install --ignore-platform-req=php --ignore-platform-req=ext-zip`
5. copy dan buat file `.env` yang diambil dari `.env.example`
6. jalankan command `php artisan key:generate`
7. setelah itu ganti user,password & database difile `.env`
8. dan kemudian jalankan `php artisan migrate --seed`
9. jalankan command `npm install` & `npm run build`
10. setelah untuk mengecek apakah aplikasi itu jalan bisa ketik `php artisan serve`
11. untuk login kedalam aplikasi terdapat 2 role yaitu admin & kasir yang dapat dilihat dalam folder database/seeders/UserSeeders

### Deploy menggunakan Docker

Menggunakan docker dalam deployment laravel ini memang tidak segampang nodejs karena banyak yang harus dipersiapakan secara manual

#### Menyiapkan Docker Images

Buatlah docker images yang berisi aplikasi yang dikemas dalam bentuk lebih kecil beserta struktur os yang akan digunakan dituliskan pada `dockerfile`

```
    FROM php:8.0-fpm

    # Copy composer.lock and composer.json into the working directory
    COPY ../src/ /var/www/laravel-cashier

    # Set working directory
    WORKDIR /var/www/laravel-cashier

    # Install dependencies for the operating system software
    RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl

    # Clear cache
    RUN apt-get clean && rm -rf /var/lib/apt/lists/*

    # Install extensions for php
    RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
    RUN docker-php-ext-configure gd --with-freetype --with-jpeg
    RUN docker-php-ext-install gd

    # Install composer (php package manager)
    RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

    RUN curl -sL https://deb.nodesource.com/setup_18.x| bash -
    RUN apt-get install -y nodejs
    # Copy existing application directory contents to the working directory
    # COPY . /var/www/html

    RUN chown -R www-data:www-data /var/www/laravel-cashier

    # Assign permissions of the working directory to the www-data user
    RUN chown -R www-data:www-data \
        /var/www/laravel-cashier/storage \
        /var/www/laravel-cashier/bootstrap/cache


    # Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
    EXPOSE 9000
    CMD ["php-fpm"]
```

setelah selesai menuliskan dockerfile

maka lakukan build images dengan command

```
    docker build -t laravel-cashier:1.0 -f docker/php/dockerfile
```

### Menyiapkan Config Webserver Nginx

Config Nginx ini bertujuan untu membuat aplikasi yang sudah dibuat dapat bejalan tanpa harus mengetikan `php artisan serve` pada container. siapkan file dengan nama laravel.conf & atau apapun namanya yang penting terakhir ada `.conf`

```
    server {
        listen 80;
        index index.php index.html;
        error_log  /var/log/nginx/error.log;
        access_log /var/log/nginx/access.log;
        root /var/www/laravel-cashier/public;

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass app:9000;
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
        }
        location / {
            try_files $uri $uri/ /index.php?$query_string;
            gzip_static on;
        }
}
```

### Menyiapkan docker compose untuk deploy

Docker compose ini bertujuan untuk memudahakan aplikasi di deploy hanya dengan text atau configuration yang sudah ada, siapkan file dengan nama `docker-compose.yml`

```
    version: "3.5"
    services:
    app:
        container_name: laravel-cashier-app
        image: testcashier:1.0
        restart: always
        tty: true
        ports:
            - "9000:9000"
        volumes:
            - 'laravel-cashier:/var/www/laravel-cashier/'
    web-server:
        container_name: nginx-cashier
        image: nginx:latest
        # restart: always
        restart: unless-stopped
        tty: true
        ports:
            - "80:80"
        volumes:
            - ./docker/nginx/laravel.conf:/etc/nginx/conf.d/default.conf
            - 'laravel-cashier:/var/www/laravel-cashier/'



    volumes:
    laravel-cashier:
        driver: local
```

setelah selesai maka jalankan `docker compose up -d` untuk menjalan script yang sudah dibuat

### Database

saya menggunakan database yang sudah disediakan oleh GCP untuk memudahkan dalam mendeploy aplikasi ini. kalian bisa juga menggunakan database dengan menggunakan docker supayah memudahakan pada saat testing & debugin

### Config yang dibuatkan

1. `docker compose exec app bash ` untuk masuk kedalam container
2. copy dan buat file `.env` yang diambil dari `.env.example`
3. ubah beberapa bagian yang ada difile menjadi seperti ini

   ```
   APP_ENV=production
   APP_DEBUG=false

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1 isi sendiri
   DB_PORT=3306
   DB_DATABASE=laravel isi sendiri
   DB_USERNAME=root isi sendiri
   DB_PASSWORD= isi sendiri
   ```

4. setelah gunakan command `composer update` / `composer install --ignore-platform-req=php --ignore-platform-req=ext-zip`
5. berikan key generate pada aplikasi dengan command `php artisan key:generate`
6. install tampilan dengan command `npm install` & `npm run build`
7. jalankan migrate strukture database & isi databse dengan command `php artisan migrate:fresh --seed`
8. berikan ruang storage dengan menjalan command `php artisan storage:link`
