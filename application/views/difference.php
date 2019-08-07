<script src="<?php echo base_url('assets'); ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?> <?php echo @$tanggal; ?>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-warning">
				<div class="box-body">
					<form action="" method="get">
						<div class="input-group date col-xs-6 col-sm-6 col-md-3">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" name="tgl" class="form-control pull-right" id="datepicker" value="<?php echo @$tgl; ?>">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Cari</button>
							</span>
						</div>
					</form>
					  
				</div>
				<div class="box-body">
					<table id="thisDataTable" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Tgl Awal</th>
								<th>Tgl Pembanding</th>
								<th>Satker</th>
								<th>KP3</th>
								<th>Penambah Terkontrak</th>
								<th>Penambah Invoice</th>
								<th>Penambah Realiasi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 0;
							foreach($getNotif as $row){ ?>
							<tr>
								<td><?php echo ++$no; ?></td>
								<td><?php echo date('d M Y', strtotime($tgl.' -2 days')); ?></td>
								<td><?php echo date('d M Y', strtotime($tgl.' -1 days')); ?></td>
								<td><?php echo strtoupper(@$row['satker']); ?></td>
								<td><?php echo strtoupper(@$row['kp3']); ?></td>
								<td align="right"><?php echo $row['selisih_terkontrak'] > 0 ? number_format($row['selisih_terkontrak'],2) : '-'; ?></td>
								<td align="right"><?php echo $row['selisih_inv'] > 0 ? number_format($row['selisih_inv'],2) : '-'; ?></td>
								<td align="right"><?php echo $row['selisih_realisasi'] > 0 ? number_format($row['selisih_realisasi'],2) : '-'; ?></td>
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
<script>
$(function(){
	$('#menuNotif').addClass('active');
	$('#thisDataTable').DataTable({
		'paging'      : true,
		'lengthChange': false,
		'searching'   : false,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false,
		'serverSide'  : false,
	});
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
    });
});
</script>