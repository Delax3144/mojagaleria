-- Создание базы данных
CREATE DATABASE IF NOT EXISTS gallery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Использование базы
USE gallery;

-- Таблица для изображений
CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    keywords TEXT,
    category VARCHAR(100),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
