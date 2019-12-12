<body class="hold-transition login-page">
  <header class="container global-header">
    <div class="inner-w">
      <div style="text-align: left;">
        <img src="https://ppid.esdm.go.id/assets/front/new/images/logo-footer.png" style="background: #fff;
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        border-radius: 5px;
        opacity: 0.9">
      </div>
      <div class="login-box" style="
        background: #dedede;
        padding: 10px;
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        border-radius: 5px;
        opacity: 0.9">
        <div class="login-logo">
          <a href="<?php echo site_url();?>"><b>DASHBOARD BLU</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Silahkan Login</p>

          <?php 
          echo $message;
          echo form_error('username', '<div class="alert alert-danger">', '</div>');
          echo form_error('password', '<div class="alert alert-danger">', '</div>');
          ?>

          <form action="<?php echo site_url('auth/proses') ?>" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="form-group has-feedback">
              <input type="email" class="form-control" placeholder="Email" name="username">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password" name="password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row"> 
              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-warning btn-block btn-flat">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>  
        </div>
        <!-- /.login-box-body -->
      </div>
      
    </div>
  </header>
  <!-- /.login-box -->
