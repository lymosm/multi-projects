# 
drop table if exists v_cate_rela;
create table v_cate_rela(
	id int(11) not null auto_increment,
	cate_id int(11) not null default 0,
	parent_id int(11) not null default 0,
	
	primary key(id),
	unique key(cate_id, parent_id)
)ENGINE=INNODB default charset=utf8mb4 comment "cate relation";

INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (1, 1, 0);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (2, 2, 0);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (3, 3, 0);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (4, 4, 2);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (5, 5, 2);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (6, 6, 3);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (7, 7, 3);
INSERT INTO `shop`.`v_cate_rela`(`id`, `cate_id`, `parent_id`) VALUES (8, 8, 6);
