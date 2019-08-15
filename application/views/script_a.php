<script src="<?php echo base_url('assets/highcharts'); ?>/highcharts.src.js"></script>
<script src="<?php echo base_url('assets/highcharts'); ?>/highcharts-more.js"></script>
<script src="<?php echo base_url('assets/highcharts'); ?>/modules/exporting.js"></script>
<script src="<?php echo base_url('assets/highcharts'); ?>/modules/export-data.js"></script>


<script>
$(function(){
	$('#menuDashboard').addClass('active');
	// $('#MenuUnitKerja').addClass('active').addClass('menu-open');
	// $('#MenuUnitKerjaLemigas').addClass('active').addClass('menu-open');
	// $('#unitKerjaLemigas-Lemigas').addClass('active');
	
$('#tahun').change(function(){
	val = $(this).val();
	window.location.href="<?php echo site_url('dashboard/form_a'); ?>/"+val;
});

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
