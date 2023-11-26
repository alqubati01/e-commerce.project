<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirmation'])
      && !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirmation'])) {
  $name = htmlentities($_POST['name']);
  $username = htmlentities($_POST['username']);
  $email = htmlentities($_POST['email']);
  $password = htmlentities($_POST['password']);
  $password_confirmation = htmlentities($_POST['password_confirmation']);
  if (!empty($_POST['phone'])) {
    if (ctype_alnum($_POST['phone'])) {
      $phone = $_POST['phone'];
    } else {
      $_SESSION['error'] = 'Please provide a valid number phone';
      header('Location: ../../register.php');
    }
  } else {
    $phone = NULL;
  }

  if (preg_match('/^[a-zA-Z ]*$/i', $name)) {
    if (preg_match('/^[a-z0-9"_. ]*$/i', $username)) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (strlen($password) >= 8 && strlen($password) <= 32) {
          if ($password_confirmation === $password) {
            global $pdo;
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username=?');
            $stmt->execute([
              $username
            ]);

            if ($stmt->rowCount()) {
              $_SESSION['error'] = 'Username is already token, please pick up another one';
              header('Location: ../../register.php');
            } else {
              $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
              $stmt->execute([
                $email
              ]);

              if ($stmt->rowCount()) {
                $_SESSION['error'] = 'Email is already token, please pick up another one';
                header('Location: ../../register.php');
              } else {
                $stmt = $pdo->prepare('INSERT INTO users (name, username, email, password, phone, created_at) VALUES(?,?,?,?,?,?)');
                $stmt->execute([
                  $name,
                  $username,
                  $email,
                  password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]),
                  $phone,
                  date('Y-m-d H:i')
                ]);

                if ($stmt->rowCount()) {
                  header('Location: ../../success_registration.php');
                } else {
                  $_SESSION['error'] = 'Something happen can not save data';
                  header('Location: ../../register.php');
                }
              }
            }
          } else {
            $_SESSION['error'] = 'Password confirmation does not match';
            header('Location: ../../register.php');
          }
        } else {
          $_SESSION['error'] = 'Please provide a valid password';
          header('Location: ../../register.php');
        }
      } else {
        $_SESSION['error'] = 'Please provide a valid email';
        header('Location: ../../register.php');
      }
    } else {
      $_SESSION['error'] = 'Please provide a valid username';
      header('Location: ../../register.php');
    }
  } else {
    $_SESSION['error'] = 'Please provide a valid name';
    header('Location: ../../register.php');
  }
} else {
  $_SESSION['error'] = 'Please fill the fields';
  header('Location: ../../register.php');
}
