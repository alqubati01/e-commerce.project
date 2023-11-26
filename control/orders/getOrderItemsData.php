<?php

session_start();
require_once '../../inc/Database.php';

global $pdo;

//unset($_SESSION['cart']);

$stmt = $pdo->prepare('
SELECT oi.id, oi.order_id, oi.product_id, p.name, oi.qty, oi.price_per_unit, oi.total
FROM order_item oi
JOIN products p
  ON oi.product_id = p.id
WHERE order_id = :order_id');

$stmt->execute([
  ':order_id' => $_GET['order_id']
]);

$products = $stmt->fetchAll();

foreach ($products as $product) {
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'][] = $product;
  } else {
   foreach ($_SESSION['cart'] as $stored_product) {
     $ids[] = $stored_product['id'];
   }

   if(!in_array($product['id'], $ids)) {
     $_SESSION['cart'][] = $product;
   }
  }
}

/*highlight_string("<?php " . var_export($_SESSION['cart'], true) . ";?>");*/

//print_r($_SESSION['cart'][0]['id']);

//die();

$subtotalStmt = $pdo->prepare('SELECT SUM(total) AS "subTotal"
  FROM order_item
  WHERE order_id = :order_id');
$subtotalStmt->execute([':order_id' => $_GET['order_id']]);
$subtotal = $subtotalStmt->fetch()['subTotal'];


if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart'])) {

  $stmt = $pdo->prepare('DELETE FROM order_item WHERE id =:id');
  $stmt->execute([
    ':id' => $_GET['remove']
  ]);

  foreach ($_SESSION['cart'] as $key => $stored_product) {
    if ($_GET['remove'] == $stored_product['id']) {
      unset($_SESSION['cart'][$key]);
    }
  }

  header('location: http://127.0.0.1/Ecommerce/edit_order.php?id=' . $_GET['id']);
  exit();
}

if (isset($_POST['product_id'], $_POST['order_id'])) {
  $stmt = $pdo->prepare('SELECT * FROM order_item WHERE order_id=:order_id AND product_id=:product_id');
  $stmt->execute([
    ':product_id' => $_POST['product_id'],
    ':order_id' => $_POST['order_id']
  ]);

  if ($stmt->rowCount()) {
    $order_item = $stmt->fetch();

    $stmt = $pdo->prepare('UPDATE order_item SET qty=:qty, total=:total WHERE order_id=:order_id AND product_id=:product_id');
    $stmt->execute([
      ':qty' => $order_item['qty'] + 1,
      ':total' => $order_item['price_per_unit'] * ($order_item['qty'] + 1),
      ':product_id' => $_POST['product_id'],
      ':order_id' => $_POST['order_id']
    ]);

    foreach ($_SESSION['cart'] as $key => $stored_product) {
      if ($_GET['addQty'] == $stored_product['id']) {
        $_SESSION['cart'][$key]['qty'] = ($order_item['qty']  + 1);
      }
    }
  } else {
    print_r('We will insert new order_item');
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id=:id');
    $stmt->execute([$_POST['product_id']]);
    $product = $stmt->fetch();
    $qty = 1;

    $stmt = $pdo->prepare('INSERT INTO order_item
          (order_id, product_id, qty, price_per_unit, total, created_at)
          VALUES (?,?,?,?,?,?)');

    $stmt->execute([
      $_POST['order_id'],
      $_POST['product_id'],
      $qty,
      $product['price'],
      $qty * $product['price'],
      date('Y-m-d H:i')
    ]);
  }

  die();
}

if (isset($_GET['addQty']) && is_numeric($_GET['addQty']) && isset($_SESSION['cart'])) {
  $stmt = $pdo->prepare('SELECT * FROM order_item WHERE id =:id');
  $stmt->execute([
    ':id' => $_GET['addQty']
  ]);

  $order_item = $stmt->fetch();

  $stmt = $pdo->prepare('UPDATE order_item SET qty=:qty, total=:total WHERE id =:id');
  $stmt->execute([
    ':qty' => $order_item['qty'] + 1,
    ':total' => $order_item['price_per_unit'] * ($order_item['qty'] + 1),
    ':id' => $_GET['addQty']
  ]);

  foreach ($_SESSION['cart'] as $key => $stored_product) {
    if ($_GET['addQty'] == $stored_product['id']) {
      $_SESSION['cart'][$key]['qty'] = ($order_item['qty']  + 1);
    }
  }

  header('location: http://127.0.0.1/Ecommerce/edit_order.php?id=' . $_GET['id']);
  exit();
}

if (isset($_GET['removeQty']) && is_numeric($_GET['removeQty']) && isset($_SESSION['cart'])) {
  $stmt = $pdo->prepare('SELECT * FROM order_item WHERE id =:id');
  $stmt->execute([
    ':id' => $_GET['removeQty']
  ]);

  $order_item = $stmt->fetch();

  $stmt = $pdo->prepare('UPDATE order_item SET qty=:qty, total=:total WHERE id =:id');
  $stmt->execute([
    ':qty' => $order_item['qty'] - 1,
    ':total' => $order_item['price_per_unit'] * ($order_item['qty'] - 1),
    ':id' => $_GET['removeQty']
  ]);

  foreach ($_SESSION['cart'] as $key => $stored_product) {
    if ($_GET['removeQty'] == $stored_product['id']) {
      $_SESSION['cart'][$key]['removeQty'] = ($order_item['qty'] - 1);
    }
  }

  header('location: http://127.0.0.1/Ecommerce/edit_order.php?id=' . $_GET['id']);
  exit();
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
    <?php foreach ($products as $key => $product): ?>
      <tr class="tb-tnx-item">
        <td class="tb-tnx-info">
          <div class="tb-tnx-desc">
            <span class="title"><?= $product['name']?></span>
          </div>
        </td>
        <td class="tb-tnx-amount is-alt">
          <div class="tb-tnx-total">
            <span class="date"><?= $product['price_per_unit']?></span>
          </div>
        </td>
        <td class="tb-tnx-amount is-alt pt-0">
          <div class="tb-tnx-total">
            <div class="form-group">
              <label class="form-label"></label>
              <div class="form-control-wrap number-spinner-wrap">
                <a href="./control/orders/getOrderItemsData.php?removeQty=<?=$product['id']?>&id=<?=$product['order_id']?>" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></a>
                <input type="number" class="form-control number-spinner" name="quantity-<?=$product['id']?>" value="<?=$product['qty']?>" min="1" max="1000">
                <a href="./control/orders/getOrderItemsData.php?addQty=<?=$product['id']?>&id=<?=$product['order_id']?>" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></a>
              </div>
            </div>
          </div>
        </td>
        <td class="tb-tnx-amount is-alt">
          <div class="tb-tnx-total">
            <span class="amount"><?=$product['price_per_unit'] * $product['qty']?></span>
          </div>
        </td>
        <td class="tb-tnx-action">
          <div class="dropdown">
            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
              <ul class="link-list-plain">
                <li>
                <span class="span-form">
                  <a href="./control/orders/getOrderItemsData.php?remove=<?=$product['id']?>&id=<?=$product['order_id']?>" class="remove">Remove</a>
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


