drop database if exists contacts_app;

create database contacts_app;
use contacts_app;

create table users(
    id int primary key auto_increment not null,
    name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null
);

create table contacts (
    id int primary key auto_increment not null,
    name varchar(64),
    phone_number varchar(64),

    user_id INT NOT NULL,
    foreign key (user_id) references users(id)
);

-- insert into users (name, email, password) values
--     ("test", "test@example.com", "test"),
--     ("test2", "test2@example.com", "test2"),
--     ("test3", "test3@example.com", "test3")
-- ;

-- insert into contacts (name, phone_number) values ("Antonio", "321213231"), 
-- ("Nate", "432432532"), 
-- ("Pepe", "5436734"), 
-- ("Jaja", "432646346362"), 
-- ("Adios", "90090908");