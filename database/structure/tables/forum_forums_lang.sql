create table forum_forums_lang (
    forum_id    smallint unsigned default 0 not null,
    language    varchar(10)                 not null,
    title       text                        not null,
    description mediumtext                  null,
    primary key (forum_id, language)
)
    engine = MyISAM
    charset = utf8;