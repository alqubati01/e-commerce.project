<?php

session_start();
require_once '../../inc/Database.php';

$statues = ['active', 'suspend'];

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id'], $_POST['status']) && !empty($_POST['id']) && !empty($_POST['status'])) {
    if (in_array($_POST['status'], $statues)) {
      if (preg_match('/^[0-9]*$/', $_POST['id'])) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
        $stmt->execute([
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          switch ($_POST['status']) {
            case 'active':
              $stmt = $pdo->prepare('UPDATE users SET is_active=:active WHERE id=:id');
              $stmt->execute([
                ':id' => $_POST['id'],
                ':active' => 1
              ]);

              if ($stmt->rowCount()) {
                echo json_encode(['status'=> 202, 'message'=> 'Success active user']);
                exit();
              } else {
                echo json_encode(['status'=> 303, 'message'=> 'Error active user']);
                exit();
              }
              break;
            case 'suspend':
              $stmt = $pdo->prepare('UPDATE users SET is_active=:suspend WHERE id=:id');
              $stmt->execute([
                ':id' => $_POST['id'],
                ':suspend' => 0
              ]);

              if ($stmt->rowCount()) {
                echo json_encode(['status'=> 202, 'message'=> 'Success suspend user']);
                exit();
              } else {
                echo json_encode(['status'=> 303, 'message'=> 'Error suspend user']);
                exit();
              }
              break;
          }
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'This user not found']);
          exit();
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'The user id not correct']);
        exit();
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The status of user not founded']);
      exit();
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
  exit();
}
