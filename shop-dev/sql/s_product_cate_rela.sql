# 
drop table if exists s_product_cate_rela;
create table s_product_cate_rela(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	cate_id int(11) not null default 0,
	
	
	primary key(id),
	unique key(product_id, cate_id)
)ENGINE=INNODB default charset=utf8mb4 comment "product cate relation";

INSERT INTO `shop`.`s_product_cate_rela`(`id`, `product_id`, `cate_id`) VALUES (1, 1, 1);
