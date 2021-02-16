create table banner_manager_banners_lang (
    banner_id   smallint unsigned not null,
    language    varchar(10)       not null,
    title       text              not null,
    description mediumtext        not null,
    primary key (banner_id, language)
)
    engine = MyISAM
    charset = utf8;