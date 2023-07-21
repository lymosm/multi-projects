# s_role
drop table if exists s_role;
create table s_role(
	id int(11) not null auto_increment,
	`name` varchar(60) not null default "",
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(`name`)
)ENGINE=INNODB default charset=utf8mb4 comment "role";

insert into s_role (name, added_date) values ("administrator", "2023-07-05 12:12:12");
insert into s_role (name, added_date) values ("customer", "2023-07-05 12:12:12");

