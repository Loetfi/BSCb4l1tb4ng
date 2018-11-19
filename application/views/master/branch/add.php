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
			<div class="box">
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
							<label for="ip_address" class="col-sm-2 control-label">ip_address</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="ip_address" placeholder="ip_address" required>
							</div>
						</div>
						<div class="form-group">
							<label for="branch_name" class="col-sm-2 control-label">branch_name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="branch_name" placeholder="branch_name" required>
							</div>
						</div>
						<div class="form-group">
							<label for="address" class="col-sm-2 control-label">address</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="address" placeholder="address" required>
							</div>
						</div>
						<div class="form-group">
							<label for="phone" class="col-sm-2 control-label">phone</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="phone" placeholder="phone" required>
							</div>
						</div>
						<div class="form-group">
							<label for="sts_deleted" class="col-sm-2 control-label">sts_deleted</label>
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
<?php $this->load->view('master/branch/script'); ?>