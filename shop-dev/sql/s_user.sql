# v_user
drop table if exists v_user;
create table v_user(
	id int(11) not null auto_increment,
	account varchar(60) not null default "",
	pwd varchar(60) not null default "",
	added_date datetime default null,
	updated_date datetime default null,
	
	primary key(id),
	unique key(account)
)ENGINE=INNODB default charset=utf8mb4 comment "用户表";

insert into v_user (account, pwd, added_date) values ("123641", md5(md5('tb7107419108888video')), "2021-05-28 12:12:12");

