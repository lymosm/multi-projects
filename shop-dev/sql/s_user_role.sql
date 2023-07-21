# s_user_role
drop table if exists s_user_role;
create table s_user_role(
	id int(11) not null auto_increment,
	user_id int(11) not null default 0,
	role_id int(11) not null default 0,
	
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(user_id, role_id)
)ENGINE=INNODB default charset=utf8mb4 comment "user role";

insert into s_user_role (user_id, role_id, added_date) values (1, 1, "2023-07-05 12:12:12");

