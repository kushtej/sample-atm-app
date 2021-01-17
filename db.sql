-- DROP DATABASE IF EXISTS atm;
-- CREATE DATABASE atm;
USE sql12386553;
CREATE TABLE user
(
        -- acc_id int auto_increment primary key,
		acc_number BIGINT primary key,
		first_name varchar(30) not null,
        last_name varchar(30) not null,
		pin varchar(6) not null,
		email varchar(30) not null,
		created_at timestamp default now()	
);

-- INSERT INTO user (acc_number,first_name,last_name,pin,email)
-- 			VALUES(20210115103332,'John','Smith','1234','johnsmith@example.com');

INSERT INTO user (acc_number,first_name,last_name,pin,email)
			VALUES(1,'John','Smith','1111','johnsmith@example.com');

CREATE TABLE transaction
(
		transaction_id int auto_increment primary key,
		acc_number BIGINT not null,
		initail_balence  BIGINT,
		transaction_amt  BIGINT,
		current_balence BIGINT,
		transaction_statement varchar(30) not null,
		created_at timestamp default now(),
		foreign key(acc_number) references user(acc_number) on delete cascade	 
);

-- INSERT INTO transaction (acc_number,initail_balence,transaction_amt,current_balence,transaction_statement)
-- 		VALUES(20210115103332,0,10000,10000,'Deposit');

INSERT INTO transaction (acc_number,initail_balence,transaction_amt,current_balence,transaction_statement)
		VALUES(1,0,10000,10000,'Deposit');
