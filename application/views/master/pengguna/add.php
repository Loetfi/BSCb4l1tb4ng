<!--
<pre><?php print_r($tahun); ?></pre>
-->
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-warning">
				<div class="box-header"> 
					
				</div>
				<!-- /.box-header -->
				<div class="box-body"> 
					<!-- form start -->
					<form role="form" action="<?php echo site_url('pengguna/add_proses/') ?>" method="POST" target="_blank">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Nama</label>
								<input type="text" class="form-control" id="text" placeholder="Masukan Nama Lengkap" name="nama" required="">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Email </label>
								<input type="email" class="form-control" id="email" placeholder="Masukan Email" name="email" required="">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" class="form-control" id="password" placeholder="Masukan Kata Sandi" name="password" required="">
							</div>
							<div class="form-group">
								<label for="exampleInputFile">Branch</label>
								<select class="form-control" name="branch" required="">
									<option value="0">Administrator</option>
									<?php foreach ($branch as $branchs) { ?>
									<option value="<?php echo $branchs['branch_id'];?>"> <?php echo $branchs['branch_name'].' - '.$branchs['ip_address'] ?></option>
									<?php } ?>
									
								</select>
							</div> 
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" class="btn btn-warning btn-sm">Buat Pengguna</button>
						</div>
					</form>

					<!-- <form action="" method="POST" class="form-horizontal" role="form">
						<div class="form-group">
							<legend>Form title</legend>
						</div>
						username 
						<input type="text" name="">
						password
						<input type="text" name="">
						role
						<select>
							<option>Admin Utama</option>
							<option>Admin Unit</option>
							<option>User Unit</option>
						</select>

						
						<div class="form-group">
							<div class="col-sm-10 col-sm-offset-2">
								<button type="submit" class="btn btn-success btn-sm">Submit</button>
							</div>
						</div>
					</form> -->
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col -->
	</div>
</section>
<?php $this->load->view('master/kegiatan_script'); ?>
