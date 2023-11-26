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
  <title>Orders | DashLite Admin Template</title>
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
              <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                  <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Orders</h3>
                  </div><!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                      <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                      <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                          <li>
                            <div class="form-control-wrap">
                              <div class="form-icon form-icon-right">
                                <em class="icon ni ni-search"></em>
                              </div>
                              <input type="text" class="form-control" id="search" placeholder="Quick search by id">
                            </div>
                          </li>
                          <li>
                            <div class="dropdown">
                              <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                <!--                                <div class="dot dot-primary"></div>-->
                                <em class="icon ni ni-filter-alt"></em>
                              </a>
                              <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                <div class="dropdown-head">
                                  <span class="sub-title dropdown-title">Filter Users</span>
                                  <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-icon">
                                      <em class="icon ni ni-more-h"></em>
                                    </a>
                                  </div>
                                </div>
                                <div class="dropdown-body dropdown-body-rg">
                                  <div class="row gx-6 gy-3">
                                    <div class="col-6">
                                      <div class="form-group">
                                        <label class="overline-title overline-title-alt">Status</label>
                                        <select class="form-select form-select-sm" id="status">
                                          <option value="any">Any Status</option>
                                          <option value="1">New</option>
                                          <option value="2">Awaiting payment</option>
                                          <option value="3">Paid</option>
                                          <option value="4">Underway</option>
                                          <option value="5">Done</option>
                                          <option value="6">Delivery is in progress</option>
                                          <option value="7">Delivered</option>
                                          <option value="8">Canceled</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-12">
                                      <div class="form-group">
                                        <button type="button" id="filter" class="btn btn-secondary">Filter</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="dropdown-foot between">
                                  <a class="clickable" href="#" id="reset_filter">Reset Filter</a>
                                </div>
                              </div><!-- .filter-wg -->
                            </div><!-- .dropdown -->
                          </li>
                          <li class="nk-block-tools-opt">
                            <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                            <a href="add_order.php" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Order</span></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block" id="orders">

              </div><!-- .nk-block -->
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
    function loadData(page) {
      $.ajax({
        url: "./control/orders/index.php",
        method: "POST",
        data: { page: page },
        success: function (data) {
          $("#orders").html(data);
          $("#search").val("");
        }
      });
    }
    loadData();

    //Pagination Code
    $(document).on("click","#pagination li a",function(e) {
      e.preventDefault();
      var page_id = $(this).attr("id");
      loadData(page_id);
    });

    $("#search").on("keyup", function() {
      var search_term = $(this).val();

      $.ajax({
        url: "./control/orders/live_search.php",
        type: "POST",
        data : { search: search_term },
        success: function(data) {
          $("#orders").html(data);
        }
      });
    });

    $("#filter").on("click", function() {
      let status = $("#status").val();

      $.ajax({
        url: "./control/orders/filter.php",
        type: "POST",
        data : {status: status},
        success: function(data) {
          $("#orders").html(data);
        }
      });
    });

    $("#reset_filter").on("click", function () {
      loadData();
      $('.filter-wg').removeClass('show');
    });

    $(document).on('click', '.mark-as-delivered', function(e) {
      e.preventDefault();
      var order_id = $(this).data('markDelivered');

      $.ajax({
        method : "POST",
        url: "./control/orders/change_status.php",
        data : {id : order_id, action: 'delivered'},
        dataType: 'json',
        success : function(data){
          if(data.status === 202) {
            loadData();
            toastr.clear();
            NioApp.Toast(data.message, 'success');
          }
          else {
            toastr.clear();
            NioApp.Toast(data.message, 'error');
          }
        }
      });
    });

    $(document).on('click', '.mark-as-paid', function(e) {
      e.preventDefault();
      var order_id = $(this).data('markPaid');

      $.ajax({
        method : "POST",
        url: "./control/orders/change_status.php",
        data : {id : order_id, action: 'paid'},
        dataType: 'json',
        success : function(data){
          if(data.status === 202) {
            loadData();
            toastr.clear();
            NioApp.Toast(data.message, 'success');
          }
          else {
            toastr.clear();
            NioApp.Toast(data.message, 'error');
          }
        }
      });
    });

    $(document).on('click', '.delete-order', function(e) {
      e.preventDefault();
      var order_id = $(this).data('deleteOrder');

      $.ajax({
        method : "POST",
        url: "./control/orders/delete.php",
        data : {id : order_id},
        dataType: 'json',
        success : function(data){
          if(data.status === 202) {
            loadData();
            toastr.clear();
            NioApp.Toast(data.message, 'success');
          }
          else {
            toastr.clear();
            NioApp.Toast(data.message, 'error');
          }
        }
      });
    });
  });
</script>
</body>

</html>
  <?php
}
?>