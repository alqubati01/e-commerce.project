<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//print_r($_FILES);
//print_r($_FILES['file']['name'][0] === 'blob');
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['productId'], $_POST['productName'], $_POST['productQty'], $_POST['productSku'], $_POST['productPrice'], $_POST['productCost']
      , $_POST['categoryIds'], $_POST['brandId'], $_POST['productDesc'], $_POST['productMainPict'], $_FILES['file'])
    && !empty($_POST['productId']) && !empty($_POST['productName']) && !empty($_POST['productPrice'])
    && !empty($_POST['productSku']) && !empty($_POST['categoryIds'])&& !empty($_POST['brandId'])) {
    $productId = $_POST['productId'];
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

      $stmt = $pdo->prepare('UPDATE products SET name=:name, price=:price, product_cost=:product_cost, brand_id=:brand_id, 
                    description=:description, updated_at=:updated_at WHERE id=:id');
      $stmt->execute([
        ':id' => $productId,
        ':name' => $productName,
        ':price' => $productPrice,
        ':product_cost' => $productCost,
        ':brand_id' => $brandId,
        ':description' => $productDesc,
        ':updated_at' => date('Y-m-d H:i')
      ]);

      $stmt = $pdo->prepare('UPDATE stock SET sku=:sku, qty=:qty, updated_at=:updated_at WHERE product_id=:product_id');
      $stmt->execute([
        ':product_id' => $productId,
        ':sku' => $productSku,
        ':qty' => $productQty,
        ':updated_at' => date('Y-m-d H:i')
      ]);

      $stmt = $pdo->prepare('DELETE FROM category_product WHERE product_id=:product_id');
      $stmt->execute([
        ':product_id' => $productId
      ]);

      foreach($categoryIdsArray as $categoryId) {
        $category_id = $categoryId;
        $product_id = $productId;
        $created_at = date('Y-m-d H:i');
        $updated_at = date('Y-m-d H:i');

        $category_product[] = "('$category_id','$product_id','$created_at','$updated_at')";
      }

      $stmt = $pdo->prepare('INSERT INTO category_product (category_id, product_id, created_at, updated_at) VALUES' . implode(', ', $category_product));
      $stmt->execute();

      if ($_FILES['file']['name'][0] !== 'blob') {
        $productImage = array();
        $file = $_FILES['file'];
        $allowedExts = ['gif', 'png', 'jpg', 'jpeg'];

        for($index = 0; $index < count($_FILES['file']['name']); $index++) {
          $product_id = $productId;
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
      }

      if ($stmt->rowCount()) {
        $pdo->commit();
        echo json_encode(['status'=> 202, 'message'=> 'Update product successfully']);
        exit();
      }
    }  catch (PDOException $e) {
      $pdo->rollBack();
      echo json_encode(['status'=> 303, 'message'=> 'Something happen']);
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