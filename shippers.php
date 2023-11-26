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
                      <h3 class="nk-block-title page-title">Shippers</h3>
                      <div class="nk-block-des text-soft">
                        <p>You have total <?= totalShippers(); ?> shipper.</p>
                      </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                      <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="more-options">
                          <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                              <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-shipper-modal"><em class="icon ni ni-plus"></em><span>Add</span></button>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block" id="shippers">


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
  <div class="modal fade" tabindex="-1" id="add-shipper-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Shipper</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </a>
        </div>
        <div class="modal-body">
          <form action="#" id="add-shipper">
            <div class="row g-4">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-label" for="name">Shipper Name</label>
                  <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="status">Status</label>
                  <div class="form-control-wrap ">
                    <select class="form-control form-select" id="status" name="status" data-placeholder="Select a option" required>
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

  <!-- Modal Form -->
  <div class="modal fade" tabindex="-1" id="edit-shipper-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Shipper</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </a>
        </div>
        <div class="modal-body">
          <form action="#" id="edit-shipper">
            <div class="row g-4">
              <div class="col-lg-6">
                <input type="hidden" id="edit-id" name="edit-id">
                <div class="form-group">
                  <label class="form-label" for="name">Shipper Name</label>
                  <div class="form-control-wrap">
                    <input type="text" class="form-control" id="edit-name" name="name" required>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label" for="edit-status">Status</label>
                  <div class="form-control-wrap ">
                    <select class="form-control form-select" id="edit-status" name="status" data-placeholder="Select a option" required>
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
          url: "./control/shippers/index.php",
          method: "POST",
          data: { page: page },
          success: function (data) {
            $("#shippers").html(data);
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

      $("#add-shipper").on("submit", function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let status = $("#status").val();

        if (name == "" && status == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/shippers/add.php",
            method: "POST",
            data: { name:name, status:status },
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
              $('#add-shipper-modal').modal('hide');
              $('#add-shipper').trigger("reset");
            }
          });
        }
      });

      $(document).on('click', '.edit-shipper', function(e) {
        e.preventDefault();
        var shipper_id = $(this).data('editShipper');

        $.ajax({
          method : "GET",
          url: "./control/shippers/get_shipper.php",
          data : {id : shipper_id},
          dataType: 'json',
          success : function(data){
            if(data.status === 303) {
              toastr.clear();
              NioApp.Toast(data.message, 'error');
            }
            else {
              $('#edit-id').val(data.id);
              $('#edit-name').val(data.name);
              $('#edit-status').val(data.status).change();
              $('#edit-shipper-modal').modal('show');
            }
          }
        });
      });

      $("#edit-shipper").on("submit", function (e) {
        e.preventDefault();
        let shipperId = $("#edit-id").val();
        let shipperName = $("#edit-name").val();
        let shipperStatus = $("#edit-status").val();

        // console.log(formData);

        if (shipperName == "" && shipperStatus == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/shippers/edit.php",
            method: "POST",
            data: { id:shipperId, name:shipperName, status:shipperStatus },
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
              $('#edit-shipper-modal').modal('hide');
              $('#edit-shipper').trigger("reset");
            }
          });
        }
      });

      $(document).on('click', '.delete-shipper', function(e) {
        e.preventDefault();
        var shipper_id = $(this).data('deleteShipper');

        $.ajax({
          method : "POST",
          url: "./control/shippers/delete.php",
          data : {id : shipper_id},
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

      // $("#search").on("keyup", function() {
      //   var search_term = $(this).val();
      //
      //   $.ajax({
      //     url: "./control/customers/live_search.php",
      //     type: "POST",
      //     data : { search: search_term },
      //     success: function(data) {
      //       $("#customers").html(data);
      //     }
      //   });
      // });

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