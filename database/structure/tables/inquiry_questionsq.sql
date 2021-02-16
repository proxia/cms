create table inquiry_questions_lang (
    question_id smallint unsigned default 0 not null,
    language    varchar(10)                 not null,
    question    text                        not null,
    description mediumtext                  null,
    primary key (question_id, language)
)
    engine = MyISAM
    charset = utf8;