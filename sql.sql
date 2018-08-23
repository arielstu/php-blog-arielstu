-- drop database if exists arielstu;
-- create database if not exists arielstu;
use arielstu;

create table users(
    user_id integer unsigned primary key auto_increment unique,
    user_name varchar(15) not null unique,
    first_name  varchar(15) not null,
    email varchar(100) not null unique,
    photo varchar(255) not null default 'no-photo.jpg',
    birthday date not null,
    creation_date datetime not null ,
    update_date datetime not null ,
    country varchar(100),
    pass varchar(255) not null,
    role enum
        ('admin','standard','ban') not null default 'standard'
 )ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table articles(
    article_id integer unsigned primary key auto_increment unique,
    title varchar(150) not null,  
    plot text not null,
    intro text not null,
    author integer unsigned not null,
    cover varchar(255) not null default 'no-cover.jpg',
    score integer not null default '0',
    views integer unsigned not null default '0',
    comments integer unsigned not null default '0',
    tags varchar(255) not null,
    creation_date datetime not null ,
    update_date datetime not null ,
    public_date datetime default null,
    role enum
        ('public','private','ban') not null default 'private',
    foreign key (author) references users (user_id)
        on delete cascade on update cascade
 )ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table comments(
    commentary_id integer unsigned primary key auto_increment unique,
    plot text(500) not null,
    author integer unsigned not null,
    article integer unsigned not null,
    creation_date datetime not null ,
    update_date datetime not null ,
    foreign key (author) references users (user_id)
        on delete cascade on update cascade,
    foreign key (article) references articles (article_id)
        on delete cascade on update cascade
)engine=InnoDB DEFAULT CHARSET=utf8;

create table points(
    point_id integer unsigned primary key auto_increment unique,
    valor integer(1) not null default '0',
    author integer unsigned not null,
    article integer unsigned not null,
    creation_date datetime not null ,
    update_date datetime not null ,
    foreign key (author) references users (user_id)
        on delete cascade on update cascade,
    foreign key (article) references articles (article_id)
        on delete cascade on update cascade
)engine=InnoDB DEFAULT CHARSET=utf8;


