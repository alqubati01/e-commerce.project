<?php

session_start();
require_once '../../inc/Database.php';

const ROW_PER_PAGE = 10;

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  $per_page_html = '';
  $page = 1;
  $offset = 0;

  if(isset($_POST["page"]) && !empty($_POST["page"])){
    $page = $_POST["page"];
    $offset = ($page - 1) * ROW_PER_PAGE;
  }

  global $pdo;
  $stmt = $pdo->prepare('SELECT id, name, username, email, is_active, is_admin, phone, image, created_at FROM users
    LIMIT ?, ?');
  $stmt->execute([
    $offset,
    ROW_PER_PAGE
  ]);

?>
  <div class="nk-tb-list is-separate mb-3">
    <div class="nk-tb-item nk-tb-head">
      <div class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
          <input type="checkbox" class="custom-control-input" id="uid">
          <label class="custom-control-label" for="uid"></label>
        </div>
      </div>
      <div class="nk-tb-col"><span class="sub-text">User</span></div>
      <div class="nk-tb-col tb-col-lg"><span class="sub-text">Username</span></div>
      <div class="nk-tb-col tb-col-lg"><span class="sub-text">Role</span></div>
      <div class="nk-tb-col tb-col-lg"><span class="sub-text">Created At</span></div>
      <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
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
    foreach ($stmt->fetchAll() as $user) {
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
                  <span class="tb-lead"><?= $user['name'] ?> <span class="dot dot-success d-md-none ml-1"></span></span>
                  <span><?= $user['email'] ?></span>
                </div>
              </div>
            </a>
          </div>
          <div class="nk-tb-col tb-col-lg">
            <span><?= $user['username'] ?></span>
          </div>
          <div class="nk-tb-col tb-col-lg">
            <?php
            if ($user['is_admin'] === 1) {
              ?>
              <span>Admin</span>
              <?php
            } else {
              ?>
              <span>Member</span>
              <?php
            }
            ?>
          </div>
          <div class="nk-tb-col tb-col-lg">
            <span><?= $user['created_at'] ?></span>
          </div>
          <div class="nk-tb-col tb-col-md">
            <?php
            if ($user['is_active'] === 1) {
              ?>
              <span class="badge badge-pill badge-success">Active</span>
              <?php
            } else {
              ?>
              <span class="badge badge-pill badge-danger">Suspend</span>
              <?php
            }
            ?>
          </div>
          <div class="nk-tb-col nk-tb-col-tools">
            <ul class="nk-tb-actions gx-1">
              <li>
                <div class="drodown">
                  <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <ul class="link-list-opt no-bdr">
                      <li>
                        <?php
                        if ($user['is_admin'] === 1) {
                          ?>
                          <a href="#" class="member-user" data-member-user="<?= $user['id']?>"><em class="icon ni ni-user"></em><span>Member</span></a>
                          <?php
                        } else {
                          ?>
                          <a href="#" class="admin-user" data-admin-user="<?= $user['id']?>"><em class="icon ni ni-account-setting"></em><span>Admin</span></a>
                          <?php
                        }
                        ?>
                      </li>
                      <li>
                        <?php
                        if ($user['is_active'] === 1) {
                          ?>
                          <a href="#" class="suspend-user" data-suspend-user="<?= $user['id']?>"><em class="icon ni ni-user-cross-fill"></em><span>Suspend</span></a>
                          <?php
                        } else {
                          ?>
                          <a href="#" class="active-user" data-active-user="<?= $user['id']?>"><em class="icon ni ni-user-check-fill"></em><span>Active</span></a>
                          <?php
                        }
                        ?>
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
    $stmt = $pdo->prepare('SELECT id FROM users');
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
