# 
drop table if exists s_order_price;
create table s_order_price(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	`discount_price` varchar(6) not null default "",
	`total_price` varchar(6) not null default "",
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_order_price";

