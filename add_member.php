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
  <title>Add team member</title>
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
                    <h5 class="nk-block-title">Add Team Member</h5>
                  </div><!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">

                  </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                <div class="card">
                  <div class="card-inner">
                    <form action="control/teams/add_member.php" method="POST" class="form-validate">
                      <div class="row g-gs">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="fv-name">Full Name</label>
                            <div class="form-control-wrap">
                              <input type="text" class="form-control" id="fv-name" name="fv-name" value="" required placeholder="Enter your full name">
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
                            <label class="form-label" for="fv-password">Password</label>
                            <div class="form-control-wrap">
                              <input type="password" class="form-control" id="fv-password" name="fv-password" required placeholder="Enter your password">
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
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label" for="fv-roles">Role</label>
                            <div class="form-control-wrap ">
                              <select class="form-control form-select" id="fv-roles" name="fv-roles" data-placeholder="Select a option" required>
                                <option label="empty" value=""></option>
                                <option value="1">Admin</option>
                                <option value="0">Member</option>
                              </select>
                            </div>
                          </div>
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
</body>

</html>

<?php
}
?>