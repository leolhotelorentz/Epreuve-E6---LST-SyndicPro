CREATE TABLE Travaux(
   idTravaux VARCHAR(20),
   libelleTravaux VARCHAR(50) NOT NULL,
   PRIMARY KEY(idTravaux)
);

CREATE TABLE Copropriete(
   idCopropriete VARCHAR(20),
   nomImmeuble VARCHAR(50) NOT NULL,
   rue VARCHAR(50) NOT NULL,
   cp CHAR(5) NOT NULL,
   ville VARCHAR(50),
   PRIMARY KEY(idCopropriete)
);

CREATE TABLE Coproprietaire(
   idCoproprietaire VARCHAR(20),
   civilite VARCHAR(10) NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   rue VARCHAR(50) NOT NULL,
   cp CHAR(5) NOT NULL,
   ville VARCHAR(50) NOT NULL,
   tel CHAR(10) NOT NULL,
   PRIMARY KEY(idCoproprietaire)
);

CREATE TABLE Lot(
   idLot VARCHAR(20),
   localisation VARCHAR(50) NOT NULL,
   tantieme INT NOT NULL,        
   idCoproprietaire VARCHAR(20) NOT NULL,
   idCopropriete VARCHAR(20) NOT NULL,
   PRIMARY KEY(idLot),
   FOREIGN KEY(idCoproprietaire) REFERENCES Coproprietaire(idCoproprietaire),
   FOREIGN KEY(idCopropriete) REFERENCES Copropriete(idCopropriete)
);

CREATE TABLE Prestataire(
   idPrestataire VARCHAR(50),
   nomPrestataire VARCHAR(50) NOT NULL,
   PRIMARY KEY(idPrestataire)
);

CREATE TABLE Devis(
   idDevis VARCHAR(20),
   dateDev DATE NOT NULL,
   MontantTTC DECIMAL(10,2) NOT NULL,
   vote BOOLEAN NOT NULL,
   idTravaux VARCHAR(10) NOT NULL, 
   idCopropriete VARCHAR(20) NOT NULL,
   idPrestataire VARCHAR(50) NOT NULL,
   PRIMARY KEY(idDevis),
   FOREIGN KEY (idTravaux) REFERENCES Travaux(idTravaux),
   FOREIGN KEY(idCopropriete) REFERENCES Copropriete(idCopropriete),
   FOREIGN KEY(idPrestataire) REFERENCES Prestataire(idPrestataire)
);

INSERT INTO Copropriete VALUES
('1', 'Résidence des Pins', '18, av de la Pins', '44000', 'Nantes'),
('2', 'Résidence des Balsamiers', '5, Pl de la résidence', '44000', 'Nantes');

INSERT INTO Coproprietaire VALUES
('1', 'Monsieur', 'MULLER', 'Jean-Marie', '18, av des Pins', '44000', 'Nantes', '0952561926'),
('2', 'Monsieur', 'VIVIAN', 'Christian', '18, av des Pins', '44000', 'Nantes', '0952324920'),
('3', 'Monsieur', 'SAIDJ', 'Simon', '49, rue des chateaux', '49000', 'Angers', '0952375642'),
('4', 'Mlle', 'BEIRUT', 'Virginie', '18, av des Pins', '44000', 'Nantes', '0952528960'),
('5', 'Monsieur', 'HAFID', 'Karim', '18, av des Pins', '44000', 'Nantes', '0952554645');

INSERT INTO Travaux VALUES
('10', 'Rénovation parking'),
('20', 'Réfection toiture'),
('30', 'Ravalement façade');

INSERT INTO Prestataire VALUES
('P1', 'PERTHUIS'),
('P2', 'SMBTP'),
('P3', 'ARDEN BTP'),
('P4', 'HEISS SARL'),
('P5', 'MURANO SA'),
('P6', 'RENOV FAÇADE');

INSERT INTO Devis VALUES
('1479', '2021-05-30', 14500.00, TRUE, '10', '1', 'P1'),
('1480', '2021-05-15', 15000.00, FALSE, '10', '1', 'P2'),
('1481', '2021-05-31', 17000.00, FALSE, '10', '1', 'P3'),
('1482', '2021-06-15', 246000.00, TRUE, '20', '2', 'P4'),
('1483', '2021-06-30', 271000.00, FALSE, '20', '2', 'P5'),
('1484', '2021-06-10', 223000.00, FALSE, '20', '2', 'P3'),
('1485', '2021-10-12', 25000.00, TRUE, '30', '1', 'P6'),
('1486', '2020-10-15', 27000.00, FALSE, '30', '1', 'P2'),
('1487', '2021-10-28', 22000.00, FALSE, '30', '1', 'P3');

INSERT INTO Lot VALUES
('1101', 'RDC coté AV des', 2097, '1', '1'),
('1102', 'REZ DE JARDIN', 1422, '2', '1'),
('1103', 'ETAGE AV DE LA', 1659, '3', '1'),
('1104', 'ETAGE JARDIN', 2222, '4', '1'),
('1105', 'COMBLE', 1400, '2', '1'),
('1106', 'ETAGE JARDIN', 1200, '5', '2');
