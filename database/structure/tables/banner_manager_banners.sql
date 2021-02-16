create table banner_manager_banners (
    id                    smallint unsigned auto_increment
        primary key,
    creation              datetime                        not null,
    author_id             smallint unsigned               not null,
    name                  varchar(255)                    not null,
    is_published          tinyint(1) unsigned   default 1 not null,
    valid_from            datetime                        null,
    valid_to              datetime                        null,
    target_url            varchar(255)                    not null,
    source_url            varchar(255)                    not null,
    width                 smallint unsigned               not null,
    height                smallint unsigned               not null,
    impressions_purchased smallint(6) unsigned  default 0 not null,
    show_count            mediumint(9) unsigned default 0 not null,
    click_count           mediumint(9) unsigned default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index is_published
    on banner_manager_banners(is_published);