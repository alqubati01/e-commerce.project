<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['fv-id'], $_POST['fv-password'], $_POST['fv-confirm-password'])
    && !empty($_POST['fv-id']) && !empty($_POST['fv-password']) && !empty($_POST['fv-confirm-password'])) {
    $id = htmlentities($_POST['fv-id']);
    $password = htmlentities($_POST['fv-password']);
    $confirmPassword = htmlentities($_POST['fv-confirm-password']);

    if (strlen($password) >= 8 && strlen($password) <= 32) {
      if ($password === $confirmPassword) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM customers WHERE id=?');
        $stmt->execute([
          $id
        ]);

        if ($stmt->rowCount()) {
          $stmt = $pdo->prepare('UPDATE customers SET password=:password, updated_at=:updated_at WHERE id=:id');
          $stmt->execute([
            ':password' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]),
            ':updated_at' => date('Y-m-d H:i'),
            ':id' => $id,
          ]);

          if ($stmt->rowCount()) {
            $_SESSION['success'] = 'Password has been changed';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
          } else {
            $_SESSION['error'] = 'An error has occurred';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
          }
        } else {
          $_SESSION['error'] = 'Customer does not found';
          header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
      } else {
        $_SESSION['error'] = 'Password does not match';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
    } else {
      $_SESSION['error'] = 'Please provide a valid password';
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

