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
    <title>Edit Order</title>
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
                      <h5 class="nk-block-title">Edit Order</h5>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                  <div class="card">
                    <div class="card-inner">
                      <form id="edit-order" class="form-validate">
                        <div class="row g-gs">
                          <div class="col-md-4">
                            <input type="hidden" class="order-id">
                            <div class="form-group">
                              <label class="form-label" for="fv-order-number">Order Number</label>
                              <?php
                              global $pdo;
                              $stmt =  $pdo->prepare('SELECT MAX(order_ref_number) AS orderNumber FROM orders');
                              $stmt->execute();
                              $orderNumber = $stmt->fetch();
                              ?>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-order-number" name="fv-order-number" value="" required placeholder="Enter your order number" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-label" for="fv-order-data">Order Data</label>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-order-data" name="fv-order-data" value="" required placeholder="Enter your order data" disabled>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="overline-title overline-title-alt" for="fv-order-status">Order Status</label>
                              <select class="form-select form-select-sm" id="fv-order-status" name="fv-order-status" required>
                                <option value="any">Select Status</option>
                                <?php
                                $getStatuses = $pdo->prepare('SELECT * FROM statuses');
                                $getStatuses->execute();
                                foreach($getStatuses->fetchAll() as $status)
                                {
                                  ?>
                                  <option value="<?= $status['id']; ?>"><?= $status['name']; ?></option>
                                  <?php
                                }
                                ?>
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
                              <button type="submit" id="save-basic-data" class="btn btn-primary">Save</button>
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
    let params = new URLSearchParams(location.search);

    $(document).ready(function() {
      function loadData() {
        $.ajax({
          url: "./control/orders/get_order.php",
          method: "GET",
          data: { id: params.get('id') },
          dataType: 'json',
          success: function (data) {
            console.log(data);

            $(".order-id").val(data.id);
            $("#fv-order-number").val(data.order_ref_number);
            $("#fv-order-data").val(data.order_date);
            $("#fv-order-status").val(data.order_status_id).change();
            $("#fv-order-customer").val(data.customer_id).change();
            $("#fv-order-shipper").val(data.shipper_id).change();
            $("#fv-order-payment").val(data.payment_method).change();
          }
        });
      }
      loadData();

      function loadOrderItemsData() {
        $.ajax({
          url: "./control/orders/getOrderItemsData.php",
          method: "GET",
          data: { order_id: params.get('id') },
          dataType: 'html',
          success: function (data) {
            $("#order-items").html(data);
          }
        });
      }
      loadOrderItemsData();

      $(document).on('click', '#fv-add-item-to-cart', function (e) {
        e.preventDefault();
        var product_id = $('#fv-order-item-id').val();
        var order_id = $('.order-id').val();

        $.ajax({
          url: "./control/orders/getOrderItemsData.php",
          method: "POST",
          data: { product_id: product_id, order_id: order_id },
          dataType: "html",
          success: function (data) {
            loadOrderItemsData();
            // console.log(data);
            // $("#order-items").html(data);
          }
        });
      });

      $('#edit-order').on('submit', function (e){
        e.preventDefault();
        let orderId = $(".order-id").val();
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
            url: "./control/orders/edit.php",
            method: "POST",
            data: { orderId:orderId, orderNumber:orderNumber, orderData:orderData, orderStatus:orderStatus, orderCustomer:orderCustomer, orderShipper:orderShipper, orderPayment:orderPayment, totalOrder: totalOrder },
            dataType: 'json',
            success: function (data) {
              if (data.status === 202) {
                toastr.clear();
                NioApp.Toast(data.message, 'success');

                setTimeout(function() {
                  location.href = './orders.php';
                }, 1500);
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