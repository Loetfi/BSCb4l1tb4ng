<script src="<?php echo base_url('assets/highcharts'); ?>/highcharts.src.js"></script>
<script src="<?php echo base_url('assets/highcharts'); ?>/highcharts-more.js"></script>
<script src="<?php echo base_url('assets/highcharts'); ?>/modules/exporting.js"></script>
<script src="<?php echo base_url('assets/highcharts'); ?>/modules/export-data.js"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>
<!-- pre><?php print_r($getGrafik_form_a); ?></pre -->

<!-- Main content -->

<section class="content">
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
				<div class="box-body">
<table class="table table-bordered table-striped">
<tr><th>Bulan	</th><th>Target 2019	</th><th>Realisasi	</td><th>Realisasi Kontrak</th><th>Realisasi Tahun Lalu</th></tr>
<?php for($i=1; $i<=12; $i++){ ?>
<tr>
	<td align="right"><?php echo date('M', strtotime($i.'/20/2019')); ?></td>
	<td align="right"><?php echo @$thisTarget[$i]; ?></td>
	<td align="right"><?php echo @$getGrafik_form_a['table']['realisasi'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['realisasi'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
	<td align="right"><?php echo @$getGrafik_form_a['table']['nilaiKontrak'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['nilaiKontrak'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
	<td align="right"><?php echo @$getGrafik_form_a['table']['realiasiTahunLalu'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['realiasiTahunLalu'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
</tr>
<?php } ?>
<!-- tr><td>Jan	</td><td>9.10	</td><td>7.01	</td><td>110.48	</td><td>7.67     </td></tr -->
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
					<div id="GrafikFormA"></div>
				</div>
			</div>
			<!-- /.box --> 
			
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered">
						<tr>
							<th rowspan="2">SatKer</th>
							<th rowspan="2">Target</th>
							<th colspan="2">Target Bulan Ini</th>
							<th colspan="2">Akumulasi Realisasi Sampai Bulan Ini</th>
							<th colspan="2">Sisa</th>
						</tr>
						<tr>
							<th>Rp M</th>
							<th>%</th>
							<th>Rp M</th>
							<th>%</th>
							<th>Rp M</th>
							<th>%</th>
						</tr>
						<?php foreach($getRekap_form_a['dataSatker'] as $row){ ?>
						<tr>
							<td><?php echo $row['Unit Kerja']; ?></td>
							<td align="right"><?php echo $row['Target']; ?></td>
							<td align="right"><?php echo $row['Target Bulan Ini']; ?></td>
							<td align="right"><?php echo $row['Target (%)']; ?></td>
							<td align="right"><?php echo $row['Realisasi']; ?></td>
							<td align="right"><?php echo $row['Realisasi(%)']; ?></td>
							<td align="right"><?php echo $row['Sisa']; ?></td>
							<td align="right"><?php echo $row['Sisa(%)']; ?></td>
						</tr>
						<?php }?>
					</table>
				</div>
			</div>
			<!-- /.box --> 
		</div>
		
	</div>
	
</section>

<script>
$(function(){
	$('#menuDashboard').addClass('active');
	// $('#MenuUnitKerja').addClass('active').addClass('menu-open');
	// $('#MenuUnitKerjaLemigas').addClass('active').addClass('menu-open');
	// $('#unitKerjaLemigas-Lemigas').addClass('active');

Highcharts.chart('GrafikFormA', {
	credits: { enabled: false },
	chart: {
        type: 'line'
    },
    title: {
        text: 'Report Kerja BLU Tahun <?php echo @$thisYear; ?>'
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

});
</script>
