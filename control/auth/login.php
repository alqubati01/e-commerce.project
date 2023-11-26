<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
  $email = htmlentities($_POST['email']);
  $password = htmlentities($_POST['password']);

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute([
      ':email' => $email
    ]);

    if ($stmt->rowCount()) {
      $user = $stmt->fetch();

      if ($user['is_active'] == 1) {
        if (password_verify($password, $user['password'])) {
          $_SESSION['admin_login'] = true;
          $_SESSION['id'] = $user['id'];
          $_SESSION['name'] = $user['name'];
          $_SESSION['image'] = $user['image'];
          $stmt = $pdo->prepare('UPDATE users SET last_login=:last_login WHERE id=:id');
          $stmt->execute([
            ':last_login' => date('Y-m-d H:i'),
            ':id' => $user['id']
          ]);

          if ($stmt->rowCount()) {
            header('Location: ../../index.php');
          } else {
            $_SESSION['error'] = 'Something happen can not save data';
            header('Location: ../../login.php');
          }
        } else {
          $_SESSION['error'] = 'Verify your password or email';
          header('Location: ../../login.php');
        }
      } else {
        $_SESSION['error'] = 'User not active';
        header('Location: ../../login.php');
      }
    } else {
      $_SESSION['error'] = 'User not found';
      header('Location: ../../login.php');
    }
  } else {
    $_SESSION['error'] = 'Please provide a valid email';
    header('Location: ../../login.php');
  }
} else {
  $_SESSION['error'] = 'Please fill in the fields';
  header('Location: ../../login.php');
}
