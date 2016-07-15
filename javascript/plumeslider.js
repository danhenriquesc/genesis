/**
* jquery.plume-slider.js v1.0.0
* http://www.ararazu.com
*
* Licensed under the MIT license.
* http://www.opensource.org/licenses/mit-license.php
* 
* Copyright 2014, Ararazu
* http://www.ararazu.com
*/

(function( $ ){
	
	$.fn.plumeSlider = function(options) {
		
		// Default Parameters
		var opt = {
			'width':			'full',
			'height':			'full',
			'type':				'fade',
			'interval':			8000,
			'transition':		1000,
			'autoplay':			true,
			'invert':			false
		};
		
		// Settings
		var settings = $.extend( { }, opt, options );

		this.each(function() {

			// Caching
			var plume				= $(this);
			var plSlider			= plume.find('.plume-slider');
			var plSlide				= plSlider.find('.plume-slide');

			var Slider = function(){
				
				this.sldStarted	= 0;
				this.sldInterval= 0;
				this.loading		= $('.loading');
				this.navPrev		= plume.find('.prev');
				this.navNext		= plume.find('.next');
				this.slides			= plume.find('.plume-slide').length;
				this.arrows			= plume.find('.nav-arrow');
				this.allBgImg		= plume.find('.plume-slide .bg-img');
				this.allElems		= plume.find('.plume-slide .animation');
				this.bullets		= plume.find('.plume-bullets a');

				// setting width and height
				this.setWidth		= function(newWidth)	{
					// get width and height
					// document.body.style.overflow = "hidden";
					var viewportWidth = $(window).width();
					// document.body.style.overflow = "";
					if (settings.width === 'full') { settings.slideWidth = viewportWidth; } else { settings.slideWidth = settings.width; }
					plume.css('width', newWidth);
					if (settings.type === 'carousel') {
						plSlider.css('width', (settings.slideWidth*this.slides));
						plSlide.css('width', settings.slideWidth);
					}
				};
				
				this.setHeight	= function(newHeight)	{
					// get width and height
					// document.body.style.overflow = "hidden";
					var viewportHeight = $(window).height();
					// document.body.style.overflow = "";
					if (settings.height === 'full') { settings.slideHeight = viewportHeight; } else { settings.slideHeight = settings.height; }
					plume.css('height', newHeight);
				};
								
				// if carousel mode (adjusting total width of slider)
				if (settings.type === 'carousel') {
					this.allBgImg.css('visibility', 'visible').animate({opacity: 1}, 10);
					plSlider.addClass('carousel');
				}

				// Reset Interval
				this.resetInterval = function() {
					clearInterval( this.sldInterval );
					if (settings.autoplay === true) { this.autoplay(); }
				};

				// Autoplay
				this.autoplay = function() {
					var interval = settings.interval;					
					this.sldInterval = setInterval( function(){
						if (settings.invert === true) { slider.go('prev'); } else { slider.go('next'); }
					}, interval);
				};
				
				// Next Slide
				this.next = function(){
					this.go('next');
				};

				// Previous Slide	
				this.prev = function(){
					this.go('prev');
				};

				// Bullet Slide
				this.goBullet = function(slideNumber){
					this.go(slideNumber);
				};


				// Slideshow Animations
				this.go = function(direction) {
					// Add a input to control the slide number
					if ( this.sldStarted == 0 ) {
						this.sldStarted++;
						$('body').append('<input name="plumeControl" id="plumeControl" type="hidden" value="0" style="visibility:hidden; display: none;" />');
					}

					var pc = $('#plumeControl');
					if ( !(isNaN(direction)) ) {
						var pcval = ( direction );
					} else {
						if (direction=='next' || (!direction) ) {
							var pcval = ( parseInt(pc.val()) + 1);
						} else {
							var pcval = ( parseInt(pc.val()) - 1);
							if (pcval <= 0) { pcval = this.slides; }
						}
						if (pcval > this.slides) { pcval = 1; }
					}

					var cS = $('.plume-slider #slide-'+(pcval)+'');
					var elements = cS.find('.animation').length;
					var toXY, toX, toY, newX, newY, offsetX, offsetY, type, time, delay, cE = '';
					
					// Assigning the object to variable
					var slideColPat	= $('.plume-slider #slide-'+(pcval)+' .over-color, .plume-slider #slide-'+(pcval)+' .over-pattern'); // color / pattern
					var otherSlides	= $('.plume-slider .plume-slide:not(#slide-'+(pcval)+')');
					var otherBgImgs	= $('.plume-slider .plume-slide:not(#slide-'+(pcval)+') .bg-img');
					var otherColPat	= $('.plume-slider .plume-slide:not(#slide-'+(pcval)+') .over-color, .plume-slider .plume-slide:not(#slide-'+(pcval)+') .over-pattern');
					var csBgImg			= cS.find('.bg-img');

					switch(settings.type) {
						case 'fading':
							// hide other slides
							otherSlides.stop().css('visibility', 'hidden').animate({opacity: 0}, 1, function(){
								otherSlides.css('z-index', 2);
								otherBgImgs.css('visibility', 'hidden').animate({opacity: 0}, 1);
								otherColPat.css('visibility', 'hidden');
							});
							cS.stop().css('visibility', 'visible').css('z-index', 3).animate({opacity: 1}, (settings.transition/2), function() {
								// enable all bg images
								cS.find('.bg-img').css('visibility', 'visible').animate({opacity: 1}, (settings.transition/2));
							});
							// hide all elements from previous slide
							this.allElems.stop().css('visibility', 'hidden').animate({opacity: 0}, (settings.transition/2));
							// enable color and pattern again
							slideColPat.stop().css('visibility', 'visible');							
							break;
						
						case 'carousel':
							csBgImg.animate({marginLeft: 0}, settings.transition);
							this.allElems.stop().css('visibility', 'hidden').animate({opacity: 0}, 10);
							slideColPat.stop().css('visibility', 'visible');
							plSlider.stop().animate({marginLeft: "-"+((pcval-1) * settings.slideWidth) }, settings.transition);
							break;
						
						default:
							// alert('no transition');
					}
					pc.val( pcval ); // save the number
					
					// bullets
					this.bullets.removeClass('active');
					$('#bullet-'+pcval).addClass('active');
					
					// Show elements from current slide
					var y = 0;
					while (y < elements) {
						// Current Element = (Current Slide > Element X)
						cE			= cS.find('.elem-'+(y+1)+'');
						toXY		= cE.data('xy');
						var dataSplitXY = toXY.split(',');
						offsetX	= cE.offset().top;
						offsetY	= cE.offset().left;
						toX			= parseInt(dataSplitXY[0].replace(" ",""));
						newX		= toX;
						toY			= parseInt(dataSplitXY[1].replace(" ",""));
						newY		= toY;
						type		= cE.data('type');
						time		= cE.data('time');
						delay		= cE.data('delay') + settings.transition;
						
						// Check element directions
						cE.stop().css('visibility', 'hidden').animate({ opacity: 0 }, (settings.transition/2) );
						if ( cE.hasClass('top') )			{ cE.stop().css('top', toX);		}
						if ( cE.hasClass('bottom') )	{ cE.stop().css('bottom', toX);}
						if ( cE.hasClass('right') )		{ cE.stop().css('right', toY);	}
						if ( cE.hasClass('left') )		{ cE.stop().css('left', toY);	}
						if ( cE.hasClass('hcenter') )	{ cE.stop().css('left', newY);	}
						if ( cE.hasClass('vcenter') )	{ cE.stop().css('top', newX);	}
						if ( cE.hasClass('ccenter') )	{ cE.stop().css('left', newY); cE.stop().css('top', newX);	}
						if ( cE.hasClass('bottom') ) {
							if ( cE.hasClass('right') ) {
								cE.stop().delay(delay).css('visibility', 'visible').animate({ bottom: 0, right: 0, opacity: 1 }, time, type);
							} else {
								cE.stop().delay(delay).css('visibility', 'visible').animate({ bottom: 0, left: 0, opacity: 1 }, time, type);
							}
						} else {
							if ( cE.hasClass('right') ) {
								cE.stop().delay(delay).css('visibility', 'visible').animate({ top: 0, right: 0, opacity: 1 }, time, type);
							} else {
								cE.stop().delay(delay).css('visibility', 'visible').animate({ top: 0, left: 0, opacity: 1 }, time, type);								
							}
						}

						y++; // go to the next element
					}
				};

				// Initialise Slideshow
				this.init = function(direction) {					
					if (settings.invert === true) { this.prev(); } else { this.next(); }
					
					this.setWidth(settings.width);
					this.setHeight(settings.height);
					//this.loading.fadeOut(300); // Removing loading					
				};

			};

			// Init Functions
			var slider = new Slider();
			slider.init();
	
			// Next Button
			slider.navNext.click(function(e){
				e.preventDefault();
				if (settings.invert === true) { slider.prev(); } else { slider.next(); }
				slider.resetInterval();
			});

			// Prev Button
			slider.navPrev.click(function(e){
				e.preventDefault();
				if (settings.invert === true) { slider.next(); } else { slider.prev(); }
				slider.resetInterval();
			});

			// Bullet Buttons
			slider.bullets.click(function(e){
				e.preventDefault();
				var slideNumber = $(this).attr('id').split('bullet-')[1];
				slider.goBullet( slideNumber );
				slider.resetInterval();
			});

			// Autoplay (using opt.interval time)
			if ( settings.autoplay == true ) {
				slider.autoplay();
			}

			// Call one time after resize screen (block multiple calls)
			var waitForFinalEvent = (function () {
				var timers = {};
				return function (callback, ms, uniqueId) {
					if (!uniqueId) {
						uniqueId = "Don't call this twice without a uniqueId";
					}
					if (timers[uniqueId]) {
						clearTimeout (timers[uniqueId]);
					}
					timers[uniqueId] = setTimeout(callback, ms);
				};
			})();

			// On resize
			$(window).resize(function () {
				waitForFinalEvent(function(){
					// get width and height
					var viewportWidth = $(this).parent().width(); 
					var viewportHeight = $(window).height();

					// resizing plume-slider
					if (settings.width === 'full')	{ slider.setWidth( viewportWidth );		}
					if (settings.height === 'full')	{ slider.setHeight( viewportHeight );	}
					
					if (settings.type === 'carousel') { plSlider.stop().animate({marginLeft: "-"+(($('#plumeControl').val()-1) * settings.slideWidth) }, (settings.transition/4)); }
				}, (100), "some unique string");
			});

		});
	
	};
})( jQuery );