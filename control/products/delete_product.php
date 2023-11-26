<?php

session_start();
require_once '../../inc/Database.php';


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    if (preg_match('/^[0-9]*$/', $_GET['id'])) {
      global $pdo;

      try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('DELETE FROM stock WHERE product_id=:product_id');
        $stmt->execute([
          ':product_id' => $_GET['id']
        ]);

        $stmt = $pdo->prepare('DELETE FROM attachments WHERE product_id=:product_id');
        $stmt->execute([
          ':product_id' => $_GET['id']
        ]);

        $stmt = $pdo->prepare('DELETE FROM category_product WHERE product_id=:product_id');
        $stmt->execute([
          ':product_id' => $_GET['id']
        ]);

        $stmt = $pdo->prepare('DELETE FROM products WHERE id=:id');
        $stmt->execute([
          ':id' => $_GET['id']
        ]);

        if ($stmt->rowCount()) {
          $pdo->commit();
          $_SESSION['success'] = 'Success delete product';
          header('refresh:0;url=../../products.php');
        }
      } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'Error something happen when delete product';
        header('refresh:0;url=../../products.php');
      }
    } else {
      $_SESSION['error'] = 'The product id not correct';
      header('refresh:0;url=../../products.php');
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('refresh:0;url=../../products.php');
  }
} else {
  $_SESSION['error'] = 'Please Login';
  header('refresh:0;url=../../products.php');
}