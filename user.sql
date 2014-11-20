DROP Table Utilizador;

CREATE TABLE Utilizador (
IdUser Integer PRIMARY KEY,
Username NVARCHAR2(50) Unique,
Permission Integer,
Pword NVARCHAR2(50) NOT NULL
);

INSERT INTO Utilizador (IdUser,Username,Permission,Pword)
	VALUES ('1','ze' ,'1','pass1'),
	('2','Joao' ,'2','pass2'),
	('3','Nelson' ,'3','pass3');