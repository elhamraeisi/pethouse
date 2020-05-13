<?php
// Taille du captcha : 6 caractères
define('LENGTH', 6); // ou const LENGTH = 6;

// Crée les tableaux de caractères pour générer le captcha
$num = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9); // archaïque plutôt range(0, 9)
$lower = range('a', 'z'); // plage de valeurs (alphabet et nombres)
$upper = range('A', 'Z');
$symbol = array('*', '$', '+', '&', '!');
$mix = array_merge($num, $lower, $upper, $symbol); // fusionne les 4 tableaux précédents
shuffle($mix);

// Pioche 6 caractères au hasard dans le tableau MIX
$captcha = '';
for ($i = 0; $i < LENGTH; $i++) {
  $captcha .= $mix[rand(0, count($mix) - 1)];
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
imagestring($zd, 5, 30, 70, $captcha, $pen);
imagettftext($zd, 30, 20, 30, 70, $pen, $font, $captcha);

// Renvoie l'image au format PNG (donc binaire !!!)
header('content-type:image/png');
imagepng($zd);
imagedestroy($zd);
