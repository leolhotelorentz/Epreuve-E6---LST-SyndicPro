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
      <h1>Calcul des appels de fonds</h1>

      <?php
      if (!empty($_GET['idDevis']) && !empty($_GET['idCopropriete'])) {
        $idDevis = $_GET['idDevis'];
        $idCopropriete = $_GET['idCopropriete'];

        $devis = getMontantDevis($bdd, $idDevis, $idCopropriete);

        if ($devis) {
          $montantTTC = $devis['MontantTTC'];
          $coproprietaires = getCoproprietairesParCopropriete($bdd, $idCopropriete);

          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCoproprietaire = $_POST['idCoproprietaire'];
            $pourcentage = floatval($_POST['pourcentage']);

            if ($pourcentage >= 0 && $pourcentage <= 100) {
              $tantiemes = getTantiemesParCoproprietaire($bdd, $idCoproprietaire);
              $montantAppel = ($montantTTC * $pourcentage / 100) * ($tantiemes / 10000);

              echo "<h4>Résultat de l'appel de fonds</h4>";
              echo "<p><strong>Montant TTC :</strong> " . number_format($montantTTC, 2, ',', ' ') . " €</p>";
              echo "<p><strong>Pourcentage :</strong> $pourcentage %</p>";
              echo "<p><strong>Tantièmes :</strong> $tantiemes</p>";
              echo "<p><strong>Montant appel :</strong> " . number_format($montantAppel, 2, ',', ' ') . " €</p>";
            } else {
              echo "<div class='alert alert-warning'>Le pourcentage doit être entre 0 et 100.</div>";
            }
          } else {
            echo "<form method='POST'>";
            echo "<div class='form-group'>
                    <label for='idCoproprietaire'>Copropriétaire :</label>
                    <select name='idCoproprietaire' class='form-control' required>
                      <option value=''>-- Sélectionnez --</option>";
            foreach ($coproprietaires as $c) {
              echo "<option value='{$c['idCoproprietaire']}'>" . htmlspecialchars($c['nomComplet']) . "</option>";
            }
            echo "  </select>
                  </div>";

            echo "<div class='form-group'>
                    <label for='pourcentage'>Pourcentage d'appel :</label>
                    <input type='number' name='pourcentage' class='form-control' min='0' max='100' step='0.01' required>
                    <br>
                  </div>";

            echo "<button type='submit' class='btn btn-primary'>Calculer</button>
                  </form>";
          }
        } else {
          echo "<div class='alert alert-warning'>Aucun devis trouvé pour cette copropriété.</div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Devis ou copropriété manquant(e).</div>";
      }
      ?>

      <br>
      <a href="SyndicProAffichageDevis.php" class="btn btn-secondary">Retour</a>
    </div>
  </div>

  <?php include('include/footer.php'); ?>

</body>
</html>