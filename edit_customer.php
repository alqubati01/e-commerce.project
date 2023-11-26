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
    <title>Edit Customer</title>
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
                      <h5 class="nk-block-title">Edit Customer Data</h5>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                  <div class="card">
                    <div class="card-inner">
                      <div class="nk-block-between mb-2">
                        <div class="nk-block-head-content">
                          <h3 class="nk-block-title page-title">Personal data</h3>
                        </div><!-- .nk-block-head-content -->
                      </div><!-- .nk-block-between -->
                      <form id="basic-data" class="form-validate">
                        <div class="row g-gs">
                          <input type="hidden" class="fv-id-customer">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-full-name">Full Name</label>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-full-name" name="fv-full-name" value="" required placeholder="Enter your full name">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-username">Username</label>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-username" name="fv-username" value="" required placeholder="Enter your username">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-email">Email address</label>
                              <div class="form-control-wrap">
                                <input type="email" class="form-control" id="fv-email" name="fv-email" value="" required placeholder="Enter your email">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-phone">Phone</label>
                              <div class="form-control-wrap">
                                <input type="number" class="form-control" id="fv-phone" name="fv-phone" value="" placeholder="Enter your phone number">
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-statuses">Status</label>
                              <div class="form-control-wrap ">
                                <select class="form-control form-select" id="fv-statuses" name="fv-statuses" data-placeholder="Select a option" required>
                                  <option label="empty" value=""></option>
                                  <option value="1">Active</option>
                                  <option value="0">Suspend</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <button type="submit" id="save-personal-data" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-inner">
                      <div class="nk-block-between mb-2">
                        <div class="nk-block-head-content">
                          <h3 class="nk-block-title page-title">Password Reset</h3>
                        </div><!-- .nk-block-head-content -->
                      </div><!-- .nk-block-between -->
                      <form action="./control/customers/update_password.php" method="POST" class="form-validate">
                        <div class="row g-gs">
                          <input type="hidden" class="fv-id-customer" name="fv-id-customer">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-password">Password</label>
                              <div class="form-control-wrap">
                                <input type="password" class="form-control" id="fv-password" name="fv-password" required placeholder="Password">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-confirm-password">Confirm the new password</label>
                              <div class="form-control-wrap">
                                <input type="password" class="form-control" id="fv-confirm-password" name="fv-confirm-password" required placeholder="Password">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-inner">
                      <div class="nk-block-between mb-2">
                        <div class="nk-block-head-content">
                          <h3 class="nk-block-title page-title">Delivery addresses</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                          <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                              <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-address-modal"><em class="icon ni ni-plus"></em><span>Add</span></button>
                            </li>
                          </ul>
                        </div><!-- .nk-block-head-content -->
                      </div><!-- .nk-block-between -->
                      <div class="nk-tb-list is-separate mb-3" id="addresses">

                      </div><!-- .nk-tb-list -->
                    </div>
                  </div>
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
  <div class="modal fade" tabindex="-1" id="add-address-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Customer Info</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </a>
        </div>
        <div class="modal-body">
          <form action="#" id="add-address" class="form-validate is-alter">
            <div class="form-group">
              <label class="form-label" for="city">City</label>
              <div class="form-control-wrap ">
                <select class="form-control form-select" id="city" name="city" data-placeholder="Select a option" required>
                  <option label="empty" value=""></option>
                  <?php
                  global $pdo;
                  $stmt = $pdo->prepare('SELECT * FROM cities');
                  $stmt->execute();

                  foreach ($stmt->fetchAll() as $city) {
                    ?>
                    <option value="<?= $city['id']; ?>"><?= $city['name']; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="address">Address</label>
              <div class="form-control-wrap">
                <input type="text" class="form-control" id="address" required>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="phone">Phone No</label>
              <div class="form-control-wrap">
                <input type="number" class="form-control" id="phone" required>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-lg btn-primary">Save</button>
            </div>
          </form>
        </div>
        <div class="modal-footer bg-light">
          <span class="sub-text">Modal Footer Text</span>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" id="edit-address-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Customer Info</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </a>
        </div>
        <div class="modal-body">
          <form action="#" id="edit-address" class="form-validate is-alter">
            <input type="hidden" class="fv-id-address">
            <div class="form-group">
              <label class="form-label" for="editCity">City</label>
              <div class="form-control-wrap ">
                <select class="form-control form-select" id="editCity" name="editCity" data-placeholder="Select a option" required>
                  <option label="empty" value=""></option>
                  <?php
                  global $pdo;
                  $stmt = $pdo->prepare('SELECT * FROM cities');
                  $stmt->execute();

                  foreach ($stmt->fetchAll() as $city) {
                    ?>
                    <option value="<?= $city['id']; ?>"><?= $city['name']; ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="editAddress">Address</label>
              <div class="form-control-wrap">
                <input type="text" class="form-control" id="editAddress" name="edit-address" required>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="editPhone">Phone No</label>
              <div class="form-control-wrap">
                <input type="number" class="form-control" id="editPhone" required>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-lg btn-primary">Save</button>
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
  <script src="./assets/js/example-toastr.js?ver=2.4.0"></script>
  <script>
    let params = new URLSearchParams(location.search);

    $(document).ready(function () {
      function loadData() {
        $.ajax({
          url: "./control/customers/get_customer.php",
          method: "GET",
          data: { id: params.get('id') },
          dataType: 'json',
          success: function (data) {
            $(".fv-id-customer").val(data.id);
            $("#fv-full-name").val(data.name);
            $("#fv-username").val(data.username);
            $("#fv-email").val(data.email);
            $("#fv-phone").val(data.phone);
            $("#fv-statuses").val(data.status).change();
          }
        });
      }
      loadData();

      $("#save-personal-data").on("click", function (e) {
        e.preventDefault();
        let id = $(".fv-id-customer").val();
        let name = $("#fv-full-name").val();
        let username = $("#fv-username").val();
        let email = $("#fv-email").val();
        let phone = $("#fv-phone").val();
        let status = $("#fv-statuses").val();

        if (name == "" || username == "" || email == "" || phone == "" || status == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/customers/update.php",
            method: "POST",
            data: { id:id, name:name, username:username, email:email, phone:phone, status:status },
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
            }
          });
        }
      });

      function loadAddresses() {
        $.ajax({
          url: "./control/addresses/index.php",
          method: "GET",
          data: { id: params.get('id') },
          success: function (data) {
            $("#addresses").html(data);
          }
        });
      }
      loadAddresses();

      $("#add-address").on("submit", function (e) {
        e.preventDefault();
        let customer_id = $(".fv-id-customer").val();
        let city_id = $("#city").val();
        let address = $("#address").val();
        let phone = $("#phone").val();

        if (city == "" || address == "" || phone == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/addresses/add.php",
            method: "POST",
            data: { customer_id:customer_id, city_id:city_id, address:address, phone:phone },
            dataType: 'json',
            success: function (data) {
              if (data.status === 202) {
                loadAddresses();
                toastr.clear();
                NioApp.Toast(data.message, 'success');
              } else {
                toastr.clear();
                NioApp.Toast(data.message, 'error');
              }
            },
            complete: function() {
              $('#add-address-modal').modal('hide');
              $('#add-address').trigger("reset");
              $("#city").val("").trigger( "change" );
            }
          });
        }
      });

      $(document).on('click', '.edit-address', function(e) {
        e.preventDefault();
        var address_id = $(this).data('editAddress');

        $.ajax({
          method : "GET",
          url: "./control/addresses/get_address.php",
          data : {id : address_id},
          dataType: 'json',
          success : function(data) {
            if(data.status === 303) {
              toastr.clear();
              NioApp.Toast(data.message, 'error');
            }
            else {
              $(".fv-id-address").val(data.id);
              $("#editCity").val(data.city_id).change();
              $("#editAddress").val(data.address);
              $("#editPhone").val(data.phone);
              $('#edit-address-modal').modal('show');
            }
          }
        });
      });

      $("#edit-address").on("submit", function (e) {
        e.preventDefault();
        let address_id = $(".fv-id-address").val();
        let city_id = $("#editCity").val();
        let address = $("#editAddress").val();
        let phone = $("#editPhone").val();

        if (city == "" || address == "" || phone == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/addresses/edit.php",
            method: "POST",
            data: { id:address_id, city_id:city_id, address:address, phone:phone },
            dataType: 'json',
            success: function (data) {
              if (data.status === 202) {
                loadAddresses();
                toastr.clear();
                NioApp.Toast(data.message, 'success');
              } else {
                toastr.clear();
                NioApp.Toast(data.message, 'error');
              }
            },
            complete: function() {
              $('#edit-address-modal').modal('hide');
            }
          });
        }
      });

      $(document).on('click', '.delete-address', function(e) {
        e.preventDefault();
        var address_id = $(this).data('deleteAddress');

        $.ajax({
          method : "POST",
          url: "./control/addresses/delete.php",
          data : {id : address_id},
          dataType: 'json',
          success : function(data){
            if(data.status === 202) {
              loadAddresses();
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