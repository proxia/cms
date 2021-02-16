create table admin_users
(
	id smallint unsigned auto_increment
		primary key,
	creation datetime default '0000-00-00 00:00:00' not null,
	last_login datetime null,
	login varchar(30) default '' not null,
	password varchar(32) default '' not null,
	firstname varchar(30) default '' not null,
	familyname varchar(30) null,
	is_enabled tinyint(1) unsigned default 1 not null
)
engine=MyISAM charset=utf8;

create index is_enabled
	on admin_users (is_enabled);
