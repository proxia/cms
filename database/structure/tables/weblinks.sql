create table weblinks (
    id            mediumint unsigned auto_increment
        primary key,
    creation      datetime            default '0000-00-00 00:00:00' not null,
    url           varchar(255)        default ''                    not null,
    target        varchar(50)         default ''                    not null,
    is_trash      tinyint(1) unsigned default 0                     not null,
    is_published  tinyint(1)          default 1                     not null,
    access        tinyint unsigned    default 1                     not null,
    access_groups text                                              null,
    image         varchar(255)                                      null,
    usable_by     tinyint unsigned    default 255                   not null
)
    engine = MyISAM
    charset = utf8;

create index is_published
    on weblinks(is_published);

create index is_trash
    on weblinks(is_trash);

create index usable_by
    on weblinks(usable_by);