# 
drop table if exists s_order_user;
create table s_order_user(
	id int(11) not null auto_increment,
	order_id int(11) not null default 0,
	user_id int(11) not null default 0,
	`country` varchar(25) not null default "",
	`state` varchar(25) not null default "",
	`city` varchar(25) not null default "",
	`address` varchar(25) not null default "",
	`phone` varchar(25) not null default "",
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_order_user";

