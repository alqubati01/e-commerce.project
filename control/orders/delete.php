<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    if (preg_match('/^[0-9]*$/', $_POST['id'])) {
      global $pdo;

      try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('DELETE FROM order_status WHERE order_id=:order_id');
        $stmt->execute([
          ':order_id' => $_POST['id']
        ]);

        $stmt = $pdo->prepare('DELETE FROM order_item WHERE order_id=:order_id');
        $stmt->execute([
          ':order_id' => $_POST['id']
        ]);

        $stmt = $pdo->prepare('DELETE FROM orders WHERE id=:id');
        $stmt->execute([
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          $pdo->commit();
          echo json_encode(['status'=> 202, 'message'=> 'Success delete order']);
          exit();
        }
      } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status'=> 303, 'message'=> 'Error delete order']);
        exit();
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
