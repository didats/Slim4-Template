# Slim 4 Template Project

```
Versi bahasa Indonesia, bisa dilihat di berkas PETUNJUK.md
```

The default skeleton from official page of Slim4 is quite difficult for me to understand, and not fun. This version is based on my understanding, and in my opinion quite easy. 

I am putting it to the public repository so I could use it in the future. I hope it could be also useful for the others.

## The very first

You will need to clone this repository, by typing:
```
$ git clone https://github.com/didats/Slim4-Template your-directory-name
```

Once you are done, rename the setting file and edit them. The setting file able to hold as many variables as you want.

```
$ mv .settings.default .settings
```

Then the last one, 

```
$ composer install
```

## Nginx configuration

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

## How to start working

This template is intended to create REST API project. To create an endpoint, open the file at `app/routes.php` and edit them based on the Slim 4 documentation here: [https://www.slimframework.com/docs/v4/objects/routing.html](https://www.slimframework.com/docs/v4/objects/routing.html)

You may create another directory under directory `src`, and create a controller inside them. Look at the directory `src/YourApp` as reference.

## Generate Model

A model is a representative of a table. Instead of creating manually, you are able to generate that automatically. Type this on the root directory:

```
$ php generator.php model YourDBTableName
```

