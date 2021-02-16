create table `groups` (
    id           smallint unsigned auto_increment
        primary key,
    creation     datetime            default '0000-00-00 00:00:00' not null,
    name         varchar(50)         default ''                    not null,
    is_published tinyint(1) unsigned default 1                     not null
)
    engine = MyISAM
    charset = utf8;