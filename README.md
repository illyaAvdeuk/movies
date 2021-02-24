# movies application

### Системные требования
* PHP 7.4
* Composer
* MySQL

### Установка
* Создать базу данных, например
```mysql
CREATE DATABASE movies CHARACTER SET utf8 COLLATE utf8_unicode_ci;
```
* Создать для неё пользователя, например
```mysql
GRANT ALL PRIVILEGES ON *.* TO 'movies'@'localhost' IDENTIFIED BY 'Jo(D0EONd@VpO7dIuB';
```
* Если название базы, имя пользователя или пароль отличаются - необходимо внести их в System/config.php в соответствующие переменные
* Запускаем приложение через команду
```
php -S localhost:8000
```
* Для генерации структуры базы данных необходимо перейти по ссылке http://127.0.0.1:8000/install/start
* После успешной генерации таблиц приложение совершит редирект на http://127.0.0.1:8000/home/main, где и происходит вся работа с приложением