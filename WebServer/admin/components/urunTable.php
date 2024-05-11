<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
              <i class="fas fa-plus"></i> Add a new component
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!--Table -->
                <table id="livesearch-results" class="table table-bordered table-hover">
                  <!-- Table names-->
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Label</th>
                    <th>ek1</th>
                    <th>ek2</th>
                  </tr>
                  </thead>
                  <!-- Table data by querying database -->
                  <tbody>
                    <?php
                    include_once("api/db_config.php");

                    $sql = "select * from ürün";

                    $result = $conn->query($sql, PDO::FETCH_ASSOC);

                      if ($result->rowCount() > 0) {

                        $resultSet= $result->fetchAll(PDO::FETCH_ASSOC);

                        //$resultSet=json_encode($resultSet, JSON_FORCE_OBJECT);
                        foreach ($resultSet as $row) {
                          //query occurence done index
                          echo "<tr>"
                          ."<td>".$row["id"]."</td>"
                          ."<td>".$row["ad"]."</td>"
                          ."<td>".$row["etiket"]."</td>"
                          .'<td><button type="button" class="btn btn-block btn-outline-danger btn-lg">'
                          .'<i class="fas fa-lightbulb"></i> Blink</button></td>'
                          ."</tr>";
                        }

                      }
                    ?>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

<!-- Ürün ekleme modal menu-->
<div class="modal fade" id="modal-default">
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
                <h4>Component</h4>
                <div class="form-group">
                  <label for="component-name">Name</label>
                  <input type="text" class="form-control form-control-border border-width-2" id="component-name" placeholder="Enter a name">
                </div>

                <div class="form-group">
                  <label for="component-category">Category</label>
                  <input id="component-category" placeholder="Enter or select a category" class="form-control form-control-border border-width-2" list="component-category-select">
                  <datalist id="component-category-select">
                    <option>Value 1</option>
                    <option>Value 2</option>
                    <option>Value 3</option>
                    </datalist>
                </div>
                <div class="form-group">
                  <label for="component-category">Sub category</label>
                  <select id="component-subcategory" class="custom-select form-control-border border-width-2">
                    <option>Optional: Select a sub category</option>
                    <option>Value 2</option>
                    <option>Value 3</option>
                  </select>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Apply</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>