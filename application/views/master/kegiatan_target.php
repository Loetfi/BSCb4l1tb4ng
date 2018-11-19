<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Detail Kegiatan</h3>
					<div class="box-tools pull-right">
						<a href="<?php echo site_url( $this->uri->segment(1)); ?>" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i></a>
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered">
						<tr>
							<th width="200px">nama_keg</th>
							<td><?php echo @$detail['nama_keg']; ?></td>
						</tr>
						<tr>
							<th>tahun</th>
							<td><?php echo @$detail['tahun']; ?></td>
						</tr>
						<tr>
							<th>status</th>
							<td><?php echo @$detail['status']; ?></td>
						</tr>
						<tr>
							<th>cdate</th>
							<td><?php echo date('d F Y h:i:s',@$detail['cdate']); ?></td>
						</tr>
						<tr>
							<th>mdate</th>
							<td><?php echo date('d F Y h:i:s',@$detail['mdate']); ?></td>
						</tr>
					</table>
				</div>
				<!-- /.box-body -->
				
			</div>
			<!-- /.box --> 
		</div>
		<div class="col-md-6">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Log Target Kegiatan</h3>
					<div class="box-tools pull-right">
						<a href="<?php echo site_url( $this->uri->segment(1)); ?>" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i></a>
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered">
						<tr>
							<th>Tahun Target</th>
							<th>Bulan Target</th>
							<th>Status</th>
							<th>Tgl Create</th>
							<th>Edit Create</th>
						</tr>
						<?php foreach($logTarget as $dataLogTarget){ ?>
						<tr>
							<td><?php echo @$dataLogTarget['tahun']; ?></td>
							<td><?php echo 'B'.str_pad(@$dataLogTarget['id_target'], 2, '0', STR_PAD_LEFT); ?></td>
							<td><?php echo @$dataLogTarget['status']; ?></td>
							<td><?php echo @$dataLogTarget['cdate'] == '' ? '-' : date('d F Y H:i:s', $dataLogTarget['cdate']); ?></td>
							<td><?php echo @$dataLogTarget['mdate'] == '' ? '-' : date('d F Y H:i:s', $dataLogTarget['mdate']); ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<!-- /.box-body -->
				
			</div>
			<!-- /.box --> 
		</div>
	
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Form Tambah Log Kegiatan</h3>
					<div class="box-tools pull-right">
						<a href="<?php echo site_url( $this->uri->segment(1)); ?>" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i></a>
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				
				<form action="<?php echo site_url('kegiatan/addLogProcess'); ?>" method="POST" id="addLogKegiatanForm" class="form-horizontal" enctype="multipart/form-data" target="_blank">
					<input type="hidden" name="id_keg" id="id_keg" value="<?php echo @$detail['id_keg']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status Kegiatan</label>
							<div class="col-sm-4">
								<select name="status" class="form-control" id="status" placeholder="status" required>
									<option value="Aktif">Aktif</option>
									<option value="Inaktif">Inaktif</option>
									<option value="Selesai">Selesai</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Target</label>
							<div class="col-sm-2">
								<select name="tahun_target" class="form-control" id="tahun_target" required>
									<?php for($i=date('Y')+1; $i>=date('Y'); $i--){ ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="bulan_target" class="form-control" id="bulan_target" required>
									<?php for($i=1; $i<=12; $i++){ ?>
									<option value="<?php echo $i; ?>"><?php echo 'B'.str_pad($i,2,'0',STR_PAD_LEFT); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Cancel</button>
						<button type="submit" class="btn btn-info pull-right">Simpan</button>
					</div>
					<!-- /.box-footer -->
				</form>
				
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col -->
	</div>
</section>
<?php $this->load->view('master/kegiatan_script'); ?>