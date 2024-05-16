<?php  if( isset($_SESSION["loggedIn"])  && $_SESSION['loggedIn']==true ){
  header("Location: index.php?route=search-page2");
} ?>
<!--Controller script:login -->
<script src="js/register.js"></script>
<!--div: page content-->
<div class="content-wrapper" style="padding:100px;">
<div class="register-box content-wrapper">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b><i class="fas fa-user-plus"></i> Register </b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="register-form" action="" method="post">
        <!-- name field-->
        <div class="input-group mb-3">
          <input type="text" name="register-name" class="form-control" placeholder="Enter name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <!-- surname field-->
        <div class="input-group mb-3">
          <input type="text" name="register-surname" class="form-control" placeholder="Enter surname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <!--email field-->
        <div class="input-group mb-3">
          <input type="email" name="register-email" class="form-control" placeholder="Enter email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <!-- Password field-->
        <div class="input-group mb-3">
          <input type="password" name="register-password" class="form-control" placeholder="Enter a password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- Password check field-->
        <div class="input-group mb-3">
          <input type="password" name="register-password-again" class="form-control" placeholder="Enter password again">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button id="register-form-button" type="submit" class="btn btn-outline-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login" class="text-center">Already have a membership? <b>Then Log in</b></a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
</div>