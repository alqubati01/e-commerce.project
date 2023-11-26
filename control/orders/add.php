<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['orderNumber'], $_POST['orderCustomer'], $_POST['orderData'], $_POST['totalOrder']
      , $_POST['orderShipper'], $_POST['orderPayment'], $_POST['orderStatus'])
    && !empty($_POST['orderNumber']) && !empty($_POST['orderCustomer']) && !empty($_POST['orderData'])
    && !empty($_POST['totalOrder']) && !empty($_POST['orderShipper']) && !empty($_POST['orderPayment'])
    && !empty($_POST['orderStatus'])) {
    $order_ref_number = $_POST['orderNumber'];
    $customer_id = $_POST['orderCustomer'];
    $order_data = $_POST['orderData'];
    $products_price = $_POST['totalOrder'];
    $total_price = $_POST['totalOrder'];
    $shipper_id = $_POST['orderShipper'];
    $payment_method = $_POST['orderPayment'];
    $order_status = $_POST['orderStatus'];

    try {
      global $pdo;
      $pdo->beginTransaction();

      $stmt = $pdo->prepare('INSERT INTO orders
        (order_ref_number, customer_id, order_date, products_price, total_price, shipper_id, payment_method, created_at)
        VALUES (?,?,?,?,?,?,?,?)');
      $stmt->execute([
        $order_ref_number,
        $customer_id,
        $order_data,
        $products_price,
        $total_price,
        $shipper_id,
        $payment_method,
        date('Y-m-d H:i')
      ]);

      $order_id = $pdo->lastInsertId();

      foreach ($_SESSION['cart'] as $product_id => $qty) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id=:id');
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        $stmt = $pdo->prepare('INSERT INTO order_item
          (order_id, product_id, qty, price_per_unit, total, created_at)
          VALUES (?,?,?,?,?,?)');

        $stmt->execute([
          $order_id,
          $product_id,
          $qty,
          $product['price'],
          $qty * $product['price'],
          date('Y-m-d H:i')
        ]);
      }

      $stmt = $pdo->prepare('INSERT INTO order_status
        (order_id, status_id, created_at)
        VALUES (?,?,?)');

      $stmt->execute([
        $order_id,
        $order_status,
        date('Y-m-d H:i')
      ]);

      if ($stmt->rowCount()) {
        $pdo->commit();
        echo json_encode(['status'=> 202, 'message'=> 'Insert order successfully']);
        unset($_SESSION['cart']);
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
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please Login']);
  exit();
}









