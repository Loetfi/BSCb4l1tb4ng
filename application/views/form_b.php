<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>

<!-- Main content -->

<section class="content">
	<!-- div class="row">
		<div class="col-lg-12 col-xs-12">
			<select class="form-control" id="satKer">
				<option value="p3tek" <?php echo $satKer == 'p3tek' ? 'selected' : ''; ?>>P3TEK</option>
				<option value="tekmira" <?php echo $satKer == 'tekmira' ? 'selected' : ''; ?>>TEKMIRA</option>
				<option value="lemigas" <?php echo $satKer == 'lemigas' ? 'selected' : ''; ?>>LEMIGAS</option>
				<option value="p3gl" <?php echo $satKer == 'p3gl' ? 'selected' : ''; ?>>P3GL</option>
			</select>
			<br>
		</div>
	</div -->
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
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo number_format($getRekap_form_c['totalInv'] / $pembagi, 2). $satuan; ?></h3>
					<p>Invoice</p>
				</div>
				<div class="icon">
					<i class="ion ion-arrow-graph-up-right"></i>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-xs-4">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo $getRekap_form_a['realisasi']; ?>(<?php echo $getRekap_form_a['persenRealisasi']; ?>)</h3>
					<p>Realisasi</p>
				</div>
				<div class="icon">
					<i class="ion ion-android-done"></i>
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
	<?php 
	$targetBulanan = $getGrafik_form_a['targetBulanan'];
	$targetBulanIni = $getGrafik_form_a['targetBulanIni'];
	// echo '<pre>';
	// print_r($targetBulanIni);
	// print_r($targetBulanan);
	// print_r($getRekap_form_b);
	// print_r($targetAll);
	// echo '</pre>';
	?>
	<div class="row">
		<div class="col-xs-4">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body" style="height: 100%; overflow-y: auto; overflow-x: auto;">
					<table class="table table-bordered">
						<tr>
							<th rowspan="2">Unit Kerja</th>
							<th rowspan="2">Target</th>
							<th colspan="2">Target Bulan Ini</th>
							<th colspan="2">Realisasi s.d <?php echo date('d m Y'); ?></th>
							<th colspan="2">Sisa</th>
						</tr>
						<tr>
							<th>Rp.M</th>
							<th>%</th>
							<th>Rp.M</th>
							<th>%</th>
							<th>Rp.M</th>
							<th>%</th>
						</tr>
						<?php 
						$thisUnitKerja = array();
						foreach($getRekap_form_b as $row){ ?>
						<tr>
							<th><?php 
								echo strtoupper(@$row['Unit Kerja']); 
								$thisUnitKerja[] = strtoupper(@$row['Unit Kerja']); 
							?></th>
							<td align="right"><?php echo $row['Target']; ?></td>
							
							<!-- td align="right"><?php echo $row['Target Bulan Ini']; ?></td>
							<td align="right"><?php echo $row['Target (%)']; ?></td -->
							
							<td align="right"><?php echo number_format(@$targetBulanIni[$row['Unit Kerja']] / $pembagi,2); ?></td>
							<td align="right"><?php echo $row['Target Bulan Ini']; ?></td>
							
							<td align="right"><?php echo $row['Realisasi']; ?></td>
							<td align="right"><?php echo $row['Realisasi(%)']; ?></td>
							<td align="right"><?php echo $row['Sisa']; ?></td>
							<td align="right"><?php echo $row['Sisa(%)']; ?></td>
						</tr>
						<?php } ?>
						<?php foreach($targetAll as $key => $val){ 
							if (!in_array($key, $thisUnitKerja)){
								$row['Unit Kerja'] = $key;
								$row['Target'] = $val
						?>
						<tr>
							<th><?php 
								echo strtoupper(@$row['Unit Kerja']); 
								$thisUnitKerja[] = strtoupper(@$row['Unit Kerja']); 
							?></th>
							<td align="right"><?php echo number_format(@$row['Target'] / $pembagi,2).$satuan; ?></td>
							<td align="right"><?php echo number_format(@$targetBulanIni[$row['Unit Kerja']] / $pembagi,2); ?></td>
							<td align="right"><?php echo @$row['Target Bulan Ini']; ?></td>
							<td align="right"></td>
							<td align="right"></td>
							<td align="right"></td>
							<td align="right"></td>
						<tr>
						<?php } } ?>
						
					</table>
				</div>
			</div>
		</div>
		<div class="col-xs-8">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="GrafikFormB"></div>
				</div>
			</div>
			
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<tr>
							<th>Bulan</th>
							<?php for($i=1; $i<=12; $i++){ ?>
							<th align="right"><?php echo date('M', strtotime($i.'/20/2019')); ?></th>
							<?php } ?>
						</tr>
						<tr>
							<th>Target</th>
							<?php for($i=1; $i<=12; $i++){ ?>
							<td align="right"><?php echo @$targetBulanan[$i] > 0 ? number_format($targetBulanan[$i]/$pembagi,2).$satuan : '-'; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<th>Realisasi Penerimaan</th>
							<?php for($i=1; $i<=12; $i++){ ?>
							<td align="right"><?php echo @$getGrafik_form_a['table']['realisasi'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['realisasi'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<th>Realisasi Kontrak</th>
							<?php for($i=1; $i<=12; $i++){ ?>
							<td align="right"><?php echo @$getGrafik_form_a['table']['nilaiKontrak'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['nilaiKontrak'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<th>Realisasi Tahun Lalu</th>
							<?php for($i=1; $i<=12; $i++){ ?>
							<td align="right"><?php echo @$getGrafik_form_a['table']['realiasiTahunLalu'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['realiasiTahunLalu'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
							<?php } ?>
						</tr>
						</table>
				</div>
			</div>
		</div>
		
	</div>
	
</section>

<script>
$(function(){
	// $('#MenuUnitKerja').addClass('active').addClass('menu-open');
	// $('#MenuUnitKerjaLemigas').addClass('active').addClass('menu-open');
	// $('#unitKerjaLemigas-Lemigas').addClass('active');
Highcharts.chart('GrafikFormB', {
	credits: { enabled: false },
	chart: {
        type: 'line'
    },
    title: {
        text: 'Report Kerja Tahun 2019'
    },
    xAxis: {
		// labels: {
			// rotation: -45,
		// },
		crosshair: true,
        categories: <?php echo json_encode($bulanan); ?>
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: <?php echo json_encode($getGrafik_form_a['dataSeries']); ?>
});

$('#satKer').change(function(){
	val = $(this).val();
	// alert(val);
	window.location.href="<?php echo site_url('dashboard/form_b'); ?>/"+val;
});
});
</script>
