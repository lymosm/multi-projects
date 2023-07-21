# s_user
drop table if exists s_user;
create table s_user(
	id int(11) not null auto_increment,
	account varchar(60) not null default "",
	pwd varchar(60) not null default "",

	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(account)
)ENGINE=INNODB default charset=utf8mb4 comment "用户表";

insert into s_user (account, pwd, added_date) values ("admin", md5(md5('123456shop')), "2021-05-28 12:12:12");

