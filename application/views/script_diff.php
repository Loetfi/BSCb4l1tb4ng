<script src="<?php echo base_url('assets'); ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
$(function(){
	$('#menuNotif').addClass('active');
	$('#thisDataTable').DataTable({
		'paging'      : true,
		'lengthChange': false,
		'searching'   : false,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false,
		'serverSide'  : false,
	});
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
    });
});
</script>