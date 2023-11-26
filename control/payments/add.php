<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['name']) && !empty($_POST['name'])) {
    $name = htmlentities($_POST['name']);

    if (preg_match('/^[a-zA-Z ]*$/i', $name)) {
      global $pdo;
      $stmt = $pdo->prepare('SELECT * FROM payment_methods WHERE name=?');
      $stmt->execute([
        $name
      ]);

      if ($stmt->rowCount()) {
        echo json_encode(['status'=> 303, 'message'=> 'Name is already token, please pick up another one']);
        exit();
      } else {
        $stmt = $pdo->prepare('INSERT INTO payment_methods (name, created_at) VALUES(?,?)');
        $stmt->execute([
          $name,
          date('Y-m-d H:i')
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status'=> 202, 'message'=> 'You add payment success']);
          exit();
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Something happen can not save data']);
          exit();
        }
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