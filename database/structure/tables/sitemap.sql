create table sitemap (
    item_id       mediumint unsigned   default 0 not null,
    item_type     smallint(4) unsigned default 0 not null,
    show_subitems tinyint unsigned     default 0 not null,
    `order`       mediumint unsigned   default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index item_id
    on sitemap(item_id, item_type);