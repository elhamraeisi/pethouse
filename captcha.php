<?php
// Taille du captcha : 6 caractères
define('LENGTH', 6); // ou const LENGTH = 6;
// Crée les tableaux de caractères pour générer le captcha
$num = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
shuffle($num);
// Pioche 6 caractères au hasard dans le tableau num
$captcha = '';
for ($i = 0; $i < LENGTH; $i++) {
  $captcha .= $num[rand(0, count($num) - 1)];
}
// Stocke la valeur du captcha dans une variable de session
session_start();
$_SESSION['captcha'] = $captcha;
// Ecrit le captcha dans une image générée par GD
$zd = imagecreatetruecolor(160, 90);
$pen = imagecolorallocate($zd, 23, 23, 23);
$back = imagecolorallocate($zd, 230, 230, 230);
$font = 'fonts/MISTRAL.TTF';
imagefilledrectangle($zd, 0, 0, 160, 90, $back);
imagettftext($zd, 30, 20, 30, 70, $pen, $font, $captcha);
// Renvoie l'image au format PNG
header('content-type:image/png');
imagepng($zd);
imagedestroy($zd);
