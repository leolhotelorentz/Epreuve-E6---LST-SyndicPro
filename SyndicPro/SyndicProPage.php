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
  $Copropriete = getCopropriete($bdd);
  ?>

  <div class="jumbotron">
    <div class="container">
      <section>
        <h1>Liste des copropriétés</h1>
        <div class="row">

          <?php
          foreach ($Copropriete as $uneCopropriete) {
            $idCopropriete = $uneCopropriete['idCopropriete'];
            $nomImmeuble = $uneCopropriete['nomImmeuble'];
            $rue = $uneCopropriete['rue'];
            $cp = $uneCopropriete['cp'];
            $ville = $uneCopropriete['ville'];

          ?>

            <article class="col-md-4">
              <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title"><?php echo "Copropriété numero" . " " . $idCopropriete ?></h5>
                  <p class="card-text"><?php echo "Nom de l'immeuble :" . " " . $nomImmeuble . "<br>" . "Adresse :" . " " . $rue . ", " . $cp . " ". $ville?></p>
                  <a href="SyndicProPageCoproprietaire.php" class="card-link">Voir les copropriétaires</a>
                </div>
              </div>

              <br>
            </article>
          <?php } ?>
        </div>
      </section>
    </div>
  </div>

  <?php include('include/footer.php'); ?>

</body>

</html>