# 
drop table if exists s_product_img;
create table s_product_img(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	attachment_id int(11) not null default 0,
	sort tinyint(1) not null default 0,
	is_main tinyint(1) not null default 0,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_product_img";
