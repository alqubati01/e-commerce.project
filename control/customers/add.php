<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['statues'])
    && !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['phone'])) {
    $name = htmlentities($_POST['name']);
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $phone = htmlentities($_POST['phone']);
    $statue = htmlentities($_POST['statues']);

    if (preg_match('/^[a-zA-Z ]*$/i', $name) && ctype_alnum($phone) && ctype_alnum($statue)) {
      if (preg_match('/^[a-z0-9"_. ]*$/i', $username)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          if (strlen($password) >= 8 && strlen($password) <= 32) {
            global $pdo;
            $stmt = $pdo->prepare('SELECT * FROM customers WHERE username=?');
            $stmt->execute([
              $username
            ]);

            if ($stmt->rowCount()) {
              echo json_encode(['status'=> 303, 'message'=> 'Username is already token, please pick up another one']);
              exit();
            } else {
              $stmt = $pdo->prepare('SELECT * FROM customers WHERE email=?');
              $stmt->execute([
                $email
              ]);

              if ($stmt->rowCount()) {
                echo json_encode(['status'=> 303, 'message'=> 'Email is already token, please pick up another one']);
                exit();
              } else {
                $stmt = $pdo->prepare('INSERT INTO customers (name, username, email, password, is_active, phone, created_at) VALUES(?,?,?,?,?,?,?)');
                $stmt->execute([
                  $name,
                  $username,
                  $email,
                  password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]),
                  $statue,
                  $phone,
                  date('Y-m-d H:i')
                ]);

                if ($stmt->rowCount()) {
                  echo json_encode(['status'=> 202, 'message'=> 'You add customer success']);
                  exit();
                } else {
                  echo json_encode(['status'=> 303, 'message'=> 'Something happen can not save data']);
                  exit();
                }
              }
            }
          } else {
            echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid password']);
            exit();
          }
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid email']);
          exit();
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid username']);
        exit();
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid data']);
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