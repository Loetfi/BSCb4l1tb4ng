<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo @$title; ?>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">&nbsp;</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div id="thisChart1"></div>
				</div>
			</div>
			<!-- /.box --> 
		</div>
		<div class="col-xs-6">
			<div class="box">
				<div class="box-body">
					<div id="branch_1"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="box">
				<div class="box-body">
					<div id="branch_2"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="box">
				<div class="box-body">
					<div id="branch_3"></div>
				</div>
			</div>
		</div>
		<!-- /.col -->
	</div>
</section>

<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script>
$(function(){
	$('#menuDashboard').addClass('active');
	
Highcharts.chart('branch_1', {
	credits: { enabled: false },
	chart: {
        type: 'column'
    },
    title: {
        text: 'Pencapaian Branch 1'
    },
    xAxis: {
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
            text: 'Profit (millions)'
        }
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		type: 'column',
        name: 'Target',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, null, null]

    }, {
		type: 'column',
        name: 'Pencapaian',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, null, null]

    }]
});
Highcharts.chart('branch_2', {
	credits: { enabled: false },
	chart: {
        type: 'column'
    },
    title: {
        text: 'Pencapaian Branch 2'
    },
    xAxis: {
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
            text: 'Profit (millions)'
        }
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		type: 'column',
        name: 'Target',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, null, null]

    }, {
		type: 'column',
        name: 'Pencapaian',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, null, null]

    }]
});
Highcharts.chart('branch_3', {
	credits: { enabled: false },
	chart: {
        type: 'column'
    },
    title: {
        text: 'Pencapaian Branch 3'
    },
    xAxis: {
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
            text: 'Profit (millions)'
        }
    }],
	legend: {
        shadow: false
    },
	tooltip: {
        shared: true
    },
	series: [{
		type: 'column',
        name: 'Target',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, null, null]

    }, {
		type: 'column',
        name: 'Pencapaian',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, null, null]

    }]
});

Highcharts.chart('thisChart1', {
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

});
</script>