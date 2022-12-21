# [Ссылка на развёрнутый сайт](http://1082601-co73864.tmweb.ru/list.php)


Главной страницей является list.php

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