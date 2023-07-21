create database mytest default character set utf8mb4 collate utf8mb4_unicode_ci;
use mytest;
create table user (
    id int(11) auto_increment not null,
    `name` varchar(100) not null default "",
    primary key(id)
)ENGINE=InnoDB;
insert into user (id, name) values (1, "admin");