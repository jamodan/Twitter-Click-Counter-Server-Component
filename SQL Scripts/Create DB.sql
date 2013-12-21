# Created By : Daniel Jamison

drop schema TwitterClickCounter;

create schema TwitterClickCounter;

use TwitterClickCounter;

create table click_tracker(
ProfileName VARCHAR(20) NOT NULL, 
ClickCount INTEGER,
URL VARCHAR(120) NOT NULL PRIMARY KEY
);