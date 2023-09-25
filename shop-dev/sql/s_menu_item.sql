# s_menu_item
drop table if exists s_menu_item;
create table s_menu_item(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	url varchar(800) not null default "",

	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "menu item";


