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

INSERT INTO `shop`.`s_loop_banner`(`id`, `name`, `img_uri`, `type`, `text`, `btn`, `btn_link`, `link`, `order`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (1, '777', '/storage/images/20220418/1.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_loop_banner`(`id`, `name`, `img_uri`, `type`, `text`, `btn`, `btn_link`, `link`, `order`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (2, '777', '/storage/images/20220418/2.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_loop_banner`(`id`, `name`, `img_uri`, `type`, `text`, `btn`, `btn_link`, `link`, `order`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (3, '777', '/storage/images/20220418/3.jpg', 'home-top', '777', '77', '777', '777', 0, 0, NULL, 0, NULL);


