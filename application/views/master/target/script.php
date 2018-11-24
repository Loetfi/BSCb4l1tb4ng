<script src="<?php echo base_url('assets'); ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script>
var branch_id = 1;
$(function(){
	$('#menuTarget').addClass('active');
	$('#thisDataTable').DataTable({
		'paging'      : true,
		'lengthChange': false,
		'searching'   : false,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false,
		'serverSide'  : false,
	});
	
	$('#addForm').submit(function(){
		org_id = $('#org_id').val();
		year = $('#year').val();
		month = $('#month').val();
		amount = $('#amount').val();
		sts_deleted = $('#sts_deleted').val();
		
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo site_url($thisUrl.'/addProcess'); ?>",
			data : {
				org_id: org_id,
				year: year,
				month: month,
				amount: amount,
				sts_deleted: sts_deleted,
			},
			success: function(data){
				if (data.status){
					window.location.href = "<?php echo site_url($thisUrl); ?>";
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
		
		return false;
	});
	
	$('#editForm').submit(function(){
		target_id = $('#target_id').val();
		org_id = $('#org_id').val();
		year = $('#year').val();
		month = $('#month').val();
		amount = $('#amount').val();
		sts_deleted = $('#sts_deleted').val();
		
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo site_url($thisUrl.'/editProcess'); ?>",
			data : {
				target_id: target_id,
				org_id: org_id,
				year: year,
				month: month,
				amount: amount,
				sts_deleted: sts_deleted,
			},
			success: function(data){
				if (data.status){
					window.location.href = "<?php echo site_url($thisUrl); ?>";
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
		
		return false;
	});
	
	$('#datepicker').datepicker({
		autoclose: true
	});
	$('#timepicker').timepicker({
		timeFormat: 'HH:mm:ss',
		interval: 15,
		showInputs: false,
	});
	
	$.ajax({
		type: "GET",
		url: "<?php echo site_url('api/Struktur/getComboOrg'); ?>",
		data : {
			branch_id: branch_id,
			parent_id: '<?php echo @$detail['org_id']; ?>',
			childOnly: 1,
		},
		success: function(data){
			data = '<option>Pilih</option>' + data;
			$('#org_id').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	});
});
</script>