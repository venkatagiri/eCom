-- DDL
CREATE TABLE brands (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(30) NOT NULL,
  description CHAR(250),
  image CHAR(20),
  categories CHAR(50),
  visible INT(1) DEFAULT 1,
  PRIMARY KEY(id)
);

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(30) NOT NULL,
  description CHAR(250),
  image CHAR(20),
  parent_id INT DEFAULT 1,
  visible INT(1) DEFAULT 1,
  PRIMARY KEY(id)
);

CREATE TABLE products (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(50) NOT NULL,
  description TEXT NOT NULL,
  image CHAR(20),
  price INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  brand_id INT NOT NULL,
  category_id INT NOT NULL,
  visible INT(1) DEFAULT 1,
  PRIMARY KEY(id),
  FOREIGN KEY(brand_id) REFERENCES brands(id),
  FOREIGN KEY(category_id) REFERENCES categories(id)
);

-- DML
INSERT INTO categories VALUES(null, 'Root Category', 'The root category', '', 0, 1);
