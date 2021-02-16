create table frontpage (
    item_id   mediumint unsigned   default 0 not null,
    item_type smallint(4) unsigned default 0 not null,
    `order`   mediumint unsigned   default 1 not null,
    primary key (item_id, item_type)
)
    engine = MyISAM
    charset = utf8;