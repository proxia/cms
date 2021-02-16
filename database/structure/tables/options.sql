create table options (
    id    smallint unsigned auto_increment
        primary key,
    `key` varchar(255) default '' not null,
    value varchar(255) default '' not null
)
    engine = MyISAM
    charset = utf8;

create index `key`
    on options(`key`);