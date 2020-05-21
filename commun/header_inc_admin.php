<?php
session_start();

// Teste si connected existe et est vrai
if (
  (!isset($_SESSION['connected']) && !$_SESSION['connected'])
) {
  header('location:login.php');
  exit();
}

//on verifie si l'utilisateur connecté a le role d'administrateur
if (
  ((int) $_SESSION['role'] !== 1)
) {
  header('location:401.php');
  exit();
}
