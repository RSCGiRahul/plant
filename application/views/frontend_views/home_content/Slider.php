<?php
$slider_images = json_decode($v_home_content['slider_images']); 
if($slider_images){
?>
<div class="home-slider-container">
    <div class="home-slider owl-carousel owl-theme owl-theme-light">
		<?php foreach($slider_images as $slider_img){ ?>
        <div class="home-slide">
            <div class="slide-bg owl-lazy" data-src="<?php echo base_url('assets/uploads/').''.$slider_img; ?>"></div>
        </div>
		<?php } ?>
      
    </div>
</div>

<div id="" class="modal fade myModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modeel-dialog-front">
	  <!-- Modal content-->
	 <div class="modal-content" style="background-image: url(assets/frontend/images/sumo-convert.webp);">
		<div class="modal-header">
		  <button type="button" class="close modal_close_btn" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body text-center">
		  <h1>Get 10% OFF</h1>
		  <p>Use the below code on your first purchase.</p>
		  <a class="pre-order-btn" href="#">PLANT</a>
		</div>
	  </div>
  
	</div>
  </div>
  
  <script>
      $(document).ready(function(){       
    $('.myModal').modal('show');
     }); 
  </script>

<?php } ?>