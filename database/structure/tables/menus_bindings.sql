create table menus_bindings (
    menu_id   smallint unsigned    default 0 not null,
    item_id   mediumint unsigned   default 0 not null,
    item_type smallint(4) unsigned default 0 not null,
    `order`   mediumint unsigned   default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index item_id
    on menus_bindings(item_id);

create index item_type
    on menus_bindings(item_type);

create index menu_id
    on menus_bindings(menu_id);