-- SQL file for Laptop Shop Management System
-- Database: LaptopShopDB
-- Table: laptops

-- Create database
CREATE DATABASE IF NOT EXISTS `LaptopShopDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `LaptopShopDB`;

-- Create laptops table for laptop data
CREATE TABLE IF NOT EXISTS `laptops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `cpu` varchar(150) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO `laptops` (`brand`, `model`, `cpu`, `price`) VALUES
('Dell', 'XPS 15', 'Intel Core i7', 35000000),
('Apple', 'Macbook Pro 14', 'Apple M2 Pro', 50000000),
('HP', 'Spectre x360', 'Intel Core i5', 28000000),
('Lenovo', 'ThinkPad X1 Carbon', 'Intel Core i7', 42000000),
('Asus', 'ROG Zephyrus G14', 'AMD Ryzen 9', 48000000),
('Microsoft', 'Surface Laptop 5', 'Intel Core i5', 31000000),
('Acer', 'Predator Helios 300', 'Intel Core i9', 55000000);
