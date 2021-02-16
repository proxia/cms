create table gallery_bindings (
    entity_id   mediumint unsigned   not null,
    entity_type smallint(4) unsigned not null,
    gallery_id  smallint unsigned    not null,
    primary key (entity_id, entity_type, gallery_id)
)
    engine = MyISAM
    charset = utf8;

create index gallery_id
    on gallery_bindings(gallery_id);