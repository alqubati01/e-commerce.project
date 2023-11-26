<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id'], $_POST['action']) && !empty($_POST['id']) && !empty($_POST['action'])) {
    if (preg_match('/^[0-9]*$/', $_POST['id'])) {
      global $pdo;
      if ($_POST['action'] === 'paid') {
        $stmt = $pdo->prepare('UPDATE order_status SET status_id=:status_id WHERE id=:id');
        $stmt->execute([
          ':status_id' => 3,
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status'=> 202, 'message'=> 'Success change order status']);
          exit();
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Error change order status']);
          exit();
        }
      }

      else if ($_POST['action'] === 'delivered') {
        $stmt = $pdo->prepare('UPDATE order_status SET status_id=:status_id WHERE id=:id');
        $stmt->execute([
          ':status_id' => 7,
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status'=> 202, 'message'=> 'Success change order status']);
          exit();
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Error change order status']);
          exit();
        }
      }

    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The order id not correct']);
      exit();
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
  exit();
}

