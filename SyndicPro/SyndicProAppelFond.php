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

$bdd = seConnecter();

$coproprietes = getCopropriete($bdd);
$devisVotes = [];
$resultats = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCopropriete'])) {
    $idCopropriete = $_POST['idCopropriete'];
    $devisVotes = getDevisVotesByCopropriete($bdd, $idCopropriete);

    if (isset($_POST['idDevis'])) {
        $idDevis = $_POST['idDevis'];
        $devis = getDevisDetails($bdd, $idDevis);
        $montant = $devis['MontantTTC'];

        $copros = getCoproprietairesEtTantiemes($bdd, $idCopropriete);
        $echeances = [
            'Décembre 2023' => 0.10,
            'Janvier 2024' => 0.30,
            'Mars 2024'    => 0.40,
            'Mai 2024'     => 0.20
        ];

        foreach ($copros as $copro) {
            $montantCopro = round($montant * ($copro['tantieme'] / 10000), 2);

            $ligne = [
                'nom' => $copro['nom'],
                'prenom' => $copro['prenom'],
                'montantTotal' => $montantCopro, 
                'appel' => []
            ];

            foreach ($echeances as $mois => $taux) {
                $appel = round($montantCopro * $taux, 2); 
                $ligne['appel'][$mois] = $appel;
            }
            $resultats[] = $ligne;
        }
    }
}
?>

<div class="jumbotron">
  <div class="container">
    <h1>Appels de fonds par copropriété</h1>

    <form method="POST" class="mb-4">
      <div class="form-group">
        <label for="idCopropriete">Choisissez une copropriété :</label>
        <select name="idCopropriete" id="idCopropriete" class="form-control" onchange="this.form.submit()">
          <option value="">-- Sélectionnez --</option>
          <?php foreach ($coproprietes as $copro): ?>
            <option value="<?= $copro['idCopropriete'] ?>" <?= ($_POST['idCopropriete'] ?? '') == $copro['idCopropriete'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($copro['nomImmeuble']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <?php if (!empty($devisVotes)): ?>
        <div class="form-group">
          <label for="idDevis">Choisissez un devis voté :</label>
          <select name="idDevis" id="idDevis" class="form-control" onchange="this.form.submit()">
            <option value="">-- Sélectionnez --</option>
            <?php foreach ($devisVotes as $devis): ?>
              <option value="<?= $devis['idDevis'] ?>" <?= ($_POST['idDevis'] ?? '') == $devis['idDevis'] ? 'selected' : '' ?>>
                Devis #<?= $devis['idDevis'] ?> - <?= $devis['MontantTTC'] ?> €
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php endif; ?>
    </form>

    <?php if (!empty($resultats)): ?>
      <h3>Appel de fonds pour le devis sélectionné</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Montant Total x tantièmes / 10 000</th> 
            <th>Décembre 2023</th>
            <th>Janvier 2024</th>
            <th>Mars 2024</th>
            <th>Mai 2024</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultats as $ligne): ?>
            <tr>
              <td><?= htmlspecialchars($ligne['nom']) ?></td>
              <td><?= htmlspecialchars($ligne['prenom']) ?></td>
              <td><?= number_format($ligne['montantTotal'], 2, ',', ' ') ?> €</td> 
              <?php foreach ($ligne['appel'] as $mois => $montant): ?>
                <td><?= number_format($montant, 2, ',', ' ') ?> €</td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>
</div>

<?php include('include/footer.php'); ?>

</body>
</html>