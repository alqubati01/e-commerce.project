<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['name'], $_POST['username'], $_POST['email'])
    && !empty($_POST['name']) && !empty($_POST['username']) && !empty($_POST['email'])) {
    $name = htmlentities($_POST['name']);
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    if (!empty($_POST['phone'])) {
      if (ctype_alnum($_POST['phone'])) {
        $phone = $_POST['phone'];
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid number phone']);
      }
    } else {
      $phone = NULL;
    }

    if (preg_match('/^[a-zA-Z ]*$/i', $name)) {
      if (preg_match('/^[a-z0-9"_. ]*$/i', $username)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          try {
            global $pdo;
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('UPDATE users SET name=:name, username=:username, email=:email, phone=:phone, updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
              ':name' => $name,
              ':username' => $username,
              ':email' => $email,
              ':phone' => $phone,
              ':updated_at' => date('Y-m-d H:i'),
              ':id' => $_SESSION['id']
            ]);

            if ($stmt->rowCount()) {
              $_SESSION['name'] = $name;
              echo json_encode(['status'=> 202, 'message'=> 'Update basic info successfully']);
              $pdo->commit();
            }
//          else {
//            echo json_encode(['status'=> 303, 'message'=> 'Something happen please try later']);
//          }
          } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['status'=> 303, 'message'=> 'Something happen please try later']);
          }
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid email']);
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid username']);
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid name']);
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
}

