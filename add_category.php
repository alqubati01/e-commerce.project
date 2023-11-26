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
              <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-between">
                    <div class="nk-block-head-content">
                      <h5 class="nk-block-title">Add Category</h5>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                  </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                  <div class="card">
                    <div class="card-inner">
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
                      <form action="control/categories/add_category.php" method="POST" class="form-validate">
                        <div class="row g-gs">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label" for="fv-name">Name</label>
                              <div class="form-control-wrap">
                                <input type="text" class="form-control" id="fv-name" name="fv-name" value="" required placeholder="Enter category name">
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