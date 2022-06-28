# 
drop table if exists s_attachment;
create table s_attachment(
	id int(11) not null auto_increment,
	`name` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	`type` varchar(10) not null default "image" comment "image/pdf/doc...",

	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_product_img";

