create table inquiry_questions (
    id       smallint unsigned auto_increment
        primary key,
    creation datetime default '0000-00-00 00:00:00' not null
)
    engine = MyISAM
    charset = utf8;