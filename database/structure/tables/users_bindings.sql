create table users_bindings (
    group_id smallint unsigned default 0 not null,
    user_id  smallint unsigned default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index group_id
    on users_bindings(group_id);

create index user_id
    on users_bindings(user_id);