<?php

session_start();
require_once '../../inc/Database.php';


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['fv-id'], $_POST['fv-name'], $_POST['fv-statues']) && !empty($_POST['fv-id']) && !empty($_POST['fv-name'])) {
    $id = htmlentities($_POST['fv-id']);
    $name = htmlentities($_POST['fv-name']);
    $status = htmlentities($_POST['fv-statues']);

    if (preg_match('/^[0-9]*$/', $_POST['id'])) {
      if (preg_match('/^[a-zA-Z0-9 ]*$/i', $name) && ctype_alnum($status)) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE name=? AND id!=?');
        $stmt->execute([
          $name,
          $id
        ]);

        if ($stmt->rowCount()) {
          $_SESSION['error'] = 'Username is already token, please pick up another one';
          header('refresh:0;url=../../edit_category.php');
        } else {
          $stmt = $pdo->prepare('UPDATE categories SET name=:name, is_active=:is_active, updated_at=:updated_at WHERE id=:id');
          $stmt->execute([
            ':name' => $name,
            ':is_active' => $status,
            ':updated_at' => date('Y-m-d H:i'),
            ':id' => $id
          ]);

          if ($stmt->rowCount()) {
                $_SESSION['success'] = 'You edit category success';
            header("Location: ../../categories.php");

          } else {
            $_SESSION['error'] = 'Something happen can not save data';
            header('refresh:0;url=../../edit_category.php');
          }
        }
      } else {
        $_SESSION['error'] = 'Please provide a valid name';
        header('refresh:0;url=../../edit_category.php');
      }
    } else {
      $_SESSION['error'] = 'The id not correct';
      header('refresh:0;url=../../edit_category.php');
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('refresh:0;url=../../edit_category.php');
  }
} else {
  $_SESSION['error'] = 'Please Login';
  header('refresh:0;url=../../edit_category.php');
}
