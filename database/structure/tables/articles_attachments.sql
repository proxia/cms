create table articles_attachments (
    article_id    mediumint unsigned    default 0 not null,
    attachment_id mediumint(5) unsigned default 0 not null,
    primary key (article_id, attachment_id)
)
    engine = MyISAM
    charset = utf8;