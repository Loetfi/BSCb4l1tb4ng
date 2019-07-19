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
<!-- <?php print_r($this->session->all_userdata()); ?> -->

<!-- Main content -->

<section class="content">
	<div class="row">
        <div class="col-lg-3 col-xs-6"> 
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Kontrak</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
							<td><?php echo number_format(22.94102100600, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
							<td><?php echo number_format(22.94102100600, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>0</td>
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
                            <td><?php echo number_format(7.94497188300, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
                            <td><?php echo number_format(7.94497188300, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>0</td>
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
                            <td><?php echo number_format(12.79379639787, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
                            <td><?php echo number_format(12.79379639787, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>0</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h2 style="margin: 0; padding: 0; font-weight: bold;">Invoice Terbayar</h2>
					<p style="">Tahun: 2018</p>
					<table width="100%">
						<tr>
							<th>Jumlah</th>
                            <td><?php echo number_format(10.79190648087, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai IDR</th>
                            <td><?php echo number_format(10.79190648087, 2); ?> M</td>
						</tr>
						<tr>
							<th>Nilai USD</th>
							<td>0</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<!-- ./col -->
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
					<div id="GrafikGlobalBulanan"></div>
				</div>
			</div>
			<!-- /.box --> 
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
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- <div id="thisChart2"></div> -->
					<div id="GrafikTahunanSubUnit"></div>
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
                <div class="box-body" style="height: 500px; overflow-y: scroll; overflow-x: scroll;">
					<table class="table table-bordered">
<tr><th>NO	</th><th>UNIT KERJA	</th><th>TARGET 2019<br>RP. M	</th><th>TERKONTRAK<br>OUTSTANDING<br>INVOICE	</th><th>INVOICE<br>TERBIT	</th><th>REALISASI </th><th>PENERIMAAN</th><th>#<br>Jan</th><th>#<br>Feb</th><th>#<br>Mar</th></tr>
<tr><td>1	</td><td>BLM-1	 </td><td align="right">8.00000 	 </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">0.51127 	</td><td align="right"> 0.51127 	</td><td align="right"> 0.08000 	</td><td align="right"> 0.08000 	</td><td align="right"> 0.10000 </td></tr>
<tr><td>2	</td><td>BLM-3	 </td><td align="right">3.16000 	 </td><td align="right">0.12760 	</td><td align="right"> 0.06310 	</td><td align="right"> 0.09600 	</td><td align="right"> 0.03290 	</td><td align="right"> -   	    </td><td align="right">0.01000 	</td><td align="right"> 0.01000 </td></tr>
<tr><td>3	</td><td>BLM-4	 </td><td align="right">1.30000 	 </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-        </td></tr>
<tr><td>4	</td><td>BLM-5	 </td><td align="right">30.00000 	 </td><td align="right">5.76427 	</td><td align="right"> 0.46985 	</td><td align="right"> 0.78003 	</td><td align="right"> 0.49226 	</td><td align="right"> 0.19000 	</td><td align="right"> 0.30000 	</td><td align="right"> 0.69000 </td></tr>
<tr><td>5	</td><td>BLM-6	 </td><td align="right">60.83000 	 </td><td align="right">4.02150 	</td><td align="right"> 3.65596 	</td><td align="right"> 4.27313 	</td><td align="right"> 3.12443 	</td><td align="right"> 2.00000 	</td><td align="right"> 1.76000 	</td><td align="right"> 0.86000 </td></tr>
<tr><td>6	</td><td>BLM-7	 </td><td align="right">22.16000 	 </td><td align="right">1.13685 	</td><td align="right"> 1.61231 	</td><td align="right"> 1.95786 	</td><td align="right"> 2.75913 	</td><td align="right"> 2.22000 	</td><td align="right"> 0.22000 	</td><td align="right"> 0.60000 </td></tr>
<tr><td>7	</td><td>BLM-8	 </td><td align="right">34.35000 	 </td><td align="right">4.30455 	</td><td align="right"> 1.39986 	</td><td align="right"> 4.30395 	</td><td align="right"> 3.24992 	</td><td align="right"> 0.72135 	</td><td align="right"> 0.54960 	</td><td align="right"> 0.75570 </td></tr>
<tr><td>8	</td><td>BLM-9	 </td><td align="right">27.33000 	 </td><td align="right">7.58624 	</td><td align="right"> 0.74390 	</td><td align="right"> 0.87157 	</td><td align="right"> 0.62199 	</td><td align="right"> 0.17000 	</td><td align="right"> 0.28697 	</td><td align="right"> 0.43728 </td></tr>
<tr><td>9	</td><td>BLM-10	 </td><td align="right">0.20000 	 </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-   	    </td><td align="right">-        </td></tr>
                    </table>
				</div>
			</div>
			
		</div>
	</div>
	
	
</section>

<script>
$(function(){
	$('#MenuUnitKerja').addClass('active').addClass('menu-open');
	$('#MenuUnitKerjaLemigas').addClass('active').addClass('menu-open');
	$('#unitKerjaLemigas-Lemigas').addClass('active');
Highcharts.chart('GrafikGlobalBulanan', {
	credits: { enabled: false },
	chart: {
        type: 'column'
    },
    title: {
        text: 'Report Kerja LEMIGAS Tahun 2019'
    },
    xAxis: {
		// labels: {
			// rotation: -45,
		// },
		crosshair: true,
        categories: <?php echo json_encode($CategoriesGlobalBulanan); ?>
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
	series: <?php echo json_encode($seriesGlobalBulanan); ?>
});

Highcharts.chart('GrafikTahunanSubUnit', {
	credits: { enabled: false },
	chart: {
        // polar: true,
        type: 'column'
    },
    pane: {
        size: '80%'
    },
    title: {
        text: 'Report Unit Kerja LEMIGAS Tahun 2019'
    },
    xAxis: {
        tickmarkPlacement: 'on',
        lineWidth: 0,
        categories: <?php echo json_encode($CategoriesGlobalKp3); ?>
    },
	yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
    },
    tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
    },
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: <?php echo json_encode(@$SeriesGlobalKp3); ?>
});

});
</script>
