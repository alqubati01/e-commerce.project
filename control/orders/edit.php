<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_POST['orderId'], $_POST['orderNumber'], $_POST['orderCustomer'], $_POST['orderData'], $_POST['totalOrder']
      , $_POST['orderShipper'], $_POST['orderPayment'], $_POST['orderStatus'])
    && !empty($_POST['orderId']) && !empty($_POST['orderNumber']) && !empty($_POST['orderCustomer'])
    && !empty($_POST['orderData']) && !empty($_POST['totalOrder']) && !empty($_POST['orderShipper'])
    && !empty($_POST['orderPayment']) && !empty($_POST['orderStatus'])) {
    $order_id = $_POST['orderId'];
    $order_ref_number = $_POST['orderNumber'];
    $customer_id = $_POST['orderCustomer'];
    $order_data = $_POST['orderData'];
    $products_price = $_POST['totalOrder'];
    $total_price = $_POST['totalOrder'];
    $shipper_id = $_POST['orderShipper'];
    $payment_method = $_POST['orderPayment'];
    $order_status = $_POST['orderStatus'];

    global $pdo;
    $stmt = $pdo->prepare('UPDATE orders SET
        order_ref_number=:order_ref_number, customer_id=:customer_id, order_date=:order_date, 
        products_price=:products_price, total_price=:total_price, shipper_id=:shipper_id, payment_method=:payment_method, updated_at=:updated_at
        WHERE id=:id
      ');
    $stmt->execute([
      ':order_ref_number' => $order_ref_number,
      ':customer_id' => $customer_id,
      ':order_date' => $order_data,
      ':products_price' => $products_price,
      ':total_price' => $total_price,
      ':shipper_id' => $shipper_id,
      ':payment_method' => $payment_method,
      ':updated_at' => date('Y-m-d H:i'),
      ':id' => $order_id
    ]);

    $stmt = $pdo->prepare('UPDATE order_status SET
        status_id=:status_id, updated_at=:updated_at
        WHERE id=:id');

    $stmt->execute([
      ':status_id' => $order_status,
      ':updated_at' => date('Y-m-d H:i'),
      ':id' => $order_id
    ]);


    if ($stmt->rowCount()) {
      echo json_encode(['status'=> 202, 'message'=> 'Update order successfully']);
      exit();
    } else {
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