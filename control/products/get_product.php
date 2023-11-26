<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    global $pdo;
    $productData = $pdo->prepare('SELECT p.id, p.name AS productName, p.price, p.product_cost, p.description, s.sku, s.qty, b.id AS brandId, b.name AS brandName
      FROM products p
      LEFT JOIN stock s
        ON p.id = s.product_id
      LEFT JOIN brands b
        ON p.brand_id = b.id
      WHERE p.id = ?');
    $productData->execute([
      $_GET['id'],
    ]);

    $productAttachments = $pdo->prepare('SELECT a.id, a.filename, a.path, a.size
      FROM products p
      LEFT JOIN attachments a
        ON p.id = a.product_id
      WHERE p.id = ?');
    $productAttachments->execute([
      $_GET['id'],
    ]);

    $productCategories = $pdo->prepare('SELECT cp.id, cp.category_id, c.name
      FROM products p
      LEFT JOIN category_product cp
        ON p.id = cp.product_id
      LEFT JOIN categories c
        ON cp.category_id = c.id
      WHERE p.id = ?');
    $productCategories->execute([
      $_GET['id'],
    ]);


    if ($productData->rowCount() && $productAttachments->rowCount() && $productCategories->rowCount()) {
      $productData = $productData->fetchAll();
      $productAttachments = $productAttachments->fetchAll();
      $productCategories = $productCategories->fetchAll();
      $productDetails = array_merge(['basic' => $productData], ['attachments' => $productAttachments], ['categories' => $productCategories]);

      echo json_encode($productDetails);
//      header("Location: ../../edit_product.php?productDetails=".$productDetails);
    } else {
      echo json_encode(['status'=> 202, 'message'=> 'User id does not exists']);
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please Login']);
  exit();
}



