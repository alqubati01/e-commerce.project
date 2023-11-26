<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id'], $_POST['name'], $_POST['status']) && !empty($_POST['id']) && !empty($_POST['name'])) {
    $id = htmlentities($_POST['id']);
    $name = htmlentities($_POST['name']);
    $status = htmlentities($_POST['status']);

    if (preg_match('/^[a-zA-Z ]*$/i', $name) && ctype_alnum($status)) {
      global $pdo;
      $stmt = $pdo->prepare('UPDATE shippers SET name=:name, is_active=:is_active, updated_at=:updated_at WHERE id=:id');
      $stmt->execute([
        ':name' => $name,
        ':is_active' => $status,
        ':updated_at' => date('Y-m-d H:i'),
        ':id' => $id
      ]);

      if ($stmt->rowCount()) {
        echo json_encode(['status'=> 202, 'message'=> 'Update shipper successfully']);
      } else {
        echo json_encode(['status'=> 202, 'message'=> 'Something happen can not update data']);
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid data']);
      exit();
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please Login']);
  exit();
}
