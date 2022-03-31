<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php $this->load->view('templates/opoin/partials/_head'); ?>
		<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
		<script type="text/javascript" src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>
		
		
		
		


<style>
#btn-covid {margin: 10px auto;
text-align: center;}
#btn-covid br {display: none;}
.btn-covid19, .btn-corona2, .btn-corona3 {position: relative;display: inline-block;height: 50px;width: 200px;line-height: 50px;padding: 0;border-radius: 50px;background: #fdfdfd;border: 2px solid #FF0066;margin: 10px;transition: .5s}
.btn-corona2 {border: 2px solid #3f51b5;}
.btn-corona3 {border: 2px solid #d83500;}
.btn-covid19:hover {background-color: #FF0066;}
.btn-corona2:hover {background-color: #3f51b5;}
.btn-corona3:hover {background-color: #d83500;}
.btn-covid19:hover span.circle, .btn-corona2:hover span.circle2, .btn-corona3:hover span.circle3 {left: 100%;margin-left: -45px;background-color: #fdfdfd;}
.btn-covid19:hover span.circle{color: #FF0066;}
.btn-corona2:hover span.circle2 {color: #3f51b5;}
.btn-corona3:hover span.circle3 {color: #d83500;}
.btn-covid19:hover span.title, .btn-corona2:hover span.title2, .btn-corona3:hover span.title3 {left: 40px;opacity: 0;}
.btn-covid19:hover span.title-hover, .btn-corona2:hover span.title-hover2, .btn-corona3:hover span.title-hover3 {opacity: 1;left: 40px;}
.btn-covid19 span.circle, .btn-corona2 span.circle2, .btn-corona3 span.circle3 {display: block;background-color: #FF0066;color: #fff;position: absolute;float: left;margin: 5px;line-height: 42px;height: 40px;width: 40px;top: 0;left: 0;transition: .5s;border-radius: 50%;}
.btn-corona2 span.circle2 {background-color: #3f51b5;}
.btn-corona3 span.circle3 {background-color: #d83500;}
.btn-covid19 span.title,.btn-covid19 span.title-hover, .btn-corona2 span.title2,.btn-corona2 span.title-hover2,.btn-corona3 span.title3, .btn-corona3 span.title-hover3 {position: absolute;left: 90px;text-align: center;margin: 0 auto;font-size: 16px;font-weight: bold;color: #FF0066;transition: .5s;}
.btn-corona2 span.title2,.btn-corona2 span.title-hover2 {color: #3f51b5;left: 80px;}
.btn-corona3 span.title3,.btn-corona3 span.title-hover3 {color: #d83500;left: 80px;}
.btn-covid19 span.title-hover, .btn-corona2 span.title-hover2, .btn-corona3 span.title-hover3 {left: 80px;opacity: 0;}
.btn-covid19 span.title-hover, .btn-corona2 span.title-hover2, .btn-corona3 span.title-hover3 {
color: #fff;
}    
</style>		

	</head>

	<body class="pushable">
		
		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('templates/opoin/partials/_mobile_menu'); ?>
		</div>
		
		<div class="ui main container pusher" id="page">
			<div class="ui celled grid main m-0 shadowless">
				<div class="one column row content p-0">
					<div class="column" id="main-section">
						<div id="categories-menu">
						<?php $this->load->view('templates/opoin/partials/_categories_menu'); ?>
						</div>

						<div id="top-menu">
							<?php $this->load->view('templates/opoin/partials/_top_menu'); ?>
						</div>

						<div class="page">
         
							<?= get_ad_units('rectangle') ?>
                            
							<div class="ui raised center aligned segment shadowless">
								<h2><?= ucfirst($page->title) ?></h2>
							</div>

							<div class="ui hidden divider"></div>
							
							<div class="content">
								<?= html_entity_decode($page->body) ?>
							</div>

						</div>

						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	
	
<script type='text/javascript'>
//<![CDATA[
$(document).ready(function(){$.wmBox()}),function(o){o.wmBox=function(){o("body").prepend('<div class="wmBox_overlay"><div class="wmBox_centerWrap"><div class="wmBox_centerer">')},o("[data-popup]").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeIn(750);var a=o(this).attr("data-popup");o(".wmBox_overlay .wmBox_centerer").html('<div class="wmBox_contentWrap"><div class="wmBox_scaleWrap"><div class="wmBox_closeBtn"><p>x</p></div><iframe src="'+a+'">'),o(".wmBox_overlay iframe").click(function(o){o.stopPropagation()}),o(".wmBox_overlay").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeOut(750)})})}(jQuery);
//]]>
</script>	
	

</html>