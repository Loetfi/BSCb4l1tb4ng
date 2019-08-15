<script>
$(function(){
	$('#MenuUnitKerja').addClass('active').addClass('menu-open');
	$('#MenuUnitKerja-<?php echo strtoupper($satKer); ?>').addClass('active').addClass('menu-open');

$('#tahun').change(function(){
	val = $(this).val();
	// alert(val);
	window.location.href="<?php echo site_url('dashboard/form_c/'.$satKer); ?>/"+val;
});

var nTableKontrak = $('#nTableKontrak').dataTable();
var nTableRealisasi = $('#nTableRealisasi').dataTable();
var nTableInvoice = $('#nTableInvoice').dataTable();

$('.btnTerkontrak').click(function(e){
	thisKp3 = $(this).attr('this_kp3');
	thisKey = $(this).attr('this_key');
	thisYear = $(this).attr('this_year');
	$.ajax({
		method: 'POST',
		type: 'json',
		url: '<?php echo site_url('api/dashboard/detailTerkontrak'); ?>', 
		data: {
			thisKey: thisKey, 
			thisYear : thisYear, 
			thisSatker : '<?php echo $satKer; ?>', 
		},
		beforeSend: function( ) {
		},
		success: function(thisData) {
			console.log(thisData.data.length);
			nTableKontrak.fnClearTable(); 
			for(i = 0; i < thisData.data.length; i++){
				row = thisData.data[i];
				nTableKontrak.fnAddData([ 
					(i+1),
					row.judul,
					row.noKontrak,
					row.pelanggan,
					row.nilaiKontrak
				]);
			}
			$('#totalKontrak').html(thisData.total);
		},
		error: function() {
			alert('Ada opsi yang belum terpilih atau refresh halaman, dan coba lagi.');
		},
		complete: function(){
			$('.modal-title').text(thisKp3);
			$('#modal-default-terkontrak').modal('show');
		}
	});
	e.preventDefault();
});

$('.btnRealisasi').click(function(e){
	thisKp3 = $(this).attr('this_kp3');
	thisKey = $(this).attr('this_key');
	thisYear = $(this).attr('this_year');
	$.ajax({
		method: 'POST',
		type: 'json',
		url: '<?php echo site_url('api/dashboard/detailRealisasi'); ?>', 
		data: {
			thisKey: thisKey, 
			thisYear : thisYear, 
			thisSatker : '<?php echo $satKer; ?>', 
		},
		beforeSend: function( ) {
		},
		success: function(thisData) {
			console.log(thisData.data.length);
			nTableRealisasi.fnClearTable(); 
			for(i = 0; i < thisData.data.length; i++){
				row = thisData.data[i];
				nTableRealisasi.fnAddData([ 
					(i+1),
					row.judul,
					row.noKontrak,
					row.pelanggan,
					row.nilaiRealisasi
				]);
			} 
			$('#totalRealisasi').html(thisData.total);
		},
		error: function() {
			alert('Ada opsi yang belum terpilih atau refresh halaman, dan coba lagi.');
		},
		complete: function(){
			$('.modal-title').text(thisKp3);
			$('#modal-default-realisasi').modal('show');
		}
	});
	e.preventDefault();
});

$('.btnInvoice').click(function(e){
	thisKp3 = $(this).attr('this_kp3');
	thisKey = $(this).attr('this_key');
	thisYear = $(this).attr('this_year');
	$.ajax({
		method: 'POST',
		type: 'json',
		url: '<?php echo site_url('api/dashboard/detailInvoice'); ?>', 
		data: {
			thisKey: thisKey, 
			thisYear : thisYear, 
			thisSatker : '<?php echo $satKer; ?>', 
		},
		beforeSend: function( ) {
		},
		success: function(thisData) {
			console.log(thisData.data.length);
			nTableInvoice.fnClearTable(); 
			for(i = 0; i < thisData.data.length; i++){
				row = thisData.data[i];
				nTableInvoice.fnAddData([ 
					(i+1),
					row.judul,
					row.noKontrak,
					row.pelanggan,
					row.nilaiInvoice
				]);
			} 
			$('#totalInv').html(thisData.total);
		},
		error: function() {
			alert('Ada opsi yang belum terpilih atau refresh halaman, dan coba lagi.');
		},
		complete: function(){
			$('.modal-title').text(thisKp3);
			$('#modal-default-invoice').modal('show');
		}
	});
	e.preventDefault();
});

});
</script>
