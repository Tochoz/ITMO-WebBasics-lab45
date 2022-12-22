# [Ссылка на развёрнутый сайт](http://1082601-co73864.tmweb.ru/list.php)


Главной страницей является list.php

#### В случае, если при создании работы выводится ошибка "Отсутствует прикреплённое изображение", скорее всего изображение не успело загрузиться, следует подождать. 

# Конфигурация таблицы БД
Имя базы данных "denisnovik"
```sql
create table denisnovik.items
(
    id          int auto_increment,
    title       varchar(255) not null,
    img longblob     not null,
    constraint items_pk
    primary key (id)
);
```