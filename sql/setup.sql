drop database if exists contacts_app;

create database contacts_app;
use contacts_app;

create table contacts (
    id int primary key auto_increment,
    name varchar(64),
    phone_number varchar(64)
);

insert into contacts (name, phone_number) values ("Antonio", "321213231"), 
("Nate", "432432532"), 
("Pepe", "5436734"), 
("Jaja", "432646346362"), 
("Adios", "90090908");