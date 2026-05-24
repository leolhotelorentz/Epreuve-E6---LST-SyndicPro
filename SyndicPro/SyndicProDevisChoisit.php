<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <?php include('include/head.php'); ?>
</head>

<body>

  <?php
  include('include/header.php');
  include('include/nav.php');
  ?>

<div class="jumbotron">
    <div class="container">
      <h1>Détail du devis sélectionné</h1>

      <?php
      if (!empty($_POST['idDevis'])) {
        $idDevis = $_POST['idDevis'];
        $devis = getDevisDetails($bdd, $idDevis);

        if ($devis) {
          echo "
            <div class='card'>
              <div class='card-body'>
                <h4 class='card-title'>Devis n° {$devis['idDevis']}</h4>
                <p><strong>Date :</strong> {$devis['dateDev']}</p>
                <p><strong>Montant TTC :</strong> " . number_format($devis['MontantTTC'], 2, ',', ' ') . " €</p>
                <p><strong>Travaux :</strong> " . htmlspecialchars($devis['libelleTravaux']) . "</p>
                <p><strong>Vote :</strong> " . ($devis['vote'] ? 'Approuvé' : 'Non Approuvé') . "</p>
                <p><strong>Copropriété :</strong> " . htmlspecialchars($devis['nomImmeuble']) . "</p>
                <p><strong>Prestataire :</strong> " . htmlspecialchars($devis['nomPrestataire']) . "</p>
              </div>
            </div>
            <br>
            <a href='SyndicProCalculerFond.php?idDevis={$devis['idDevis']}&idCopropriete={$devis['idCopropriete']}' class='btn btn-primary'>Calculer les fonds </a>
          ";
        } else {
          echo "<div class='alert alert-warning'>Aucun devis trouvé. </div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Aucun devis sélectionné.</div>";
      }
      ?>

      <br><br>
      <a href="SyndicProAffichageDevis.php" class="btn btn-secondary">Retour</a>
    </div>
  </div>

  <?php include('include/footer.php'); ?>

</body>
</html>