<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//print_r($_FILES['edit-brand-image']);
////print_r($_FILES['edit-brand-image']['name']);
////print_r($_FILES['edit-brand-image']['size']);
//
//if ($_FILES['edit-brand-image']['size'] > 0) {
//  echo 'hello';
//} else {
//  echo 'hi';
//}
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['brandId'], $_POST['brandName'], $_POST['categoryId'], $_FILES['edit-brand-image'])
    && !empty($_POST['brandId']) && !empty($_POST['brandName']) && !empty($_POST['categoryId'])) {
    $brandName = htmlentities($_POST['brandName']);
    $categoryId = htmlentities($_POST['categoryId']);

    $file = $_FILES['edit-brand-image'];
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
                $stmt = $pdo->prepare('UPDATE brands SET name=:name, category_id=:category_id, image=:image, updated_at=:updated_at WHERE id=:id');
                $stmt->execute([
                  ':name' => $brandName,
                  ':category_id' => $categoryId,
                  ':image' => $file_destination,
                  ':updated_at' => date('Y-m-d H:i'),
                  ':id' => $_POST['brandId']
                ]);

                if ($stmt->rowCount()) {
                  echo json_encode(['status'=> 202, 'message'=> 'Edit brand successfully']);
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
          $stmt = $pdo->prepare('SELECT * FROM brands WHERE id=:id');
          $stmt->execute([
            ':id' => $_POST['brandId']
          ]);

          if ($stmt->rowCount()) {
            $brand = $stmt->fetch();
            $stmt = $pdo->prepare('UPDATE brands SET name=:name, category_id=:category_id, image=:image, updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
              ':name' => $brandName,
              ':category_id' => $categoryId,
              ':image' => $brand['image'],
              ':updated_at' => date('Y-m-d H:i'),
              ':id' => $_POST['brandId']
            ]);

            if ($stmt->rowCount()) {
              echo json_encode(['status'=> 202, 'message'=> 'Edit brand successfully']);
              exit();
            } else {
              echo json_encode(['status'=> 303, 'message'=> 'Something happen']);
              exit();
            }
          } else {
            echo json_encode(['status'=> 303, 'message'=> 'the brand not founded']);
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
