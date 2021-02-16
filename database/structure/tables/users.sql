create table users (
    id              mediumint unsigned auto_increment
        primary key,
    creation        datetime            default '0000-00-00 00:00:00' not null,
    group_id        tinyint unsigned                                  null,
    company_id      smallint unsigned                                 null,
    last_login      datetime                                          null,
    login           varchar(30)                                       null,
    password        varchar(32)                                       null,
    nickname        varchar(30)                                       null,
    avatar          varchar(100)                                      null,
    firstname       varchar(30)                                       null,
    familyname      varchar(30)                                       null,
    age             tinyint unsigned                                  null,
    sex             tinyint(1) unsigned                               null,
    title           varchar(30)                                       null,
    street          varchar(30)                                       null,
    city            varchar(30)                                       null,
    zip             varchar(10)                                       null,
    country         varchar(3)                                        null,
    phone           varchar(20)                                       null,
    fax             varchar(20)                                       null,
    cell            varchar(20)                                       null,
    email           varchar(50)                                       null,
    website         varchar(255)                                      null,
    is_enabled      tinyint(1)          default 1                     not null,
    is_editor       tinyint(1)          default 0                     not null,
    send_newsletter tinyint(1) unsigned default 1                     not null
)
    engine = MyISAM
    charset = utf8;

create index company_id
    on users(company_id);

create index group_id
    on users(group_id);

create index is_editor
    on users(is_editor);

create index is_enabled
    on users(is_enabled);

create index login
    on users(login);