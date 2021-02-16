create table inquiry_answers (
    id          mediumint unsigned auto_increment
        primary key,
    question_id smallint unsigned  default 0 not null,
    image       varchar(255)                 null,
    count       mediumint unsigned default 0 not null,
    `order`     mediumint unsigned default 1 not null
)
    engine = MyISAM
    charset = utf8;

create index question_id
    on inquiry_answers(question_id);