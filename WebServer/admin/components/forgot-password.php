<?php  if( isset($_SESSION["loggedIn"])  && $_SESSION['loggedIn']==true ){
  header("Location: index.php?route=search-page2");
} ?>
<!--Controller script:login -->
<script src="js/forgot-password.js"></script>
<!--div: page content-->
<div class="content-wrapper" style="padding:100px;">
<div class="login-box content-wrapper">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"> Forgot password <i class="fas fa-question"></i></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><i class="far fa-comment-dots"></i> Send request to DB admins to change password</p>
      <form id="pass-recover-form" action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="recover-email" class="form-control" placeholder="Enter your email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button id="pass-recover-form-button" type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="login">Or back to Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>