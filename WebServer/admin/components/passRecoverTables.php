<div class="content-wrapper">
  <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <!--Table -->
                <table id="recoverRequest-results" class="table table-bordered table-hover">
                  <!-- Table names-->
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                  </tr>
                  </thead>
                  <!-- Table data by querying database -->
                  <tbody>
                    <?php
                    include_once("api/db_config.php");

                    $sql = "CALL sp_şifreYenilemeTalepleriniGetir();";

                    $result = $conn->query($sql, PDO::FETCH_ASSOC);

                      if ($result->rowCount() > 0) {

                        $resultSet= $result->fetchAll(PDO::FETCH_ASSOC);

                        //$resultSet=json_encode($resultSet, JSON_FORCE_OBJECT);
                        foreach ($resultSet as $row) {
                          //query occurence done index
                          echo "<tr>"
                          ."<td>".$row["id"]."</td>"
                          ."<td>".$row["ad"]."</td>"
                          ."<td>".$row["soyad"]."</td>"
                          ."<td>".$row["email"]."</td>"
                          .'<td><button type="button" class="btn btn-block btn-outline-info btn-lg">'
                          .'<i class="fas fa-lightbulb"></i> Reset Password </button></td>'
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