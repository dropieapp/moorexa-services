CREATE TABLE IF NOT EXISTS `security_questions` (
	security_questionid BIGINT(20) auto_increment primary key, 
	security_question VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `account_services` (
	account_serviceid BIGINT(20) auto_increment primary key, 
	service_name VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS `customer_services` (
	customer_serviceid BIGINT(20) auto_increment primary key, 
	customerid INT , 
	serviceid INT , 
	isenabled TINYINT default 1
);
CREATE TABLE IF NOT EXISTS `customer_downlines` (
	customer_downlineid BIGINT(20) auto_increment primary key, 
	customerid BIGINT , 
	downlineid BIGINT , 
	transactions INT default 0, 
	bonus_earned FLOAT default 0, 
	time_registered VARCHAR(255)
);