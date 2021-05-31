# Slim 4 Template Project

Skeleton yang disediakan Slim 4 buat saya cukup membingungkan, dan tidak menyenangkan. Versi template ini adalah yang paling mudah untuk saya gunakan dan menyenangkan untuk lebih ditingkatkan lagi.

Saya menyediakan ini untuk publik semata-mata untuk saya gunakan sendiri di projek-projek mendatang. Kalau-kalau ada yang pakai, itu adalah bonus.

## Kenapa Slim?

Saya pengguna Slim sejak versi awal. Jatuh cinta pada pandangan pertama. Terlebih saya tidak terlalu menyukai Laravel, CI, dan Yii karena saya hanya butuh membuat Rest API saja. Menggunakan framework yang saya sebut sebelumnya terlalu besar. 

## Pertama kali

Ambil repositori github ini dengan mengetikkan perintah di bawah ini:
```
$ git clone https://github.com/didats/Slim4-Template tujuan-direktori
```

Setelah selesai, ubah nama berkas `.settings.default` menjadi `.settings`. Jangan lupa isi variabelnya dengan benar. 

```
$ mv .settings.default .settings
```

Dan untuk terakhir kalinya, pasang semua pustaka composer dengan mengetikkan:

```
$ composer install
```

## Konfigurasi Nginx

Mohon jangan tanyakan Apache, saya tidak tau.

```
server {
    index           index.php index.html;
    listen          80;
    server_name     _your_domain_;
    root            /to-your-directory/public; #public is required

    location / {
            try_files $uri /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```

## Bagaimana memulai projek

Untuk menggunakan template ini, buka berkas di `app/routes.php` dan ubah sesuai dengan yang Anda inginkan. Untuk tahu lebih lanjut bagaimana router Slim 4 bekerja, silahkan lihat ini: [https://www.slimframework.com/docs/v4/objects/routing.html](https://www.slimframework.com/docs/v4/objects/routing.html)

Untuk lebih jelas memisahkan kode, untuk setiap topik, buatlah sebuah direktori di bawah `src`, dan buat class baru di dalamnya. Sebagai referensi, silahkan lihat berkas `src/YourApp/MyApp.php`.

## Model Generator

Model adalah perwakilan dari sebuah tabel did atabase. Daripada menulisnya sendiri, lebih baik gunakan generator yang sudah disediakan.

```
$ php generator.php model YourDBTableName
```

