CREATE DATABASE mangas;
CREATE USER 'manga_user'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON mangas.* TO 'manga_user'@'localhost';
FLUSH PRIVILEGES;