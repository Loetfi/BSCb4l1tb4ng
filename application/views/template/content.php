<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="http://jdih.awanesia.com/logo-esdm-kuning.png"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BSC</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
     <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">   
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="http://jdih.awanesia.com/logo-esdm-kuning.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo @$this->session->userdata('name') ? $this->session->userdata('name') : 'Undefined'; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="http://jdih.awanesia.com/logo-esdm-kuning.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo @$this->session->userdata('name') ? $this->session->userdata('name') : 'Undefined'; ?>
                </p>
                <p><?php echo @$this->session->userdata('branch_name'); ?></p>
              </li>
              <!-- Menu Body --> 
              <!-- Menu Footer-->
              <li class="user-footer"> 
                <div class="pull-right">
                  <a href="<?php echo site_url('auth/logout/') ?>" class="btn btn-default btn-flat">Keluar</a>
                </div>
              </li>
            </ul>
          </li> 
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar"> 
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGASI</li>
           <li id="menuDashboard">
          <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
          </a>
        </li> 
        <li id="MenuUnitKerja" class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Unit Kerja</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="MenuUnitKerjaLemigas" class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Lemigas
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="unitKerjaLemigas-Lemigas"><a href="<?php echo site_url('dashboard/lemigas'); ?>"><i class="fa fa-circle-o"></i> Lemigas</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-1</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-3</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-4</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-5</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-6</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-7</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-8</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-9</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLM-10</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Tekmira
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-1</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-2</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-3</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-4</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-5</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-6</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> BLT-7</a></li>
              </ul>
            </li>
          </ul>
        </li>
        
        <li class="header">Data Master</li>
        <li id="menuTarget">
          <a href="<?php echo site_url('master/target'); ?>">
            <i class="fa fa-rocket"></i> <span>Master Target</span>
          </a>
        </li>
        <li id="menuStruktur">
          <a href="<?php echo site_url('master/struktur'); ?>">
            <i class="fa fa-sitemap"></i> <span>Master Organisasi</span>
          </a>
        </li>  
        <li id="menuBranch">
          <a href="<?php echo site_url('master/branch'); ?>">
            <i class="fa fa-briefcase"></i> <span>Master Unit Kerja</span>
          </a>
        </li>

        <li class="header">Pengaturan</li>
           <li class="<?php echo @$this->uri->segment(1) === 'pengguna' ? 'active' : '' ; ?>">
          <a href="<?php echo site_url('pengguna'); ?>">
            <i class="fa fa-users"></i> <span>Pengguna</span> 
          </a>
        </li>
		<li class="header">Form Laporan</li>
        <li class=""><a href="<?php echo site_url('dashboard/form_a'); ?>"><span>Form A</span></a></li>
        <li class=""><a href="<?php echo site_url('dashboard/form_b'); ?>"><span>Form B</span></a></li>
        <li class=""><a href="<?php echo site_url('dashboard/form_c'); ?>"><span>Form C</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php
  // echo @$page ? $this->load->view($page) : ''; 
    if (@$page) {
      $this->load->view($page);
    }
  ?>
  </div>
  <!-- /.content-wrapper -->
  
