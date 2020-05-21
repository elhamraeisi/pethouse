<?php
include_once 'commun/header_inc_admin.php';
include 'commun/db_connect_inc.php';

//Si on est en mode update (si hot_id dans l'URL)
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $sql = 'SELECT * FROM generique WHERE id = ?';
  $params = array($_GET['id']);
  $data = $pdo->prepare($sql);
  $data->execute($params);
  $row = $data->fetch();
  $update = true;
} else {
  $row = array(
    'titre' => ''
  );
  $update = false;
}
?>
<div id="myform">
  <div class="container">
    <div id="myform-row" class="row justify-content-center align-items-center mb-5">
      <div id="myform-column">
        <div id="myform-box" class="col-md-12">
          <h2 class="text-center text-info pb-4">Ajouter un générique</h2>
          <form id="myform-form" class="form" action="actions/generique_action.php<?php echo ($update ? '?id=' . $_GET['id'] : ''); ?>" method="post" enctype="multipart/form-data">
            <div>
              <label for="titre">Nom*</label>
              <input type="text" class="form-control noborder" value="<?php echo $row['titre'] ?>" id="titre" name="titre" maxlength="30" required>
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