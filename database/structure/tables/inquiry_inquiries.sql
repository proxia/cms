create table inquiry_inquiries (
    id           smallint unsigned auto_increment
        primary key,
    creation     datetime            default '0000-00-00 00:00:00' not null,
    valid_for    int unsigned                                      null,
    image        varchar(255)                                      null,
    show_results tinyint(1) unsigned default 1                     not null,
    is_published tinyint(1) unsigned default 1                     not null
)
    engine = MyISAM
    charset = utf8;

create index is_published
    on inquiry_inquiries(is_published);

create index valid_for
    on inquiry_inquiries(valid_for);