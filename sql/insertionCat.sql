USE Cairone_661284;

INSERT INTO category (Name, ImgPath)
VALUES 
    ("HTML", "img/HTML.jpg"),
    ("CSS", "img/CSS.jpg"),
    ("JavaScript", "img/JavaScript.jpg"),
    ("PHP", "img/PHP.jpg"),
    ("MySQL", "img/MySQL.jpg");


/*
USE forumDB;

INSERT INTO user (Username, Email, Password, AdditionalInfo, ImgPath, JoinedDateTime) 
VALUES 
    ('john_doe', 'john@example.com', 'hashed_password_1', 'Info1', 'img/profiles/car.jpg', NOW()),
    ('alice_smith', 'alice@example.com', 'hashed_password_2', 'Info2', 'img/profiles/cat.jpg', NOW()),
    ('bob_jones', 'bob@example.com', 'hashed_password_3', 'Info3', 'img/profiles/frog.png', NOW());
INSERT INTO question (Author, Body, InsertTimestamp, Category)
VALUES 
    ('john_doe', 'Come inserisco una tabella?', NOW(), 'HTML'),
    ('john_doe', 'HTML è orientato agli oggetti?', NOW(), 'HTML'),
    ('bob_jones', 'Come ci si connette a un database?', NOW(), 'PHP'),
    ('alice_smith', 'Come faccio a validare il codice HTML?', NOW(), 'HTML'),
    ('john_doe', 'Cosa è il DOM?', NOW(), 'Javascript'),
    ('alice_smith', 'Come rimuovo i duplicati su una colonna?', NOW(), 'MySQL'),
    ('john_doe', 'Come inserisco le immagini?', NOW(), 'CSS'),
    ('alice_smith', 'Come funziona il z-index?', NOW(), 'CSS'),
    ('bob_jones', 'Cosa cambia tra DDL e DML?', NOW(), 'MySQL'),
    ('bob_jones', 'Cosa vuol dire CASCADE?', NOW(), 'MySQL'),
    ('john_doe', 'Cosa sono le temporary table?', NOW(), 'MySQL'),
    ('alice_smith', 'Cosa cambia tra MySql e SqlLite?', NOW(), 'MySQL');
INSERT INTO answer (Question, Author, Body, InsertTimestamp)
VALUES
    (1, 'bob_jones', "Puoi inserire una tabella in HTML utilizzando l'elemento table", NOW()),
    (2, 'bob_jones', "No, HTML è un linguaggio di markup per strutturare il contenuto web, non orientato agli oggetti.", NOW()),
    (2, 'bob_jones', "Per la programmazione orientata agli oggetti, guarda a linguaggi come JavaScript, non HTML.", NOW()),
    (2, 'alice_smith', "Esatto, HTML si concentra sulla presentazione dei dati e sulla struttura delle pagine.", NOW()),
    (3, 'alice_smith', "In PHP, la connessione a un database coinvolge l'utilizzo di estensioni come MySQLi o PDO. Utilizza le funzioni di connessione appropriate e gestisci le eccezioni per una connessione sicura e robusta.", NOW()),
    (4, 'john_doe', "Puoi validare il codice HTML utilizzando strumenti online come il validatore HTML del W3C. Basta inserire l'URL o incollare direttamente il codice per identificare e correggere eventuali errori.", NOW());
*/