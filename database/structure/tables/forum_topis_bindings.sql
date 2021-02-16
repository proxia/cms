create table forum_topic_bindings (
    forum_id smallint unsigned default 0 not null,
    topic_id smallint unsigned default 0 not null,
    `order`  smallint unsigned default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index forum_id
    on forum_topic_bindings(forum_id);

create index topic_id
    on forum_topic_bindings(topic_id);