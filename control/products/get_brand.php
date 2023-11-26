<?php


session_start();
require_once '../../inc/Database.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
      global $pdo;

      $categoryIds = $_GET['id'];
      $in  = str_repeat('?,', count($categoryIds) - 1) . '?';
      $sql = "SELECT * FROM brands WHERE category_id IN ($in) ORDER BY id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute($categoryIds);
      ?>
      <option label="empty" value=""></option>
      <?php
      foreach ($stmt->fetchAll() as $brand) {
        ?>
        <option value="<?= $brand["id"]; ?>"><?= $brand["name"]; ?></option>
        <?php
      }
  } else {
    $_SESSION['error'] = 'Please fill the fields';
    header('Location: ../../add_product.php');
  }
} else {
  $_SESSION['error'] = 'Please login';
  header('Location: ../../add_product.php');
}
