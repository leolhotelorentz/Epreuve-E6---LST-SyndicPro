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
  $Coproprietaire = getCoproprietaire($bdd);
  ?>

  <div class="jumbotron">
    <div class="container">
      <section>
        <h1>Liste des copropriétaires</h1>
        <div class="row">

          <?php
          foreach ($Coproprietaire as $unCoproprietaire) {
            $idCoproprietaire = $unCoproprietaire['idCoproprietaire'];
            $civilite = $unCoproprietaire['civilite'];
            $nom = $unCoproprietaire['nom'];
            $prenom = $unCoproprietaire['prenom'];
            $rue = $unCoproprietaire['rue'];
            $cp = $unCoproprietaire['cp'];
            $ville = $unCoproprietaire['ville'];
            $tel = $unCoproprietaire['tel'];

          ?>

            <article class="col-md-4">
              <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title"><?php echo "Copropriétaire numero" . " " . $idCoproprietaire ?></h5>
                  <p class="card-text"><?php echo "civilité :" . " " . $civilite . "<br>" . "Nom :" . " " . $nom . "<br>" . "Prenom :" . " " . $prenom . "<br>" . "Adresse :" . " " . $rue . ", " . $cp . " ". $ville . "<br>" . "Telephone :" . " " . $tel ?></p>

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