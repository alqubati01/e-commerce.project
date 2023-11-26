<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_GET);
//die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT a.id, a.customer_id, a.address, a.phone, c.name
      FROM addresses a
      JOIN cities c
        ON a.city_id = c.id
      WHERE customer_id=?
      ORDER BY a.id');
    $stmt->execute([
      $_GET['id']
    ]);

    ?>

    <div class="nk-tb-item nk-tb-head">
      <div class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
          <input type="checkbox" class="custom-control-input" id="uid">
          <label class="custom-control-label" for="uid"></label>
        </div>
      </div>
      <div class="nk-tb-col"><span class="sub-text">City name</span></div>
      <div class="nk-tb-col tb-col-lg"><span class="sub-text">Address</span></div>
      <div class="nk-tb-col tb-col-lg"><span class="sub-text">Phone</span></div>
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
      foreach ($stmt->fetchAll() as $address) {
        ?>
        <div class="nk-tb-item">
          <div class="nk-tb-col nk-tb-col-check">
            <div class="custom-control custom-control-sm custom-checkbox notext">
              <input type="checkbox" class="custom-control-input" id="uid1">
              <label class="custom-control-label" for="uid1"></label>
            </div>
          </div>
          <div class="nk-tb-col tb-col-lg">
            <span><?= $address['name'] ?></span>
          </div>
          <div class="nk-tb-col tb-col-lg">
            <span><?= $address['address'] ?></span>
          </div>
          <div class="nk-tb-col tb-col-lg">
            <span><?= $address['phone'] ?></span>
          </div>
          <div class="nk-tb-col nk-tb-col-tools">
            <ul class="nk-tb-actions gx-1">
              <li>
                <div class="drodown">
                  <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <ul class="link-list-opt no-bdr">
                      <li>
                        <a href="#" class="edit-address" data-edit-address="<?= $address['id']?>"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                      </li>
                      <li>
                        <a href="#" class="delete-address" data-delete-address="<?= $address['id']?>"><em class="icon ni ni-trash"></em><span>Delete</span></a>
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
    } else {
      echo 'No Addresses yet';
    }
  } else {
    echo 'Please file the filed';
  }
} else {
  echo 'Please login';
}



