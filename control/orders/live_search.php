<?php

session_start();
require_once '../../inc/Database.php';


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  $search = '';
  if (!empty($_POST['search'])) {
    $search = $_POST['search'];
  }

  global $pdo;
  $stmt = $pdo->prepare('SELECT
    o.id,
    o.order_ref_number,
    o.order_date,
    s.name AS status,
    c.name AS customer,
    o.total_price,
    (
        SELECT
            COUNT(*)
        FROM
            order_item oi
        WHERE
            oi.order_id = o.id
    ) AS purchased
    FROM orders o
    JOIN order_status os ON o.id = os.order_id
    JOIN statuses s ON os.status_id = s.id
    JOIN customers c ON o.customer_id = c.id
    WHERE o.order_ref_number LIKE ?');
  $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
  $stmt->execute();
  ?>
  <div class="nk-tb-list is-separate is-medium mb-3">
  <div class="nk-tb-item nk-tb-head">
    <div class="nk-tb-col nk-tb-col-check">
      <div class="custom-control custom-control-sm custom-checkbox notext">
        <input type="checkbox" class="custom-control-input" id="uid">
        <label class="custom-control-label" for="uid"></label>
      </div>
    </div>
    <div class="nk-tb-col"><span>Order</span></div>
    <div class="nk-tb-col tb-col-md"><span>Date</span></div>
    <div class="nk-tb-col"><span class="d-none d-mb-block">Status</span></div>
    <div class="nk-tb-col tb-col-sm"><span>Customer</span></div>
    <div class="nk-tb-col tb-col-md"><span>Purchased</span></div>
    <div class="nk-tb-col"><span>Total</span></div>
    <div class="nk-tb-col nk-tb-col-tools">
      <ul class="nk-tb-actions gx-1 my-n1">
        <li>
          <div class="drodown">
            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul class="link-list-opt no-bdr">
                <li><a href="#"><em class="icon ni ni-edit"></em><span>Update Status</span></a></li>
                <li><a href="#"><em class="icon ni ni-truck"></em><span>Mark as Delivered</span></a></li>
                <li><a href="#"><em class="icon ni ni-money"></em><span>Mark as Paid</span></a></li>
                <li><a href="#"><em class="icon ni ni-report-profit"></em><span>Send Invoice</span></a></li>
                <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Orders</span></a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div><!-- .nk-tb-item -->

  <?php
  if ($stmt->rowCount()) {
    foreach ($stmt->fetchAll() as $order) {
      ?>
      <div class="nk-tb-item">
        <div class="nk-tb-col nk-tb-col-check">
          <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" class="custom-control-input" id="uid1">
            <label class="custom-control-label" for="uid1"></label>
          </div>
        </div>
        <div class="nk-tb-col">
          <span class="tb-lead"><a href="#"><?= $order['order_ref_number']; ?></a></span>
        </div>
        <div class="nk-tb-col tb-col-md">
          <span class="tb-sub"><?= $order['order_date']; ?></span>
        </div>
        <div class="nk-tb-col">
          <span class="dot bg-warning d-mb-none"></span>
          <span class="badge badge-sm badge-dot has-bg badge-warning d-none d-mb-inline-flex"><?= $order['status']; ?></span>
        </div>
        <div class="nk-tb-col tb-col-sm">
          <span class="tb-sub"><?= $order['customer']; ?></span>
        </div>
        <div class="nk-tb-col tb-col-md">
          <span class="tb-sub text-primary"><?= $order['purchased']; ?></span>
        </div>
        <div class="nk-tb-col">
          <span class="tb-lead"><?= $order['total_price']; ?></span>
        </div>
        <div class="nk-tb-col nk-tb-col-tools">
          <ul class="nk-tb-actions gx-1">
            <li class="nk-tb-action-hidden"><a href="#" class="btn btn-icon btn-trigger btn-tooltip" title="Mark as Delivered" data-toggle="dropdown">
                <em class="icon ni ni-truck"></em></a></li>
            <li class="nk-tb-action-hidden"><a href="#" class="btn btn-icon btn-trigger btn-tooltip" title="View Order" data-toggle="dropdown">
                <em class="icon ni ni-eye"></em></a></li>
            <li>
              <div class="drodown mr-n1">
                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <ul class="link-list-opt no-bdr">
                    <li><a href="#"><em class="icon ni ni-eye"></em><span>Order Details</span></a></li>
                    <li><a href="#"><em class="icon ni ni-truck"></em><span>Mark as Delivered</span></a></li>
                    <li><a href="#"><em class="icon ni ni-money"></em><span>Mark as Paid</span></a></li>
                    <li><a href="#"><em class="icon ni ni-report-profit"></em><span>Send Invoice</span></a></li>
                    <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Order</span></a></li>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div><!-- .nk-tb-item -->
      <?php
    }
    ?>
    </div><!-- .nk-tb-list -->
    <?php
  } else {
    echo 'No orders founded yet';
  }
} else {
  echo 'Please login';
}

