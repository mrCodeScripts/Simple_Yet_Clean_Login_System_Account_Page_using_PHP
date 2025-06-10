-- Active: 1741822176111@@127.0.0.1@3306@login_system

DROP DATABASE login_signup_system;

CREATE DATABASE login_signup_system;

use login_signup_system;

CREATE TABLE user_account (
    acc_uuid VARCHAR(255) PRIMARY KEY,
    acc_username VARCHAR(30) NOT NULL UNIQUE,
    acc_password VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE user_info (
    acc_uuid VARCHAR(255) PRIMARY KEY,
    user_profile_img_id VARCHAR(64) UNIQUE,
    user_firstname VARCHAR(50),
    user_lastname VARCHAR(50),
    user_birthdate DATE,
    user_gender_id CHAR(10),
    user_mobile_number VARCHAR(11),
    user_email VARCHAR(50),
    user_weight FLOAT(2),
    user_height FLOAT(2)
);

CREATE TABLE user_profile_img (
    user_profile_img_id VARCHAR(64) PRIMARY KEY,
    user_profile_filepath TEXT,
    user_profile_date_added DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_gender (
    gender_id CHAR(10) PRIMARY KEY,
    gender_name CHAR(20) NOT NULL UNIQUE,
    gender_description TEXT
);

INSERT INTO
    user_gender (
        gender_id,
        gender_name,
        gender_description
    )
VALUES (
        1,
        'Male',
        'Identifies as male'
    ),
    (
        2,
        'Female',
        'Identifies as female'
    );

ALTER TABLE user_info
ADD FOREIGN KEY (acc_uuid) REFERENCES user_account (acc_uuid) ON DELETE CASCADE;

ALTER TABLE user_info
ADD FOREIGN KEY (user_profile_img_id) REFERENCES user_profile_img (user_profile_img_id) ON DELETE CASCADE;

ALTER TABLE user_info
ADD FOREIGN KEY (user_gender_id) REFERENCES user_gender (gender_id);