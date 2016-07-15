<?php 
	header('Content-Type: text/javascript'); 
	require('../../../config.php');
?>

<?php 
	if(get_config('theme_genesis', 'slidermode') == 'slideshow'){ 
		$sliderPlugin = get_config('theme_genesis', 'sliderplugin');

		if($sliderPlugin == 'content'){
?>

			$(function() {
			    $('#slider1').cslider({
			            autoplay	: true,
			            interval	: <?php echo get_config('theme_genesis', 'sliderspeed'); ?>
			    });
			});


<?php 	}else if($sliderPlugin == 'plume'){ ?>

			var sldshow = $('#slideshow');
			sldshow.css('height', '<?php echo get_config('theme_genesis', 'sliderheight'); ?>');

			$( window ).load(function() {
				// Initialise Slideshow ( function .plumeSlider() )
				// ----------------------------------------------------
				sldshow.plumeSlider({
					// options
					'width':			'full',				// full or customized width (only number - in pixels)
					'height':			'<?php echo get_config('theme_genesis', 'sliderheight'); ?>',				// full or customized height (only number - in pixels)
					'type':				'fading',			// fading or carousel
					'interval':			 <?php echo get_config('theme_genesis', 'sliderspeed'); ?>,					// the time that each slide remains on the screen
					'transition':		 1000,					// the time of slide transitions
					'autoplay':			 true,					// automatic slide transitions (after 'interval', go to the next)
					'invert':			 false					// show the last slide as the first
				});
				// ----------------------------------------------------
			});

<?php   }
	} 
?>