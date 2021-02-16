create table forum_reply_bindings (
    thread_id mediumint unsigned default 0 not null,
    reply_id  mediumint unsigned default 0 not null,
    `order`   mediumint unsigned default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index reply_id
    on forum_reply_bindings(reply_id);

create index thread_id
    on forum_reply_bindings(thread_id);