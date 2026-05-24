<?php

function seConnecter()
{// port 3306 si mysql et 3307 si mariadb
   $serveur = 'mysql:host=localhost;port=3306';
   $bdd = 'dbname=LST';
   $user = 'root';
   $mdp = '';
   try {
      $pdo = new PDO($serveur . ';' . $bdd . ';charset=UTF8', $user, $mdp);
   } catch (PDOException $e) {
      echo ('Erreur : ' . $e->getMessage());
   }
   return $pdo;
};

function getCopropriete($bdd)
{
    $req = "SELECT * FROM Copropriete";
    $res = $bdd->query($req);
    $lesCopropriete = $res->fetchAll();
    return $lesCopropriete;
}

function getCoproprietaire ($bdd)
{
    $req = "SELECT * FROM Coproprietaire";
    $res = $bdd->query($req);
    $lesCoproprietaire = $res->fetchAll();
    return $lesCoproprietaire;
}

function getPrestataire ($bdd)
{
    $req = "SELECT * FROM Prestataire";
    $res = $bdd->query($req);
    $lesPrestataire = $res->fetchAll();
    return $lesPrestataire;
}

function getLotsByCopropriete($bdd, $idCopropriete) {
    $req = "SELECT Lot.idLot, Lot.localisation, Lot.tantieme, Copropriete.nomImmeuble 
            FROM Lot
            INNER JOIN Copropriete ON Lot.idCopropriete = Copropriete.idCopropriete
            WHERE Lot.idCopropriete = '$idCopropriete'";
    $res = $bdd->query($req);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getLotsByCoproprietaire($bdd, $idCoproprietaire) {
    $req = "SELECT Lot.idLot, Lot.localisation, Lot.tantieme, Copropriete.nomImmeuble 
            FROM Lot
            INNER JOIN Copropriete ON Lot.idCopropriete = Copropriete.idCopropriete
            WHERE Lot.idCoproprietaire = '$idCoproprietaire'";
    $res = $bdd->query($req);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function enregistrerDevis($bdd, $dateDev, $MontantTTC, $vote, $idCopropriete, $idPrestataire) {
    try {
        $req = "SELECT MAX(idDevis) AS max_id FROM Devis";
        $res = $bdd->query($req);
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $newId = $row['max_id'] + 1;

        $req = "INSERT INTO Devis (idDevis, dateDev, MontantTTC, vote, idCopropriete, idPrestataire) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $res = $bdd->prepare($req);
        $res->execute([$newId, $dateDev, $MontantTTC, $vote, $idCopropriete, $idPrestataire]);

        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

function getDevisByCopropriete($bdd, $idCopropriete) {
    $req = "SELECT D.idDevis, D.dateDev, D.MontantTTC, D.vote,
               P.nomPrestataire, T.libelleTravaux
            FROM Devis D
            JOIN Prestataire P ON D.idPrestataire = P.idPrestataire
            JOIN Travaux T ON D.idTravaux = T.idTravaux
            WHERE D.idCopropriete = '$idCopropriete'
            ORDER BY D.dateDev";
    $res = $bdd->query($req);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getDevisDetails($bdd, $idDevis) {
    $req = "SELECT D.*, P.nomPrestataire, C.nomImmeuble, T.libelleTravaux
            FROM Devis D
            JOIN Prestataire P ON D.idPrestataire = P.idPrestataire
            JOIN Copropriete C ON D.idCopropriete = C.idCopropriete
            JOIN Travaux T ON D.idTravaux = T.idTravaux
            WHERE D.idDevis = ?";
    $res = $bdd->prepare($req);
    $res->execute([$idDevis]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function getMontantDevis($bdd, $idDevis, $idCopropriete) {
    $req = "SELECT MontantTTC FROM Devis WHERE idDevis = ? AND idCopropriete = ?";
    $res = $bdd->prepare($req);
    $res->execute([$idDevis, $idCopropriete]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function getCoproprietairesParCopropriete($bdd, $idCopropriete) {
    $req = "SELECT L.idCoproprietaire, CONCAT(C.nom, ' ', C.prenom) AS nomComplet
            FROM Lot L
            JOIN Coproprietaire C ON L.idCoproprietaire = C.idCoproprietaire
            WHERE L.idCopropriete = ?";
    $res = $bdd->prepare($req);
    $res->execute([$idCopropriete]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getTantiemesParCoproprietaire($bdd, $idCoproprietaire) {
    $req = "SELECT SUM(tantieme) AS totalTantiemes FROM Lot WHERE idCoproprietaire = ?";
    $res = $bdd->prepare($req);
    $res->execute([$idCoproprietaire]);
    $result = $res->fetch(PDO::FETCH_ASSOC);
    return $result['totalTantiemes'] ?? 0;
}

function getDevisVotesByCopropriete($bdd, $idCopropriete) {
    $req = "SELECT idDevis, MontantTTC FROM Devis WHERE vote = 1 AND idCopropriete = ?";
    $res = $bdd->prepare($req);
    $res->execute([$idCopropriete]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getCoproprietairesEtTantiemes($bdd, $idCopropriete) {
    $req = "SELECT C.nom, C.prenom, SUM(L.tantieme) as tantieme
            FROM Coproprietaire C
            JOIN Lot L ON C.idCoproprietaire = L.idCoproprietaire
            WHERE L.idCopropriete = ?
            GROUP BY C.idCoproprietaire
            ORDER BY C.nom, C.prenom";
    $res = $bdd->prepare($req);
    $res->execute([$idCopropriete]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}


