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
  <title>Settings</title>
  <!-- StyleSheets  -->
  <link rel="stylesheet" href="./assets/css/dashlite.css?ver=2.4.0">
  <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
  <link rel="stylesheet" href="./assets/css/style.css">
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
                    <h3 class="nk-block-title page-title">Account settings</h3>
                  </div><!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">

                  </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                <div class="row g-gs">
                  <div class="col-xl-4 col-sm-6">
                    <div class="card">
                      <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner text-center">
                          <em class="icon ni ni-account-setting fs-55px"></em>
                          <div class="card-title-group justify-content-center mt-1 position-static">
                            <div class="card-title">
                              <a href="account_setting.php" class="title h6 card-clickable text-secondary">Account settings</a>
                            </div>
                          </div>
                          <div class="card-text mt-1">Edit account information</div>
                        </div><!-- .card-inner -->
                      </div><!-- .nk-ecwg -->
                    </div><!-- .card -->
                  </div><!-- .col -->
                </div><!-- .row -->
              </div><!-- .nk-block -->
              <div class="nk-block-head nk-block-head-sm">
                  <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Basic settings</h3>
                  </div><!-- .nk-block-head-content -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                <div class="row g-gs">
                  <div class="col-xl-4 col-sm-6">
                    <div class="card">
                      <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner text-center">
                          <em class="icon ni ni-setting fs-55px"></em>
                          <div class="card-title-group justify-content-center mt-1 position-static">
                            <div class="card-title">
                              <a href="/" class="title h6 card-clickable text-secondary">Store settings</a>
                            </div>
                          </div>
                          <div class="card-text mt-1">Logo, name, description</div>
                        </div><!-- .card-inner -->
                      </div><!-- .nk-ecwg -->
                    </div><!-- .card -->
                  </div><!-- .col -->
                  <div class="col-xl-4 col-sm-6">
                    <div class="card">
                      <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner text-center">
                          <em class="icon ni ni-cc-alt fs-55px"></em>
                          <div class="card-title-group justify-content-center mt-1 position-static">
                            <div class="card-title">
                              <a href="payment_methods.php" class="title h6 card-clickable text-secondary">Payment methods</a>
                            </div>
                          </div>
                          <div class="card-text mt-1">Activate the payment gateway and bank accounts</div>
                        </div><!-- .card-inner -->
                      </div><!-- .nk-ecwg -->
                    </div><!-- .card -->
                  </div><!-- .col -->
                  <div class="col-xl-4 col-sm-6">
                    <div class="card">
                      <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner text-center">
                          <em class="icon ni ni-account-setting fs-55px"></em>
                          <div class="card-title-group justify-content-center mt-1 position-static">
                            <div class="card-title">
                              <a href="shippers.php" class="title h6 card-clickable text-secondary">Shipping and delivery</a>
                            </div>
                          </div>
                          <div class="card-text mt-1">Activate shipping and delivery options</div>
                        </div><!-- .card-inner -->
                      </div><!-- .nk-ecwg -->
                    </div><!-- .card -->
                  </div><!-- .col -->
                </div><!-- .row -->
              </div><!-- .nk-block -->
              <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-head-content">
                  <h3 class="nk-block-title page-title">Other settings</h3>
                </div><!-- .nk-block-head-content -->
              </div><!-- .nk-block-head -->
              <div class="nk-block">
                <div class="row g-gs">
                  <div class="col-xl-4 col-sm-6">
                    <div class="card">
                      <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner text-center">
                          <em class="icon ni ni-users fs-55px"></em>
                          <div class="card-title-group justify-content-center mt-1 position-static">
                            <div class="card-title">
                              <a href="teams.php" class="title h6 card-clickable text-secondary">Work team</a>
                            </div>
                          </div>
                          <div class="card-text mt-1">Team management</div>
                        </div><!-- .card-inner -->
                      </div><!-- .nk-ecwg -->
                    </div><!-- .card -->
                  </div><!-- .col -->
                </div><!-- .row -->
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
</body>

</html>

<?php
}
?>