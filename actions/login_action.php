<?php
// Imports
include_once '../commun/db_connect_inc.php';

// Analyse et transforme la saisie 
// Pour securiser les champs contre l'injection de script (special character comme '<script>')
$mail = htmlspecialchars($_POST['mail']);
$pass = htmlspecialchars($_POST['pass']);
$captcha = htmlspecialchars($_POST['captcha']);

// cryptage de mot de passe
$pass = sha1(md5($pass) . sha1($mail));
// ici c'est la requete pour trouver l'utilisateur par son email et son mdp
$sql = 'SELECT * FROM utilisateur WHERE mail=? AND pass=?';
$params = array($mail, $pass);
$data = $pdo->prepare($sql);
$data->execute($params);
$row = $data->fetch();

// Test authentification
if (!empty($row['id'])) {
  //on a besoin de recuperer la sesion pour verifier le captcha
  session_start();
  //je compare le code saisi par l'utilisateur avec le code correct qui se trouve dans la sesion
  if ($_POST['captcha'] === $_SESSION['captcha']) {

    // Suppprime la session en cours
    session_unset();
    session_destroy();

    // Créer une nouvelle session pour securiser toutes les pages webs
    session_start();
    $_SESSION['connected'] = true;
    $_SESSION['role'] = (int) $row['role'];

    // Redirection vers INDEX
    if ((int) $row['role'] === 1) {
      header('location:../admin.php');
    } else {
      header('location:../index.php');
    }
  } else {
    header('location:../login.php?captcha=false');
  }
} else {
  header('location:../login.php?auth=false');
}
