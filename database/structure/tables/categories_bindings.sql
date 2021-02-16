create table categories_bindings (
    category_id smallint unsigned    default 0 not null,
    item_id     mediumint unsigned   default 0 not null,
    item_type   smallint(4) unsigned default 0 not null,
    `order`     mediumint unsigned   default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index category_id
    on categories_bindings(category_id);

create index item_id
    on categories_bindings(item_id);

create index item_type
    on categories_bindings(item_type);