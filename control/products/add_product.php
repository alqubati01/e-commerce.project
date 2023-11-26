<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_FILES);
//print_r($_POST);
//die();


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['productName'], $_POST['productQty'], $_POST['productSku'], $_POST['productPrice'], $_POST['productCost']
      , $_POST['categoryIds'], $_POST['brandId'], $_POST['productDesc'], $_POST['productMainPict'], $_FILES['file'])
    && !empty($_POST['productName']) && !empty($_POST['productPrice']) && !empty($_POST['productSku'])
    && !empty($_POST['categoryIds'])&& !empty($_POST['brandId'])) {
    $productName = $_POST['productName'];
    $productQty = $_POST['productQty'];
    $productSku = $_POST['productSku'];
    $productPrice = $_POST['productPrice'];
    $productCost = $_POST['productCost'];
    $categoryIds = $_POST['categoryIds'];
    $brandId = $_POST['brandId'];
    $productDesc = $_POST['productDesc'];
    $productMainPict = $_POST['productMainPict'];

    if (empty($productQty)) {
      $productQty = NULL;
    } else {
      $productQty = $productQty;
    }

    $categoryIdsArray = explode(',', $categoryIds);
    $category_product = array();

    try {
      global $pdo;
      $pdo->beginTransaction();

      $stmt = $pdo->prepare('INSERT INTO products (name, price, product_cost, brand_id, description, created_at) VALUES(?,?,?,?,?,?)');
      $stmt->execute([
        $productName,
        $productPrice,
        $productCost,
        $brandId,
        $productDesc,
        date('Y-m-d H:i')
      ]);

      $product_id = $pdo->lastInsertId();

      $stmt = $pdo->prepare('INSERT INTO stock (product_id, sku, qty, created_at) VALUES(?,?,?,?)');
      $stmt->execute([
        $product_id,
        $productSku,
        $productQty,
        date('Y-m-d H:i')
      ]);

      foreach($categoryIdsArray as $categoryId) {
        $category_id = $categoryId;
        $product_id = $product_id;
        $created_at = date('Y-m-d H:i');

        $category_product[] = "('$category_id','$product_id','$created_at')";
      }

      $stmt = $pdo->prepare('INSERT INTO category_product (category_id, product_id, created_at) VALUES' . implode(', ', $category_product));
      $stmt->execute();


      $productImage = array();
      $file = $_FILES['file'];
      $allowedExts = ['gif', 'png', 'jpg', 'jpeg'];

      for($index = 0; $index < count($_FILES['file']['name']); $index++) {
        $product_id = $product_id;
        $file_name = $file['name'][$index];
        $file_size = $file['size'][$index];
        $file_type = $file['type'][$index];
        $file_tmp = $file['tmp_name'][$index];
        $file_error = $file['error'][$index];
        $extension = explode('.', $file_name);
        $extension = strtolower(end($extension));
        $file_new_name = sha1(uniqid('',true)) . '.' . $extension;
        $file_destination = "../../assets/images/products/" . $file_new_name;
        move_uploaded_file($file_tmp, $file_destination);
        $file_destination = "images/products/" . $file_new_name;
        $created_at = date('Y-m-d H:i');

        $productImage[] = "('$product_id','$file_name','$file_destination','$extension','$file_type','$file_size','$created_at')";
      }

      $stmt = $pdo->prepare('INSERT INTO attachments (product_id, filename, path, extension, mime, size, created_at) VALUES' . implode(', ', $productImage));
      $stmt->execute();

      if ($stmt->rowCount()) {
        $pdo->commit();
        echo json_encode(['status'=> 202, 'message'=> 'Insert product successfully']);
        exit();
      }
    } catch (PDOException $e) {
      $pdo->rollBack();
      echo json_encode(['status'=> 303, 'message'=> 'Something happen']);
      exit();
    }

  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
}  else {
  echo json_encode(['status'=> 303, 'message'=> 'Please Login']);
  exit();
}
