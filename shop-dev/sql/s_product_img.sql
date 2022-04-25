# 
drop table if exists s_product_img;
create table s_product_img(
	id int(11) not null auto_increment,
	product_id int(11) not null default 0,
	`name` varchar(120) not null default "",
	`uri` varchar(60) not null default "",
	sort tinyint(1) not null default 0,

	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_product_img";

INSERT INTO `shop`.`s_product_img`(`id`, `product_id`, `name`, `uri`, `sort`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (1, 1, '88.jpg', '/storage/images/20220418/1.jpg', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_product_img`(`id`, `product_id`, `name`, `uri`, `sort`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (2, 1, '99.jpg', '/storage/images/20220418/2.jpg', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_product_img`(`id`, `product_id`, `name`, `uri`, `sort`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (3, 1, '66.jpg', '/storage/images/20220418/3.jpg', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_product_img`(`id`, `product_id`, `name`, `uri`, `sort`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (4, 1, '99.jpg', '/storage/images/20220418/2.jpg', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_product_img`(`id`, `product_id`, `name`, `uri`, `sort`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (5, 1, '99.jpg', '/storage/images/20220418/1.jpg', 0, 0, NULL, 0, NULL);
INSERT INTO `shop`.`s_product_img`(`id`, `product_id`, `name`, `uri`, `sort`, `added_by`, `added_date`, `updated_by`, `updated_date`) VALUES (6, 1, '99.jpg', '/storage/images/20220418/3.jpg', 0, 0, NULL, 0, NULL);
