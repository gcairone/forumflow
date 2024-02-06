DROP DATABASE IF EXISTS Cairone_661284;
CREATE DATABASE if not exists Cairone_661284;
USE Cairone_661284;
CREATE TABLE if not exists category(
    Name VARCHAR(50) PRIMARY KEY,
    ImgPath VARCHAR(256)
);
CREATE TABLE if not exists user(
    Username VARCHAR(20) PRIMARY KEY ,
    Email VARCHAR(40) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL, 
    AdditionalInfo VARCHAR(255), 
    ImgPath VARCHAR(256),
    JoinedDateTime DATETIME
);
CREATE TABLE if not exists question(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Author VARCHAR(20),
    Body TEXT,
    InsertTimestamp DATETIME,
    Category VARCHAR(50),
    FOREIGN KEY (Author) REFERENCES user(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Category) REFERENCES category(Name)
);
CREATE TABLE if not exists answer(
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Question INT,
    Author VARCHAR(20),
    Body TEXT,
    InsertTimestamp DATETIME,
    FOREIGN KEY (Author) REFERENCES user(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Question) REFERENCES question(Id) ON DELETE CASCADE ON UPDATE CASCADE
);
