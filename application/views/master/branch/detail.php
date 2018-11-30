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
				
				<form action="#" method="POST" id="addBranchForm" class="form-horizontal">
					<div class="box-body">
						<table class="table table-bordered table-strip">
							<tr>
								<th width="150px">IP Address</th>
								<td><?php echo @$detail['ip_address']; ?></td>
							</tr>
							<tr>
								<th>Unit Kerja</th>
								<td><?php echo @$detail['branch_name']; ?></td>
							</tr>
							<tr>
								<th>Alamat</th>
								<td><?php echo @$detail['address']; ?></td>
							</tr>
							<tr>
								<th>Tlp</th>
								<td><?php echo @$detail['phone']; ?></td>
							</tr>
							<tr>
								<th>Wkt Input</th>
								<td><?php echo @$detail['create_date']==''?'':date('Y-m-d H:i',@$detail['create_date']); ?></td>
							</tr>
							<tr>
								<th>Wkt Edit</th>
								<td><?php echo @$detail['modify_date']==''?'':date('Y-m-d H:i',@$detail['modify_date']); ?></td>
							</tr>
							<tr>
								<th>Status</th>
								<td><?php echo @$detail['sts_deleted']=='1'?'Aktif':'Pasif'; ?></td>
							</tr>
						</table>
						
					</div>
					<!-- /.box-body -->
				</form>
				
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col -->
	</div>
</section>
<?php $this->load->view('master/branch/script'); ?>