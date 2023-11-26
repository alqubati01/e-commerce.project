<?php

session_start();
require_once '../../inc/Database.php';

//print_r($_POST);
//die();

global $pdo;
if (isset($_POST['id'], $_POST['qty']) && is_numeric($_POST['id']) && is_numeric($_POST['qty'])) {
  $product_id = (int)$_POST['id'];
  $quantity = (int)$_POST['qty'];

  $stmt = $pdo->prepare('SELECT p.id, p.name, p.price, s.qty FROM products p JOIN stock s ON p.id=s.product_id WHERE p.id = ?');
  $stmt->execute([$product_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product && $quantity > 0) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
      if (array_key_exists($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$product_id] += $quantity;
      } else {
        $_SESSION['cart'][$product_id] = $quantity;
      }
    } else {
      $_SESSION['cart'] = array($product_id => $quantity);
    }
  }

  header('location: http://127.0.0.1/Ecommerce/add_order.php');
  exit();
}

if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
  unset($_SESSION['cart'][$_GET['remove']]);

  header('location: http://127.0.0.1/Ecommerce/add_order.php');
  exit();
}

if (isset($_GET['addQty']) && is_numeric($_GET['addQty']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['addQty']])) {
  $_SESSION['cart'][$_GET['addQty']] += 1;

  header('location: http://127.0.0.1/Ecommerce/add_order.php');
  exit();
}

if (isset($_GET['removeQty']) && is_numeric($_GET['removeQty']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['removeQty']])) {
  $_SESSION['cart'][$_GET['removeQty']] -= 1;

  header('location: http://127.0.0.1/Ecommerce/add_order.php');
  exit();
}

$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

if ($products_in_cart) {
  $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
  $stmt = $pdo->prepare('SELECT p.id, p.name, p.price, s.qty FROM products p JOIN stock s ON p.id=s.product_id WHERE p.id IN (' . $array_to_question_marks . ')');
  $stmt->execute(array_keys($products_in_cart));
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($products as $product) {
    $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
  }
}

?>

<table class="table table-tranx">
  <thead>
    <tr class="tb-tnx-head">
      <th class="tb-tnx-info">
        <span class="tb-tnx-desc d-none d-sm-inline-block">
          <span>Product</span>
        </span>
      </th>
      <th class="tb-tnx-amount is-alt">
        <span class="tb-tnx-total">Price</span>
      </th>
      <th class="tb-tnx-amount is-alt">
        <span class="tb-tnx-total">Qty</span>
      </th>
      <th class="tb-tnx-amount is-alt">
        <span class="tb-tnx-total">Total</span>
      </th>
      <th class="tb-tnx-action">
        <span>&nbsp;</span>
      </th>
    </tr>
  </thead>
  <tbody>
  <?php if (empty($products)): ?>
    <tr>
      <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
    </tr>
  <?php else: ?>
  <?php foreach ($products as $product): ?>
    <tr class="tb-tnx-item">
      <td class="tb-tnx-info">
        <div class="tb-tnx-desc">
          <span class="title"><?= $product['name']?></span>
        </div>
      </td>
      <td class="tb-tnx-amount is-alt">
        <div class="tb-tnx-total">
          <span class="date"><?= $product['price']?></span>
        </div>
      </td>
      <td class="tb-tnx-amount is-alt pt-0">
        <div class="tb-tnx-total">
          <div class="form-group">
            <label class="form-label"></label>
            <div class="form-control-wrap number-spinner-wrap">
              <a href="./control/orders/orderItemsData.php?removeQty=<?=$product['id']?>" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></a>
              <input type="number" class="form-control number-spinner" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="1000">
              <a href="./control/orders/orderItemsData.php?addQty=<?=$product['id']?>" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></a>
            </div>
          </div>
        </div>
      </td>
      <td class="tb-tnx-amount is-alt">
        <div class="tb-tnx-total">
          <span class="amount"><?=$product['price'] * $products_in_cart[$product['id']]?></span>
        </div>
      </td>
      <td class="tb-tnx-action">
        <div class="dropdown">
          <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
            <ul class="link-list-plain">
              <li>
                <span class="span-form">
                  <a href="./control/orders/orderItemsData.php?remove=<?=$product['id']?>" class="remove">Remove</a>
                </span>
              </li>
            </ul>
          </div>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php endif; ?>
  </tbody>
</table>
<hr class="my-0">
<div class="d-flex justify-content-between py-2">
  <h6 class="mb-0" style="padding-left: 20px;">Total Order</h6>
  <h6 class="mb-0" id="totalOrder" data-total-order="<?=$subtotal?>" style="padding-right: 30px;">$ <?=$subtotal?></h6>
</div>

