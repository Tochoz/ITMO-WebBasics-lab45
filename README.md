## Главная страница 
[localhost/list.php](localhost/list.php)

# Конфигурация таблицы БД
Имя базы данных "denisnovik"
```sql
create table denisnovik.items
(
    id          int auto_increment,
    title       varchar(255) not null,
    column_name longblob     not null,
    constraint items_pk
    primary key (id)
);
```

# Примечание
Ограничение по максимальному объёму загружаемых картинок на сайте установлено в 128МБ, если в конфигурации PHP(php.ini) и MySQL(my.ini) ограничения будут меньше, возможны ошибки со стороны сервера. 