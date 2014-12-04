DROP Table Utilizador;
DROP Table Poll;
DROP Table Question;
DROP Table Answer;
DROP Table UtilizadorAnswer;

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
Image NVARCHAR2(300) NOT NULL,
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
Text NVARCHAR2(250) NOT NULL
);

/* Utilizadores que responderam a Poll */
CREATE TABLE UtilizadorAnswer (
 idUtilizador Integer references Utilizador(IdUser),
 idAnswer Integer references Answer(Id),
 idPoll INTEGER references Poll(Id),
 primary key (idUtilizador, idAnswer)
);

INSERT INTO Poll (Owner,Title,Image,PrivatePoll) VALUES
	('1' ,'Poll1','http://i.imgur.com/C9EXH62.jpg','public'),
	('1' ,'Poll2','http://i.imgur.com/nScazCd.jpg','public'),
	('1' ,'Poll3','http://i.imgur.com/YbsUWRR.jpg','private');
	
INSERT INTO Question (PollId, Text) VALUES
	('1' ,'Quest1'),
	('1' ,'Quest2'),
	('1' ,'Quest3'),
	('2' ,'Quest1'),
	('2' ,'Quest2'),
	('3' ,'Quest1');
	
INSERT INTO Answer (QuestionId, Text) VALUES
	('1' ,'A1'),
	('1' ,'A2'),
	('1' ,'A3'),
	('2' ,'A4'),
	('3' ,'A5'),
	('4' ,'A6'),
	('5' ,'A8'),
	('6' ,'A9');
	
INSERT INTO UtilizadorAnswer (idUtilizador, idAnswer, idPoll) VALUES
	('1' ,'1', '1'),
	('1' ,'2', '1');

INSERT INTO Utilizador (Username,Permission,Pword)
	VALUES ('ZE' ,'1','a722c63db8ec8625af6cf71cb8c2d939'),
	('JOAO' ,'2','c1572d05424d0ecb2a65ec6a82aeacbf'),
	('SARA' ,'3','de90022ef728b7f0f6ff92e5d6a90200');