# 
drop table if exists v_cate_rela;
create table v_cate_rela(
	id int(11) not null auto_increment,
	cate_id int(11) not null default 0,
	parent_id int(11) not null default 0,
	
	primary key(id),
	unique key(cate_id, parent_id)
)ENGINE=INNODB default charset=utf8mb4 comment "cate relation";

