## About Music Playlist API using Laravel framework

A music streaming service wants users to be able to listen to music, upload new songs, edit songs, and delete them.


## Getting started

Assuming you've already installed on your machine: PHP (>= 7.0.0), [Git](https://git-scm.com/) and [Composer](https://getcomposer.org).

##### Clone repository
``` bash
git clone https://github.com/devEdrick/music-playlist.git
```
``` bash
cd music-playlist
```
##### Install dependencies
``` bash
composer install
```

##### Create .env file and generate the application key
``` bash
cp .env.example .env
```
``` bash
php artisan key:generate
```

## Serve

To serve project [http://localhost:8000](http://localhost:8000), by run the following command:
``` bash
php artisan serve
```

## Documentation

To generate project documentation [http://localhost:8000/api/documentation#/Song](http://localhost:8000/api/documentation#/Song), by run the following command:

``` bash
php artisan config:cache
```
``` bash
php artisan l5-swagger:generate
```

## Testing

To unit test, by run the following command:

``` bash
php artisan config:cache
```
``` bash
./vendor/bin/phpunit tests/Feature/SongTest.php
```
