CREATE DATABASE bookmarks_db;
USE bookmarks_db;

CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP
);
