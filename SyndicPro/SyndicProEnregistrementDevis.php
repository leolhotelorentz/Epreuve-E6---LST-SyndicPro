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
    <h1>Enregistrement du Devis</h1>

    <form method="post">
      <div class="form-group">
        <label for="dateDev">Date du devis :</label>
        <input type="date" class="form-control" id="dateDev" name="dateDev" required>
      </div>

      <div class="form-group">
        <label for="MontantTTC">Montant TTC :</label>
        <input type="number" class="form-control" id="MontantTTC" name="MontantTTC" step="0.01" required>
      </div>

      <div class="form-group">
        <label for="vote">Vote :</label>
        <select class="form-control" name="vote" id="vote" required>
          <option value="1">Approuvé</option>
          <option value="0">Non Approuvé</option>
        </select>
      </div>

      <div class="form-group">
        <label for="idCopropriete">Copropriété :</label>
        <select class="form-control" name="idCopropriete" id="idCopropriete" required>
          <?php
          $copros = getCopropriete($bdd);
          foreach ($copros as $copro) {
            echo "<option value='{$copro['idCopropriete']}'>" . htmlspecialchars($copro['nomImmeuble']) . "</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="idPrestataire">Prestataire :</label>
        <select class="form-control" name="idPrestataire" id="idPrestataire" required>
          <?php
          $prestataires = getPrestataire($bdd);
          foreach ($prestataires as $prest) {
            echo "<option value='{$prest['idPrestataire']}'>" . htmlspecialchars($prest['nomPrestataire']) . "</option>";
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $dateDev = $_POST['dateDev'];
      $MontantTTC = $_POST['MontantTTC'];
      $vote = $_POST['vote'];
      $idCopropriete = $_POST['idCopropriete'];
      $idPrestataire = $_POST['idPrestataire'];

      $resultat = enregistrerDevis($bdd, $dateDev, $MontantTTC, $vote, $idCopropriete, $idPrestataire);

      if ($resultat === true) {
        echo "<div class='alert alert-success'>Devis enregistré avec succès.</div>";
      } else {
        echo "<div class='alert alert-danger'>Erreur : " . htmlspecialchars($resultat) . "</div>";
      }
    }
    ?>
  </div>
</div>


<?php include('include/footer.php'); ?>
</body>
</html>