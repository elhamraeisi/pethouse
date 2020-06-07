<?php
include_once 'commun/header_inc_admin.php';
include 'commun/db_connect_inc.php';

//Si on est en mode update (si hot_id dans l'URL)
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $sql = 'SELECT * FROM proprietaire WHERE id = ?';
  $params = array($_GET['id']);
  $data = $pdo->prepare($sql);
  $data->execute($params);
  $row = $data->fetch();
  $update = true;
} else {
  $row = array(
    'prenom' => '',
    'nom' => '',
    'sexe' => '',
    'ddn' => '',
    'adresse' => '',
    'lat' => 0.0,
    'lon' => 0.0,
    'tel' => '',
    'mail' => ''
  );
  $update = false;
}
?>

<div id="myform">
  <div class="container">
    <div id="myform-row" class="row justify-content-center align-items-center mb-5">
      <div id="myform-column">
        <div id="myform-box" class="col-md-12">
          <h2 class="text-center text-info py-4">Ajouter un propriétaire</h2>
          <form id="myform-form" class="form" action="actions/proprietaire_action.php<?php echo ($update ? '?id=' . $_GET['id'] : ''); ?>" method="post" enctype="multipart/form-data">
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="prenom">Prénom*</label>
                <input type="text" class="form-control noborder" value="<?php echo $row['prenom'] ?>" id="prenom" name="prenom" maxlength="50" required>
              </div>
              <div class="col-md-6">
                <label for="nom">Nom*</label>
                <input type="text" class="form-control noborder" value="<?php echo $row['nom'] ?>" id="nom" name="nom" maxlength="50" required>
              </div>
            </div>
            <div class="group-control pt-4">
              <label for="sexe">Sexe*</label>
              <input type="radio" name="sexe" value="F" id="femme" <?php echo $row['sexe'] == 'F' ? 'checked' : '' ?> required>
              <label for="femme">Femme</label>
              <input type="radio" name="sexe" value="M" id="homme" <?php echo $row['sexe'] == 'M' ? 'checked' : '' ?> required>
              <label for="homme">Homme</label>
            </div>
            </select>
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="ddn">Date de naissance</label>
                <input type="date" class="form-control noborder" value="<?php echo $row['ddn'] ?>" id="ddn" name="ddn">
              </div>
            </div>
            <div class="group-control pt-4">
              <label for="adresse">Adresse*</label>
              <input type="text" class="form-control noborder" value="<?php echo $row['adresse'] ?>" id="adresse" name="adresse" required>
              <input type="hidden" value="<?php echo $row['lat'] ?>" id="lat" name="lat">
              <input type="hidden" value="<?php echo $row['lon'] ?>" id="lon" name="lon">

            </div>
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="tel">Tél*</label>
                <input type="tel" class="form-control noborder" value="<?php echo $row['tel'] ?>" id="tel" name="tel" minlength="10" required>
              </div>
              <div class="col-md-6">
                <label for="mail">Mail*</label>
                <input type="email" class="form-control noborder" value="<?php echo $row['mail'] ?>" id="mail" name="mail" required>
              </div>
            </div>
            <div class="group-control pt-4">
              <label for="photo">Photo</label>
              <input type="file" class="form-control noborder" id="photo" name="photo">
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-success rounded-pill btn-block" value="<?php echo ($update ? 'Mettre à jour' : 'Ajouter'); ?>">
              <button type="button" class="btn btn-info rounded-pill btn-block" data-dismiss="modal">Annuler</button>
            </div>
          </form>
          <script>
            var placeSearch, autocomplete;

            function activatePlacesSearch() {
              var input = document.getElementById('adresse');
              autocomplete = new google.maps.places.Autocomplete(input);
              autocomplete.addListener('place_changed', fillInAddress);
            }

            function fillInAddress() {
              var place = autocomplete.getPlace();
              // on recuper lat et lng et on rempli les chemps lat et lng dans le formulaire
              $('#lat').val(place.geometry.location.lat())
              $('#lon').val(place.geometry.location.lng())
            }
          </script>
          <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUDt3l_44xD1JPX51qm2_EPOfEqkCGk9g&libraries=places&callback=activatePlacesSearch"></script>
        </div>
      </div>
    </div>
  </div>