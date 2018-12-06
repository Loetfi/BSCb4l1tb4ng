<body class="hold-transition login-page">
  <div class="login-box">
    <center><img src="<?php echo base_url('assets/logo-esdm-kuning.png') ?>" width="100px" align="center"></center>
    <div class="login-logo">
      <a href="<?php echo site_url();?>"><b>Balance Score Card</b></a>
      <p style="font-size: 15px">Lembaga Minyak dan Gas Bumi</p>
      <p style="font-size: 18px">Kementerian Energi dan Sumber Daya Mineral</p>
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
  <!-- /.login-box -->
