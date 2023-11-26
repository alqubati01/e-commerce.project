<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT id, name FROM payment_methods where id=?');
    $stmt->execute([
      $_GET['id'],
    ]);

    if ($stmt->rowCount()) {
      echo json_encode($stmt->fetch());
    } else {
      echo json_encode(['status'=> 202, 'message'=> 'Brand id does not exists']);
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please Login']);
  exit();
}



