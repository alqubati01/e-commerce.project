<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['fv-name']) && !empty($_POST['fv-name'])) {
    $name = htmlentities($_POST['fv-name']);

    if (preg_match('/^[a-zA-Z0-9 ]*$/i', $name)) {
      global $pdo;
      $stmt = $pdo->prepare('SELECT * FROM categories WHERE name=?');
      $stmt->execute([
        $name
      ]);

      if ($stmt->rowCount()) {
        $_SESSION['error'] = 'Username is already token, please pick up another one';
        header('refresh:0;url=../../add_category.php');
      } else {
        $stmt = $pdo->prepare('INSERT INTO categories (name, created_at) VALUES(?,?)');
        $stmt->execute([
          $name,
          date('Y-m-d H:i')
        ]);

        if ($stmt->rowCount()) {
          $_SESSION['success'] = 'You add category success';
          header('refresh:0;url=../../categories.php');
        } else {
          $_SESSION['error'] = 'Something happen can not save data';
          header('refresh:0;url=../../add_category.php');
        }
      }
    } else {
      $_SESSION['error'] = 'Please provide a valid name';
      header('refresh:0;url=../../add_category.php');
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('refresh:0;url=../../add_category.php');
  }
} else {
  $_SESSION['error'] = 'Please login';
  header('refresh:0;url=../../add_category.php');
}
