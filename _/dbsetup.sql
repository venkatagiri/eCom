-- DDL
create table brands (
	id int NOT NULL AUTO_INCREMENT,
	name char(30) NOT NULL,
	categories text,
	visible int(1) DEFAULT 1,
	PRIMARY KEY(id),
	UNIQUE(name)
);

CREATE TABLE categories (
	id int NOT NULL AUTO_INCREMENT,
	name char(30) NOT NULL,
	description CHAR(250),
	parent_id int DEFAULT 0,
	visible int(1) DEFAULT 1,
	PRIMARY KEY(id)
);

CREATE TABLE products (
  id INT NOT NULL AUTO_INCREMENT,
  name CHAR(50) NOT NULL,
  description CHAR(250) NOT NULL,
  price INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  brand CHAR(30) NOT NULL,
  category CHAR(30) NOT NULL,
  visible int(1) DEFAULT 1,
  PRIMARY KEY(id),
  FOREIGN KEY(brand) REFERENCES brands(name),
  FOREIGN KEY(category) REFERENCES categories(name)
);
