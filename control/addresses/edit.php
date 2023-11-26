<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['id'], $_POST['city_id'], $_POST['address'], $_POST['phone'])
    && !empty($_POST['id']) && !empty($_POST['city_id']) && !empty($_POST['address']) && !empty($_POST['phone'])) {
    $id = htmlentities($_POST['id']);
    $city_id= htmlentities($_POST['city_id']);
    $address = htmlentities($_POST['address']);
    $phone = htmlentities($_POST['phone']);

    if (ctype_alnum($id) && ctype_alnum($city_id) && ctype_alnum($phone)) {
      if (preg_match('/^[a-z0-9"_. ]*$/i', $address)) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE addresses SET city_id=:city_id, address=:address, phone=:phone, updated_at=:updated_at WHERE id=:id');
        $stmt->execute([
          ':city_id' => $city_id,
          ':address' => $address,
          ':phone' => $phone,
          ':updated_at' => date('Y-m-d H:i'),
          ':id' => $id
        ]);

        if ($stmt->rowCount()) {
          echo json_encode(['status'=> 202, 'message'=> 'Update address successfully']);
          exit();
        } else {
          echo json_encode(['status'=> 303, 'message'=> 'Please provide a valid email']);
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
