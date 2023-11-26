<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_FILES['profile-image']) && !empty($_FILES['profile-image'])) {
    $file = $_FILES['profile-image'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_error = $file['error'];
    $allowedExts = ['gif', 'png', 'jpg', 'jpeg'];
    $extension = explode('.', $file_name);
    $extension = strtolower(end($extension));

    if (in_array($extension, $allowedExts)) {
      if ($file_error === 0) {
        if ($file_size <= 2*1024*1024) {
          $file_new_name = sha1(uniqid('',true)) . '.' . $extension;
          $file_destination = "../../assets/images/profile/" . $file_new_name;
          if (move_uploaded_file($file_tmp, $file_destination)) {
            $file_destination = "images/profile/" . $file_new_name;
            global $pdo;
            $stmt = $pdo->prepare('UPDATE users SET image=:image WHERE id=:id');
            $stmt->execute([
              ':image' => $file_destination,
              ':id' => $_SESSION['id']
            ]);

            if ($stmt->rowCount()) {
              $_SESSION['image'] = $file_destination;
              $_SESSION['success'] = 'File has been uploaded successfully';
              header('Location: ../../account_setting.php');
            } else {
              $_SESSION['error'] = 'An error has occurred';
              header('Location: ../../account_setting.php');
            }
          }
        } else {
          $_SESSION['error'] = 'File size is big';
          header('Location: ../../account_setting.php');
        }
      } else {
        $_SESSION['error'] = 'An error has occurred';
        header('Location: ../../account_setting.php');
      }
    }  else {
      $_SESSION['error'] = 'Extension not allowed';
      header('Location: ../../account_setting.php');
    }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('Location: ../../account_setting.php');
  }
} else {
  $_SESSION['error'] = 'Please Login';
  header('Location: ../../account_setting.php');
}

