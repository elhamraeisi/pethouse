<?php
// Imports
include_once 'commun/db_connect_inc.php'; // Connexion à PDO (PHP Data Objects)
include_once 'commun/header_inc.php';
include('commun/head.php');
include('nav_visitor.php');
?>

<body>
  <div class="background-blue">
    <div class="container">
      <div class="billboard">
        <div class="row align-items-end text-center">
          <div class="col-md-4 order-2 order-md-1 pt-5">
            <img src="pics/dog-wh.png" alt="dog" class="img-fluid" width="400" />
          </div>
          <div class="col-md-8 order-1 order-md-2 mb-5">
            <h1 class="text-white text-center m-5">Trouvez votre nouvel
              animal de compagnie !</h1>
            <div class="mt-5 px-5">
              <p><span>Utilisez notre moteur de recherche qui permet de trouver enfin votre animal de rêve </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="background-light-blue p-5">
      <div class="card rounded">
        <div class="card-body p-5">
          <form action="index.php#liste_animaux" class="w-100 d-flex align-items-end">
            <div class="flex-grow-1 mr-3">
              <label for="search" class="control-label search-label">Recherche</label>
              <input class="form-control search-placeholder" type="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Nom de l'animal" />
            </div>
            <button class="btn-darkBlue my-2 my-sm-0 px-3" type="submit"><span>cherche</span></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id='liste_animaux' class="bg-light mx-5 my-5">
    <div class="text-center">
      <?php
      $sql = 'SELECT * from generique';
      $data = $pdo->prepare($sql);
      $data->execute();
      echo '<a href="index.php#liste_animaux" class="btn btn-secondary p-3 m-2 rounded-pill" >TOUS</a>';
      while ($row = $data->fetch()) {
        $buttonColor = (!empty($_GET['idGenerique']) && $_GET['idGenerique'] == $row['id']) ? 'btn-darkBlue' : 'btn-info';
        echo '<a href="index.php?idGenerique=' . $row['id'] . '#liste_animaux" class="btn text-uppercase '
          . $buttonColor . ' p-3 m-2 rounded-pill">' . $row['titre'] . ' </a>';
      }
      ?>
    </div>
    <h1 class="text-primary text-capitalize pt-4">
      <?php
      //ici on recupere le titre du generique qui se trouve dans URL
      if (!empty($_GET['idGenerique'])) {
        $sql = 'SELECT * from generique WHERE id=' . $_GET['idGenerique'];
        $data = $pdo->prepare($sql);
        $data->execute();
        $row = $data->fetch();
        echo $row['titre'];
      } else {
        echo 'Tous les Animaux';
      }
      ?>
    </h1>
    <div class="row">
      <?php
      // Exécute la requête SQL
      $sql = 'SELECT * from animal WHERE 1=1';

      if (!empty($_GET['idGenerique']))
        $sql .= ' AND id_generique=' . $_GET['idGenerique'];

      if (!empty($_GET['search']))
        $sql .= ' AND nom like "%' . $_GET['search'] . '%"';
      //SELECT * from animal WHERE 1=1' AND nom like '%toto%'


      $data = $pdo->prepare($sql);
      $data->execute();

      // Lecture du dataset et défibit les cards
      $html = '';
      while ($row = $data->fetch()) {
        $html .= '<a href="animal_details.php?id=' . $row['id'] . '" style="text-decoration-line: none;">';
        $html .= '<div class="card-animal m-3 justify-content-center" style="width: 16.9rem;">';
        $html .= '<img src="' . ($row['photo'] === null ? 'pics/animal_generic.png' : $row['photo']) . '" class="cover" style="border-top-left-radius:18px; border-top-right-radius:18px;" />';
        $html .= '<div class="card-body">';
        $html .= '<h2 class="card-title text-info text-truncate" style="text-transform: capitalize;">' . $row['nom'] . '</h2>';
        $html .= '<h3 class="card-title">' . $row['prix'] . '‎€</h3>';
        $html .= '<h5 class="card-text">Disponibilité : ' . $row['disponibilite'] . '</h5>';
        $html .= '</div></div></a>';
      }
      if (empty($html)) {
        $html = '<div class="w-100"><h2 class="card-title text-secondary text-center m-5 p-5">Aucun animal n\'a été trouvé</h2></div>';
      }
      echo $html;
      ?>
    </div>
  </div>
</body>

</html>