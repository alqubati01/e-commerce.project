<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['customer_id'], $_POST['city_id'], $_POST['address'], $_POST['phone'])
    && !empty($_POST['customer_id']) && !empty($_POST['city_id']) && !empty($_POST['address']) && !empty($_POST['phone'])) {
    $customer_id = htmlentities($_POST['customer_id']);
    $city_id = htmlentities($_POST['city_id']);
    $address = htmlentities($_POST['address']);
    $phone = htmlentities($_POST['phone']);

    if (ctype_alnum($customer_id) && ctype_alnum($city_id) && ctype_alnum($phone)) {
      if (preg_match('/^[a-z0-9"_. ]*$/i', $address)) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO addresses (customer_id, city_id, address, phone, created_at) VALUES(?,?,?,?,?)');
        $stmt->execute([
          $customer_id,
          $city_id,
          $address,
          $phone,
          date('Y-m-d H:i')
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status'=> 202, 'message'=> 'You add address success']);
          exit();
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Something happen can not save data']);
          exit();
        }
      } else {
        echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid address']);
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