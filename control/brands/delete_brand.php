<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    if (preg_match('/^[0-9]*$/', $_POST['id'])) {
      global $pdo;
      $stmt = $pdo->prepare('SELECT * FROM brands WHERE id=:id');
      $stmt->execute([
        ':id' => $_POST['id']
      ]);

      if ($stmt->rowCount()) {
        try {
          $pdo->beginTransaction();
          $stmt = $pdo->prepare('UPDATE products SET brand_id = NULL WHERE brand_id=:brand_id');
          $stmt->execute([
            ':brand_id' => $_POST['id']
          ]);

          $stmt = $pdo->prepare('DELETE FROM brands WHERE id=:id');
          $stmt->execute([
            ':id' => $_POST['id']
          ]);

          if ($stmt->rowCount()) {
            echo json_encode(['status' => 202, 'message' => 'Success delete brand']);
            $pdo->commit();
            exit();
          } else {
            echo json_encode(['status' => 303, 'message' => 'Error something happen when delete brand']);
            exit();
          }
        } catch (PDOException $e) {
          $pdo->rollBack();
          echo json_encode(['status'=> 303, 'message'=> 'Error something happen when delete brand']);
          exit();
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'This brand not found']);
        exit();
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The brand id not correct']);
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