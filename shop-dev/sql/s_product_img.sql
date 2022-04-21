# 
drop table if exists s_product_img;
create table s_product_img(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	`name` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	sort tinyint(1) not null default 0,

	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_product_img";

