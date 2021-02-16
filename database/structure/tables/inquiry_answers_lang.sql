create table inquiry_answers_lang (
    answer_id smallint unsigned default 0 not null,
    language  varchar(10)                 not null,
    answer    text                        not null,
    primary key (answer_id, language)
)
    engine = MyISAM
    charset = utf8;