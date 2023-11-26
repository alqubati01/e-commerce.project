<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['fv-name'], $_POST['fv-username'], $_POST['fv-email'], $_POST['fv-password'], $_POST['fv-roles'])
    && !empty($_POST['fv-name']) && !empty($_POST['fv-username']) && !empty($_POST['fv-email']) && !empty($_POST['fv-password'])) {
    $name = htmlentities($_POST['fv-name']);
    $username = htmlentities($_POST['fv-username']);
    $email = htmlentities($_POST['fv-email']);
    $password = htmlentities($_POST['fv-password']);
    $role = htmlentities($_POST['fv-roles']);
    if (!empty($_POST['fv-phone'])) {
      if (ctype_alnum($_POST['fv-phone'])) {
        $phone = $_POST['fv-phone'];
      } else {
        $_SESSION['error'] = 'Please provide a valid number phone';
        header('refresh:0;url=../../add_member.php');
      }
    } else {
      $phone = NULL;
    }

    if (preg_match('/^[a-zA-Z ]*$/i', $name) && ctype_alnum($role)) {
      if (preg_match('/^[a-z0-9"_. ]*$/i', $username)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          if (strlen($password) >= 8 && strlen($password) <= 32) {
            global $pdo;
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username=?');
            $stmt->execute([
              $username
            ]);

            if ($stmt->rowCount()) {
              $_SESSION['error'] = 'Username is already token, please pick up another one';
              header('refresh:0;url=../../add_member.php');
            } else {
              $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
              $stmt->execute([
                $email
              ]);

              if ($stmt->rowCount()) {
                $_SESSION['error'] = 'Email is already token, please pick up another one';
                header('refresh:0;url=../../add_member.php');
              } else {
                $stmt = $pdo->prepare('INSERT INTO users (name, username, email, password, is_admin, phone, created_at) VALUES(?,?,?,?,?,?,?)');
                $stmt->execute([
                  $name,
                  $username,
                  $email,
                  password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]),
                  $role,
                  $phone,
                  date('Y-m-d H:i')
                ]);

                if ($stmt->rowCount()) {
                  $_SESSION['success'] = 'You add member success';
                  header('refresh:0;url=../../teams.php');
                } else {
                  $_SESSION['error'] = 'Something happen can not save data';
                  header('refresh:0;url=../../add_member.php');
                }
              }
            }
          } else {
            $_SESSION['error'] = 'Please provide a valid password';
            header('refresh:0;url=../../add_member.php');
          }
        } else {
          $_SESSION['error'] = 'Please provide a valid email';
          header('refresh:0;url=../../add_member.php');
        }
      } else {
        $_SESSION['error'] = 'Please provide a valid username';
        header('refresh:0;url=../../add_member.php');
      }
    } else {
      $_SESSION['error'] = 'Please provide a valid name';
      header('refresh:0;url=../../add_member.php');
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('refresh:0;url=../../add_member.php');
  }
} else {
  $_SESSION['error'] = 'Please Login';
  header('refresh:0;url=../../add_member.php');
}

