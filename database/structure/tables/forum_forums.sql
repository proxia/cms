create table forum_forums (
    id           smallint unsigned auto_increment
        primary key,
    creation     datetime            default '0000-00-00 00:00:00' not null,
    user_id      smallint unsigned   default 0                     not null,
    is_published tinyint(1) unsigned default 1                     not null,
    usable_by    smallint(4) unsigned                              not null
)
    engine = MyISAM
    charset = utf8;

create index is_published
    on forum_forums(is_published);

create index user_id
    on forum_forums(user_id);