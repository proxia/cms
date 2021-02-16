create table articles_lang (
    article_id                    mediumint unsigned  default 0 not null,
    language                      varchar(10)                   not null,
    title                         text                          not null,
    description                   mediumtext                    null,
    text                          mediumtext                    not null,
    quick_help                    text                          null,
    language_is_visible           tinyint(1) unsigned default 1 not null,
    frontpage_language_is_visible tinyint(1) unsigned default 1 not null,
    primary key (article_id, language)
)
    engine = MyISAM
    charset = utf8;