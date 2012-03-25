-- DDL
CREATE TABLE brands (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(30) NOT NULL,
  `key` CHAR(30) NOT NULL,
  description CHAR(250),
  image CHAR(20),
  categories CHAR(50),
  visible INT(1) DEFAULT 1,
  PRIMARY KEY(id),
  UNIQUE(`key`)
);

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(30) NOT NULL,
  `key` CHAR(30) NOT NULL,
  description CHAR(250),
  image CHAR(20),
  parent_id INT DEFAULT 1,
  visible INT(1) DEFAULT 1,
  PRIMARY KEY(id),
  UNIQUE(`key`)
);

CREATE TABLE products (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(50) NOT NULL,
  `key` CHAR(50) NOT NULL,
  short_description CHAR(250) NOT NULL,
  description TEXT NOT NULL,
  image CHAR(20),
  price INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  brand_id INT NOT NULL,
  category_id INT NOT NULL,
  date_created DATETIME NOT NULL,
  date_modified DATETIME NOT NULL,
  status INT(1) DEFAULT 1,
  PRIMARY KEY(id),
  UNIQUE(`key`),
  FOREIGN KEY(brand_id) REFERENCES brands(id),
  FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE banners (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(50) NOT NULL,
  type INT NOT NULL,
  category_id INT DEFAULT 0,
  image CHAR(20) NOT NULL,
  link CHAR(100) NOT NULL,
  width INT NOT NULL,
  height INT NOT NULL,
  date_created DATETIME NOT NULL,
  date_modified DATETIME NOT NULL,
  visible INT(1) DEFAULT 1,
  PRIMARY KEY(id),
  FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE attributes (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(50) NOT NULL,
  group_id INT NOT NULL DEFAULT 1,
  PRIMARY KEY(id)
);

CREATE TABLE product_attributes (
  id INT NOT NULL AUTO_INCREMENT,
  product_id INT NOT NULL,
  attribute_id INT NOT NULL,
  group_id INT NOT NULL,
  name CHAR(50) NOT NULL,
  value CHAR(50) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(product_id) REFERENCES products(id),
  FOREIGN KEY(attribute_id) REFERENCES attributes(id)
);

CREATE TABLE product_features (
  id INT NOT NULL AUTO_INCREMENT,
  product_id INT NOT NULL,
  value CHAR(50) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(product_id) REFERENCES products(id)
);

CREATE TABLE customers (
  id INT NOT NULL AUTO_INCREMENT,
  email VARCHAR(96) NOT NULL,
  password VARCHAR(60) NOT NULL,
  first_name VARCHAR(32) NOT NULL DEFAULT '',
  last_name VARCHAR(32) NOT NULL DEFAULT '',
  address_1 VARCHAR(128) NOT NULL,
  address_2 VARCHAR(128) NOT NULL,
  city VARCHAR(128) NOT NULL,
  state VARCHAR(128) NOT NULL,
  pincode VARCHAR(10) NOT NULL,
  country VARCHAR(128) NOT NULL,
  telephone VARCHAR(32) NOT NULL,
  status INT(1) NOT NULL,
  date_created DATETIME NOT NULL,
  date_modified DATETIME NOT NULL,
  PRIMARY KEY(id),
  UNIQUE(email)
);

CREATE TABLE orders (
  id INT NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  customer_name VARCHAR(32) NOT NULL,
  customer_address TEXT NOT NULL,
  customer_email VARCHAR(96) NOT NULL,
  customer_telephone VARCHAR(32) NOT NULL,
  no_of_products INT(2) NOT NULL DEFAULT 1,
  total_amount DECIMAL(15, 2) NOT NULL DEFAULT '0.00',
  status INT(1) NOT NULL,
  date_created DATETIME NOT NULL,
  date_modified DATETIME NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(customer_id) REFERENCES customers(id)
);

CREATE TABLE order_products (
  id INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  name CHAR(50) NOT NULL,
  price INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  FOREIGN KEY(order_id) REFERENCES orders(id),
  FOREIGN KEY(product_id) REFERENCES products(id),
  PRIMARY KEY(id)
);

-- TRIGGERS
CREATE TRIGGER product_created 
BEFORE INSERT ON products 
FOR EACH ROW
SET NEW.date_created = NOW(), NEW.date_modified = NOW();
CREATE TRIGGER product_modified
BEFORE UPDATE ON products 
FOR EACH ROW
SET NEW.date_created = OLD.date_created, NEW.date_modified = NOW();

CREATE TRIGGER banner_created
BEFORE INSERT ON banners 
FOR EACH ROW
SET NEW.date_created = NOW(), NEW.date_modified = NOW();
CREATE TRIGGER banner_modified
BEFORE UPDATE ON banners 
FOR EACH ROW
SET NEW.date_created = OLD.date_created, NEW.date_modified = NOW();

CREATE TRIGGER order_created
BEFORE INSERT ON orders
FOR EACH ROW
SET NEW.date_created = NOW(), NEW.date_modified = NOW();
CREATE TRIGGER order_modified
BEFORE UPDATE ON orders
FOR EACH ROW
SET NEW.date_created = OLD.date_created, NEW.date_modified = NOW();

CREATE TRIGGER customer_created
BEFORE INSERT ON customers
FOR EACH ROW
SET NEW.date_created = NOW(), NEW.date_modified = NOW();
CREATE TRIGGER customer_modified
BEFORE UPDATE ON customers
FOR EACH ROW
SET NEW.date_created = OLD.date_created, NEW.date_modified = NOW();

-- DML
INSERT INTO categories VALUES(null, 'Root Category', 'root-category', 'The root category', '', 0, 1);
INSERT INTO attributes VALUES(null, 'Root Group', 0);
