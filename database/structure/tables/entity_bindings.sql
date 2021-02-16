create table entity_bindings (
    parent_id   bigint       not null,
    parent_type bigint       not null,
    child_id    bigint       not null,
    child_type  bigint       not null,
    `order`     bigint       not null,
    context     varchar(100) null
)
    engine = MyISAM
    charset = utf8;

create index child_id
    on entity_bindings(child_id, child_type);

create index parent_id
    on entity_bindings(parent_id, parent_type);