CREATE TABLE IF NOT EXISTS `session_storage` (
	sessionid BIGINT(20) auto_increment primary key, 
	session_identifier TEXT , 
	session_value LONGTEXT , 
	user_agent TEXT null, 
	date_created DATETIME default CURRENT_TIMESTAMP
);
