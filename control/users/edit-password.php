<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['fv-password'], $_POST['fv-new-password'], $_POST['fv-confirm-password']) &&
    !empty($_POST['fv-password']) && !empty($_POST['fv-new-password']) && !empty($_POST['fv-confirm-password'])) {
    $password = htmlentities($_POST['fv-password']);
    $newPassword = htmlentities($_POST['fv-new-password']);
    $confirmPassword = htmlentities($_POST['fv-confirm-password']);

    if (strlen($password) >= 8 && strlen($password) <= 32) {
      if (strlen($newPassword) >= 8 && strlen($newPassword) <= 32) {
        if ($newPassword === $confirmPassword) {
          global $pdo;
          $stmt = $pdo->prepare('SELECT * FROM users WHERE id=?');
          $stmt->execute([
            $_SESSION['id']
          ]);

          if ($stmt->rowCount()) {
            $user = $stmt->fetch();

            if (password_verify($password, $user['password'])) {
              $stmt = $pdo->prepare('UPDATE users SET password=:password, updated_at=:updated_at WHERE id=:id');
              $stmt->execute([
                ':password' => password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 11]),
                ':updated_at' => date('Y-m-d H:i'),
                ':id' => $_SESSION['id'],
              ]);

              if ($stmt->rowCount()) {
                $_SESSION['success'] = 'Password has been changed';
                header('Location: ../../account_setting.php');
              } else {
                $_SESSION['error'] = 'An error has occurred';
                header('Location: ../../account_setting.php');
              }
            } else {
              $_SESSION['error'] = 'Incorrect Password';
              header('Location: ../../account_setting.php');
            }
          } else {
            $_SESSION['error'] = 'User does not found';
            header('Location: ../../account_setting.php');
          }
        } else {
          $_SESSION['error'] = 'Password does not match';
          header('Location: ../../account_setting.php');
        }
      } else {
        $_SESSION['error'] = 'Please provide a valid password';
        header('Location: ../../account_setting.php');
      }
    } else {
      $_SESSION['error'] = 'Please provide a valid password';
      header('Location: ../../account_setting.php');
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('Location: ../../account_setting.php');
  }
} else {
  $_SESSION['error'] = 'Please Login';
  header('Location: ../../account_setting.php');
}

