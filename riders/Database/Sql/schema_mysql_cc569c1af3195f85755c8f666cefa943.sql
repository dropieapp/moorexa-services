CREATE TABLE IF NOT EXISTS `drivers_rating` (
	drivers_ratingid BIGINT(20) auto_increment primary key, 
	customerid BIGINT , 
	rating FLOAT , 
	public_comment TEXT , 
	sender_fullname VARCHAR(255) , 
	sender_phonenumber VARCHAR(255) , 
	date_submitted VARCHAR(255)
);
