<?php

session_start();
require_once '../../inc/Database.php';

const ROW_PER_PAGE = 10;

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  $per_page_html = '';
  $page = 1;
  $offset = 0;

  if(isset($_POST["page"]) && !empty($_POST["page"])) {
    $page = $_POST["page"];
    $offset = ($page - 1) * ROW_PER_PAGE;
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
    ORDER BY o.id
    LIMIT ?, ?');
  $stmt->execute([
    $offset,
    ROW_PER_PAGE
  ]);

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
                    <li><a href="edit_order.php?id=<?= $order['id']; ?>"><em class="icon ni ni-edit"></em><span>Edit Order</span></a></li>
                    <li><a href="#" class="mark-as-delivered" data-mark-delivered="<?= $order['id']; ?>"><em class="icon ni ni-truck"></em><span>Mark as Delivered</span></a></li>
                    <li><a href="#" class="mark-as-paid" data-mark-paid="<?= $order['id']; ?>"><em class="icon ni ni-money"></em><span>Mark as Paid</span></a></li>
                    <li><a href="./control/orders/extract.php"><em class="icon ni ni-report-profit"></em><span>Send Invoice</span></a></li>
                    <li><a href="#" class="delete-order" data-delete-order="<?= $order['id']; ?>"><em class="icon ni ni-trash"></em><span>Delete Order</span></a></li>
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
    $stmt = $pdo->prepare('SELECT id FROM orders');
    $stmt->execute();
    $row_count = $stmt->rowCount();

    if (!empty($row_count) && $row_count > 10) {
      $total_pages = ceil($row_count/ROW_PER_PAGE);
      ?>
      <div class="card">
        <div class="card-inner">
          <div class="nk-block-between-md g-3">
            <nav>
              <ul class="pagination" id="pagination">
                <?php
                if($total_pages > 1) {
                  for($i = 1; $i <= $total_pages; $i++) {
                    if($i == $page){
                      ?>
                      <li class="page-item active" aria-current="page"><a class="page-link" id="<?= $i ?>" href="#"><?= $i ?><span class="sr-only">(current)</span></a></li>
                      <?php
                    } else {
                      ?>
                      <li class="page-item"><a class="page-link" id="<?= $i ?>" href="#"><?= $i ?></a></li>
                      <?php
                    }
                  }
                }
                ?>
              </ul>
            </nav>
          </div><!-- .nk-block-between -->
        </div><!-- .card-inner -->
      </div><!-- .card -->
      <?php
    }
  } else {
    echo 'No users founded yet';
  }
} else {
  echo 'Please login';
}
