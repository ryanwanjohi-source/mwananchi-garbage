-- schema.sql — the database the team designed, for the W13 project.
-- Import in phpMyAdmin (XAMPP): open phpMyAdmin, click Import, choose
-- this file. It creates the database and the two tables. Then import
-- seed.sql for the starting rows.
-- Two tables: areas holds the collection areas once; bookings holds one
-- row per booking and points at its area with a foreign key (area_id).
CREATE DATABASE IF NOT EXISTS mwananchi_garbage
 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mwananchi_garbage;

CREATE TABLE IF NOT EXISTS areas (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS bookings (
 id INT AUTO_INCREMENT PRIMARY KEY,
 fullname VARCHAR(100) NOT NULL,
 phone VARCHAR(20) NOT NULL,
 area_id INT NOT NULL,
 service VARCHAR(50) NOT NULL,
 notes TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (area_id) REFERENCES areas (id)
);
