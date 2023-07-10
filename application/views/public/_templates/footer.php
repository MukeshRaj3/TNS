<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var baseUrl = '<?php echo base_url(); ?>';
</script>
<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/tether.min.js"></script>
 <script src="<?php echo base_url($assets_dir); ?>js/jquery-ui.js" ></script>

<script src="<?php echo base_url($assets_dir); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/jquery.easing.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/jquery-waypoints.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/jquery-validate.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/numinate.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/slick.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/price_range_script.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/easyzoom.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/main.js"></script>
<script src="<?php echo base_url($assets_dir); ?>js/product.js"></script>
<!-- Revolution Slider -->
<script src="<?php echo base_url($assets_dir); ?>revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/slider.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="<?php echo base_url($assets_dir); ?>revolution/js/extensions/revolution.extension.video.min.js"></script>
<!-- Javascript end-->
</body>

</html>
<script type="text/javascript">
    $('#search_query_top').autocomplete({
    source:base_url+'welcome/get_auto_product_list', 
    minLength:1,
    width:'900px',
    select: function (event, ui) {
        var p_id = ui.item.id;
        var value = ui.item.value;
         var p_url = ui.item.p_url;
        location.href= p_url;
    }
});


function search_category_product()
{
   var cat=$('#search_category').val();
   location.href= cat;
}    
</script>
<script>

    function IsNumeric(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>