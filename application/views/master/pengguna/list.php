<!--
<pre><?php print_r($tahun); ?></pre>
-->
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
			<div class="box box-success">
				<div class="box-header"> 
					<a href="<?php echo site_url('pengguna/add/') ?>" class="btn btn-success "><i class="fa fa-plus"></i> Tambah Pengguna</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php echo @$message; ?>
					<table id="datatables" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID User</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Branch ID</th>
								<th>Nama Branch</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead> 
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col -->
	</div>
</section>
<script>
	$(function(){  

		var thisDataTables = $('#datatables').DataTable({ 
			scrollCollapse: true,
			fixedColumns:   {
				leftColumns: 0,
				rightColumns: 1
			},
			"order": [
			[0, "DESC"]
			],
			"orderable" : true,
			"processing": true,
			"serverSide": true,
			"ajax": {
				"data" : {
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
					'masteritem' : '#',
					'detail' : '<?=@urlencode($detail)?>',
					'update' : '<?=@urlencode($edit)?>',
					'delete' : '<?=@urlencode($delete)?>',
					'param' : '<?=@($param)?>'
				},

				"url": "<?php echo @$url?>", 
				"type": "POST", 

				complete: function () {
					$('.ttipDatatables').tooltip();
				},

				dataFilter: function(data){
					var json = jQuery.parseJSON( data );
					json.recordsTotal = json.data.recordsTotal;
					json.recordsFiltered = json.data.recordsFiltered;
					json.data = json.data.data;
        return JSON.stringify( json ); // return JSON string
    }
},
});



	});
</script>

<?php //$this->load->view('master/kegiatan_script'); ?>
