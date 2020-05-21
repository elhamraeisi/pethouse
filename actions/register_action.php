<?php
// Imports
include_once '../commun/constants_inc.php';
include_once '../commun/db_connect_inc.php'; // Se connecter à la BDD
//include_once 'functions_inc.php';

// Crée ou restaure une session
session_start();

// Vérifier que l'adresse mail est nouvelle (pas de doublon)
$sql = 'SELECT COUNT(*) AS NumberOfUser FROM utilisateur WHERE mail = ?';
$params = array($_POST['mail']);
$data = $pdo->prepare($sql);
$data->execute($params);
$row = $data->fetch();

if ((int) $row['NumberOfUser'] === 0) {
  if ($_POST['captcha'] === $_SESSION['captcha']) {

    $mail = htmlspecialchars($_POST['mail']);
    $pass = htmlspecialchars($_POST['pass']); //convertir les characters specieaux en html examples: '<' -> '&lt;'


    // Insérer les données dans la table UTILISATEUR
    $sql = 'INSERT INTO utilisateur(prenom, nom, mail, pass) VALUES(:prenom, :nom, :mail, :pass)';
    $data = $pdo->prepare($sql);

    // cryptage de mot de passe
    $hash = sha1(md5($pass) . sha1($mail));

    $params = array(
      ':prenom' => htmlspecialchars($_POST['prenom']),
      ':nom' => htmlspecialchars($_POST['nom']),
      ':mail' => htmlspecialchars($_POST['mail']),
      ':pass' => $hash
    );
    $data->execute($params);
    header('location:../login.php');
  } else {
    header('location:../register_form.php?captcha=false');
  }

  // Renvoie vers LOGIN
} else {
  header('location:../register_form.php?exists=true');
}
