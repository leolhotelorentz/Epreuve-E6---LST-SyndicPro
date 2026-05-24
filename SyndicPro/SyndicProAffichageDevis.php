<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <?php
  include('include/head.php');
  ?>
</head>

<body>

  <?php
  include('include/header.php');
  include('include/nav.php');
  ?>

<div class="jumbotron">
  <div class="container">
    <h1>Afficher les devis</h1>

    <form method="GET" action="">
      <div class="form-group">
        <label for="copro">Copropriété :</label>
        <select name="idCopropriete" id="copro" class="form-control" required>
          <option value="">-- Sélectionner --</option>
          <?php
          $copros = getCopropriete($bdd);
          foreach ($copros as $copro) {
            $selected = ($_GET['idCopropriete'] ?? '') == $copro['idCopropriete'] ? 'selected' : '';
            echo "<option value='{$copro['idCopropriete']}' $selected>" . htmlspecialchars($copro['nomImmeuble']) . "</option>";
          }
          ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Voir</button>
    </form>

    <hr>

    <?php
    if (!empty($_GET['idCopropriete'])) {
      $idCopro = $_GET['idCopropriete'];
      $devis = getDevisByCopropriete($bdd, $idCopro);

      if ($devis) {
        echo "<table class='table table-striped'>
                <thead><tr>
                  <th>ID</th><th>Date</th><th>Travaux</th>
                  <th>Montant</th><th>Prestataire</th><th>Vote</th><th></th>
                </tr></thead><tbody>";

        foreach ($devis as $d) {
          echo "<tr>
                  <td>{$d['idDevis']}</td>
                  <td>{$d['dateDev']}</td>
                  <td>" . htmlspecialchars($d['libelleTravaux']) . "</td>
                  <td>" . number_format($d['MontantTTC'], 2, ',', ' ') . " €</td>
                  <td>" . htmlspecialchars($d['nomPrestataire']) . "</td>
                  <td>" . ($d['vote'] ? 'Oui' : 'Non') . "</td>
                  <td>
                    <form method='POST' action='SyndicProDevisChoisit.php'>
                      <input type='hidden' name='idDevis' value='{$d['idDevis']}'>
                      <button class='btn btn-success'>Choisir</button>
                    </form>
                  </td>
                </tr>";
        }

        echo "</tbody></table>";
      } else {
        echo "<div class='alert alert-info'>Aucun devis trouvé.</div>";
      }
    }
    ?>
  </div>
</div>

  <?php include('include/footer.php'); ?>

</body>

</html>