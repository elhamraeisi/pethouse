<?php
// Imports
include_once '../commun/constants_inc.php';
include_once '../commun/db_connect_inc.php';

// Crée ou restaure une session
session_start();

// Analyse et transforme la saisie
$mail = htmlspecialchars($_POST['mail']);
$pass = htmlspecialchars($_POST['pass']);
$pass = sha1(md5($pass) . sha1($mail));

// Prépare la requête d'authentification
$sql = 'SELECT * FROM utilisateur WHERE mail=? AND pass=?';
$params = array($mail, $pass);
$data = $pdo->prepare($sql);
$data->execute($params);
$row = $data->fetch();

// Test authentification
if (!empty($row['id'])) {
  if ($_POST['captcha'] === $_SESSION['captcha']) {
    // Suppprime la session en cours
    session_unset();
    session_destroy();

    // Créer une nouvelle session pour securiser toutes les pages webs
    session_start();
    $_SESSION['connected'] = true;
    $_SESSION['role'] = (int) $row['role'];
    //pour afficher le nom et prenom de l'utilisateur connecté dans le header 
    $_SESSION['nom'] = $row['nom'];
    $_SESSION['prenom'] = $row['prenom'];


    // Redirection vers INDEX
    if ((int) $row['role'] === 1) {
      header('location:../admin.php');
    } else {
      header('location:../index.php');
    }
  } else {
    header('location:../login.php?auth=false');
  }
} else {
  header('location:../login.php?auth=false');
}
