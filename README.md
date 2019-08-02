# lacrud
This is a laravel project that can help you to speed up coding in production while many controller and api has been complete by very short command line.

# Getting Start
> make sure you have composer on your computer or otherwise please go to https://getcomposer.org/

**LET ROCK**

> - git clone https://github.com/kechankrisna/lacrud.git
> - cd lacrud
> - composer install
> - php artisan serve
> - Your server will start at http://127.0.0.1:8000

*Usage and Feature*

**New Command Line make:crud**

> php artisan make:crud ModelName {--web}(Optional) {--api}(Optional)
```
Example: php artisan make:crud Student --web --api
```
![Screenshot](https://raw.githubusercontent.com/kechankrisna/lacrud/master/screens/screenshot1.png)

> php artisan remove:crud ModelName
```
Example: php artisan make:remove Student
```