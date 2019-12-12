
<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>
<!-- script type="text/javascript" src="<?php echo base_url('assets/bgslideshow/js/modernizr.custom.86080.js');?>"></script -->
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script>
//Array of images which you want to show: Use path you want.
var images=new Array('<?php echo base_url('assets/bgslideshow/images/1.jpg');?>','<?php echo base_url('assets/bgslideshow/images/2.jpg');?>','<?php echo base_url('assets/bgslideshow/images/3.jpg');?>','<?php echo base_url('assets/bgslideshow/images/4.jpg');?>');
var nextimage=0;
doSlideshow();

function doSlideshow(){
    if(nextimage>=images.length){nextimage=0;}
    $('.global-header')
    .css('background-image','url("'+images[nextimage++]+'")')
    .fadeIn(500,function(){
        setTimeout(doSlideshow,5000);
    });
}
</script>
</body>
</html>
