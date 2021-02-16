create table menus_lang (
    menu_id     smallint unsigned default 0 not null,
    language    varchar(10)                 not null,
    title       text                        null,
    description mediumtext                  null,
    primary key (menu_id, language)
)
    engine = MyISAM
    charset = utf8;