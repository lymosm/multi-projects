# 视频表
drop table if exists v_video_list;
create table v_video_list(
	id int(11) not null auto_increment,
	name varchar(60) not null default "",
	origin_video_uri varchar(60) not null default "",
	video_uri varchar(60) not null default "",
	qrcode_uri varchar(60) not null default "",
	qrcode_text varchar(60) not null default "",
	detail_uri varchar(60) not null default "",
	added_by int(11) not null default 0,
	added_date datetime default null,
	updated_by int(11) not null default 0,
	updated_date datetime default null,
	
	primary key(id)
)ENGINE=INNODB default charset=utf8mb4 comment "视频表";
