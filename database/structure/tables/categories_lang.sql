create table categories_lang (
    category_id         smallint unsigned   default 0 not null,
    language            varchar(10)                   not null,
    title               text                          not null,
    description         mediumtext                    null,
    quick_help          text                          null,
    language_is_visible tinyint(1) unsigned default 1 not null,
    localized_image     varchar(255)                  null,
    primary key (category_id, language)
)
    engine = MyISAM
    charset = utf8;

create index language_is_visible
    on categories_lang(language_is_visible);
