<?php  if( isset($_SESSION["loggedIn"])  && $_SESSION['loggedIn']==true ){
  header("Location: index.php?route=search-page2");
} ?>
<!--Controller script:login -->
<script src="js/login.js"></script>
<!--div: page content-->
<div class="content-wrapper" style="padding:100px;">
  <div class="login-box content-wrapper">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b><i class="fas fa-door-open"></i> Welcome </b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to use Shelf System</p>
        <?php if ( isset($_SESSION['login-error']) ){
          echo'<p class="login-box-msg">'.$_SESSION['login-error'].'</p>';
        } ?>

        <!-- FORM-->
        <form id="login-form" action="" method="post">
          <!-- Email field-->
          <div class="input-group mb-3">
            <input type="email" id="login-email" name="email" class="form-control" placeholder="Enter email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <!-- Password field-->
          <div class="input-group mb-3">
            <input type="password" id="login-password" name="password" class="form-control" placeholder="Enter password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button id="login-form-button" type="submit" class="btn btn-outline-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="forgot-password">Forgot password?</a>
        </p>
        <p class="mb-0">
          <a href="register" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>