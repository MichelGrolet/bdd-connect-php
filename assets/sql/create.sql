create table users
(
    userid     int(11)      not null auto_increment,
    username   varchar(255),
    name       varchar(255),
    password   varchar(255) not null,
    email      varchar(255) not null,
    created_at datetime     not null,
    updated_at datetime     not null,
    primary key (userid),
    unique key (username),
    unique key (email)
);