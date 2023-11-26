<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id'], $_POST['name'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['status'])
    && !empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['phone'])) {
    $id = htmlentities($_POST['id']);
    $name = htmlentities($_POST['name']);
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $phone = htmlentities($_POST['phone']);
    $status = htmlentities($_POST['status']);

    if (preg_match('/^[a-zA-Z ]*$/i', $name) && ctype_alnum($phone) && ctype_alnum($status)) {
      if (preg_match('/^[a-z0-9"_. ]*$/i', $username)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          try {
            global $pdo;
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('UPDATE customers SET name=:name, username=:username, email=:email, is_active=:is_active, phone=:phone, updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
              ':name' => $name,
              ':username' => $username,
              ':email' => $email,
              ':is_active' => $status,
              ':phone' => $phone,
              ':updated_at' => date('Y-m-d H:i'),
              ':id' => $id
            ]);

            if ($stmt->rowCount()) {
              echo json_encode(['status'=> 202, 'message'=> 'Update customer info successfully']);
              $pdo->commit();
            }
          } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['status'=> 303, 'message'=> 'Something happen please try later']);
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
