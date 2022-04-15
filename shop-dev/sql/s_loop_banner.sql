# 
drop table if exists s_loop_banner;
create table s_loop_banner(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	img_uri varchar(60) not null default "",
	type varchar(25) not null default "",
	text varchar(500) not null default "",
	btn varchar(25) not null default "",
	btn_link varchar(255) not null default "",
	link varchar(255) not null default "",
	`order` int(11) not null default 0 comment "sort index",
	
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "loop banner";

