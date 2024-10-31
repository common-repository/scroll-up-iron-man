/**
* The plugin "Iron Man Scroll Up" scripts.
*/


jQuery(function($){
	var $main_up = $('.IR-Scroll-Up'),
		$up_animate = $main_up.find('.sptite-animate'),
		$up_button = $main_up.find('.scroll-button'),
		up_animate = false,
		scroll_animate = false,
		timer = false,
		state = [0, 0, 0, 1],
		length = 149,
		start = 298,
		animate_time = 100,
		animation= false,
		
		scroll = function() {
			if($(this).scrollTop() > 300 || scroll_animate) {
				$main_up.fadeIn();
			} else {
				$main_up.fadeOut();
			}
		},
		
		hover_in = function() {
			$up_animate.stop().fadeTo(500, 1);
		},
		hover_out = function() {
			if (up_animate || scroll_animate) {
				return;
			}
			
			$up_animate.stop().fadeTo(500, 0);
		},
		
		click = function() {
			scroll_animate = true;
			
			animate();
			srollTop();
		},
		
		animate = function() {
			for (i = 0; i < state.length; i++) {
				if (state[i] == 1) {
					state[i] = 0;
					if (!animation) {
						if ((i + 2) < state.length) {
							state[i + 1] = 1;
						} else {
							state[0] = 1;
							animation= true;
						}
					} else {
						if ((i - 1) < 0) {
							state[1] = 1;
						} else {
							state[i - 1] = 1;
							animation= false;
						}
					}
					break
				}
			}
			
			$up_animate.css({
				'background-position': '-' + (start + (i * length)) + 'px 0px',
				display: 'block'
			});
			
			timer = setTimeout(animate, animate_time);
		}
		
		srollTop = function() {
			$('html, body').animate({
				scrollTop: 0
			}, 'slow', function() {
				scroll_animate = false;
				
				if (!up_animate) {
					up_animate = true;
					thisTop = $main_up[0].offsetTop + 250;
					
					$main_up.animate({
						'top': '-=' + thisTop + 'px'
					}, 300, function() {
						$main_up.hide();
						reset();
					})
				}
			});
		},
		
		reset = function() {
			$main_up.css({
				top: 'auto'
			});
			
			$up_animate.css({
				'background-position': '-149px 0px',
				opacity: 0
			});
			
			up_animate = false;
			clearTimeout(timer);
		};

	$(document).ready(scroll);
	$(window).scroll(scroll);
	$up_button.click(click);
	$up_button.hover(hover_in, hover_out);
});