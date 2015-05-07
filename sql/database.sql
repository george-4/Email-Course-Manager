CREATE TABLE student (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
	email VARCHAR(50),
	cycle_id INT,
	lessons_received TINYINT,
	date_added DATE
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


CREATE TABLE _cycle_ (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	startdate DATE,
	lessons_sent TINYINT NOT NULL DEFAULT '0',
	active BOOLEAN NOT NULL DEFAULT '1'
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;