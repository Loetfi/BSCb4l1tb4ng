<script src="<?php echo base_url('assets'); ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script>
$(function(){
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
		ip_address = $('#ip_address').val();
		branch_name = $('#branch_name').val();
		address = $('#address').val();
		phone = $('#phone').val();
		sts_deleted = $('#sts_deleted').val();
		
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo site_url($thisUrl.'/addProcess'); ?>",
			data : {
				ip_address: ip_address,
				branch_name: branch_name,
				address: address,
				phone: phone,
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
		branch_id = $('#branch_id').val();
		ip_address = $('#ip_address').val();
		branch_name = $('#branch_name').val();
		address = $('#address').val();
		phone = $('#phone').val();
		sts_deleted = $('#sts_deleted').val();
		
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo site_url($thisUrl.'/editProcess'); ?>",
			data : {
				branch_id: branch_id,
				ip_address: ip_address,
				branch_name: branch_name,
				address: address,
				phone: phone,
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
			branch_id: 2
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