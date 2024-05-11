<div class="content-wrapper" style="padding:100px;">
<div class="register-box content-wrapper">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b><i class="fas fa-user-plus"></i> Register </b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="api_register.php" method="post">
        <!-- name field-->
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Enter name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <!-- surname field-->
        <div class="input-group mb-3">
          <input type="text" name="surname" class="form-control" placeholder="Enter surname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <!--email field-->
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Enter email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <!-- Password field-->
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Enter a password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- Password check field-->
        <div class="input-group mb-3">
          <input type="password" name="password-again" class="form-control" placeholder="Enter password again">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
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