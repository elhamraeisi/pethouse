<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  try {
    include_once 'db_connect_inc.php';
    $sql = 'DELETE FROM animal WHERE id=?';
    $params = array($_GET['id']);
    $data = $pdo->prepare($sql);
    $data->execute($params);
    unset($pdo);
    header('location:admin.php');
  } catch (PDOException $err) {
    echo '<p>' . $err->getMessage() . '</p>';
  }
}
