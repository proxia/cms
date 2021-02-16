create table admin_users_fork_data
(
	admin_user_id smallint unsigned default 0 not null,
	dsn varchar(100) default '' not null,
	name varchar(255) not null,
	site_name varchar(255) default '' not null
)
engine=MyISAM charset=utf8;

create index admin_user_id
	on admin_users_fork_data (admin_user_id);
