<?php

session_start();

require_once './inc/Helper.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
  header("Location: login.php");
}
else
{
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="author" content="Softnio">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
  <!-- Fav Icon  -->
  <link rel="shortcut icon" href="./images/favicon.png">
  <!-- Page Title  -->
  <title>Products</title>
  <!-- StyleSheets  -->
  <link rel="stylesheet" href="./assets/css/dashlite.css?ver=2.4.0">
  <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
<div class="nk-app-root">
  <!-- main @s -->
  <div class="nk-main ">
    <!-- sidebar @s -->
    <?php
      require_once './inc/Sidebar.php';
    ?>
    <!-- sidebar @e -->
    <!-- wrap @s -->
    <div class="nk-wrap ">
      <!-- main header @s -->
      <?php
        require_once './inc/MainHeader.php';
      ?>
      <!-- main header @e -->
      <!-- content @s -->
      <div class="nk-content ">
        <div class="container-fluid">
          <div class="nk-content-inner">
            <div class="nk-content-body">
              <div class="components-preview wide-xxl mx-auto">
                <div class="nk-block nk-block-lg">
                  <div class="nk-block-head nk-block-between">
                    <div class="nk-block-head-content">
                      <h4 class="nk-block-title">Products</h4>
                      <div class="nk-block-des">
                        <p>You have total <?= totalProductItems(); ?> products.</p>
                      </div>
                    </div>
                    <div class="nk-block-head-content">
                      <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="more-options">
                          <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                              <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                              <a href="add_product.php" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div><!-- .nk-block-head-content -->
                  </div>
                  <!-- Error -->
                  <?php
                  if (isset($_SESSION['error']) && !empty($_SESSION['error']))
                  {
                    ?>
                    <div class="alert alert-pro alert-danger alert-dismissible">
                      <div class="alert-text">
                        <p><?= $_SESSION['error'] ?></p>
                      </div>
                      <button class="close" data-dismiss="alert"></button>
                    </div>
                    <?php
                    unset($_SESSION['error']);
                  }
                  ?>
                  <!-- Success -->
                  <?php
                  if (isset($_SESSION['success']) && !empty($_SESSION['success']))
                  {
                    ?>
                    <div class="alert alert-pro alert-success alert-dismissible">
                      <div class="alert-text">
                        <p><?= $_SESSION['success'] ?></p>
                      </div>
                      <button class="close" data-dismiss="alert"></button>
                    </div>
                    <?php
                    unset($_SESSION['success']);
                  }
                  ?>
                  <table class="datatable-init nowrap nk-tb-list is-separate" data-auto-responsive="false" id="products">
                    <thead>
                      <tr class="nk-tb-item nk-tb-head">
                      <th class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                          <input type="checkbox" class="custom-control-input" id="puid">
                          <label class="custom-control-label" for="puid"></label>
                        </div>
                      </th>
                      <th class="nk-tb-col tb-col-sm"><span>Name</span></th>
                      <th class="nk-tb-col"><span>SKU</span></th>
                      <th class="nk-tb-col"><span>Price</span></th>
                      <th class="nk-tb-col"><span>Stock</span></th>
                      <th class="nk-tb-col tb-col-md"><span>Brand</span></th>
                      <th class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                          <li class="mr-n1">
                            <div class="dropdown">
                              <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                  <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit Selected</span></a></li>
                                  <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Selected</span></a></li>
                                  <li><a href="#"><em class="icon ni ni-bar-c"></em><span>Update Stock</span></a></li>
                                  <li><a href="#"><em class="icon ni ni-invest"></em><span>Update Price</span></a></li>
                                </ul>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </th>
                    </tr><!-- .nk-tb-item -->
                    </thead>
                    <tbody>
                      <?php
                        global $pdo;
                        $stmt = $pdo->prepare('SELECT p.id AS productId, p.name AS productName, p.price AS productPrice, p.product_cost, b.name AS brandName, p.description AS productDesc, p.created_at, p.updated_at, s.sku, s.qty
                          FROM products p
                          JOIN stock s
                            ON p.id = s.product_id
                          JOIN brands b
                            ON p.brand_id = b.id
                            ORDER BY p.id');
                        $stmt->execute();
                        if ($stmt->rowCount()) {
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
                                <span class="tb-sub"><?= $product['brandName'] ?></span>
                              </td>
                              <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1 my-n1">
                                  <li class="mr-n1">
                                    <div class="dropdown">
                                      <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                      <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                          <li><a href="edit_product.php?id=<?= $product['productId'] ?>"><em class="icon ni ni-edit"></em><span>Edit Product</span></a></li>
                                          <li><a href="./control/products/delete_product.php?id=<?= $product['productId'] ?>"><em class="icon ni ni-trash"></em><span>Remove Product</span></a></li>
                                        </ul>
                                      </div>
                                    </div>
                                  </li>
                                </ul>
                              </td>
                            </tr><!-- .nk-tb-item -->
                            <?php
                          }
                        }
                      ?>
                    </tbody>
                  </table><!-- .nk-tb-list -->
                </div> <!-- nk-block -->
              </div><!-- .components-preview -->
            </div>
          </div>
        </div>
      </div>
      <!-- content @e -->
      <!-- footer @s -->
      <?php
        require_once './inc/Footer.php';
      ?>
      <!-- footer @e -->
    </div>
    <!-- wrap @e -->
  </div>
  <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="./assets/js/bundle.js?ver=2.4.0"></script>
<script src="./assets/js/scripts.js?ver=2.4.0"></script>
<script>
  $(document).ready(function () {

  });
</script>
</body>

</html>
<?php
}
?>