<?php $thisSession = $this->session->all_userdata(); ?>
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
		
		<?php if ($thisSession['branch_name'] == 'Administrator'){ ?>
        <li id="menuDashboard">
          <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Kinerja BLU</span> 
          </a>
        </li> 
		<li id="menuDashboard2">
          <a href="<?php echo site_url('dashboard/form_a'); ?>">
            <i class="fa fa-dashboard"></i> <span>Realisasi Penerimaan BLU</span> 
          </a>
        </li> 
        <?php } ?>
		
		
		<li id="MenuUnitKerja" class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Satuan Kerja</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<?php if ($thisSession['branch_name'] == 'Administrator' || $thisSession['branch_name'] == 'P3TEK'){ ?>
            <li id="MenuUnitKerja-P3TEK" class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> P3TEK
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('dashboard/form_b/p3tek'); ?>"><i class="fa fa-circle-o"></i> Rekap</a></li>
                <li><a href="<?php echo site_url('dashboard/form_c/p3tek'); ?>"><i class="fa fa-circle-o"></i> Detail</a></li>
              </ul>
            </li>
			<?php } ?>
			
			
			<?php if ($thisSession['branch_name'] == 'Administrator' || $thisSession['branch_name'] == 'TERKMIRA'){ ?>
            <li id="MenuUnitKerja-TERKMIRA" class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> TERKMIRA
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('dashboard/form_b/tekmira'); ?>"><i class="fa fa-circle-o"></i> Rekap</a></li>
                <li><a href="<?php echo site_url('dashboard/form_c/tekmira'); ?>"><i class="fa fa-circle-o"></i> Detail</a></li>
              </ul>
            </li>
			<?php } ?>
			
			
			<?php if ($thisSession['branch_name'] == 'Administrator' || $thisSession['branch_name'] == 'LEMIGAS'){ ?>
            <li id="MenuUnitKerja-LEMIGAS" class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> LEMIGAS
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('dashboard/form_b/lemigas'); ?>"><i class="fa fa-circle-o"></i> Rekap</a></li>
                <li><a href="<?php echo site_url('dashboard/form_c/lemigas'); ?>"><i class="fa fa-circle-o"></i> Detail</a></li>
              </ul>
            </li>
			<?php } ?>
			
			
			<?php if ($thisSession['branch_name'] == 'Administrator' || $thisSession['branch_name'] == 'P3GL'){ ?>
            <li id="MenuUnitKerja-P3GL" class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> P3GL
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('dashboard/form_b/p3gl'); ?>"><i class="fa fa-circle-o"></i> Rekap</a></li>
                <li><a href="<?php echo site_url('dashboard/form_c/p3gl'); ?>"><i class="fa fa-circle-o"></i> Detail</a></li>
              </ul>
            </li>
			<?php } ?>
			
          </ul>
        </li>
        
		<?php if ($thisSession['branch_name'] == 'Administrator'){ ?>
		<li class="header">Data Master</li>
        <!-- <li id="menuBranch">
          <a href="<?php echo site_url('master/branch'); ?>">
            <i class="fa fa-briefcase"></i> <span>Master Unit Kerja</span>
          </a>
        </li> -->
        <li id="menuStruktur">
          <a href="<?php echo site_url('master/struktur'); ?>">
            <i class="fa fa-sitemap"></i> <span>Master Satuan Kerja(KP3)</span>
          </a>
        </li>  
        <li id="menuTarget">
          <a href="<?php echo site_url('master/target'); ?>">
            <i class="fa fa-rocket"></i> <span>Master Target</span>
          </a>
        </li>

        <li class="header">Pengguna</li>
           <li class="<?php echo @$this->uri->segment(1) === 'pengguna' ? 'active' : '' ; ?>">
          <a href="<?php echo site_url('pengguna'); ?>">
            <i class="fa fa-users"></i> <span>Pengguna</span> 
          </a>
        </li>
		<li id="menuNotif">
          <a href="<?php echo site_url('diff'); ?>">
            <i class="fa fa-bell"></i> <span>Difference Log</span> 
          </a>
        </li> 
		<?php } ?>
		
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
  
