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
				
				<form action="#" method="POST" id="editForm" class="form-horizontal">
					<input type="hidden" id="org_id" value="<?php echo @$detail['org_id']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="parent_id" class="col-sm-2 control-label">parent_id</label>
							<div class="col-sm-10">
								<select class="form-control" id="parent_id" placeholder="parent_id" required>
									<option value="">Pilih Parent</option>
									<option value="0">No Parent</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="branch_id" class="col-sm-2 control-label">branch_id</label>
							<div class="col-sm-10">
								<select class="form-control" id="branch_id" placeholder="branch_id" required>
									<option value="">Pilih Cabang</option>
									<?php foreach($branchAll as $row){ ?>
									<option value="<?php echo $row['branch_id']; ?>" <?php echo $row['branch_id']==$detail['branch_id']?'selected':''; ?>><?php echo $row['branch_name'].' '.$row['ip_address']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="code" class="col-sm-2 control-label">code</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="code" placeholder="code" value="<?php echo $detail['code']; ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="type" class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
								<select class="form-control" id="type" required>
									<option value="">Pilih Type</option>
									<option value="Penerimaan" <?php echo $detail['type']=='Penerimaan'?'selected':''; ?>>Penerimaan</option>
									<option value="Pelaksanaan" <?php echo $detail['type']=='Pelaksanaan'?'selected':''; ?>>Pelaksanaan</option>
									<option value="Keuangan" <?php echo $detail['type']=='Keuangan'?'selected':''; ?>>Keuangan</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="org_name" class="col-sm-2 control-label">org_name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="org_name" placeholder="org_name" value="<?php echo $detail['org_name']; ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-2 control-label">description</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="description" placeholder="description" value="<?php echo $detail['description']; ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="sts_deleted" class="col-sm-2 control-label">sts_deleted</label>
							<div class="col-sm-10">
								<select name="sts_deleted" class="form-control" id="sts_deleted" required>
									<option value="0" <?php echo $detail['sts_deleted']==0?'selected':''; ?>>Aktif</option>
									<option value="1" <?php echo $detail['sts_deleted']==1?'selected':''; ?>>Pasif</option>
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