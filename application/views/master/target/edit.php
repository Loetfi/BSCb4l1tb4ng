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
					<input type="hidden" id="target_id" value="<?php echo @$detail['target_id']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="org_id" class="col-sm-2 control-label">Nama Organisasi</label>
							<div class="col-sm-10">
								<select id="org_id" class="form-control" required>
									<?php foreach($org as $row){ if ($row['org_id']==$detail['org_id']){ ?>
									<option value="<?php echo $row['org_id']; ?>" <?php echo $row['org_id']==$detail['org_id']?'selected':''; ?>><?php echo $row['branch_name'].' -> '.$row['org_name']; ?></option>
									<?php } } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="year" class="col-sm-2 control-label">Tahun</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="year" placeholder="year" value="<?php echo @$detail['year']; ?>" readonly required>
							</div>
						</div>
						<div class="form-group">
							<label for="month" class="col-sm-2 control-label">Bulan</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="month" placeholder="month" value="<?php echo @$detail['month']; ?>" readonly required>
							</div>
						</div>
						<div class="form-group">
							<label for="amount" class="col-sm-2 control-label">Total Nominal</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="amount" placeholder="amount" value="<?php echo @$detail['amount']; ?>" required>
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
<script>
var edited = 1;
</script>
<?php $this->load->view('master/target/script'); ?>
