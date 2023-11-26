<?php

session_start();
require_once './inc/Database.php';

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
    <title>Add Order</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
  </head>

  <body class="nk-body bg-lighter npc-default has-sidebar ">
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
              <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                    <div class="nk-block-head-content">
                      <h5 class="nk-block-title">Add Order</h5>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                  <div class="card">
                    <div class="card-inner">
                      <form id="add-order" class="form-validate">
                        <div class="row g-gs">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-label" for="fv-order-number">Order Number</label>
                              <?php
                              global $pdo;
                              $stmt =  $pdo->prepare('SELECT MAX(order_ref_number) AS orderNumber FROM orders');
                              $stmt->execute();
                              $orderNumber = $stmt->fetch();
                              ?>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-order-number" name="fv-order-number" value="<?= $orderNumber['orderNumber'] + 1; ?>" required placeholder="Enter your order number" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-label" for="fv-order-data">Order Data</label>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-order-data" name="fv-order-data" value="<?= date('Y-m-d H:i'); ?>" required placeholder="Enter your order data" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="overline-title overline-title-alt" for="fv-order-status">Order Status</label>
                              <select class="form-select form-select-sm" id="fv-order-status" name="fv-order-status" required>
                                <option value="1">New</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="overline-title overline-title-alt" for="fv-order-customer">Customer</label>
                              <select class="form-select form-select-sm" id="fv-order-customer" name="fv-order-customer" required>
                                <option value="any">Select Customer</option>
                                <?php
                                $getCustomers = $pdo->prepare('SELECT * FROM customers');
                                $getCustomers->execute();
                                foreach($getCustomers->fetchAll() as $customer)
                                {
                                  ?>
                                  <option value="<?= $customer['id']; ?>"><?= $customer['name']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="overline-title overline-title-alt" for="fv-order-shipper">Shipper</label>
                              <select class="form-select form-select-sm" id="fv-order-shipper" name="fv-order-shipper" required>
                                <option value="any">Select Shipper</option>
                                <?php
                                $getShippers = $pdo->prepare('SELECT * FROM shippers');
                                $getShippers->execute();
                                foreach($getShippers->fetchAll() as $shipper)
                                {
                                  ?>
                                  <option value="<?= $shipper['id']; ?>"><?= $shipper['name']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="overline-title overline-title-alt" for="fv-order-payment">Payment</label>
                              <select class="form-select form-select-sm" id="fv-order-payment" name="fv-order-payment" required>
                                <option value="any">Select Payment</option>
                                <?php
                                $getPaymentMethods = $pdo->prepare('SELECT * FROM payment_methods');
                                $getPaymentMethods->execute();
                                foreach($getPaymentMethods->fetchAll() as $paymentMethods)
                                {
                                  ?>
                                  <option value="<?= $paymentMethods['id']; ?>"><?= $paymentMethods['name']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="nk-block nk-block-lg">
                              <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                  <h4 class="nk-block-title">Products</h4>
                                </div>
                                <div class="row">
                                  <div class="col-md-9">
                                    <div class="form-group">
                                      <label class="overline-title overline-title-alt" for="fv-order-item-id"></label>
                                      <select class="form-select form-select-sm" id="fv-order-item-id" data-search="on" name="fv-order-item-id" required>
                                        <option value="default_option">Default Option</option>
                                        <?php
                                        $getProducts = $pdo->prepare('SELECT * FROM products');
                                        $getProducts->execute();
                                        foreach($getProducts->fetchAll() as $product)
                                        {
                                          ?>
                                          <option value="<?= $product['id']; ?>"><?= $product['name']; ?></option>
                                          <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label class="form-label" for="fv-add-item-to-cart"></label>
                                      <div class="form-control-wrap">
                                        <button class="btn btn-primary" id="fv-add-item-to-cart">Add Item</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card card-bordered card-preview" id="order-items">

                              </div><!-- .card-preview -->
                            </div>
                          </div>
                          <div class="col-md-3">

                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <button type="submit" id="save-basic-data" class="btn btn-primary">Add</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
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
    $(document).ready(function() {
      function loadOrderItemsData(page) {
        $.ajax({
          url: "./control/orders/orderItemsData.php",
          method: "POST",
          data: { page: page },
          success: function (data) {
            $("#order-items").html(data);
          }
        });
      }
      loadOrderItemsData();

      $(document).on('click', '#fv-add-item-to-cart', function (e) {
        e.preventDefault();
        var productId = $('#fv-order-item-id').val();
        var productQty = 1;

        $.ajax({
          url: "./control/orders/orderItemsData.php",
          method: "POST",
          data: { id: productId, qty: productQty },
          dataType: "html",
          success: function (data) {
            // console.log(data);
            $("#order-items").html(data);
          }
        });
      });

      $('#add-order').on('submit', function (e){
        e.preventDefault();
        let orderNumber = $("#fv-order-number").val();
        let orderData = $("#fv-order-data").val();
        let orderStatus = $("#fv-order-status").val();
        let orderCustomer = $("#fv-order-customer").val();
        let orderShipper = $("#fv-order-shipper").val();
        let orderPayment = $("#fv-order-payment").val();
        let totalOrder = $('#totalOrder').data('totalOrder');

        if (orderStatus == "" || orderCustomer === "any" || orderShipper === "any" || orderPayment === "any") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/orders/add.php",
            method: "POST",
            data: { orderNumber:orderNumber, orderData:orderData, orderStatus:orderStatus, orderCustomer:orderCustomer, orderShipper:orderShipper, orderPayment:orderPayment, totalOrder: totalOrder },
            dataType: 'json',
            success: function (data) {
              if (data.status === 202) {
                toastr.clear();
                NioApp.Toast(data.message, 'success');

                setTimeout(function() {
                  location.href = './orders.php';
                }, 1000);
              } else {
                toastr.clear();
                NioApp.Toast(data.message, 'error');
              }
            }
          });
        }
      });
    });
  </script>
  </body>

  </html>

  <?php
}
?>