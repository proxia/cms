create table articles_bindings (
    article_id mediumint unsigned   not null,
    item_id    mediumint unsigned   not null,
    item_type  smallint(4) unsigned not null,
    `order`    mediumint unsigned   not null
)
    engine = MyISAM
    charset = utf8;

create index article_id
    on articles_bindings(article_id);

create index item_id
    on articles_bindings(item_id);

create index item_type
    on articles_bindings(item_type);
