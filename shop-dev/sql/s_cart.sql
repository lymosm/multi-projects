# 
drop table if exists s_cart;
create table s_cart(
	id int(11) not null auto_increment,
	session_id varchar(125) not null default "",
	`cart_content` text default null,
	updated_date datetime default null,
	expired_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_cart";

