CREATE TABLE MY_TABLE (
  id INT,
  Email VARCHAR,
  FirstName VARCHAR,
  LastName VARCHAR,
  AccountType INT,
  Password VARCHAR,
  DateAdded DATETIME,
  LastModified DATETIME,
  Phone VARCHAR,
  Active TINYINT,
  Restriction INT,
  Online TINYINT
);
INSERT INTO MY_TABLE(id, Email, FirstName, LastName, AccountType, Password, DateAdded, LastModified, Phone, Active, Restriction, Online) VALUES (1, 'tbarnes@arbsol.com', 'Tyler', 'Barnes', 1, '$2y$10$pbClvD.OBOoeLBnM5WLhPu3Xhh.7DPHxTRgTKPJOe.XcFiiLt2O1K', '2015-10-08 21:23:51', '2015-10-30 17:19:15', '6195773861', 1, 0, 1);
INSERT INTO MY_TABLE(id, Email, FirstName, LastName, AccountType, Password, DateAdded, LastModified, Phone, Active, Restriction, Online) VALUES (2, 'cschaefer@arbsol.com', 'Chris', 'Schaefer', 1, '$2y$10$PtSBL5gNiq.6vC9pRWj5DO4VM80eDjZLmGJSxoqSwZJR4eebmamfe', '2015-10-28 15:04:45', '2015-11-07 03:54:43', '2489829600', 1, 0, 0);
INSERT INTO MY_TABLE(id, Email, FirstName, LastName, AccountType, Password, DateAdded, LastModified, Phone, Active, Restriction, Online) VALUES (10, 'spalma@arbsol.com', 'Scott', 'Palma', 1, '$2y$10$lVLA3vKDBMmrqubrogND9u2AoICD0/ItBH1b3rmg/dkiFfEglBFzK', '2015-11-02 13:58:27', '2015-11-02 13:58:27', '6166901728', 1, 0, null);
INSERT INTO MY_TABLE(id, Email, FirstName, LastName, AccountType, Password, DateAdded, LastModified, Phone, Active, Restriction, Online) VALUES (11, 'rpalma@arbsol.com', 'Richie', 'Palma', 1, '$2y$10$dnN0MG7qjMuqKrsOj/DtG.snRT4lRrhbnxSFXerjfq1VwDx1xJNcm', '2015-11-04 14:13:45', '2015-11-07 03:57:35', '', 1, 0, 0);