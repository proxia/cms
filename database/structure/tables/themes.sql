create table themes (
    id         smallint unsigned auto_increment
        primary key,
    name       varchar(50) default '' not null,
    screenshot varchar(36)            null
)
    engine = MyISAM
    charset = utf8;