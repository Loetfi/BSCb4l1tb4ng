<script src="<?php echo base_url('assets'); ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script>
var branch_id = 1;
$(function(){
	$('#menuStruktur').addClass('active');
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
		parent_id = $('#parent_id').val();
		branch_id = $('#branch_id').val();
		type = $('#type').val();
		code = $('#code').val();
		org_name = $('#org_name').val();
		description = $('#description').val();
		sts_deleted = $('#sts_deleted').val();
		
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo site_url($thisUrl.'/addProcess'); ?>",
			data : {
				parent_id: parent_id,
				branch_id: branch_id,
				type: type,
				code: code,
				org_name: org_name,
				description: description,
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
		org_id = $('#org_id').val();
		parent_id = $('#parent_id').val();
		branch_id = $('#branch_id').val();
		type = $('#type').val();
		code = $('#code').val();
		org_name = $('#org_name').val();
		description = $('#description').val();
		sts_deleted = $('#sts_deleted').val();
		
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo site_url($thisUrl.'/editProcess'); ?>",
			data : {
				org_id: org_id,
				parent_id: parent_id,
				branch_id: branch_id,
				code: code,
				type: type,
				org_name: org_name,
				description: description,
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
			parent_id: '<?php echo @$detail['parent_id']; ?>'
		},
		success: function(data){
			data = '<option value="0">No Parent</option>' + data;
			$('#parent_id').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		}
	});
});
</script>