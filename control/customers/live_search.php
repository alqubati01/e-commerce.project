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
    c.id,
    c.name,
    c.created_at,
    c.phone,
    c.email,
    (
        SELECT
            COUNT(o.customer_id)
        FROM
            orders o
        WHERE
            c.id = o.customer_id
    ) AS orderCount
    FROM customers c
    WHERE name LIKE ?');
  $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
  $stmt->execute();
  ?>
  <div class="nk-tb-list is-separate mb-3">
  <div class="nk-tb-item nk-tb-head">
    <div class="nk-tb-col nk-tb-col-check">
      <div class="custom-control custom-control-sm custom-checkbox notext">
        <input type="checkbox" class="custom-control-input" id="uid">
        <label class="custom-control-label" for="uid"></label>
      </div>
    </div>
    <div class="nk-tb-col"><span class="sub-text">Name</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Created At</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Phone</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Email</span></div>
    <div class="nk-tb-col tb-col-md"><span class="sub-text">Order Count</span></div>
    <div class="nk-tb-col nk-tb-col-tools">
      <ul class="nk-tb-actions gx-1 my-n1">
        <li>
          <div class="drodown">
            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul class="link-list-opt no-bdr">
                <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email to All</span></a></li>
                <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend Selected</span></a></li>
                <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Seleted</span></a></li>
                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Password</span></a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div><!-- .nk-tb-item -->

  <?php
  if ($stmt->rowCount()) {
    foreach ($stmt->fetchAll() as $customer) {
      ?>
      <div class="nk-tb-item">
        <div class="nk-tb-col nk-tb-col-check">
          <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" class="custom-control-input" id="uid1">
            <label class="custom-control-label" for="uid1"></label>
          </div>
        </div>
        <div class="nk-tb-col">
          <a href="">
            <div class="user-card">
              <div class="user-avatar bg-primary">
                <span>AB</span>
              </div>
              <div class="user-info">
                <span class="tb-lead"><?= $customer['name'] ?> <span class="dot dot-success d-md-none ml-1"></span></span>
              </div>
            </div>
          </a>
        </div>
        <div class="nk-tb-col tb-col-lg">
          <span><?= $customer['created_at'] ?></span>
        </div>
        <div class="nk-tb-col tb-col-lg">
          <span><?= $customer['phone'] ?></span>
        </div>
        <div class="nk-tb-col tb-col-lg">
          <span><?= $customer['email'] ?></span>
        </div>
        <div class="nk-tb-col tb-col-md">
          <span><?= $customer['orderCount'] ?></span>
        </div>
        <div class="nk-tb-col nk-tb-col-tools">
          <ul class="nk-tb-actions gx-1">
            <li>
              <div class="drodown">
                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <ul class="link-list-opt no-bdr">
                    <li>
                      <a href="#" class="delete-user" data-suspend-user="<?= $customer['id']?>"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                    </li>
                    <li>
                      <a href="#" class="delete-user" data-suspend-user="<?= $customer['id']?>"><em class="icon ni ni-trash"></em><span>Delete</span></a>
                    </li>
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
    echo 'No users founded yet';
  }
} else {
  echo 'Please login';
}

