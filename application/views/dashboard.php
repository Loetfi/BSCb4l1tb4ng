<script src="https://code.highcharts.com/highcharts.src.js"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>
<!-- <?php print_r($this->session->all_userdata()); ?> -->

<!-- Main content -->

<section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6"> 
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Kontrak</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td><?php echo @$jumlah_kontrak; ?></td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Invoice</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Job/LHU</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Invoice Terbayar</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
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
				<div class="box-body">
					<div id="thisChart2"></div>
				</div>
			</div>
			<!-- /.box --> 
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch_1"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch_2"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="box box-warning">
				<div class="box-header">
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div id="branch_3"></div>
				</div>
			</div>
		</div>
		<!-- /.col -->
	</div>
	
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Kontrak</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Invoice</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Job/LHU</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Invoice Terbayar</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td>asd</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>asd</td>
						</tr>
					</table>
				</div>
			</div>
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
                <div class="box-body">
                    <!-- <div id="thisChart2"></div> -->
					<div id="GrafikTahunanSubUnit"></div>
				</div>
			</div>
			
			<div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">&nbsp;</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<div id="GrafikBulananUnit"></div>
				</div>
			</div>
		</div>
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
                <div class="box-body">
					
					<table class="table table-bordered">
					<thead>
						<tr>
							<th rowspan="3">Unit Kerja</th>
							<th rowspan="3">Target</th>
							<th rowspan="3">Target Bulan Ini</th>
							
							<th colspan="3">Terkontrak</th>
							<th colspan="2">Potensi</th>
							<th>INV</th>
							<th colspan="4">Tealisasi Penerimaan</th>
							<th>Outstanding INV</th>
							<th colspan="6">Target Bulanan</th>
						</tr>
						<tr>
							<th rowspan="2">Luncuran</th>
							<th rowspan="2">RP. M</th>
							<th rowspan="2">PKT</th>
							
							<th rowspan="2">RP. M</th>
							<th rowspan="2">PKT</th>
							
							<th rowspan="2">RP. M</th>
							
							<th>Luncuran</th>
							<th>2018</th>
							<th>Total</th>
							<th rowspan="2">%</th>
							
							<th rowspan="2">RP. M</th>
							
							<th colspan="2">Oktober</th>
							<th colspan="2">November</th>
							<th colspan="2">Desember</th>
						</tr>
						<tr>
							<th>RP. M</th>
							<th>RP. M</th>
							<th>RP. M</th>
							
							<th>%</th>
							<th>RP</th>
							<th>%</th>
							<th>RP</th>
							<th>%</th>
							<th>RP</th>
							
						</tr>
					</thead>
					<?php 
					$i=0;
					foreach($allStruktur as $row){ 
						$org_id = $row['org_id']; 
						?>
						<tr>
							<td><?php echo 'BLM-'.$row['code']; ?></td>
							<td align="right"><?php echo number_format(@$dataTargetOrg[$org_id]); ?></td>
							<td align="right"><?php echo number_format(@$targetBulanIni[$org_id]); ?></td>
						</tr>
					<?php } ?>
					</table>
				</div>
			</div>
			
		</div>
	</div>
	
	
</section>

<script>
$(function(){
	$('#menuDashboard').addClass('active');
	
Highcharts.chart('branch_1', {
	credits: { enabled: false },
	chart: {
        type: 'line'
    },
    title: {
        text: 'Pencapaian Unit Kerja 1'
    },
    xAxis: {
		crosshair: true,
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ]
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }, {
        title: {
            text: 'NIlai USD'
        },
		opposite: true,
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		// type: 'column',
        name: 'Target',
        data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]
    }, {
		// type: 'column',
        name: 'Pendapatan IDR',
        data: [2, 4, 16, 27, 39, 47, 55, 61, 67, 77, 81, 120]
    }, {
		// type: 'column',
        name: 'Penerimaan IDR',
        data: [2, 4, 16, 27, 39, 47, 55, 61, 67, 77, 81, 120]
    }, {
		// type: 'column',
        name: 'Penerimaan USD',
		yAxis: 1,
        data: [0, 0, 10, 48, 50, 61, 63, 63, 63, 81, 81, 100]

    }]
});
Highcharts.chart('branch_2', {
	credits: { enabled: false },
	chart: {
        type: 'line'
    },
    title: {
        text: 'Pencapaian Unit Kerja 2'
    },
    xAxis: {
		crosshair: true,
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ]
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }, {
        title: {
            text: 'NIlai USD'
        },
		opposite: true,
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		// type: 'column',
        name: 'Target',
        data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]
    }, {
		// type: 'column',
        name: 'Pendapatan IDR',
        data: [2, 4, 16, 27, 39, 47, 55, 61, 67, 77, 81, 120]
    }, {
		// type: 'column',
        name: 'Penerimaan IDR',
        data: [2, 4, 16, 27, 39, 47, 55, 61, 67, 77, 81, 120]
    }, {
		// type: 'column',
        name: 'Penerimaan USD',
		yAxis: 1,
        data: [0, 0, 10, 48, 50, 61, 63, 63, 63, 81, 81, 100]

    }]
});
Highcharts.chart('branch_3', {
	credits: { enabled: false },
	chart: {
        type: 'line'
    },
    title: {
        text: 'Pencapaian Unit Kerja 3'
    },
    xAxis: {
		crosshair: true,
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ]
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }, {
        title: {
            text: 'NIlai USD'
        },
		opposite: true,
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		// type: 'column',
        name: 'Target',
        data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120]
    }, {
		// type: 'column',
        name: 'Pendapatan IDR',
        data: [2, 4, 16, 27, 39, 47, 55, 61, 67, 77, 81, 120]
    }, {
		// type: 'column',
        name: 'Penerimaan IDR',
        data: [2, 4, 16, 27, 39, 47, 55, 61, 67, 77, 81, 120]
    }, {
		// type: 'column',
        name: 'Penerimaan USD',
		yAxis: 1,
        data: [0, 0, 10, 48, 50, 61, 63, 63, 63, 81, 81, 100]

    }]
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
	chart: {
        type: 'column'
    },
    title: {
        text: 'Report Unit Kerja Tahun 2018'
    },
    xAxis: {
        categories: [
            'Unit 1',
            'Unit 2',
            'Unit 3',
        ]
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }, {
        title: {
            text: 'NIlai USD'
        },
		opposite: true,
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		// type: 'column',
        name: 'Target',
        data: [1000, 1200, 1000]

    }, {
		// type: 'column',
        name: 'Pendapatan IDR',
        data: [800, 1300, 500]

    }, {
		// type: 'column',
        name: 'Penerimaan IDR',
        data: [700, 1200, 400]

    }, {
		// type: 'column',
        name: 'Penerimaan USD',
		yAxis: 1,
        data: [10, 20, 60]

    }]
});

Highcharts.chart('GrafikTahunanSubUnit', {
	credits: { enabled: false },
	chart: {
        type: 'column'
    },
    title: {
        text: 'Report Unit Kerja Tahun 2019'
    },
    xAxis: {
		// labels: {
			// rotation: -45,
		// },
		crosshair: true,
        categories: <?php echo json_encode($categoriesStruktur); ?>
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }, {
        title: {
            text: 'NIlai USD'
        },
		opposite: true,
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [<?php echo json_encode($seriesDataTarget); ?>]
});
Highcharts.chart('GrafikBulananUnit', {
	credits: { enabled: false },
	chart: {
        // type: 'column'
    },
    title: {
        text: 'Report Unit Kerja Tahun 2019'
    },
    xAxis: {
		// labels: {
			// rotation: -45,
		// },
		crosshair: true,
        categories: <?php echo json_encode($categoriesBulanan); ?>
    },
	yAxis: [{
        title: {
            text: 'Nilai IDR'
        }
    }, {
        title: {
            text: 'NIlai USD'
        },
		opposite: true,
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: <?php echo json_encode($seriesDataTargetBulanan); ?>
});


});
</script>
