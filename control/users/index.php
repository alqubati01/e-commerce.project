<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  global $pdo;
  $stmt = $pdo->prepare('SELECT name, username, email, phone, image FROM users where id=?');
  $stmt->execute([
    $_SESSION['id']
  ]);

  if ($stmt->rowCount()) {
    echo json_encode($stmt->fetch());
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'User id does not exists']);
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
}


