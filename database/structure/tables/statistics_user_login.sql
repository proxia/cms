create table statistics_user_login (
    user_id     smallint unsigned default 0                     not null,
    login_time  datetime          default '0000-00-00 00:00:00' not null,
    logout_time datetime                                        null
)
    engine = MyISAM
    charset = utf8;

create index user_id
    on statistics_user_login(user_id);