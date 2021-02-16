create table languages (
    id                smallint unsigned auto_increment
        primary key,
    code              varchar(10)                    not null,
    native_name       varchar(50)         default '' not null,
    global_visibility tinyint(1) unsigned default 1  not null,
    local_visibility  tinyint(1) unsigned default 1  not null
)
    engine = MyISAM
    charset = utf8;

create index code
    on languages(code);