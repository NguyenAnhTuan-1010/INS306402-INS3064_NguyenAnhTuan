drop table if exists users;
drop table if exists categories;
drop table if exists tags;
drop table if exists posts;
drop table if exists comments;


create table users (
    UserID int default auto_increment primary key,
    UserName varchar(55) not null
);

create table categories (
    CategoryID int default auto_increment primary key,
    category varchar(36) unique not null
);

create table tags (
    TagID int not null default auto_increment primary key,
    UserID int not null,

    foreign key users(UserID) references users(UserID)
);

create table posts (
    PostID int default auto_increment primary key,
    content varchar(1000) not null,
    created_at timestamp not null default current_timestamp,
    UserID int not null,
    CategoryID int not null,

    foreign key posts(UserID) references to users(UserID),
    foreign key categories(CategoryID) references categories(CategoryID)
);

create table comments (
    CommentID int default auto_increment primary key,
    content varchar(666) not null,
    created_at timestamp not null default current_timestamp,
    UserID int not null,
    parent_comment_id int default null,
    TagID int default null,

    foreign key comments(UserID) references users(UserID),
    foreign key comments(parent_comment_id) references comments(CommentID) on delete cascade,
    foreign key comments(TagID) references tags(TagID)
);

create table post_tags (
    id int default auto_increment primary key,
    PostID int not null,
    TagID int not null,

    foreign key posts_tags(PostID) references posts(PostID) on delete cascade,
    foreign key posts_tags(TagID) references tags(TagID) on delete cascade 
);

create table post_categories (
    id int default auto_increment primary key,
    PostID int not null,
    CategoryID int not null,

    foreign key post_categories(PostID) references post(PostID) on delete cascade,
    foreign key post_categories(CategoryID) references categories(CategoryID) on delete cascade
);

insert into users
values
    ("Khanh Bes"),
    ("Tuan Nguyen"),
    ("Quang Le"),
    ("Bach Trinh");

insert into categories 
values
    ("sad"),
    ("joke"),
    ("funny"),
    ("QA");

