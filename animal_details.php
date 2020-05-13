<?php
// Imports
include_once 'constants_inc.php';
include_once 'db_connect_inc.php'; // Connexion à PDO
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<?php include('nav_visitors.php'); ?>

<body>
  <div class="container p-5">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <?php
          $sql = 'SELECT * from animal WHERE id=' . $_GET['id'];
          $data = $pdo->prepare($sql);
          $data->execute();
          $animal = $data->fetch();
          $html = '';
          $html .= '<img class="card-img-top" src="' . $animal['photo'] . '"alt="...">';
          $html .= '<div class="card-body">';
          $html .= '<h5 class="card-title">' . $animal['nom'] . '</h5>';
          $html .= '<p class="card-text">Sexe : ' . $animal['sexe'] . '</p>';
          $html .= '<p class="card-text">Vacciné : ' . $animal['vaccine'] . '</p>';
          $html .= '<p class="card-text">Identifié : ' . $animal['identifie'] . '</p>';
          $html .= '<p class="card-text">Description : ' . $animal['description'] . '</p>';
          $html .= '<p class="card-text">Prix : ' . $animal['prix'] . '€</p>';
          $html .= '<p class="card-text">Disponibilité : ' . $animal['disponibilite'] . '</p>';
          $html .= '<p class="card-text">Poids : ' . $animal['poids'] . '</p>';
          $html .= '<p class="card-text">Couleur : ' . $animal['couleur'] . '</p>';
          $html .= '<p class="card-text">Date de naissance : ' . $animal['ddn'] . '</p> </div></div></div>';
          $html .= '<div class="col-md-4">';
          $html .= '<div class="card">';
          $html .= '<div class="text-center">';
          $sql = 'SELECT * from proprietaire WHERE id=' . $animal['id_proprietaire'];
          $data = $pdo->prepare($sql);
          $data->execute();
          $propr = $data->fetch();
          $html .= '<img class="rounded-circle mt-2" src="' . $propr['photo'] . '"alt="pro-pic" width="100px" height="100px"></div>';
          $html .= '<div class="card-body">';
          $html .= '<h5 class="card-title">' . $propr['prenom'] . ' ' . $propr['nom'] . '</h5>';
          $html .= '<p class="card-text">Sexe : ' . $propr['sexe'] . '</p>';
          $html .= '<p class="card-text">Date de naissance : ' . $propr['ddn'] . '</p>';
          $html .= '<p class="card-text">Mail : ' . $propr['mail'] . '</p>';
          $html .= '<p class="card-text">Tél : ' . $propr['tel'] . '</p>';
          $html .= '<p class="card-text">Adresse : ' . $propr['adresse'] . '</p> </div></div></div>';
          echo $html;
          ?>
        </div>
      </div>
</body>

</html>