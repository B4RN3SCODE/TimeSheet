/* SQL For Snake Charmer Application */

USE SnakeCharmer;

/* NotificationElmType table */
CREATE TABLE NotificationElmType (
	Id INT NOT NULL AUTO_INCREMENT,
	Type VARCHAR(50) NOT NULL,
	Description VARCHAR(200) NULL DEFAULT NULL,
	HtmlTag VARCHAR(20) NULL DEFAULT NULL,
	CloseTag TINYINT(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (Id),
	UNIQUE Type (Type)
) ENGINE = InnoDB;
/* end NotificationElmType table */


/* NotificationElm table */
CREATE TABLE NotificationElm (
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	TypeId INT UNSIGNED NOT NULL DEFAULT '0',
	AccId INT UNSIGNED NOT NULL DEFAULT '0',
	Name VARCHAR(50) NULL DEFAULT NULL,
	ElmId VARCHAR(50) NULL DEFAULT NULL,
	Height VARCHAR(20) NOT NULL DEFAULT '100%',
	Width VARCHAR(20) NOT NULL DEFAULT '100%',
	Style VARCHAR(200) NULL DEFAULT NULL,
	DisplayOrder TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
	InnerHtml TEXT NULL DEFAULT NULL,
	DisplayNotifCount TINYINT(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (Id),
	UNIQUE( TypeId, AccId, Name)
) ENGINE = InnoDB;
/* end NotificationElm table */


/* NotificationElmAttribute table */
CREATE TABLE NotificationElmAttribute (
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	NotificationElmId INT UNSIGNED NOT NULL,
	Attribute VARCHAR(50) NULL DEFAULT NULL,
	Value VARCHAR(200) NULL DEFAULT NULL,
	PRIMARY KEY (Id)
) ENGINE = InnoDB;
/* end NotificationElmAttribute table */


/* NotificationSet table */
CREATE TABLE NotificationSet ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
NotificationElmId INT UNSIGNED NOT NULL,
ThemeId INT UNSIGNED NOT NULL,
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end NotificationSet table */


/* Theme table */
CREATE TABLE Theme ( Id INT NOT NULL AUTO_INCREMENT,
AccId INT NOT NULL DEFAULT '0',
Name VARCHAR(50) NOT NULL,
Description VARCHAR(200) NULL DEFAULT NULL,
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end Theme table */

/* Account table */
CREATE TABLE Account ( Id INT NOT NULL AUTO_INCREMENT,
License VARCHAR(12) NOT NULL,
Domain VARCHAR(100) NOT NULL,
PRIMARY KEY (Id),
UNIQUE License (License),
UNIQUE Domain (Domain) ) ENGINE = InnoDB;
/* end Account table */


/* Page table */
CREATE TABLE Page ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
AccId INT UNSIGNED NOT NULL,
Uri VARCHAR(200) NOT NULL,
IsIndex TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
Active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
Del TINYINT(1) UNSIGNED NOT NULL,
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end Page table */


/* EventType table */
CREATE TABLE EventType ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
Type VARCHAR(50) NOT NULL,
Description VARCHAR(200) NULL DEFAULT NULL,
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end EventType table */


/* Event table */
CREATE TABLE Event ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
AccId INT UNSIGNED NOT NULL DEFAULT '0',
EventTypeId INT UNSIGNED NOT NULL DEFAULT '0',
Name VARCHAR(50) NOT NULL,
Description VARCHAR(200) NULL DEFAULT NULL,
SubjectAttr VARCHAR(20) NULL DEFAULT NULL,
SubjectVal VARCHAR(100) NULL DEFAULT NULL,
Active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
Del TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' ) ENGINE = InnoDB;
/* end Event table */


/* Notification table */
CREATE TABLE Notification ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
Title VARCHAR(100) NULL DEFAULT NULL,
Media VARCHAR(200) NULL DEFAULT NULL,
Body TEXT NULL DEFAULT NULL,
Active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
Del TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end Notification table */


/* Link table */
CREATE TABLE Link ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
AccId INT UNSIGNED NOT NULL DEFAULT '0',
Uri VARCHAR(200) NULL DEFAULT NULL,
Active TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
Del TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end Link table */


/* Action table */
CREATE TABLE Action ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
Name VARCHAR(20) NOT NULL,
Description VARCHAR(200) NULL DEFAULT NULL,
PRIMARY KEY (Id),
UNIQUE Name (Name) ) ENGINE = InnoDB;
/* end Action table */


/* PageEvent table */
CREATE TABLE PageEvent ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
PageId INT UNSIGNED NOT NULL DEFAULT '0',
EventId INT UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end PageEvent table */


/* EventNotification table */
CREATE TABLE EventNotification ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
EventId INT UNSIGNED NOT NULL DEFAULT '0',
NotificationId INT UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end EventNotification table */


/* EventAction table */
CREATE TABLE EventAction ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
EventId INT UNSIGNED NOT NULL DEFAULT '0',
ActionId INT UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end EventAction table */


/* NotificationLink table */
CREATE TABLE NotificationLink ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
NotificationId INT UNSIGNED NOT NULL DEFAULT '0',
LinkId INT UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end NotificationLink table */


/* EventTrigger table */
CREATE TABLE EventTrigger ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
EventId INT UNSIGNED NOT NULL DEFAULT '0',
TimeStamp DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end EventTrigger table */


/* NotificationView table */
CREATE TABLE NotificationView ( Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
NotificationId INT UNSIGNED NOT NULL DEFAULT '0',
TimeStamp DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (Id) ) ENGINE = InnoDB;
/* end NotificationView table */
