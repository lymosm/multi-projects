# 
drop table if exists s_page;
create table s_page(
	id int(11) not null auto_increment,
	`title` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	`content` longtext default null,
	
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(uri)
)ENGINE=INNODB default charset=utf8mb4 comment "page";

