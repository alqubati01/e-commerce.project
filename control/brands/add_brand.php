<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//print_r($_FILES['brand-image']);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['brandName'], $_POST['categoryId'], $_FILES['brand-image'])
    && !empty($_POST['brandName']) && !empty($_POST['categoryId']) && !empty($_FILES['brand-image'])) {
    $brandName = htmlentities($_POST['brandName']);
    $categoryId = htmlentities($_POST['categoryId']);

    $file = $_FILES['brand-image'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_error = $file['error'];
    $allowedExts = ['gif', 'png', 'jpg', 'jpeg'];
    $extension = explode('.', $file_name);
    $extension = strtolower(end($extension));

    if (preg_match('/^[0-9]*$/', $categoryId)) {
      if (preg_match('/^[a-zA-Z0-9 ]*$/i', $brandName)) {
        if ($file_error === 0) {
          if (in_array($extension, $allowedExts)) {
            if ($file_size <= 2*1024*1024) {
              $file_new_name = sha1(uniqid('',true)) . '.' . $extension;
              $file_destination = "../../assets/images/brands/" . $file_new_name;
              if (move_uploaded_file($file_tmp, $file_destination)) {
                $file_destination = "images/brands/" . $file_new_name;
                global $pdo;
                $stmt = $pdo->prepare('INSERT INTO brands (name, category_id, image, created_at) VALUES(?,?,?,?)');
                $stmt->execute([
                  $brandName,
                  $categoryId,
                  $file_destination,
                  date('Y-m-d H:i')
                ]);

                if ($stmt->rowCount()) {
                  echo json_encode(['status'=> 202, 'message'=> 'Insert brand successfully']);
                  exit();
                } else {
                  echo json_encode(['status'=> 303, 'message'=> 'Something happen']);
                  exit();
                }
              }
            } else {
              echo json_encode(['status'=> 303, 'message'=> 'File size is big']);
              exit();
            }
          } else {
            echo json_encode(['status'=> 303, 'message'=> 'The extension not allowed']);
            exit();
          }
        } else {
          global $pdo;
          $stmt = $pdo->prepare('INSERT INTO brands (name, category_id, created_at) VALUES(?,?,?)');
          $stmt->execute([
            $brandName,
            $categoryId,
            date('Y-m-d H:i')
          ]);

          if ($stmt->rowCount()) {
            echo json_encode(['status'=> 202, 'message'=> 'Insert brand successfully']);
            exit();
          } else {
            echo json_encode(['status' => 303, 'message' => 'Something happen']);
            exit();
          }
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid name']);
        exit();
      }
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'The category id not correct']);
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
