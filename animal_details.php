<?php
// Imports
include_once 'commun/constants_inc.php';
include_once 'commun/db_connect_inc.php'; // Connexion à PDO
include_once 'commun/header_inc.php'; // Connexion à PDO
?>
<?php include('head.php'); ?>
<?php include('nav_visitor.php'); ?>

<?php
$sql = 'SELECT * from animal WHERE id=' . $_GET['id'];
$data = $pdo->prepare($sql);
$data->execute();
$animal = $data->fetch();

$sql = 'SELECT * from proprietaire WHERE id=' . $animal['id_proprietaire'];
$data = $pdo->prepare($sql);
$data->execute();
$propr = $data->fetch();
?>

<body>
  <div class="container pt-5">
    <div class="row">
      <div class="col-lg-6">
        <img class="img-fluid rounded cover-detail" height="400" width="600" src=<?php echo ($animal['photo'] === null ? 'pics/animal_generic.png' : $animal['photo']) ?> alt="...">
        <div class="card rounded mt-4 p-3">
          <div class="row">
            <div class="col-lg-6">
              <div class="text-left pl-5">
                <img class="rounded-circle mt-2" src=<?php echo ($propr['photo'] === null ? 'pics/profile-pic.png' : $propr['photo']) ?> alt="pro-pic" width="100px" height="100px">
              </div>
            </div>
            <div class="col-lg-6 pt-4">
              <a href=<?php echo 'http://192.168.64.2/animaux/wordpress/?page_id=131&proprEmail=' . ($propr['mail']) ?> class="btn btn-success p-3"><i class="far fa-envelope pr-2"></i>Envoyer un message</a>
              <button onclick="myFunction()">Click me</button>
            </div>
            <div class="card-body">
              <h3 class="text-primary"><?php echo $propr['prenom'] . $propr['nom'] ?></h3>
              <p class="detail">Mail : <span class="detail-info"><?php echo $propr['mail'] ?></span></p>
              <p class="detail">Tél : <span class="detail-info"><?php echo $propr['tel'] ?></span></p>
              <p class="detail">Adresse : <span class="detail-info"><?php echo $propr['adresse'] ?></span></p>
              <div id="map"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-8">
            <h1 class="text-info" style="text-transform: capitalize;"><?php echo $animal['nom'] ?></h1>
          </div>

          <div class="col-lg-4 pt-4">
            <h3 class="text-primary"><?php echo $animal['prix'] ?>€</h3>
          </div>
        </div>
        <p>Disponibilité à partir de : <?php echo $animal['disponibilite'] ?></p>
        <p class="detail"> <span class="detail-info"> <?php echo $animal['description'] ?></span></p>
        <div class="row">
          <div class="col-lg-6">
            <p class="detail">Sexe : <span class="detail-info"> <?php echo $animal['sexe'] ?></span></p>
            <p class="detail">Vacciné : <span class="detail-info"> <?php echo $animal['vaccine']  == true ? 'Oui' : 'Non'; ?></span></p>
            <p class="detail">Identifié : <span class="detail-info"> <?php echo $animal['identifie']  == true ? 'Oui' : 'Non'; ?></span></p>
          </div>
          <div class="col-lg-6">
            <p class="detail">Poids : <span class="detail-info"> <?php echo $animal['poids'] ?> gr</span></p>
            <p class="detail">Couleur : <span class="detail-info"> <?php echo $animal['couleur'] ?></span></p>
            <p class="detail">Date de naissance : <span class="detail-info"> <?php echo $animal['ddn'] ?></span></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Initialize and add the map
    function initMap() {
      // The location of Uluru
      var uluru = {
        lat: <?php echo $propr['lat']; ?>,
        lng: <?php echo $propr['lon']; ?>
      };
      // The map, centered at Uluru
      var map = new google.maps.Map(
        document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
      console.log(map)
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({
        position: uluru,
        map: map
      });
    }
  </script>
  <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUDt3l_44xD1JPX51qm2_EPOfEqkCGk9g&callback=initMap">
  </script>
</body>

</html>