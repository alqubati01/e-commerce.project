<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    if (preg_match('/^[0-9]*$/', $_POST['id'])) {
      global $pdo;
      $stmt = $pdo->prepare('SELECT * FROM addresses WHERE id=:id');
      $stmt->execute([
        ':id' => $_POST['id']
      ]);

      if ($stmt->rowCount()) {
        $stmt = $pdo->prepare('DELETE FROM addresses WHERE id=:id');
        $stmt->execute([
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status' => 202, 'message' => 'Success delete address']);
          exit();
        } else {
          echo json_encode(['status' => 303, 'message' => 'Error something happen when delete address']);
          exit();
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'This address not found']);
        exit();
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The address id not correct']);
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