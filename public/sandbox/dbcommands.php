<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DB Sandbox</title>
  </head>

  <body>
    <pre>
      sudo mysql -p
      password 123, then toor

      show databases;
      create database pickdb;
      use pickdb;

      create user 'pickuser'@'localhost' identified by '9!(k@f@c3@n6n!(K';
      grant all privileges on *.* to 'pickuser'@'localhost';

      create table users (id int not null auto_increment primary key,
      first_name varchar(100) not null,
      last_name varchar(100) not null,
      username varchar(100) not null,
      email varchar(100) not null,
      password varchar(600) not null,
      type varchar(10) not null,
      comment varchar(100) not null);
    </pre>
  </body>
</html>
