create table attachments_lang (
    attachment_id       smallint unsigned   default 0 not null,
    language            varchar(10)                   not null,
    title               text                          not null,
    description         mediumtext                    null,
    language_is_visible tinyint(1) unsigned default 1 not null,
    primary key (attachment_id, language)
)
    engine = MyISAM
    charset = utf8;