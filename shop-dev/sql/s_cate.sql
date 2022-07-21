# 
drop table if exists s_cate;
create table s_cate(
	id int(11) not null auto_increment,
	cate_name varchar(60) not null default "",
	uri varchar(60) not null default "",
	img_uri varchar(60) not null default "",
	`desc` varchar(800) not null default "",
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(uri)
)ENGINE=INNODB default charset=utf8mb4 comment "product cate";
