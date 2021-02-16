create table templates_lang (
    template_id smallint unsigned not null,
    language    varchar(10)       not null,
    title       text              not null,
    description mediumtext        null
)
    engine = MyISAM
    charset = utf8;

create index template_id
    on templates_lang(template_id, language);