<script src="<?php echo base_url('assets/highcharts'); ?>/highcharts.src.js"></script>

<script>
$(function(){
	$('#menuDashboard').addClass('active');

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
