create table groups_lang (
    group_id            mediumint(8)         not null,
    language            varchar(10)          not null,
    title               text                 not null,
    description         mediumtext           null,
    language_is_visible tinyint(1) default 1 not null,
    primary key (group_id, language)
)
    engine = MyISAM
    charset = utf8;

create index language_is_visible
    on groups_lang(language_is_visible);