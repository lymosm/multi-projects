# 
drop table if exists s_product;
create table s_product(
	id int(11) not null auto_increment,
	`name` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "product";

INSERT INTO `shop`.`s_product`(`id`, `name`, `uri`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (1, 'product1', 'product1', 0, NULL, 0, NULL);
