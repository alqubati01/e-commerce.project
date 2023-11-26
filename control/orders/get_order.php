<?php

session_start();
require_once '../../inc/Database.php';


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT o.id, o.order_ref_number, o.order_date, os.status_id AS 'order_status_id', st.name, 
       o.customer_id, c.name AS 'customer_name', o.shipper_id, s.name AS 'shipper_name', o.payment_method, pm.name AS 'payment_name'
      FROM orders o
      JOIN order_status os
        ON o.id = os.order_id
      JOIN statuses st
        ON os.status_id = st.id
      JOIN customers c
        ON o.customer_id = c.id
      JOIN shippers s
        ON o.shipper_id = s.id
      JOIN payment_methods pm
        ON o.payment_method = pm.id
      WHERE o.id = :id");
    $stmt->execute([
      ':id' => $_GET['id']
    ]);

    if ($stmt->rowCount()) {
      echo json_encode($stmt->fetch());
    } else {
      echo json_encode(['status'=> 303, 'message'=> 'Error Happen try later']);
    }
  } else {
    echo json_encode(['status'=> 303, 'message'=> 'Please fill the fields']);
    exit();
  }
} else {
  echo json_encode(['status'=> 303, 'message'=> 'Please login']);
}
