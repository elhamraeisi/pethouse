<?php
session_start();
// Teste si utilisateur est connecter ou pas
if (
  (!isset($_SESSION['connected']) || !$_SESSION['connected'])
) {
  header('location:login.php');
  exit();
}
//on verifie si l'utilisateur connecté a le role admin
if (
  ((int) $_SESSION['role'] !== 1)
) {
  header('location:401.php');
  exit();
}
