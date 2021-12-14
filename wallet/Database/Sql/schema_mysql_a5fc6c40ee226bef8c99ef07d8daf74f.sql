CREATE TABLE IF NOT EXISTS `customer_wallet` (
	walletid BIGINT(20) auto_increment primary key, 
	customerid BIGINT , 
	account_number VARCHAR(255) , 
	wallet_balance FLOAT default 0, 
	wallet_pin VARCHAR(255) , 
	authorization_token VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `customer_wallet_transactions` (
	wallet_transactionid BIGINT(20) auto_increment primary key, 
	walletid BIGINT , 
	amount FLOAT , 
	transactionTypeid INT , 
	narration VARCHAR(255) , 
	date_recorded VARCHAR(255) , 
	statusid VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS `transaction_types` (
	transactionTypeid BIGINT(20) auto_increment primary key, 
	transactionType VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS `wallet_status` (
	statusid BIGINT(20) auto_increment primary key, 
	status VARCHAR(255)
);