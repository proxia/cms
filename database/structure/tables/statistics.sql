create table statistics (
    id          int unsigned auto_increment
        primary key,
    date        datetime             default '0000-00-00 00:00:00' not null,
    entity_id   int unsigned         default 0                     not null,
    entity_type smallint(4) unsigned default 0                     not null,
    user_id     smallint unsigned                                  null,
    user_agent  varchar(100)                                       null
)
    engine = MyISAM
    charset = utf8;

create index entity_id
    on statistics(entity_id);

create index entity_type
    on statistics(entity_type);

create index user_id
    on statistics(user_id);