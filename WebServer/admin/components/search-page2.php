  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <!-- search field -->
<section class="content">
    <div class="container-fluid">
        <h2 class="text-center display-4">Components Search</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="#">
                    <div class="input-group">
                        <input type="search" id="uruntable-search-pane" class="form-control form-control-lg" placeholder="Search any component or category">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-outline-info">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <!--
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
            -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#urun-ekleme-modal">
              <i class="fas fa-plus"></i> Add a new component
                </button>
                <table id="uruntableResults" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Label</th>
                    <th>Category</th>
                    <th>Main category</th>
                    <th>Blink</th>
                  </tr>
                  </thead>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->
<!-- Ürün ekleme modal menu-->
<div class="modal fade" id="urun-ekleme-modal">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header bg-primary">
                <h4 class="modal-title">Add a new component</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Form element for component append-->
                <div class="card">
                <div class="card-header">
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <form action="" method="post">
                    <h4>Component</h4>
                    <div class="form-group">
                      <label for="component-name">Name</label>
                      <input type="text" class="form-control form-control-border border-width-2" id="component-name" name="component-name" placeholder="Enter a name">
                    </div>
                    <!--Component label-->
                    <div class="form-group">
                      <label for="component-label">Label</label>
                      <input type="text" class="form-control form-control-border border-width-2" id="component-label" name="component-label" placeholder="Enter a label">
                    </div>
                    <!--Component category-->
                    <div class="form-group">
                      <label for="component-category">Category</label>
                      <input id="component-category" name="component-category" placeholder="Enter or select a category" class="custom-select form-control-border border-width-2" list="component-category-select">
                      <datalist id="component-category-select">
                      <?php
                      $sql = "CALL sp_kategorileriGetir()";

                      $result = $conn->query($sql, PDO::FETCH_ASSOC);

                      if ($result->rowCount() > 0) {

                        $resultSet= $result->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($resultSet as $row) {
                          echo '<option id="cid-'.$row["id"].'">'.$row["ad"]."</option>";
                        }
                      } ?>
                      </datalist>
                    </div>
                    <div class="form-group">
                      <label for="component-category-description">Category description</label>
                      <textarea type="text" rows="3" class="form-control form-control-border border-width-2" id="component-category-description" name="component-category-description" placeholder="Enter a description"></textarea>
                    </div>
                    <!--Component sub category-->
                    <div class="form-group">
                      <label for="component-subcategory">Sub category</label>
                      <select id="component-subcategory" name="component-subcategory" class="custom-select form-control-border border-width-2">
                        <option value="0">Optional: Select a sub category</option>
                        <?php
                        if ($result->rowCount() > 0) {

                          foreach ($resultSet as $row) {
                            echo '<option id="scid-'.$row["id"].'">'.$row["ad"]."</option>";
                          }
                        } ?>
                      </select>
                    </div>
                    <!--Onaylama butonu-->
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                      <button id="urun-ekleme-modal-apply-button" type="submit" class="btn btn-outline-success">Apply</button>
                    </div>
                  </form>
                </div>
              <!-- /.card-body -->
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- Ürün ekleme modal menu-->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!--Kendi js bileşenlerim-->
<script src="plugins/toastr/toastr.min.js"></script>
 <!--<script src="dist/js/adminlte.js"></script>-->
<script src="js/ürüntable.js"></script>
<script src="js/ürün-kayıt.js"></script>