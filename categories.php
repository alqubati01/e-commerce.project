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
  <title>Categories</title>
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
                    <h3 class="nk-block-title page-title">Categories</h3>
                  </div><!-- .nk-block-head-content -->
                  <div class="nk-block-head-content">
                    <ul class="nk-block-tools g-3">
                      <li class="nk-block-tools-opt">
                        <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                        <a href="add_category.php" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a>
                      </li>
                    </ul>
                  </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block" id="categories">

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
    function loadData() {
      $.ajax({
        url: "./control/categories/index.php",
        method: "GET",
        success: function (data) {
          $("#categories").html(data);
        }
      });
    }
    loadData();

    $(document).on('click', '.delete-category', function(e) {
      e.preventDefault();
      var category_id = $(this).data('deleteCategory');

      $.ajax({
        method : "POST",
        url: "./control/categories/delete_category.php",
        data : {id : category_id},
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