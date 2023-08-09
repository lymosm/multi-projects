create database fly_db default character set utf8mb4 collate utf8mb4_unicode_ci;
use fly_db;
create table tb_user (
    id int(11) auto_increment not null,
    `name` varchar(100) not null default "",
    primary key(id)
)ENGINE=InnoDB;
insert into user (id, name) values (1, "admin");

create table tb_visit_log (
    id int(11) auto_increment not null,
    ip varchar(255) not null default "",
    agent varchar(1000) not null default "",
    url varchar(1000) not null default "",
    added_date datetime default null,

    primary key(id) 

)ENGINE=InnoDB;