/*use this to set up the database*/
CREATE DATABASE IF NOT EXISTS portfolio2;

USE portfolio2;

CREATE TABLE IF NOT EXISTS users(
UserName varchar(255) NOT NULL,
UserPass varchar(255) NOT NULL,
UserPic varchar(255) NOT NULL,
ID int NOT NULL
);

CREATE TABLE IF NOT EXISTS  videos(
creatorID int NOT NULL,
videoPath varchar(255) NOT NULL,
videoName varchar(255) NOT NULL,
videoPic varchar(255) NOT NULL,
videoTags varchar(8) NOT NULL,
uploadDate DATETIME Not NULL
);