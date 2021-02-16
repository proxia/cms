create table templates_bindings (
    entity_id   mediumint unsigned   null,
    entity_type smallint(4) unsigned null,
    template_id smallint unsigned    not null
)
    engine = MyISAM
    charset = utf8;

create index entity_id
    on templates_bindings(entity_id, entity_type);

create index template_id
    on templates_bindings(template_id);
