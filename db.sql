---
-----create tables for "accounts"
---
CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `accounts` (`id`, `username`, `password`, `email`) 
VALUES (1, 'test', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'test@test.com');




---
----create tables for "tblporters"
---

CREATE TABLE tblporters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    national_id VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    station VARCHAR(255) NOT NULL,
    bank_name VARCHAR(255) NOT NULL,
    bank_account VARCHAR(255) NOT NULL,
    branch VARCHAR(255) NOT NULL
);

---
----dumped data for "tblporters"
---

INSERT INTO tblporters (name, national_id, phone, station, bank_name, bank_account, branch)
VALUES
    ('Porter 1', '123456789', '1234567890', 'Station 1', 'Bank A', '1234567890', 'Branch A'),
    ('Porter 2', '987654321', '9876543210', 'Station 2', 'Bank B', '9876543210', 'Branch B'),
    ('Porter 3', '456789123', '4567891230', 'Station 3', 'Bank C', '4567891230', 'Branch C');



--
----Create tables for "milk_receipt" for a daily 
--

CREATE TABLE milk_receipt (
  id INT PRIMARY KEY AUTO_INCREMENT,
  porter_name VARCHAR(255),
  farmer_name VARCHAR(255),
  morning_milk_quantity DECIMAL(10, 2),
  evening_milk_quantity DECIMAL(10, 2),
  total_milk_quantity DECIMAL(10, 2),
  date DATE
);



--
------dummy data for milk_receipt
--

INSERT INTO milk_receipt (porter_name, farmer_name, morning_milk_quantity, evening_milk_quantity, total_milk_quantity, date)
VALUES
('John', 'Farmer A', 10.5, 12.3, 22.8, '2023-05-23'),
('John', 'Farmer B', 8.2, 9.5, 17.7, '2023-05-23'),
('Sarah', 'Farmer C', 6.7, 7.8, 14.5, '2023-05-23');


------------------------------------------------------------------------------------------------------------------------------------------


--
----Create tables for "milk_farmer_receipt" for a daily delivery
--

CREATE TABLE milk_receipt_farmers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  receipt_id INT,
  farmer_name VARCHAR(255),
  morning_milk_quantity DECIMAL(10, 2),
  evening_milk_quantity DECIMAL(10, 2),
  FOREIGN KEY (receipt_id) REFERENCES milk_receipt(id)
);


