<?php

session_start();

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
  <title>Account settings</title>
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
                    <h5 class="nk-block-title">Account settings</h5>
                  </div><!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">

                  </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                <div class="card">
                  <div class="card-header rounded-top bg-primary-dim">Basic Info</div>
                  <div class="card-inner">
                    <form id="basic-data" class="form-validate">
                      <div class="row g-gs">
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
                        <div class="col-md-12">
                          <div class="form-group">
                            <button type="submit" id="save-basic-data" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header rounded-top bg-primary-dim">Profile Image</div>
                  <div class="card-inner">
                    <form action="./control/users/edit-image.php" method="POST" id="profile-image" class="form-validate" enctype="multipart/form-data">
                      <div class="row g-gs">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="profile-image">Select Image to Upload</label>
                            <div class="form-control-wrap">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="profile-image" name="profile-image">
                                <label class="custom-file-label" for="profile-image">Choose file</label>
                              </div>
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
                  <div class="card-header rounded-top bg-primary-dim">Password</div>
                  <div class="card-inner">
                    <form action="./control/users/edit-password.php" method="POST" id="password" class="form-validate">
                      <div class="row g-gs">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="form-label" for="fv-password">Current Password</label>
                            <div class="form-control-wrap">
                              <input type="password" class="form-control" id="fv-password" name="fv-password" required placeholder="Password">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="fv-new-password">New Password</label>
                            <div class="form-control-wrap">
                              <input type="password" class="form-control" id="fv-new-password" name="fv-new-password" required placeholder="Password">
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
<script src="./assets/js/example-toastr.js?ver=2.4.0"></script>
<script>
  // basic-data
  $(document).ready(function () {
    function loadData() {
      $.ajax({
        url: "./control/users/index.php",
        method: "GET",
        dataType: 'json',
        success: function (data) {
          $("#fv-full-name").val(data.name);
          $("#fv-username").val(data.username);
          $("#fv-email").val(data.email);
          $("#fv-phone").val(data.phone);
        }
      });
    }
    loadData();

    $("#save-basic-data").on("click", function (e) {
      e.preventDefault();
      let name = $("#fv-full-name").val();
      let username = $("#fv-username").val();
      let email = $("#fv-email").val();
      let phone = $("#fv-phone").val();

      if (name == "" || username == "" || email == "") {
        toastr.clear();
        NioApp.Toast('All fields are required.', 'error');
      } else {
        $.ajax({
          url: "./control/users/edit.php",
          method: "POST",
          data: { name:name, username:username, email:email, phone:phone },
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

    // $("#profile-image").on("click", function (e) {
    //   e.preventDefault();
    // });

    // $("#password").on("click", function (e) {
    //   e.preventDefault();
    // });
  });
</script>
</body>

</html>

<?php
}
?>