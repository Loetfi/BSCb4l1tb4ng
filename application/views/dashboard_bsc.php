<script src="https://code.highcharts.com/highcharts.src.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>
<?php /*
$getRekap_form_a = array(
	[target] => 305.65 M
    [targetBulanIni] => 21.07 M
    [persenTarget] => 6.89 %
    [realisasi] => 14.68 M
    [persenRealisasi] => 4.80 %
    [dataSatker] => Array (
		[0] => Array(
			[Unit Kerja] => BLE
			[Target] => 19.80 M
			[Target Bulan Ini] => 1.20 M
			[Target (%)] => 6.06
			[Realisasi] => 2.46 M
			[Realisasi(%)] => 204.72
			[Sisa] => -1.26 M
			[Sisa(%)] => -104.72
		)
	)
    [kontrakSatker] => 5.94 M
)

*/ ?>

<!-- Main content -->
<!-- pre><?php print_r($getRekap_form_a); ?></pre -->
<section class="content">
	<div class="row">
		<?php foreach($getRekap_form_a['dataSatker'] as $row){ ?>
		<div class="col-lg-3 col-xs-6"> 
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;"><?php echo $row['Unit Kerja']; ?></h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Target</th>
							<td align="right"><?php echo $row['Target']; ?></td>
						</tr>
						<tr>
							<th>Realisasi</th>
							<td align="right"><?php echo $row['Realisasi']; ?></td>
						</tr>
						<tr>
							<th>Realisasi Target(%)</th>
							<td align="right"><?php 
								$thisTarget = floatval(str_replace(' M','',$row['Target']));
								$thisRealisasi = floatval(str_replace(' M','',$row['Realisasi']));
								echo $thisSr = floatval(number_format(floatval(str_replace(' M','',$row['Realisasi'])) / floatval(str_replace(' M','',$row['Target'])) * 100,2));
							?> %</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php } ?>
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
				<div class="box-body">
					<div id="thisChart2"></div>
				</div>
			</div>
			<!-- /.box --> 
		</div>
		
	</div>
	<div class="row">	
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">p3tek</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch-p3tek"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">p3gl</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch-p3gl"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">tekmira</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch-tekmira"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">lemigas</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch-lemigas"></div>
				</div>
			</div>
		</div>
		<!-- /.col -->
	</div>
	
	
</section>

<script>
$(function(){
	$('#menuDashboard2').addClass('active');

var thisTitle = 'branch-p3tek';
Highcharts.chart('branch-p3tek', {
	credits: { enabled: false },
	chart: { type: 'line' },
	title: { text: thisTitle },
	xAxis: {
		crosshair: true,
		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
	},
	yAxis: [{
		title: { text: 'Nilai IDR' }
	}],
	legend: { shadow: false },
	tooltip: { shared: true },
	series: <?php echo json_encode($getGrafik['p3tek']['dataSeries']); ?>
});

var thisTitle = 'branch-p3gl';
Highcharts.chart('branch-p3gl', {
	credits: { enabled: false },
	chart: { type: 'line' },
	title: { text: thisTitle },
	xAxis: {
		crosshair: true,
		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
	},
	yAxis: [{
		title: { text: 'Nilai IDR' }
	}],
	legend: { shadow: false },
	tooltip: { shared: true },
	series: <?php echo json_encode($getGrafik['p3gl']['dataSeries']); ?>
});

var thisTitle = 'branch-tekmira';
Highcharts.chart('branch-tekmira', {
	credits: { enabled: false },
	chart: { type: 'line' },
	title: { text: thisTitle },
	xAxis: {
		crosshair: true,
		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
	},
	yAxis: [{
		title: { text: 'Nilai IDR' }
	}],
	legend: { shadow: false },
	tooltip: { shared: true },
	series: <?php echo json_encode($getGrafik['tekmira']['dataSeries']); ?>
});

var thisTitle = 'branch-lemigas';
Highcharts.chart('branch-lemigas', {
	credits: { enabled: false },
	chart: { type: 'line' },
	title: { text: thisTitle },
	xAxis: {
		crosshair: true,
		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
	},
	yAxis: [{
		title: { text: 'Nilai IDR' }
	}],
	legend: { shadow: false },
	tooltip: { shared: true },
	series: <?php echo json_encode($getGrafik['lemigas']['dataSeries']); ?>
});

/* Highcharts.chart('thisChart1', {
	credits: { enabled: false },
    chart: {
        type: 'column'
    },
    title: {
        text: 'BSC ALL'
    },
    xAxis: {
        categories: [
            'Branch 1',
            'Branch 2',
            'Branch 3'
        ]
    },
    yAxis: [{
        title: {
            text: 'Profit (millions)'
        }
    }],
    legend: {
        shadow: false
    },
    tooltip: {
        shared: true
    },
    plotOptions: {
        column: {
            grouping: false,
            shadow: false,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Target',
        color: 'rgba(248,161,63,1)',
        data: [183.6, 178.8, 198.5],
        tooltip: {
            valuePrefix: '$',
            valueSuffix: ' M'
        },
        pointPadding: 0.3,
        // pointPlacement: 0.2,
    }, {
        name: 'Profit Optimized',
        color: 'rgba(186,60,61,.9)',
        data: [203.6, 150, 208.5],
        tooltip: {
            valuePrefix: '$',
            valueSuffix: ' M'
        },
        pointPadding: 0.4,
        // pointPlacement: 0.2,
    }]
});
*/

Highcharts.chart('thisChart2', {
	credits: { enabled: false },
	chart: { type: 'column' },
    title: { text: 'Report Unit Kerja' },
    xAxis: { categories: <?php echo json_encode($unit); ?> },
	yAxis: [{ 
		title: { text: 'Nilai IDR (M)' } 
	},{
        title: { text: 'Success Rate(%)' },
		opposite: true
		// min: 0, max: 100
    }],
	legend: { shadow: false },
	tooltip: { shared: true },
	series: [{
		// type: 'column',
        name: 'Target',
		tooltip: { valueSuffix: ' M' },
        data: <?php echo json_encode($target); ?>

    }, {
		// type: 'column',
        name: 'Realisasi',
		tooltip: { valueSuffix: ' M' },
        data: <?php echo json_encode($realisasi); ?>

    }, {
		// type: 'column',
        name: 'Success Rate',
		yAxis: 1,
		tooltip: { valueSuffix: ' %' },
        data: <?php echo json_encode($sr); ?>

    }]
});

});
</script>
