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
ClosedPoll BOOLEAN NOT NULL DEFAULT FALSE,
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
	('2' ,'Poll3','http://i.imgur.com/YbsUWRR.jpg','private'),
	('2' ,'Again we go','http://i.imgur.com/YbsUWRR.jpg','public');
	
INSERT INTO Question (PollId, Text) VALUES
	('1' ,'What would you be doing if you were not here right now?'),
	('1' ,'If you could choose any era to live in, what would it be?'),
	('1' ,'What is your favorite holiday?'),
	('2' ,'Quest1'),
	('2' ,'Quest2'),
	('3' ,'Quest1'),
	('4' ,'All is good?');
	
INSERT INTO Answer (QuestionId, Text) VALUES
	('1' ,'The mill rates the slave.'),
	('1' ,'Without the screen farms a round dragon.'),
	('1' ,'How will the component fiddle opposite a designed valley?'),
	('2' ,'The summer undesirable waves.'),
	('2' ,'A diet prevails above an aided editorial.'),
	('2' ,'A dubious flour obsesses a visitor with the afraid complaint.'),
	('3' ,'Christmas.'),
	('3' ,'Christmas.'),
	('3' ,'Christmas.'),
	('4' ,'A6'),
	('5' ,'A8'),
	('6' ,'A9'),
	('7' ,'Yes'),
	('7' ,'No');
	
INSERT INTO UtilizadorAnswer (idUtilizador, idAnswer, idPoll) VALUES
	('1' ,'1', '1'),
	('1' ,'4', '1'),
	('1' ,'7', '1'),
	('3' ,'2', '1'),
	('3' ,'5', '1'),
	('3' ,'8', '1'),
	('2' ,'1', '1'),	
	('3' ,'13', '4');

INSERT INTO Utilizador (Username,Permission,Pword)
	VALUES ('ZE' ,'1','a722c63db8ec8625af6cf71cb8c2d939'),
	('JOAO' ,'2','c1572d05424d0ecb2a65ec6a82aeacbf'),
	('SARA' ,'3','de90022ef728b7f0f6ff92e5d6a90200');
	
CREATE TRIGGER delete_poll
	BEFORE DELETE ON Poll
	FOR EACH row 
	begin 
	delete from Question where Question.PollId= Old.Id;
	delete from UtilizadorAnswer where UtilizadorAnswer.idPoll= Old.Id;
	end;

CREATE TRIGGER delete_question
	BEFORE DELETE ON Question
	FOR EACH row begin delete from Answer where Answer.QuestionId= Old.Id;
	end;