$(function(){
	//alert('coso');
	var $slider = $('#slider');
	//var $slider = $('#slides');

	$slider.on('unslider.ready', function(){
		//console.log('pepe');
		var i = 0;
		var t_elem;
		$slider.find('.pane').each(function(){
			$this = $(this);
		    if ( $this.outerHeight() > i ) {
		        t_elem = this;
		        i      = $this.outerHeight();
		    }
		});

		emaxHeight = $(t_elem).outerHeight();
		if(emaxHeight >= 500){
			$slider.css('height', emaxHeight).find('.pane').css('height', emaxHeight);
		}
	});

	$slider.on('mouseenter', function() {
		//console.log('stop');
		$slider.unslider('stop');
	});

	$slider.on('mouseleave', function() {
		//console.log('start');
		$slider.unslider('start');
	});

	$slider.unslider({
		arrows: true,
		autoplay: true,
		//animation: 'horizontal', //need fix
		animation: 'fade', //need fix
		animateHeight: true,
		delay: 5000,
		speed: 2000,
		arrows: {
			prev: '<a class="unslider-arrow prev"><i class="icon-prev"></i></a>',
			next: '<a class="unslider-arrow next"><i class="icon-next"></i></a>'
		}
	});
});
