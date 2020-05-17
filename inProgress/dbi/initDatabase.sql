drop database if exists cw2test1;
create database cw2test1;

use cw2test1;

create table customer(
    cID bigint primary key auto_increment,
    usename varchar(255) not null,
    realname varchar(255) not null,
    passportID varchar(255) not null,
    telephone varchar(20) not null,
    email varchar(255) not null,
    region varchar(40) not null,
    password varchar(255) not null,
    repID int(10),
    repUsername varchar(255)
);

create table rep(
	eID int primary key auto_increment,
    username varchar(255) not null,
    realname varchar(255) not null,
    telephone varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    region varchar(255),
    quota int(10)
);

create table manager(
	mID int primary key auto_increment,
    username varchar(255) not null,
    password varchar(255) not null
);

create table masksStorage(
	maskName varchar(20) primary key not null,
    maskNum int(10) not null
);


insert into masksStorage values("mask1",50000);
insert into masksStorage values("mask2", 100000);
insert into masksStorage values("mask3",30000);

create table CostomerOrderTotal(
	
    cOrderID bigint primary key auto_increment,
    cID bigint not null,
    CustomerName varchar(255) not null,
    maskType1Num int(10) not null,
    maskType2Num int(10) not null,
	maskType3Num int(10) not null,
    OrderTime varchar(255) not null,
    Orderstatus varchar(10) not null,
    repID	varchar(50)
);