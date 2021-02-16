create table menus (
    id       smallint unsigned auto_increment
        primary key,
    name     varchar(50)         default '' not null,
    is_trash tinyint(1) unsigned default 0  not null,
    editors  tinytext                       null
)
    engine = MyISAM
    charset = utf8;

create index is_trash
    on menus(is_trash);