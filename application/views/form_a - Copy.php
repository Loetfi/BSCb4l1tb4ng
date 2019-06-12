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
<!-- <?php print_r($this->session->all_userdata()); ?> -->

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
		</div>
		
		<div class="col-lg-4 col-xs-4">
			<div class="col-lg-12 col-xs-12">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php echo $getRekap_form_a['targetBulanIni']; ?></h3>
						<p>Target Bulan Ini</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-checkmark-circle"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-xs-12">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<!-- h3>14.38<sup style="font-size: 20px">%</sup></h3 -->
						<h3><?php echo $getRekap_form_a['persenTarget']; ?></h3>
						<p>Target Bulan Ini</p>
					</div>
					<div class="icon">
						<i class="ion ion-arrow-graph-up-right"></i>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-xs-4">
			<div class="col-lg-12 col-xs-12">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php echo $getRekap_form_a['realisasi']; ?></h3>
						<p>Realisasi</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-done"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-xs-12">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php echo $getRekap_form_a['persenRealisasi']; ?></h3>
						<p>Realisasi</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-done-all"></i>
					</div>
				</div>
			</div>
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
<table class="table table-bordered">
<tr><th>Bulan	</th><th>Target 2019	</th><th>Realisasi	</td><th>Realisasi Kontrak</th><th>Realisasi</th></tr>
<tr><td>Jan	</td><td>9.10	</td><td>7.01	</td><td>110.48	</td><td>7.67     </td></tr>
<tr><td>Feb	</td><td>15.10	</td><td>14.36	</td><td>132.90	</td><td>12.86    </td></tr>
<tr><td>Mar	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Apr	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>May	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Jun	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Jul	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Aug	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Sep	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Oct	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Nov	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
<tr><td>Dec	</td><td>	</td><td>	</td><td>	</td><td>         </td></tr>
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
<tr><th>Bulan	</th><th>Target 2019	</th><th>Realisasi	</td><th>Realisasi Kontrak</th><th>Realisasi</th></tr>
<?php for($i=1; $i<=12; $i++){ ?>
<tr>
	<td align="right"><?php echo date('M', strtotime($i.'/20/2019')); ?></td>
	<td align="right"><?php echo @$getGrafik_form_a['table']['target'][$i-1] > 0 ? number_format($getGrafik_form_a['table']['target'][$i-1]/$pembagi,2).$satuan : '-'; ?></td>
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
							<th colspan="2">Realisasi Bulan Ini</th>
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
	$('#MenuUnitKerja').addClass('active').addClass('menu-open');
	$('#MenuUnitKerjaLemigas').addClass('active').addClass('menu-open');
	$('#unitKerjaLemigas-Lemigas').addClass('active');
Highcharts.chart('GrafikGlobalBulanan', {
	credits: { enabled: false },
	chart: {
        type: 'line'
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

Highcharts.chart('GrafikFormA', {
	credits: { enabled: false },
	chart: {
        type: 'line'
    },
    title: {
        text: 'Report Kerja LEMIGAS Tahun 2019'
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
