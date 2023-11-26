<?php

session_start();
require_once '../../inc/Database.php';

global $pdo;
$stmt = $pdo->prepare('SELECT p.id AS productId, p.name AS productName, p.price AS productPrice, p.product_cost, c.name AS categoryName, b.name AS brandName, p.description AS productDesc, p.created_at, p.updated_at, s.sku, s.qty
FROM products p
JOIN stock s
	ON p.id = s.product_id
JOIN categories c
	ON p.category_id = c.id
JOIN brands b
	ON p.brand_id = b.id');
$stmt->execute();

if ($stmt->rowCount()) {
  ?>
<!--    <tbody>-->
  <?php
  foreach ($stmt->fetchAll() as $product) {
    ?>
    <tr class="nk-tb-item">
      <td class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
          <input type="checkbox" class="custom-control-input" id="puid1">
          <label class="custom-control-label" for="puid1"></label>
        </div>
      </td>
      <td class="nk-tb-col tb-col-sm">
                        <span class="tb-product">
                            <img src="./images/product/a.png" alt="" class="thumb">
                            <span class="title"><?= $product['productName'] ?></span>
                        </span>
      </td>
      <td class="nk-tb-col">
        <span class="tb-sub"><?= $product['sku'] ?></span>
      </td>
      <td class="nk-tb-col">
        <span class="tb-lead"><?= $product['productPrice'] ?></span>
      </td>
      <td class="nk-tb-col">
        <span class="tb-sub"><?= $product['qty'] ?></span>
      </td>
      <td class="nk-tb-col tb-col-md">
        <span class="tb-sub"><?= $product['categoryName'] ?></span>
      </td>
      <td class="nk-tb-col tb-col-md">
        <span class="tb-sub"><?= $product['brandName'] ?></span>
      </td>
      <td class="nk-tb-col tb-col-md">
        <div class="asterisk tb-asterisk">
          <a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a>
        </div>
      </td>
      <td class="nk-tb-col nk-tb-col-tools">
        <ul class="nk-tb-actions gx-1 my-n1">
          <li class="mr-n1">
            <div class="dropdown">
              <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
              <div class="dropdown-menu dropdown-menu-right">
                <ul class="link-list-opt no-bdr">
                  <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit Product</span></a></li>
                  <li><a href="#"><em class="icon ni ni-eye"></em><span>View Product</span></a></li>
                  <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Product Orders</span></a></li>
                  <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Product</span></a></li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
      </td>
    </tr><!-- .nk-tb-item -->
    <?php
  }
  ?>
<!--    </tbody>-->
<?php
} else {
//  echo json_encode(['status'=> 303, 'message'=> 'User id does not exists']);
  echo 'No users yet';
}
