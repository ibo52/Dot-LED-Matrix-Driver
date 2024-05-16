<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="dist/img/user2-160x160.jpg"
                       alt="User profile picture">
                </div>
                <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){

                    $sql = "CALL sp_personelBilgi(".$_SESSION["login-userid"].")";

                    $result = $conn->query($sql, PDO::FETCH_ASSOC);
                    $row=$result->fetch();
                    ?>
                <h3 class="profile-username text-center"><?php echo $row["ad"]." ".$row["soyad"]; ?></h3>

                <p class="text-muted text-center"><?php echo $row["meslek"]; ?></p>

                <button class="btn btn-primary btn-block"><b><i class="fas fa-book mr-1"></i></b></button>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- About Me Box -->
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">About</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                    <strong><i class="far fa-envelope mr-1"></i> Email </strong>

                    <p class="text-muted"><a class="text-muted"><?php echo $_SESSION["login-email"]; ?></a></p>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Address </strong>

                        <p class="text-muted"><a class="text-muted"><?php echo $row["adres"]; ?></a></p>
                        <?php }; ?>
                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> Permissions </strong>

                        <p class="text-muted">
                            <?php
                            $result->closeCursor();
                            $sql='CALL sp_yetkileriGetir('
                            .$_SESSION["login-userid"].','
                            .$_SESSION["login-userid"]
                            .',@retval);';

                            $result = $conn->query($sql, PDO::FETCH_ASSOC);
                            $resultSet= $result->fetchAll();

                            $rr='<ul class="list-group list-group-unbordered mb-3">';
                            //hiçbir yetkisi yoksa mesaj yaz
                            if( !$result->rowCount() > 0) {
                                $rr='<li>User have no permissions</li>';
                            }
                            foreach ($resultSet as $row){
                                $rr.= '<li class="list-group-item"><a class="text-muted">
                                <i class="far fa-circle nav-icon"></i> '.$row['açıklama'].' </a></li>';
                            }

                            echo $rr."</ul>";
                            ?>
                        </p>
                    </div>
                    <!-- /.card-body -->
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<!--<script src="dist/js/adminlte.min.js"></script> -->
</body>
</html>
