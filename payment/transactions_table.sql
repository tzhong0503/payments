create database payments;

use payments;

drop table transactions;

select * from transactions;

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Revpay_Merchant_ID VARCHAR(255),
    Reference_Number VARCHAR(255),
    Amount DECIMAL(10, 2),
    Currency VARCHAR(10),
    Transaction_Description VARCHAR(255),
    Return_URL VARCHAR(255),
    Key_Index INT,
    Signature VARCHAR(255),
    Response_Code VARCHAR(255),
    Transaction_ID VARCHAR(255),
    Payment_ID VARCHAR(255),
    Request_DateTime DATETIME,
    Response_DateTime DATETIME
);
