create table inquiry_inquiries_lang (
    inquiry_id          smallint unsigned default 0 not null,
    language            varchar(10)                 not null,
    title               text                        not null,
    description         mediumtext                  null,
    language_is_visible tinyint(1)        default 1 not null,
    primary key (inquiry_id, language)
)
    engine = MyISAM
    charset = utf8;