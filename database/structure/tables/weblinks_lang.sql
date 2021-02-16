create table weblinks_lang (
    weblink_id          mediumint unsigned  default 0 not null,
    language            varchar(10)                   not null,
    title               text                          not null,
    description         mediumtext                    null,
    language_is_visible tinyint(1) unsigned default 1 not null
)
    engine = MyISAM
    charset = utf8;

create index language_is_visible
    on weblinks_lang(language_is_visible);

create index weblink_id
    on weblinks_lang(weblink_id, language);