<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>

<!-- Main content -->

<section class="content">
	<div class="row">
		<div class="col-lg-12 col-xs-12">
			<select class="form-control" id="satKer">
				<option value="p3tek" <?php echo $satKer == 'p3tek' ? 'selected' : ''; ?>>P3TEK</option>
				<option value="tekmira" <?php echo $satKer == 'tekmira' ? 'selected' : ''; ?>>TERKMIRA</option>
				<option value="lemigas" <?php echo $satKer == 'lemigas' ? 'selected' : ''; ?>>LEMIGAS</option>
			</select>
			<br>
		</div>
	</div>
	
	<div class="row">
        <div class="col-lg-4 col-xs-4"> 
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $getRekap_form_a['target']; ?></h3>
					<p>Target</p>
				</div>
				<div class="icon">
					<i class="ion ion-aperture"></i>
				</div>
			</div>
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo @$getRekap_form_a['kontrakSatker']; ?></h3>
					<p>Kontrak</p>
				</div>
				<div class="icon">
					<i class="ion ion-aperture"></i>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-xs-4">
			<div class="col-lg-12 col-xs-12">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php echo $getRekap_form_a['targetBulanIni']; ?>(<?php echo $getRekap_form_a['persenTarget']; ?>)</h3>
						<p>Target Bulan Ini</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-checkmark-circle"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-xs-12">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?php echo 'xxx'; ?></h3>
						<p>Invoice</p>
					</div>
					<div class="icon">
						<i class="ion ion-arrow-graph-up-right"></i>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-xs-4">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php echo $getRekap_form_a['realisasi']; ?>(<?php echo $getRekap_form_a['persenRealisasi']; ?>)</h3>
						<p>Realisasi</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-done"></i>
					</div>
				</div>
			</div>
			<!-- div class="col-lg-12 col-xs-12">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php echo $getRekap_form_a['persenRealisasi']; ?></h3>
						<p>Realisasi</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-done-all"></i>
					</div>
				</div>
			</div -->
        </div>
		<!-- ./col -->
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body" style="height: 100%; overflow-x: scroll;">
					<table class="table table-bordered table-striped">
						<thead>
						<tr>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">No</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Unit Kerja</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Target</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Terkontrak [Rp.M]</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Invoice [Rp.M]</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Realisasi [Rp.M]</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Sisa Kontrak [Rp.M]</th>
							<th rowspan="3" style="vertical-align: middle; text-align:center;">Capaian Realisasi <br>%</th>
							<th colspan="36"style="vertical-align: middle; text-align:center; width: 2400px;">Realisasi Bulanan</th>
						</tr>
						<tr>
							<?php for($i=1; $i<=12; $i++){ ?>
							<th colspan="3" style="text-align:center;"><?php echo date('M', strtotime($i.'/20/2019')); ?></th>
							<?php } ?>
						</tr>
						<tr>
							<?php for($bulan=1; $bulan<=12; $bulan++){ ?>
							<th>%</th>
							<th style="width: 100px;">[Rp.M]</th>
							<th style="width: 100px;">Sum</th>
							<?php } ?>
						</tr>
						</thead>
						<tbody>
							<?php 
							// $akumulasi = 0;
							$tableRekap = $getRekap_form_c['tableRekap'];
							$dataTable = $getRekap_form_c['dataTable'];
							$arrKp3 = $getRekap_form_c['arrKp3'];
							$arrOrgId = $getRekap_form_c['arrOrgId'];
							for($i=0; $i<count($arrKp3); $i++){ 
								$kp3 = strtoupper($arrKp3[$i]);
								$org = @$arrOrgId[$kp3];
							?>
							<tr>
								<td><?php echo $i+1; ?></td>
								<td><?php echo $kp3; ?></td>
								<td>Target</td>
								<td align="right">
									<button class="btn btn-link btnTerkontrak" this_key="<?php echo $org == null ? $kp3 : $org; ?>" this_year="<?php echo date('Y'); ?>" this_kp3="<?php echo $kp3; ?>">
										<?php echo number_format(@$tableRekap[$kp3]['terkontrak'] / $pembagi ,4); ?>
									</button>
								</td>
								<td align="right"><?php echo number_format(@$tableRekap[$kp3]['inv'] / $pembagi ,4); ?></td>
								<td align="right">
									<button class="btn btn-link btnRealisasi" this_key="<?php echo $org == null ? $kp3 : $org; ?>" this_year="<?php echo date('Y'); ?>" this_kp3="<?php echo $kp3; ?>">
										<?php echo number_format(@$tableRekap[$kp3]['realisasi'] / $pembagi ,4); ?>
									</button>
								</td>
								<td align="right"><?php echo number_format(((@$tableRekap[$kp3]['terkontrak'] - @$tableRekap[$kp3]['realisasi']) / $pembagi),4); ?></td>
								<td align="right"><?php echo number_format((@$tableRekap[$kp3]['realisasi'] / @$tableRekap[$kp3]['terkontrak'] * 100),2) ?></td>
								<?php 
								for($bulan=1; $bulan<=12; $bulan++){ 
									$nilai = '-';
									$persen = '-';
									if (@$dataTable[$kp3][$bulan]['realisasi'] > 0){
										$nilai = number_format(@$dataTable[$kp3][$bulan]['realisasi'] / $pembagi ,4);
										$persen = number_format(rand(1,80),2);
										@$akumulasi[$kp3] += @$dataTable[$kp3][$bulan]['realisasi'];
									}
								
								?>
								<td align="right"><?php echo @$persen; ?></td>
								<td align="right"><?php echo @$nilai; ?></td>
								<td align="right"><?php echo ($bulan <= (int)date('m')) ? number_format(@$akumulasi[$kp3] / $pembagi,4) : '-'; ?></td>
								<?php } ?>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</div>
	
</section>
<div class="modal fade" id="modal-default-terkontrak">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"></h4>
	  </div>
	  <div class="modal-body">
	    <table id="nTableKontrak" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Kontrak</th>
					<th>No Kontrak</th>
					<th>Pelanggan</th>
					<th>Nilai Kontrak</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-default-realisasi">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"></h4>
	  </div>
	  <div class="modal-body">
	    <table id="nTableRealisasi" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Kontrak</th>
					<th>No Kontrak</th>
					<th>Pelanggan</th>
					<th>Nilai Kontrak</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
$(function(){
	// $('#MenuUnitKerja').addClass('active').addClass('menu-open');
	// $('#MenuUnitKerjaLemigas').addClass('active').addClass('menu-open');
	// $('#unitKerjaLemigas-Lemigas').addClass('active');

$('#satKer').change(function(){
	val = $(this).val();
	// alert(val);
	window.location.href="<?php echo site_url('dashboard/form_c'); ?>/"+val;
});

var nTableKontrak = $('#nTableKontrak').dataTable();
var nTableRealisasi = $('#nTableRealisasi').dataTable();

$('.btnTerkontrak').click(function(){
	thisKp3 = $(this).attr('this_kp3');
	thisKey = $(this).attr('this_key');
	thisYear = $(this).attr('this_year');
	$.ajax({
		method: 'POST',
		type: 'json',
		url: '<?php echo site_url('api/dashboard/detailTerkontrak'); ?>', 
		data: {
			thisKey: thisKey, 
			thisYear : thisYear, 
			thisSatker : '<?php echo $satKer; ?>', 
		},
		beforeSend: function( ) {
		},
		success: function(thisData) {
			console.log(thisData.data.length);
			nTableKontrak.fnClearTable(); 
			for(i = 0; i < thisData.data.length; i++){
				row = thisData.data[i];
				nTableKontrak.fnAddData([ 
					(i+1),
					row.judul,
					row.noKontrak,
					row.pelanggan,
					row.nilaiKontrak
				]);
			} 
		},
		error: function() {
			alert('Ada opsi yang belum terpilih atau refresh halaman, dan coba lagi.');
		},
		complete: function(){
			$('.modal-title').text(thisKp3);
			$('#modal-default-terkontrak').modal('show');
		}
	});
	
});

$('.btnRealisasi').click(function(){
	thisKp3 = $(this).attr('this_kp3');
	thisKey = $(this).attr('this_key');
	thisYear = $(this).attr('this_year');
	$.ajax({
		method: 'POST',
		type: 'json',
		url: '<?php echo site_url('api/dashboard/detailRealisasi'); ?>', 
		data: {
			thisKey: thisKey, 
			thisYear : thisYear, 
			thisSatker : '<?php echo $satKer; ?>', 
		},
		beforeSend: function( ) {
		},
		success: function(thisData) {
			console.log(thisData.data.length);
			nTableRealisasi.fnClearTable(); 
			for(i = 0; i < thisData.data.length; i++){
				row = thisData.data[i];
				nTableRealisasi.fnAddData([ 
					(i+1),
					row.judul,
					row.noKontrak,
					row.pelanggan,
					row.nilaiRealisasi
				]);
			} 
		},
		error: function() {
			alert('Ada opsi yang belum terpilih atau refresh halaman, dan coba lagi.');
		},
		complete: function(){
			$('.modal-title').text(thisKp3);
			$('#modal-default-realisasi').modal('show');
		}
	});
	
});

});
</script>
