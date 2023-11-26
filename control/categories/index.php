<?php

session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  global $pdo;
  $stmt = $pdo->prepare('SELECT * FROM categories');
  $stmt->execute();

  if ($stmt->rowCount()) {
    $category = array(
      'categories' => array(),
      'parent_cats' => array()
    );

    while ($row = $stmt->fetch()) {
      $category['categories'][$row['id']] = $row;
      $category['parent_cats'][$row['parent_id']][] = $row['id'];
    }

    function buildCategory($parent, $category) {
      if (isset($category['parent_cats'][$parent])) {
        foreach ($category['parent_cats'][$parent] as $cat_id) {
          ?>
          <div class="nk-tb-list is-separate ml-5 w-90">
            <?php
            if (!isset($category['parent_cats'][$cat_id])) {
              ?>
              <div class="nk-tb-item">
                <div class="nk-tb-col">
                  <span class="tb-lead"><?= $category['categories'][$cat_id]['name'];?></span>
                </div>
                <div class="nk-tb-col">
                  <?php
                  if ($category['categories'][$cat_id]['is_active'] === 1) {
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
                            <li><a href="edit_category.php?id=<?= $cat_id;?>"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                            <li><a href="#" class="delete-category" data-delete-category="<?= $cat_id;?>"><em class="icon ni ni-delete"></em><span>Delete</span></a></li>
                          </ul>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <a href="add_branch.php?id=<?= $cat_id;?>" class="btn btn-primary ml-4 mb-3">Add Branch</a>
              <?php
            }
            if (isset($category['parent_cats'][$cat_id])) {
              ?>
              <div class="nk-tb-item">
                <div class="nk-tb-col">
                  <span class="tb-lead"><?= $category['categories'][$cat_id]['name'];?></span>
                </div>
                <div class="nk-tb-col">
                  <?php
                  if ($category['categories'][$cat_id]['is_active'] === 1) {
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
                            <li><a href="edit_category.php?id=<?= $cat_id;?>"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                            <li><a  href="#" class="delete-category" data-delete-category="<?= $cat_id;?>"><em class="icon ni ni-delete"></em><span>Delete</span></a></li>
                          </ul>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <a href="add_branch.php?id=<?= $cat_id;?>" class="btn btn-primary ml-4 mb-3">Add Branch</a>
              <?php
              buildCategory($cat_id, $category);
            }
            ?>
          </div>
          <?php
        }
      }
    }

    buildCategory(NULL, $category);
  } else {
   echo 'No categories founded';
  }
} else {
  echo 'Please Login';
}
