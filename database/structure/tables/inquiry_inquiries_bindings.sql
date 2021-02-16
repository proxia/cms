create table inquiry_inquiries_bindings (
    inquiry_id  smallint unsigned default 0 not null,
    question_id smallint unsigned default 0 not null,
    `order`     smallint unsigned default 0 not null
)
    engine = MyISAM
    charset = utf8;

create index inquiry_id
    on inquiry_inquiries_bindings(inquiry_id);

create index question_id
    on inquiry_inquiries_bindings(question_id);