# 
drop table if exists s_product_detail;
create table s_product_detail(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	`price` varchar(10) not null default "",
	`short_desc` varchar(500) not null default "",
	`long_desc` text default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_product_detail";

