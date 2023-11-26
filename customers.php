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
    <title>Customers</title>
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
              <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                    <div class="nk-block-head-content">
                      <h3 class="nk-block-title page-title">Work Team</h3>
                      <div class="nk-block-des text-soft">
                        <p>You have total <?= totalCustomers(); ?> customer.</p>
                      </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                      <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="more-options">
                          <ul class="nk-block-tools g-3">
                            <li>
                              <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                  <em class="icon ni ni-search"></em>
                                </div>
                                <input type="text" class="form-control" id="search" placeholder="Search by name" autocomplete="off">
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
                                          <label class="overline-title overline-title-alt">Role</label>
                                          <select class="form-select form-select-sm" id="role">
                                            <!--                                          <option value="any">Any Role</option>-->
                                            <option value="admin">Admin</option>
                                            <option value="member">Member</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-6">
                                        <div class="form-group">
                                          <label class="overline-title overline-title-alt">Status</label>
                                          <select class="form-select form-select-sm" id="status">
                                            <!--                                          <option value="any">Any Status</option>-->
                                            <option value="active">Active</option>
                                            <option value="suspend">Suspend</option>
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
                            </li><!-- li -->
                            <li class="nk-block-tools-opt">
                              <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-customer-modal"><em class="icon ni ni-plus"></em><span>Add</span></button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block" id="customers">


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

  <!-- Modal Form -->
  <div class="modal fade" tabindex="-1" id="add-customer-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Customer</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </a>
        </div>
        <div class="modal-body">
          <form action="#" id="add-customer">
            <div class="row g-4">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="name">Full Name</label>
                  <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="username">Username</label>
                  <div class="form-control-wrap">
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="email">Email</label>
                  <div class="form-control-wrap">
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="password">Password</label>
                  <div class="form-control-wrap">
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="phone">Phone No</label>
                  <div class="form-control-wrap">
                    <input type="number" class="form-control" id="phone" name="phone" required>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="statues">Status</label>
                  <div class="form-control-wrap ">
                    <select class="form-control form-select" id="statues" name="statues" data-placeholder="Select a option" required>
                      <option label="empty" value=""></option>
                      <option value="1">Active</option>
                      <option value="0">Suspend</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-primary">Save</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer bg-light">
          <span class="sub-text">Modal Footer Text</span>
        </div>
      </div>
    </div>
  </div>
  <!-- JavaScript -->
  <script src="./assets/js/bundle.js?ver=2.4.0"></script>
  <script src="./assets/js/scripts.js?ver=2.4.0"></script>
  <script>
    $(document).ready(function () {
      function loadData(page) {
        $.ajax({
          url: "./control/customers/index.php",
          method: "POST",
          data: { page: page },
          success: function (data) {
            $("#customers").html(data);
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

      $("#add-customer").on("submit", function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let username = $("#username").val();
        let email = $("#email").val();
        let password = $("#password").val();
        let phone = $("#phone").val();
        let statues = $("#statues").val();

        if (name == "" || username == "" || email == "" || password == "" || phone == "" || statues == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/customers/add.php",
            method: "POST",
            data: { name:name, username:username, email:email, password:password, phone:phone, statues:statues },
            dataType: 'json',
            success: function (data) {
              if (data.status === 202) {
                loadData();
                toastr.clear();
                NioApp.Toast(data.message, 'success');
              } else {
                toastr.clear();
                NioApp.Toast(data.message, 'error');
              }
            },
            complete: function() {
              $('#add-customer-modal').modal('hide');
              $('#add-customer').trigger("reset");
            }
          });
        }
      });

      $(document).on('click', '.delete-customer', function(e) {
        e.preventDefault();
        var customer_id = $(this).data('deleteCustomer');

        $.ajax({
          method : "POST",
          url: "./control/customers/delete.php",
          data : {id : customer_id},
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

      $("#search").on("keyup", function() {
        var search_term = $(this).val();

        $.ajax({
          url: "./control/customers/live_search.php",
          type: "POST",
          data : { search: search_term },
          success: function(data) {
            $("#customers").html(data);
          }
        });
      });

      // $("#filter").on("click", function() {
      //   let role = $("#role").val();
      //   let status = $("#status").val();
      //
      //   $.ajax({
      //     url: "./control/teams/filter.php",
      //     type: "POST",
      //     data : {role: role, status: status},
      //     success: function(data) {
      //       $("#users").html(data);
      //     }
      //   });
      // });
      //
      // $("#reset_filter").on("click", function () {
      //   loadData();
      //   $('.filter-wg').removeClass('show');
      // });
    });
  </script>
  </body>

  </html>

  <?php
}
?>