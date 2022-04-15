# 
drop table if exists v_product_cate_rela;
create table v_product_cate_rela(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	cate_id int(11) not null default 0,
	
	
	primary key(id),
	unique key(product_id, cate_id)
)ENGINE=INNODB default charset=utf8mb4 comment "product cate relation";

