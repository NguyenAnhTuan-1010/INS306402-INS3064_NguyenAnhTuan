drop table if exists users;
drop table if exists products;
drop table if exists categories;
drop table if exists orders;
drop table if exists order_items;


create table users (
    id int auto_increment primary key,
    name varchar(55) not null,
    email varchar(55) not null unique,
    created_at datetime default current_datetime
);

create table categories (
    id int auto_increment primary key,
    category_name varchar(20) not null unique
);

create table products (
    id int auto_increment primary key,
    name varchar(55) not null unique,
    price int not null,
    category_id int not null,
    stock int not null,

    foreign key (category_id) references categories(id)
);

create table orders (
    id int auto_increment primary key,
    user_id int not null,
    order_date datetime default current_datetime,

    foreign key (user_id) references users(id)
);

create table order_items (
    id int auto_increment primary key,
    order_id int not null,
    product_id int not null,
    quantity int not null,

    foreign key (order_id) references orders(id),
    foreign key (product_id) references products(id)
);

INSERT INTO users (name, email) VALUES
('Tuan Nguyen', 'tuannguyen@example.com'),
('Quang Le', 'quangle@example.com'),
('Khanh Bes', 'khanhbes@example.com'),
('Bach Trinh', 'bachtrinh@example.com'),
('Dam Pham', 'dampham@example.com'),
('Le Xuan Hai', 'dcmtml@example.com'),
('Grace Do', 'grace@example.com'),
('Henry Bui', 'henry@example.com'),
('Isabella Dang', 'isabella@example.com'),
('Jack Phan', 'jack@example.com');

INSERT INTO categories (category_name) VALUES
('Electronics'),
('Clothing'),
('Books'),
('Home'),
('Toys'),
('Sports'),
('Beauty'),
('Food'),
('Accessories'),
('Stationery');

INSERT INTO products (name, price, category_id, stock) VALUES
('iPhone 14', 1000, 1, 50),
('Samsung TV', 800, 1, 30),
('T-Shirt', 20, 2, 100),
('Jeans', 40, 2, 60),
('Novel Book', 15, 3, 120),
('Cookbook', 25, 3, 80),
('Sofa', 500, 4, 10),
('Desk Lamp', 35, 4, 40),
('Toy Car', 10, 5, 200),
('Football', 25, 6, 70),
('Lipstick', 15, 7, 90),
('Chocolate Box', 12, 8, 150),
('Watch', 120, 9, 35),
('Notebook', 5, 10, 300),
('Pen Set', 8, 10, 250);

INSERT INTO orders (user_id) VALUES
(1),
(2),
(3),
(4),
(5),
(1),
(2),
(6),
(7),
(8),
(9),
(10);

INSERT INTO order_items (order_id, product_id, quantity) VALUES
(1, 1, 1),
(1, 3, 2),
(2, 2, 1),
(2, 5, 3),
(3, 4, 1),
(3, 6, 2),
(4, 7, 1),
(5, 8, 2),
(6, 9, 5),
(7, 10, 2),
(8, 11, 3),
(9, 12, 4),
(10, 13, 1),
(11, 14, 6),
(12, 15, 3);