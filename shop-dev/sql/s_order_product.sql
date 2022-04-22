# 
drop table if exists s_order_product;
create table s_order_product(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	product_id int(11) not null default 0,
	`product_name` varchar(120) not null default "",
	`price` varchar(6) not null default "",
	qty int(11) not null default 0,
	`total_price` varchar(6) not null default "",
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_order_product";

