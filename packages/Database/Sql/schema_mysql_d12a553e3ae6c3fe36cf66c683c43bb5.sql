CREATE TABLE IF NOT EXISTS `delivery_rates` (
	rateid BIGINT(20) auto_increment primary key, 
	current_day VARCHAR(255) , 
	from_5_7_am VARCHAR(255) , 
	from_7_12_pm VARCHAR(255) , 
	from_12_4_pm VARCHAR(255) , 
	from_4_7_pm VARCHAR(255) , 
	from_7_10_pm VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `coupon_codes` (
	couponid BIGINT(20) auto_increment primary key, 
	coupon_code VARCHAR(255) , 
	discount INT , 
	coupon_title VARCHAR(255) , 
	coupon_description TEXT , 
	isavaliable TINYINT default 1
);