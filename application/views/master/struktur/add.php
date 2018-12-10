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
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<a href="<?php echo site_url($thisUrl); ?>" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i></a>
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				
				<form action="#" method="POST" id="addForm" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="parent_id" class="col-sm-2 control-label">Parent</label>
							<div class="col-sm-10">
								<select class="form-control" id="parent_id" placeholder="parent_id" required>
									<option value="">Pilih Parent</option>
									<option value="0">No Parent</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="branch_id" class="col-sm-2 control-label">Nama Branch</label>
							<div class="col-sm-10">
								<select class="form-control" id="branch_id" placeholder="branch_id" required>
									<option value="">Pilih Cabang</option>
									<?php foreach($branchAll as $row){ ?>
									<option value="<?php echo $row['branch_id']; ?>"><?php echo $row['branch_name'].' '.$row['ip_address']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="code" class="col-sm-2 control-label">Kode</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="code" placeholder="code" required>
							</div>
						</div>
						<div class="form-group">
							<label for="type" class="col-sm-2 control-label">Tipe</label>
							<div class="col-sm-10">
								<select class="form-control" id="type" required>
									<option value="">Pilih Type</option>
									<option value="Penerimaan">Penerimaan</option>
									<option value="Pelaksanaan">Pelaksanaan</option>
									<option value="Keuangan">Keuangan</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="org_name" class="col-sm-2 control-label">Nama Organisasi</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="org_name" placeholder="org_name" required>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-2 control-label">Deskripsi</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="description" placeholder="description" required>
							</div>
						</div>
						<div class="form-group">
							<label for="sts_deleted" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<select name="sts_deleted" class="form-control" id="sts_deleted" required>
									<option value="0">Aktif</option>
									<option value="1">Pasif</option>
								</select>
							</div>
						</div>
						
						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default" id="btnReset">Cancel</button>
						<button type="submit" class="btn btn-info pull-right" id="btnSubmit">Simpan</button>
					</div>
					<!-- /.box-footer -->
				</form>
				
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col -->
	</div>
</section>
<?php $this->load->view('master/struktur/script'); ?>
