<?php

session_start();
require_once '../../inc/Database.php';

$roles = ['admin', 'member'];

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id'], $_POST['role']) && !empty($_POST['id']) && !empty($_POST['role'])) {
    if (in_array($_POST['role'], $roles)) {
      if (preg_match('/^[0-9]*$/', $_POST['id'])) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
        $stmt->execute([
          ':id' => $_POST['id']
        ]);

        if ($stmt->rowCount()) {
          switch ($_POST['role']) {
            case 'admin':
              $stmt = $pdo->prepare('UPDATE users SET is_admin=:admin WHERE id=:id');
              $stmt->execute([
                ':id' => $_POST['id'],
                ':admin' => 1
              ]);

              if ($stmt->rowCount()) {
                echo json_encode(['status'=> 202, 'message'=> 'Success change user to admin']);
                exit();
              } else {
                echo json_encode(['status'=> 303, 'message'=> 'Error change user to admin']);
                exit();
              }
              break;
            case 'member':
              $stmt = $pdo->prepare('UPDATE users SET is_admin=:member WHERE id=:id');
              $stmt->execute([
                ':id' => $_POST['id'],
                ':member' => 0
              ]);

              if ($stmt->rowCount()) {
                echo json_encode(['status'=> 202, 'message'=> 'Success change user to member']);
                exit();
              } else {
                echo json_encode(['status'=> 303, 'message'=> 'Error change user to member']);
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
