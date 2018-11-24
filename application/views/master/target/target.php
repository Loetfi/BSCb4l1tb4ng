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
			<div class="box">
				<div class="box-header">
					<a href="<?php echo site_url($thisUrl.'/add'); ?>" class="btn btn-success" id="btnTambah"><i class="fa fa-plus"></i> Tambah <?php echo @$title; ?></a>
					
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="thisDataTable" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>ip_address</th>
								<th>branch_name</th>
								<th>org_name</th>
								<th>code</th>
								<th>year</th>
								<th>month</th>
								<th>amount</th>
								<th>Wkt Input</th>
								<th>Wkt Update</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($getAll as $row){ ?>
							<tr>
								<td><?php echo @$row['target_id']; ?></td>
								<td><?php echo @$row['ip_address']; ?></td>
								<td><?php echo @$row['branch_name']; ?></td>
								<td><?php echo @$row['org_name']; ?></td>
								<td><?php echo @$row['code']; ?></td>
								<td><?php echo @$row['year']; ?></td>
								<td><?php echo @$row['month']; ?></td>
								<td align="right"><?php echo number_format(@$row['amount']); ?></td>
								<td><?php echo @$row['create_date']==''?'':date('Y-m-d H:i',@$row['create_date']); ?></td>
								<td><?php echo @$row['modify_date']==''?'':date('Y-m-d H:i',@$row['modify_date']); ?></td>
								<td><?php echo @$row['sts_deleted']=='1'?'Pasif':'Aktif'; ?></td>
								<td>
									<a href="<?php echo site_url($thisUrl.'/detail/'.$row['target_id']); ?>" class="btn btn-xs btn-info" title="Detail"><i class="fa fa-eye"></i></a>
									<a href="<?php echo site_url($thisUrl.'/edit/'.$row['target_id']); ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col -->
	</div>
</section>
<?php $this->load->view('master/target/script'); ?>