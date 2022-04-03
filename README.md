## About Music Playlist API using Laravel framework

A music streaming service wants users to be able to listen to music, upload new songs, edit songs, and delete them.


## Install

To clone repository and install packages, by run the following commands:

``` bash
git clone https://github.com/devEdrick/music-playlist.git
```
``` bash
cd music-playlist
```
``` bash
composer install
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
