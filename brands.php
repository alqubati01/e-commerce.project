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
  <title>Brands</title>
  <!-- StyleSheets  -->
  <link rel="stylesheet" href="./assets/css/dashlite.css?ver=2.4.0">
  <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
<!--  <link rel="stylesheet" href="./assets/css/comboTreePlugin.css">-->
  <link rel="stylesheet" href="./assets/css/comboTreePlugin2.css">
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
                    <h3 class="nk-block-title page-title">Brands</h3>
                    <div class="nk-block-des text-soft">
                      <p>You have total <?= totalBrands(); ?> brands.</p>
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
                                  <span class="sub-title dropdown-title">Filter Brands</span>
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
                                        <label class="overline-title overline-title-alt">Category</label>
                                        <input class="form-control categories_list-filter" type="text" id="category" placeholder="Type to filter" autocomplete="off" />
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="form-group">
                                        <label class="overline-title overline-title-alt">Status</label>
                                        <select class="form-select form-select-sm" id="status">
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-brand-modal"><em class="icon ni ni-plus"></em><span>Add</span></button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
              </div><!-- .nk-block-head -->
              <div class="nk-block" id="brands">


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

<!-- Modal Add Brand -->
<div class="modal fade" tabindex="-1" id="add-brand-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Brand</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
      </div>
      <div class="modal-body">
        <form action="#" class="form-validate is-alter" id="add-brand" enctype="multipart/form-data">
          <div class="form-group">
            <label class="form-label" for="brand-name">Brand Name</label>
            <div class="form-control-wrap">
              <input type="text" class="form-control" id="brand-name" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="category-id">Category</label>
            <div class="form-control-wrap">
              <input class="form-control categories_list-add" type="text" id="category-id" placeholder="Type to filter" autocomplete="off" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="brand-image">Upload Image</label>
            <div class="form-control-wrap">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="brand-image" name="brand-image">
                <label class="custom-file-label" for="brand-image">Choose file</label>
              </div>
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

<!-- Modal Edit Brand -->
<div class="modal fade" tabindex="-1" id="edit-brand-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Brand</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
          <em class="icon ni ni-cross"></em>
        </a>
      </div>
      <div class="modal-body">
        <form action="#" class="form-validate is-alter" id="edit-brand" enctype="multipart/form-data">
          <input type="hidden" class="form-control" id="edit-brand-id" required>
          <div class="form-group">
            <label class="form-label" for="edit-brand-name">Brand Name</label>
            <div class="form-control-wrap">
              <input type="text" class="form-control" id="edit-brand-name" required>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="edit-category-id">Category</label>
            <div class="form-control-wrap">
              <input class="form-control categories_list-edit" type="text" id="edit-category-id" placeholder="Type to filter" autocomplete="off" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="edit-brand-image">Upload Image</label>
            <div class="user-avatar sq xl mb-2">
              <img src="" alt="" id="src-brand-image">
            </div>
            <div class="form-control-wrap">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="edit-brand-image" name="edit-brand-image">
                <label class="custom-file-label" for="brand-image">Choose file</label>
              </div>
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
<script src="./assets/js/comboTreePlugin.js"></script>
<script>
  $(document).ready(function () {
    function loadData(page) {
      $.ajax({
        url: "./control/brands/pagination.php",
        method: "POST",
        data: {page: page},
        success: function (data) {
          $("#brands").html(data);
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
        url: "./control/brands/live_search.php",
        type: "POST",
        data : { search: search_term },
        success: function(data) {
          $("#brands").html(data);
        }
      });
    });

    $("#filter").on("click", function() {
      let category = $("#category").val();
      let status = $("#status").val();

      $.ajax({
        url: "./control/brands/filter.php",
        type: "POST",
        data : {category: category, status: status},
        success: function(data) {
          $("#brands").html(data);
        }
      });
    });

    $("#reset_filter").on("click", function () {
      loadData();
      $('.filter-wg').removeClass('show');
    });


    function loadCategoriesFilter(page) {
      $.ajax({
        url: "./control/categories/nested_categories.php",
        method: "GET",
        dataType: 'json',
        success: function (data) {
          $('.categories_list-filter').comboTree({
            source: data,
            isMultiple: false
          });
        }
      });
    }
    loadCategoriesFilter();

    function categories() {
      var result = "";
      $.ajax({
        url: "./control/categories/nested_categories.php",
        method: "GET",
        async: false,
        dataType: 'json',
        success: function (data) {
          result = data;
        }
      });

      return result;
    }

    let categories_list = categories();

    comboTree2 = $('.categories_list-add').comboTree({
      source: categories_list,
      isMultiple: false
    });

    comboTree2.onChange(function(){
      // console.log(comboTree2.getSelectedIds());
      // $('#other_input_box_hidden').val(comboTree2.getSelectedIds());

      $("#add-brand").on("submit", function (e) {
        e.preventDefault();
        let brandName = $("#brand-name").val();
        let categoryId = comboTree2.getSelectedIds()[0];
        // var file_data = $('#brand-image').prop('files')[0];
        var formData = new FormData(this);
        // formData.append('file_data', file_data);
        formData.append('categoryId', categoryId);
        formData.append('brandName', brandName);

        // console.log(formData);

        if (brandName == "" || categoryId == "") {
          toastr.clear();
          NioApp.Toast('All fields are required.', 'error');
        } else {
          $.ajax({
            url: "./control/brands/add_brand.php",
            method: "POST",
            // data: { brandName:brandName, categoryId:categoryId, formData:formData },
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
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
              $('#add-brand-modal').modal('hide');
              $('#add-brand').trigger("reset");
            }
          });
        }
      });
    });

    comboTree3 = $('.categories_list-edit').comboTree({
      source: categories_list,
      isMultiple: false
    });

    $(document).on('click', '.editBrandLink', function(e) {
      e.preventDefault();
      var brand_id = $(this).data('editBrandLink');

      $.ajax({
        method : "GET",
        url: "./control/brands/get_brand.php",
        data : {id : brand_id},
        dataType: 'json',
        success : function(data){
          if(data.status === 303) {
            toastr.clear();
            NioApp.Toast(data.message, 'error');
          }
          else {
            $('#edit-brand-id').val(data.id);
            $('#edit-brand-name').val(data.name);
            comboTree3.setSelection([data.category_id]);
            $('#src-brand-image').attr('src', './assets/' + data.image);

            $('#edit-brand-modal').modal('show');
          }
        }
      });
    });

    $("#edit-brand").on("submit", function (e) {
      e.preventDefault();
      let brandId = $("#edit-brand-id").val();
      let brandName = $("#edit-brand-name").val();
      let categoryId = comboTree3.getSelectedIds()[0];
      // var file_data = $('#edit-brand-image').prop('files')[0];
      var formData = new FormData(this);
      // formData.append('file_data', file_data);
      formData.append('brandId', brandId);
      formData.append('brandName', brandName);
      formData.append('categoryId', categoryId);

      // console.log(formData);

      if (brandName == "" || categoryId == "") {
        toastr.clear();
        NioApp.Toast('All fields are required.', 'error');
      } else {
        $.ajax({
          url: "./control/brands/edit_brand.php",
          method: "POST",
          // data: { brandName:brandName, categoryId:categoryId, formData:formData },
          data: formData,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData:false,
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
            $('#edit-brand-modal').modal('hide');
            $('#edit-brand').trigger("reset");
          }
        });
      }
    });


    $(document).on('click', '.deleteBrandLink', function(e) {
      var brand_id = $(this).data('deleteBrandLink');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            url: "./control/brands/delete_brand.php",
            method: "POST",
            data: { id:brand_id },
            dataType: 'json',
            success: function (data) {
              if (data.status === 202) {
                loadData();
                Swal.fire('Deleted!', data.message, 'success');
              } else {
                // toastr.clear();
                // NioApp.Toast(data.message, 'error');
                Swal.fire('Deleted!', data.message, 'error');
              }
            }
          });
        }
      });
      e.preventDefault();
    });

    $(document).on('click', '.suspend-brand', function(e) {
      e.preventDefault();
      var brand_id = $(this).data('suspendBrand');

      $.ajax({
        method : "POST",
        url: "./control/brands/brand_status.php",
        data : {id : brand_id, status: 'suspend'},
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

    $(document).on('click', '.active-brand', function(e) {
      e.preventDefault();
      var brand_id = $(this).data('activeBrand');

      $.ajax({
        method : "POST",
        url: "./control/brands/brand_status.php",
        data : {id : brand_id, status: 'active'},
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