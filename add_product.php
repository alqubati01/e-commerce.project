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
    <title>Add Product</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
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
                      <h5 class="nk-block-title">Add Product</h5>
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
                      <form id="add-product" class="form-validate">
                        <div class="row g-gs">
                          <div class="col-md-6">
                            <div class="col-md-12 m-0 p-0">
                              <div class="form-group">
                                <label class="form-label" for="fv-name">Product Name</label>
                                <div class="form-control-wrap">
                                  <input type="text" class="form-control" id="fv-name" name="fv-name" value=""  placeholder="Enter product name">
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-12 m-0 p-0 mt-2">
                              <div class="col-md-6 m-0 p-0">
                                <div class="form-group">
                                  <div class="row justify-content-between m-0">
                                    <label class="form-label" for="fv-qty">QTY</label>
                                    <div class="">
                                      <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="stock_manage" id="stock-manage">
                                        <label class="custom-control-label" for="stock-manage">Unlimited Qty</label>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="fv-qty" name="fv-qty" value="" placeholder="Enter qty of product">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6 m-0 p-0 pl-3">
                                <div class="form-group">
                                  <label class="form-label" for="fv-sku">SKU</label>
                                  <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="fv-sku" name="fv-sku" value="" placeholder="Enter sku of product">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row col-md-6 mt-4">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label" for="fv-price">Price</label>
                                <div class="form-control-wrap">
                                  <input type="number" class="form-control" id="fv-price" name="fv-price" value="" placeholder="Enter price of product">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label" for="fv-cost">Cost of product</label>
                                <div class="form-control-wrap">
                                  <input type="number" class="form-control" id="fv-cost" name="fv-cost" value="" placeholder="Enter cost of product">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <label class="form-label" for="fv-category-id">Category</label>
                              <div class="form-control-wrap">
                                <input class="form-control categories_list" type="text" id="fv-category-id" placeholder="Type to filter" autocomplete="off" />
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-label" for="fv-brand">Brands</label>
                              <div class="form-control-wrap ">
                                <select class="form-control form-select" id="fv-brand" name="fv-brand" data-placeholder="Select a option" >

                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <div class="card card-bordered">
                              <!-- Create the editor container -->
                              <input name="product-desc" id="product-desc" type="hidden">
                              <div id="quill-editor"></div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <label class="form-label">Image Upload</label>
                            <div class="dropzone" data-accepted-files="image/*">
                              <div class="dz-message" data-dz-message>
                                <span class="dz-message-text">Drag and drop file</span>
                                <span class="dz-message-or">or</span>
                                <button type="button" class="btn btn-primary">SELECT</button>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <button type="submit" id="save-product" class="btn btn-primary">Add</button>
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
  <link rel="stylesheet" href="./assets/css/editors/quill.css?ver=2.4.0">
  <script src="./assets/js/libs/editors/quill.js?ver=2.4.0"></script>
  <script src="./assets/js/editors.js?ver=2.4.0"></script>
  <script src="./assets/js/comboTreePlugin.js"></script>
  <script>
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
      $('#stock-manage').change(function() {
        var checked = $('#stock-manage').is(':checked');
        if(checked) {
          $('#fv-qty').attr('readonly', true);
          $('#fv-qty').val(null);
        }
        else {
          $('#fv-qty').removeAttr("readonly");
        }
      });

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

      comboTree2 = $('.categories_list').comboTree({
        source: categories_list,
        isMultiple: true
      });

      comboTree2.onChange(function(){
        // console.log(comboTree2.getSelectedIds());

        $.ajax({
          url: "./control/products/get_brand.php",
          method: "GET",
          data: {id: comboTree2.getSelectedIds()},
          success: function (data) {
            $("#fv-brand").html(data);
          }
        });
      });

      var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],

        ['clean']                                         // remove formatting button
      ];

      var quill = new Quill('#quill-editor', {
        modules: {
          toolbar: toolbarOptions
        },
        placeholder: 'add description',
        theme: 'snow'
      });

      let myDropzone = new Dropzone('.dropzone', {
        url: "./control/products/add_product.php",
        autoProcessQueue: false,
        acceptedFiles: ".svg,.png,.jpg,.jpeg",
        addRemoveLinks: true,
        uploadMultiple: true,
        paramName: "file",
        maxFiles: 7,
        init: function() {
          dzClosure = this;
          document.getElementById("save-product").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
          });

          this.on("addedfile", function(file) {
            //Do something before the file gets processed.

            // var defaultRadioButton = Dropzone.createElement(
            //   '<div><label class="container-radio">Main Picture</label><input class="" type="radio" checked="checked" value="'+file.name+'" name="defaultPict" id="productMainPict"></div>');
            // file.previewElement.appendChild(defaultRadioButton);
          })
          this.on("sending", function(file, xhr, formData){
            //Do something when the file gets processed.
            //This is a good time to append additional information to the formData. It's where I add tags to make the image searchable.
            formData.append("productName", jQuery("#fv-name").val());
            formData.append("productQty", jQuery("#fv-qty").val());
            formData.append("productSku", jQuery("#fv-sku").val());
            formData.append("productPrice", jQuery("#fv-price").val());
            formData.append("productCost", jQuery("#fv-cost").val());
            formData.append("categoryIds", comboTree2.getSelectedIds());
            formData.append("brandId", jQuery("#fv-brand").val());
            formData.append("productDesc", JSON.stringify(quill.getContents()));
            formData.append("productMainPict", jQuery("#productMainPict").val());
          }),
          this.on("success", function(file, xhr) {
            //Do something after the file has been successfully processed e.g. remove classes and make things go back to normal.
            if (JSON.parse(xhr).status === 202) {
              toastr.clear();
              NioApp.Toast(JSON.parse(xhr).message, 'success');

              setTimeout(function() {
                // window.location.href = "thankyou.php";
                location.href = './products.php';
              }, 2000);
            } else {
              toastr.clear();
              NioApp.Toast(JSON.parse(xhr).message, 'error');
            }
          }),
          this.on("complete", function() {
            //Do something after the file has been both successfully or unsuccessfully processed.
            //This is where I remove all attached files from the input, otherwise they get processed again next time if you havent refreshed the page.
            myDropzone.removeAllFiles();
            // rest product form
            $('#add-product').trigger("reset");
            $('#fv-qty').removeAttr("readonly");
            $('#fv-brand').empty().append('');
            quill.setContents('');
          }),
          this.on("error", function(file, errorMessage, xhr) {
            //Do something if there is an error.
            //This is where I like to alert to the user what the error was and reload the page after.
            alert(errorMessage);
            window.location.reload();
          })
        }
      });
    });
  </script>
  </body>

  </html>

  <?php
}
?>