DROP Table Utilizador;
DROP Table Poll;
DROP Table Question;
DROP Table Answer;
DROP Table UtilizadorPoll;

CREATE TABLE Utilizador (
IdUser Integer PRIMARY KEY AUTOINCREMENT,
Username NVARCHAR2(50) Unique NOT NULL,
Permission Integer,
Pword NVARCHAR2(50) NOT NULL
);

CREATE TABLE Poll (
Id Integer PRIMARY KEY AUTOINCREMENT,
Owner Integer NOT NULL,
Title NVARCHAR2(50) Unique NOT NULL,
PrivatePoll BOOLEAN NOT NULL,
FOREIGN KEY (Owner) REFERENCES Utilizador(IdUser)
);

CREATE TABLE Question (
Id Integer PRIMARY KEY AUTOINCREMENT,
PollId Integer NOT NULL REFERENCES Poll(Id),
Text NVARCHAR2(250) NOT NULL
);

CREATE TABLE Answer (
Id Integer PRIMARY KEY AUTOINCREMENT,
QuestionId Integer NOT NULL REFERENCES Question(Id),
Text NVARCHAR2(250) NOT NULL,
VotesCount Integer 
);

/* Utilizadores que responderam a Poll */
CREATE TABLE UtilizadorPoll (
 idUtilizador Integer references Utilizador(IdUser),
 idPoll Integer references Poll(Id),
 primary key (idUtilizador, idPoll)
);

INSERT INTO Poll (Owner,Title,PrivatePoll) VALUES
	('1' ,'Poll1','0'),
	('1' ,'Poll2','0'),
	('1' ,'Poll3','0');
	
INSERT INTO Question (PollId, Text) VALUES
	('1' ,'Quest1'),
	('1' ,'Quest2'),
	('1' ,'Quest3'),
	('2' ,'Quest1'),
	('2' ,'Quest2'),
	('3' ,'Quest1');
	
INSERT INTO Answer (QuestionId, Text, VotesCount) VALUES
	('1' ,'A1','0'),
	('1' ,'A2','0'),
	('1' ,'A3','0'),
	('2' ,'A4','0'),
	('3' ,'A5','0'),
	('4' ,'A6','0'),
	('5' ,'A8','0'),
	('6' ,'A9','0');
	
INSERT INTO UtilizadorPoll (idUtilizador, idPoll) VALUES
	('1' ,'1'),
	('1' ,'2');

INSERT INTO Utilizador (Username,Permission,Pword)
	VALUES ('ze' ,'1','pass1'),
	('Joao' ,'2','pass2'),
	('Sara' ,'3','linhaspaiva');