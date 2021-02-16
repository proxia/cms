create table attachments_bindings (
    entity_id       mediumint unsigned default 0   not null,
    entity_type     smallint unsigned  default 0   not null,
    attachment_id   mediumint unsigned default 0   not null,
    attachment_type tinyint unsigned   default 255 not null,
    `order`         mediumint unsigned default 0   not null
)
    engine = MyISAM
    charset = utf8;

create index attachment_id
    on attachments_bindings(attachment_id);

create index entity_id
    on attachments_bindings(entity_id);

create index entity_type
    on attachments_bindings(entity_type);
