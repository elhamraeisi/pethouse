<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  try {
    include_once '../commun/db_connect_inc.php';
    $sql = 'DELETE FROM generique WHERE id=?';
    $params = array($_GET['id']);
    $data = $pdo->prepare($sql);
    $data->execute($params);
    unset($pdo);
    header('location:../generique_list.php?deleteSuccess=true');
  } catch (PDOException $err) {
    echo '<p>' . $err->getMessage() . '</p>';
  }
}
