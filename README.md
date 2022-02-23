<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)


INSTALLATION

### Install with Docker

Build and Start the container

    docker-compose up -d

Enter inside container

    docker exec -it test-task-php sh

Install all requirement libraries

    composer install


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=test-task',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

Run migration

    php yii migrate

in migration default will be added test admin user:
```
    username: admin
    password: admin
```

before run application you should give permissions:

```
    sudo chown $USER:www-data -R web/assets
    sudo chown $USER:www-data -R runtime/
    sudo chown $USER:www-data -R web/uploads/
```

You can then access the application through the following URL:

    http://127.0.0.1:8080

**NOTES:** 
- Minimum required Docker engine version `20.10.12` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches




