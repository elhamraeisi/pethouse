<?php
//je recuper la session
session_start();
//je supprime la session
session_unset();
session_destroy();
//j'afiche la page de conexion
header('location:../login.php');
