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
  description TEXT NOT NULL,
  image CHAR(20),
  price INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  brand_id INT NOT NULL,
  category_id INT NOT NULL,
  date_created DATETIME NOT NULL,
  date_modified DATETIME NOT NULL,
  visible INT(1) DEFAULT 1,
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

-- DML
INSERT INTO categories VALUES(null, 'Root Category', 'root-category', 'The root category', '', 0, 1);
INSERT INTO attributes VALUES(null, 'Root Group', 0);
