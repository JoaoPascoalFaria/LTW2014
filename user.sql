DROP Table Utilizador;

CREATE TABLE Utilizador (
IdUser Integer PRIMARY KEY AUTO_INCREMENT,
Username NVARCHAR2(50) Unique,
Permission Integer,
Pword NVARCHAR2(50) NOT NULL
);

INSERT INTO Utilizador (Username,Permission,Pword)
	VALUES ('ze' ,'1','pass1'),
	('Joao' ,'2','pass2'),
	('Sara' ,'3','linhaspaiva');