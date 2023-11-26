<?php

session_start();
require_once '../../inc/Database.php';


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    if (preg_match('/^[0-9]*$/', $_POST['id'])) {
      global $pdo;
      $stmt = $pdo->prepare('SELECT * FROM categories WHERE id=:id');
      $stmt->execute([
        ':id' => $_POST['id']
      ]);

      try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE products SET category_id = NULL WHERE category_id=:category_id');
        $stmt->execute([
          ':category_id' => $_POST['id']
        ]);

        $stmt = $pdo->prepare('UPDATE brands SET category_id = NULL WHERE category_id=:category_id');
        $stmt->execute([
          ':category_id' => $_POST['id']
        ]);

        $stmt = $pdo->prepare('UPDATE categories SET parent_id = NULL WHERE parent_id=:category_id');
        $stmt->execute([
          ':category_id' => $_POST['id']
        ]);

        $stmt = $pdo->prepare('DELETE FROM categories WHERE id=:id');
        $stmt->execute([
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status'=> 202, 'message'=> 'Success delete category']);
          $pdo->commit();
          exit();
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Error something happen when delete category']);
          exit();
        }
      } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status'=> 303, 'message'=> 'Error something happen when delete category']);
        exit();
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The category id not correct']);
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