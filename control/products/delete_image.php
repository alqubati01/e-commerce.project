<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_GET);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    if (preg_match('/^[0-9]*$/', $_GET['id'])) {
      global $pdo;

      $stmt = $pdo->prepare('DELETE FROM attachments WHERE id=:id');
      $stmt->execute([
        ':id' => $_GET['id']
      ]);

      if ($stmt->rowCount()) {
        $_SESSION['success'] = 'Success delete product image';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
    } else {
      $_SESSION['error'] = 'The product image id not correct';
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
} else {
  $_SESSION['error'] = 'Please Login';
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}