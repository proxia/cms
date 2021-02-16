create table categories (
    id                   smallint unsigned auto_increment
        primary key,
    creation             datetime             default '0000-00-00 00:00:00' not null,
    author_id            smallint unsigned                                  null,
    is_published         tinyint(1) unsigned  default 1                     not null,
    is_trash             tinyint(1) unsigned  default 0                     not null,
    access               tinyint unsigned     default 1                     not null,
    access_groups        text                                               null,
    editors              text                                               null,
    image                varchar(255)                                       null,
    map_image            varchar(50)                                        null,
    map_area_shape       enum ('rect', 'circle', 'poly', 'default')         null,
    map_area_coordinates text                                               null,
    usable_by            smallint(4) unsigned default 255                   not null
)
    engine = MyISAM
    charset = utf8;

create index author_id
    on categories(author_id);

create index is_published
    on categories(is_published);

create index is_trash
    on categories(is_trash);

create index usable_by
    on categories(usable_by);