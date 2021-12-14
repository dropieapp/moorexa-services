CREATE TABLE IF NOT EXISTS `payments` (
	paymentsid BIGINT(20) auto_increment primary key
);

ALTER TABLE `payments` CHANGE COLUMN paymentsid paymentid BIGINT(20) auto_increment primary key;
ALTER TABLE `payments` ADD reference VARCHAR(255) AFTER paymentid;
ALTER TABLE `payments` ADD verification LONGTEXT AFTER reference;
ALTER TABLE `payments` ADD datesubmitted INT AFTER verification;
CREATE TABLE IF NOT EXISTS `payments` (
	paymentid BIGINT(20) auto_increment primary key, 
	reference VARCHAR(255) , 
	verification LONGTEXT , 
	datesubmitted INT
);
DROP TABLE `payments`;