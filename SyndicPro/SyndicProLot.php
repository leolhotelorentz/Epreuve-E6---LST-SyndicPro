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
   <h1>Affichage des lots</h1>

   <?php
   $coproprietes = getCopropriete($bdd);
   $coproprietaires = getCoproprietaire($bdd);
   $lots = [];
   $titre = '';

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choix'])) {
       if ($_POST['choix'] === 'copropriete' && !empty($_POST['copropriete'])) {
           $idCopropriete = $_POST['copropriete'];
           $lots = getLotsByCopropriete($bdd, $idCopropriete);
           $titre = "Lots pour la copropriété sélectionnée :";
       } elseif ($_POST['choix'] === 'coproprietaire' && !empty($_POST['coproprietaire'])) {
           $idCoproprietaire = $_POST['coproprietaire'];
           $lots = getLotsByCoproprietaire($bdd, $idCoproprietaire);
           $titre = "Lots pour le copropriétaire sélectionné :";
       }
   }
   ?>

   <form method="POST" class="mb-4">
     <div class="form-group">
       <label for="choix">Choisissez un critère :</label>
       <select name="choix" id="choix" class="form-control" onchange="this.form.submit()">
         <option value="">-- Choisissez un critère --</option>
         <option value="copropriete" <?= ($_POST['choix'] ?? '') === 'copropriete' ? 'selected' : '' ?>>Par Copropriété</option>
         <option value="coproprietaire" <?= ($_POST['choix'] ?? '') === 'coproprietaire' ? 'selected' : '' ?>>Par Copropriétaire</option>
       </select>
     </div>

     <?php if (($_POST['choix'] ?? '') === 'copropriete'): ?>
     <div class="form-group">
       <label for="copropriete">Choisissez une copropriété :</label>
       <select name="copropriete" id="copropriete" class="form-control" onchange="this.form.submit()">
         <?php foreach ($coproprietes as $copro): ?>
           <option value="<?= $copro['idCopropriete'] ?>" <?= (($_POST['copropriete'] ?? '') == $copro['idCopropriete']) ? 'selected' : '' ?>>
             <?= htmlspecialchars($copro['nomImmeuble']) ?>
           </option>
         <?php endforeach; ?>
       </select>
     </div>
     <?php endif; ?>

     <?php if (($_POST['choix'] ?? '') === 'coproprietaire'): ?>
     <div class="form-group">
       <label for="coproprietaire">Choisissez un copropriétaire :</label>
       <select name="coproprietaire" id="coproprietaire" class="form-control" onchange="this.form.submit()">
         <?php foreach ($coproprietaires as $copro): ?>
           <option value="<?= $copro['idCoproprietaire'] ?>" <?= (($_POST['coproprietaire'] ?? '') == $copro['idCoproprietaire']) ? 'selected' : '' ?>>
             <?= htmlspecialchars($copro['prenom'] . ' ' . $copro['nom']) ?>
           </option>
         <?php endforeach; ?>
       </select>
     </div>
     <?php endif; ?>
   </form>

   <?php if (!empty($lots)): ?>
     <h3><?= $titre ?></h3>
     <table class="table table-bordered table-striped">
       <thead>
         <tr>
           <th>ID Lot</th>
           <th>Localisation</th>
           <th>Tantième</th>
           <th>Nom Immeuble</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($lots as $lot): ?>
           <tr>
             <td><?= htmlspecialchars($lot['idLot']) ?></td>
             <td><?= htmlspecialchars($lot['localisation']) ?></td>
             <td><?= htmlspecialchars($lot['tantieme']) ?></td>
             <td><?= htmlspecialchars($lot['nomImmeuble']) ?></td>
           </tr>
         <?php endforeach; ?>
       </tbody>
     </table>
   <?php endif; ?>

   <br>
   <a href="index.php" class="btn btn-secondary">Retour</a>
 </div>
</div>

<?php include('include/footer.php'); ?>

</body>

</html>