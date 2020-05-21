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
// Préparation et exécution requête
try {

  if (!isset($_GET['id']) && empty($_GET['id'])) {
    // Si id est vide alors INSERT
    $sql = 'INSERT INTO generique(titre) VALUES(:titre)';
  } else {

    // Si id n'est pas vide alors UPDATE
    // avec id on trouve le generique à mettre à jour
    $sql = 'UPDATE generique SET titre=:titre WHERE id=' . $_GET['id'];
  }
  $data = $pdo->prepare($sql);
  $data->execute($params);
  header('location:../generique_list.php?saveSuccess=true');
} catch (PDOException $err) {
  echo $err->getMessage();
}
