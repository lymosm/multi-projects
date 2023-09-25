# s_menu
drop table if exists s_menu;
create table s_menu(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	menu text default null,

	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(`name`)
)ENGINE=INNODB default charset=utf8mb4 comment "menu";


