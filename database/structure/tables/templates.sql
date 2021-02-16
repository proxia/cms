create table templates (
    id         smallint unsigned auto_increment
        primary key,
    creation   datetime     not null,
    template   varchar(255) not null,
    conditions text         null
)
    engine = MyISAM
    charset = utf8;