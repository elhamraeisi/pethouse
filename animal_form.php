<?php
include 'commun/db_connect_inc.php';

//Si on est en mode update (si hot_id dans l'URL)
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $sql = 'SELECT * FROM animal WHERE id = ?';
  $params = array($_GET['id']);
  $data = $pdo->prepare($sql);
  $data->execute($params);
  $row = $data->fetch();
  $update = true;
} else {
  $row = array(
    'id_generique' => '',
    'nom' => '',
    'sexe' => '',
    'ddn' => '',
    'poids' => '',
    'couleur' => '',
    'prix' => '',
    'disponibilite' => '',
    'vaccine' => 0,
    'identifie' => 0,
    'description' => ''
  );
  $update = false;
}
?>
<div id="myform">
  <div class="container">
    <div id="myform-row" class="row justify-content-center align-items-center mb-5">
      <div id="myform-column">
        <div id="myform-box" class="col-md-12">
          <h2 class="text-center text-info pb-4">Ajouter un animal</h2>
          <form id="myform-form" class="form" action="actions/animal_action.php<?php echo ($update ? '?id=' . $_GET['id'] : ''); ?>" method="post" enctype="multipart/form-data">
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="generique">Générique*</label>
                <a href="generique_list.php" type="submit" class="badge badge-secondary ml-3">Ajouter</a>
                <select class="form-control" name="id_generique" value="<?php echo $row['id_generique'] ?>" id="id_generique">
                  <?php
                  $sql = 'SELECT * from generique';
                  $data = $pdo->prepare($sql);
                  $data->execute();
                  while ($rowGenerique = $data->fetch()) {
                    echo '<option value=' . $rowGenerique['id'] . '>' . $rowGenerique['titre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="proprietaire">Propriétaire*</label>
                <a href="proprietaire_list.php" type="submit" class="badge badge-secondary ml-3">Ajouter</a>
                <select class="form-control" name="id_proprietaire" value="<?php echo $row['id_proprietaire'] ?>" id="id_proprietaire" required>
                  <?php
                  $sql = 'SELECT * from proprietaire';
                  $data = $pdo->prepare($sql);
                  $data->execute();
                  while ($rowPropr = $data->fetch()) {
                    echo '<option value=' . $rowPropr['id'] . '>' . $rowPropr['prenom'] . ' ' . $rowPropr['nom'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="group-control pt-4">
              <label for="sexe">Sexe</label>
              <input type="radio" name="sexe" id="male" value="M" <?php echo $row['sexe'] == 'M' ? 'checked' : '' ?>>
              <label for="male">Mâle</label>
              <input type="radio" name="sexe" id="femelle" value="F" <?php echo $row['sexe'] == 'F' ? 'checked' : '' ?>>
              <label for="femelle">Femelle</label>
            </div>
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="nom">Nom*</label>
                <input type="text" class="form-control noborder" value="<?php echo $row['nom'] ?>" id="nom" name="nom" maxlength="32" required>
              </div>
              <div class="col-md-6">
                <label for="ddn">Date de naissance</label>
                <input type="date" class="form-control noborder" value="<?php echo $row['ddn'] ?>" id="ddn" name="ddn">
              </div>
            </div>
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="disponibilite">Disponibilité*</label>
                <input type="date" class="form-control noborder" value="<?php echo $row['disponibilite'] ?>" id="disponibilite" name="disponibilite" required>
              </div>
              <div class="col-md-6">
                <label for="prix">Prix*</label>
                <input type="number" class="form-control noborder" value="<?php echo $row['prix'] ?>" id="prix" name="prix" required>
              </div>
            </div>
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="poids">Poids</label>
                <input type="number" class="form-control noborder" value="<?php echo $row['poids'] ?>" id="poids" name="poids" placeholder="gr" min=1>
              </div>
              <div class="col-md-6">
                <label for="couleur">Couleur</label>
                <input type="text" class="form-control noborder" value="<?php echo $row['couleur'] ?>" id="couleur" name="couleur">
              </div>
            </div>
            <div class="group-control pt-4">
              <label for="description">Description*</label>
              <textarea class="form-control noborder" id="description" name="description" rows="5" cols="33" maxlength="2048" required> <?php echo $row['description'] ?></textarea>
            </div>
            <div class="group-control pt-4">
              <label for="photo">Photo</label>
              <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
              <input type="file" class="form-control noborder" id="photo" name="photo">
            </div>
            <div class="row pt-4">
              <div class="col-md-6">
                <label for="vaccine">Vacciné</label>
                <input type="radio" name="vaccine" id="Oui" value=1 <?php echo $row['vaccine'] == true  ? 'checked' : '' ?>>
                <label for="Oui">Oui</label>
                <input type="radio" name="vaccine" id="Non" value=0 <?php echo $row['vaccine'] == false ? 'checked' : '' ?>>
                <label for="Non">Non</label>
              </div>
              <div class="col-md-6">
                <label for="identifie">Identifié</label>
                <input type="radio" name="identifie" id="Oui" value=1 <?php echo $row['identifie'] == true  ? 'checked' : '' ?>>
                <label for="Oui">Oui</label>
                <input type="radio" name="identifie" id="Non" value=0 <?php echo $row['identifie'] == false ? 'checked' : '' ?>>
                <label for="Non">Non</label>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-success rounded-pill btn-block" value="<?php echo ($update ? 'Mettre à jour' : 'Ajouter'); ?>">
              <button type="button" class="btn btn-info rounded-pill btn-block" data-dismiss="modal">Annuler</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>