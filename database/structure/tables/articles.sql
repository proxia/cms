create table articles (
    id                          mediumint unsigned auto_increment
        primary key,
    author_id                   smallint unsigned                                  null,
    update_authors              text                                               null,
    creation                    datetime             default '0000-00-00 00:00:00' not null,
    is_published                tinyint(1) unsigned  default 1                     not null,
    is_trash                    tinyint(1) unsigned  default 0                     not null,
    is_archive                  tinyint(1) unsigned  default 0                     not null,
    access                      tinyint unsigned     default 1                     not null,
    access_groups               text                                               null,
    editors                     text                                               null,
    editors_groups              text                                               null,
    expiration                  datetime                                           null,
    image                       varchar(255)                                       null,
    map_image                   varchar(50)                                        null,
    map_area_shape              enum ('rect', 'circle', 'poly', 'default')         null,
    map_area_coordinates        text                                               null,
    is_news                     tinyint(1) unsigned  default 0                     not null,
    is_flash_news               tinyint(1) unsigned  default 0                     not null,
    frontpage_show_full_version tinyint(1) unsigned  default 0                     not null,
    usable_by                   smallint(4) unsigned default 255                   not null
)
    engine = MyISAM
    charset = utf8;

create index is_archive
    on articles(is_archive);

create index is_flash_news
    on articles(is_flash_news);

create index is_news
    on articles(is_news);

create index is_published
    on articles(is_published);

create index is_trash
    on articles(is_trash);

create index usable_by
    on articles(usable_by);
