create table privileges (
    entity_id   smallint unsigned    not null,
    entity_type smallint(4) unsigned not null,
    privileges  text                 not null
)
    engine = MyISAM
    charset = utf8;

create index entity_id
    on privileges(entity_id, entity_type);