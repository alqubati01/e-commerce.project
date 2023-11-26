<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    if (preg_match('/^[0-9]*$/', $_GET['id'])) {
      global $pdo;
      $stmt = $pdo->prepare('SELECT id, name, username, email, phone, is_active AS status FROM customers where id=?');
      $stmt->execute([
        $_GET['id']
      ]);

      if ($stmt->rowCount()) {
        echo json_encode($stmt->fetch());
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'Error Happen try later']);
      }

    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The customer id not correct']);
      exit();
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
}


