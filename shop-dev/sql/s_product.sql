# 
drop table if exists v_product;
create table v_product(
	id int(11) not null auto_increment,
	`name` varchar(120) not null default "",
	
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "product";

