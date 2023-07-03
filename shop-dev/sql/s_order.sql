# 
drop table if exists s_order;
create table s_order(
	id int(11) not null auto_increment,
	`order_num` varchar(25) not null default "",
	`paid_date` datetime default null,
	paid_type varchar(12) not null default "" comment "wechatpay | alipay | paypal",
	order_status tinyint(1) not null default 0 comment "1.pending 2.process 3. complete 4. failed 5. cancel 6. refund",
	
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "s_order";

