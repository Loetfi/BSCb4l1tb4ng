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
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="judul_kegiatan" class="col-sm-4 control-label">judul_kegiatan</label>
									<div class="col-sm-8">
										<textarea name="judul_kegiatan" class="form-control" id="judul_kegiatan" placeholder="judul_kegiatan" required></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="hasil_kegiatan" class="col-sm-4 control-label">hasil_kegiatan</label>
									<div class="col-sm-8">
										<textarea name="hasil_kegiatan" class="form-control" id="hasil_kegiatan" placeholder="hasil_kegiatan" required></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="tanggal" class="col-sm-4 control-label">tanggal</label>
									<div class="col-sm-8">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" name="tanggal" class="form-control pull-right" id="datepicker">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="tanggal" class="col-sm-4 control-label">Waktu</label>
									<div class="col-sm-8">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</div>
											<input type="text" name="waktu" class="form-control" id="timepicker">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="lokasi" class="col-sm-4 control-label">lokasi</label>
									<div class="col-sm-8">
										<input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="lokasi" required>
									</div>
								</div>
								<div class="form-group">
									<label for="status" class="col-sm-4 control-label">Status Kegiatan</label>
									<div class="col-sm-8">
										<select name="status" class="form-control" id="status" placeholder="status" required>
											<option value="Aktif">Aktif</option>
											<option value="Selesai">Selesai</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="file_pendukung" class="col-sm-4 control-label">file_pendukung</label>
									<div class="col-sm-8">
										<input type="file" name="uploadfile[]" class="form-control" placeholder="file_pendukung">
										<input type="file" name="uploadfile[]" class="form-control" placeholder="file_pendukung">
										<input type="file" name="uploadfile[]" class="form-control" placeholder="file_pendukung">
										<input type="file" name="uploadfile[]" class="form-control" placeholder="file_pendukung">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<table class="table">
									<tr>
										<th>Jabatan</th>
										<th>Nama Peserta</th>
									</tr>
									<tr>
										<td><input type="text" name="jabatan[]" class="form-control" placeholder="nama jabatan"></td>
										<td><input type="text" name="nama_peserta[]" class="form-control" placeholder="nama peserta"></td>
									</tr>
									<tr>
										<td><input type="text" name="jabatan[]" class="form-control" placeholder="nama jabatan"></td>
										<td><input type="text" name="nama_peserta[]" class="form-control" placeholder="nama peserta"></td>
									</tr>
									<tr>
										<td><input type="text" name="jabatan[]" class="form-control" placeholder="nama jabatan"></td>
										<td><input type="text" name="nama_peserta[]" class="form-control" placeholder="nama peserta"></td>
									</tr>
								</table>
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