<?php
// Import
include_once '../commun/db_connect_inc.php';

// Récupération des valeurs du formulaire : 2nde itération
foreach ($_POST as $key => $val) {
  if (isset($_POST[$key]) && !empty($_POST[$key])) {
    $params[':' . $key] = htmlspecialchars($val);
  } else {
    $params[':' . $key] = null;
  }
}

// Récupération du fichier à téléverser
if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {

  $file_name = $_FILES['photo']['name'];

  // Extrait l'extension du nom de fichier
  $file_ext = strtolower(substr($file_name, strrpos($file_name, '.') + 1));

  // Type du fichier (Ex.: application/pdf OU text/css OU image/png)
  $file_type = $_FILES['photo']['type'];

  // Adresse du fichier temporaire avant upload
  $file_temp = $_FILES['photo']['tmp_name'];

  // Extensions autorisées
  $allowed_ext = array('bmp', 'gif', 'jpg', 'jpeg', 'png');

  $errors = array();
  // Si extension incorrecte
  if (!in_array($file_ext, $allowed_ext)) {
    $errors[] = '<p>Extension ' . $file_ext . ' non autorisée : ' . implode(',', $allowed_ext);
  }

  if (empty($errors)) {
    // 1. Conversion de l'image en base64 et insertion 
    // dans le tableau de paramètres
    $bin = file_get_contents($file_temp);
    $base64 = 'data:' . $file_type . ';base64,' . base64_encode($bin); // Prête à afficher dans SRC
    $params[':photo'] = $base64; // Ajoute l'entrée au tableau de paramètres

  } else {
    // Affiche les erreurs du tableau
    foreach ($errors as $error) {
      echo $error;
      echo '<a href="admin.php"> Retour page d\'accueil</a>';
      exit();
    }
  }
} else {
  // Si pas de photo choisie
  //si on ajoute un nouveau proprietaire et aucune photo est choisie on mets la photo à NULL
  if (!isset($_GET['id']) && empty($_GET['id'])) {
    $params[':photo'] = null;
  }
}
// Préparation et exécution requête
try {
  if (empty($params[':sexe']))
    $params[':sexe'] = 'N';

  if (!isset($_GET['id']) && empty($_GET['id'])) {
    // Si id est vide alors INSERT
    $sql = 'INSERT INTO proprietaire(prenom, nom, sexe, ddn, adresse,lat,lon, tel, mail, photo) VALUES(:prenom, :nom, :sexe, :ddn, :adresse,:lat,:lon, :tel, :mail, :photo)';
  } else {
    // Si id n'est pas vide alors UPDATE
    $sql = 'UPDATE proprietaire SET prenom=:prenom, nom=:nom, sexe=:sexe, ddn=:ddn, adresse=:adresse,lat=:lat,lon=:lon ,tel=:tel, mail=:mail ';

    if (!empty($params[':photo'])) {
      //mis à jour de la photo, si une photo est selectionnée
      $sql .= ', photo=:photo ';
    }

    // Si on donne pas id tous les animeaux seront mise à jour
    $sql .= ' WHERE id=' . $_GET['id'];
  }
  $data = $pdo->prepare($sql);
  $data->execute($params);
  header('location:../proprietaire_list.php?saveSuccess=true');
} catch (PDOException $err) {
  echo $err->getMessage();
}
