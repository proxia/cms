create table attachments (
    id       mediumint unsigned auto_increment
        primary key,
    creation datetime     default '0000-00-00 00:00:00' not null,
    file     varchar(255) default ''                    not null
)
    engine = MyISAM
    charset = utf8;

create index file
    on attachments(file);
