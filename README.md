# Расширенная версия задания 1-2 с функционалом хранения и изменения [(задание)](https://github.com/Tochoz/ITMO-WebBasics-lab12/)

[Ссылка на развёрнутый сайт (**не работает**)](http://1082601-co73864.tmweb.ru/list.php)  
[Макет в фигме](https://www.figma.com/file/unpbxYXorzU0tOrFKXJBst/Free--Landing--Page-Template-(Copy)?type=design&node-id=0%3A1&mode=design&t=NGSFSl9SeUTDbT3j-1)

## Задача
Основываясь на результатах выполнения лабораторной работы №2, разработать северную часть веб-приложения с использованием языка PHP. Серверная часть должна возвращать пользователю динамически формируемую веб-страницу, контент которой зависит от полученного запроса.

## Инфо
Главной страницей является list.php

В случае, если при создании работы выводится ошибка **"Отсутствует прикреплённое изображение"**, скорее всего изображение не успело загрузиться, следует подождать. 

## Конфигурация таблицы БД
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
