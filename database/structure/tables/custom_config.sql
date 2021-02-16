create table custom_config (
    entity_id   mediumint    default 0  not null,
    entity_type smallint     default 0  not null,
    `key`       varchar(255) default '' not null,
    value       varchar(255) default '' not null
)
    engine = MyISAM
    charset = utf8;

create index entity_id
    on custom_config(entity_id);

create index entity_type
    on custom_config(entity_type);

create index `key`
    on custom_config(`key`);