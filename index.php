<?php
// Imports
include_once 'constants_inc.php';
include_once 'db_connect_inc.php'; // Connexion à PDO
?>
<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<?php include('nav_visitor.php'); ?>

<body>
  <div class="background-blue">
    <div class="container">
      <div class="billboard">
        <div class="row align-items-end text-center justify-content-center">
          <div class="col-12 col-md-4 px-0 order-2 order-md-1">
            <img src="pics/dog-img.png" alt="dog" class="img-fluid lazyloaded" width="400" />
          </div>
          <div class="col-sm-9 col-md-8 px-0 order-1 order-md-2 mr-md-0 ml-md-auto align-self-center mb-5">
            <h1 class="text-white text-center m-5">Dog Breed Library</h1>
            <div class="mt-5 px-5">
              <p><span>Are you a new or prospective pet parent but not sure what is the right breed for you and your family? From the history of the breed to health and exercise needs to choosing the right food, use our breed library to learn more about your favorite dog breeds.</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 px-0">
      <div class="background-light-blue h-100 p-5">
        <div class="card rounded">
          <div class="card-body p-5">
            <form action="index.php" class="w-100 d-flex align-items-end">
              <div class="flex-grow-1 mr-3">
                <label for="search" class="control-label search-label">Recherche</label>
                <input class="form-control search-placeholder" type="search" name="search" placeholder="Nom de l'animal" />
              </div>
              <button class="btn-primary my-2 my-sm-0 px-3" type="submit"><span>cherche</span></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-light mx-5 my-5">
    <h1 class="text-info ">Animaux</h1>
    <div class="row">
      <?php
      // Exécute la requête SQL
      $sql = 'SELECT * from animal WHERE 1=1';

      if (!empty($_GET['idGenerique']))
        $sql .= ' AND id_generique=' . $_GET['idGenerique'];

      if (!empty($_GET['search']))
        $sql .= ' AND nom like "%' . $_GET['search'] . '%"';

      $data = $pdo->prepare($sql);
      $data->execute();

      // Lecture du dataset et défibit les cards
      $html = '';
      while ($row = $data->fetch()) {
        $html .= '<a href="animal_details.php?id=' . $row['id'] . '" style="text-decoration-line: none;">';
        $html .= '<div class="card-animal m-3 justify-content-center" style="width: 16.9rem;">';
        $html .= '<img src="' . ($row['photo'] === null ? 'pics/animal_generic.png' : $row['photo']) . '" class="cover" style="border-top-left-radius:18px; border-top-right-radius:18px;" />';
        $html .= '<div class="card-body">';
        $html .= '<h2 class="card-title" style="text-transform: capitalize;">' . $row['nom'] . '</h2>';
        $html .= '<h3 class="card-title">' . $row['prix'] . '‎€</h3>';
        $html .= '<h5 class="card-text">Disponibilité : ' . $row['disponibilite'] . '</h5>';
        //$html .= '<a class="btn btn-info" href="animal_details.php?id=' . $row['id'] . '">Détails...</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</a>';
      }
      echo $html;
      ?>
    </div>
  </div>
</body>

</html>