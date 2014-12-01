DROP Table Utilizador;
DROP Table Poll;
DROP Table Question;
DROP Table Choice;
DROP Table Vote;

CREATE TABLE Utilizador (
IdUser Integer PRIMARY KEY AUTOINCREMENT,
Username NVARCHAR2(50) Unique,
Permission Integer,
Pword NVARCHAR2(50) NOT NULL
);

CREATE TABLE Poll(
idPoll Integer PRIMARY KEY AUTOINCREMENT,
idCreator Integer,
FOREIGN KEY(idCreator) references Utilizador(IdUser)
);

CREATE TABLE Question(
idQuestion Integer PRIMARY KEY AUTOINCREMENT,
idPoll Integer,
Qtext NVARCHAR2(50) NOT NULL,
foreign key(idPoll) references Poll(idPoll)
);

CREATE TABLE Choice(
idOption Integer PRIMARY KEY AUTOINCREMENT,
idQuestion Integer,
foreign key(idQuestion) references Question(idQuestion)
);

CREATE TABLE Vote(
idVote Integer PRIMARY KEY AUTOINCREMENT,
idChoice Integer,
idPerson Integer,
foreign key(idChoice) references Utilizador(idUser),
foreign key (idOption) references OPTION(idOption)
);

INSERT INTO Utilizador (Username,Permission,Pword)
	VALUES ('ze' ,'1','pass1');
	
	INSERT INTO Utilizador (Username,Permission,Pword)
	VALUES ('ze' ,'1','pass1');
	
	
