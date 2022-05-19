# 
drop table if exists s_cate;
create table s_cate(
	id int(11) not null auto_increment,
	cate_name varchar(60) not null default "",
	uri varchar(60) not null default "",
	img_uri varchar(60) not null default "",
	`desc` varchar(800) not null default "",
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id),
	unique key(uri)
)ENGINE=INNODB default charset=utf8mb4 comment "product cate";

INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (1, 'aa', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (2, 'bb', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (3, 'cc', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (4, 'bbb', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (5, 'bbb2', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (6, 'ccc', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (7, 'ccc2', 0, '2022-04-19 15:40:35', 0, NULL);
INSERT INTO `shop`.`s_cate`(`id`, `cate_name`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (8, 'cccc', 0, '2022-04-19 15:40:35', 0, NULL);
