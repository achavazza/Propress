$(function(){

		//your scripts
		//alert('jquery');
		$('body').on('click','.menu-trigger', function(){
		//	console.log($('#menu-header'));
			$('#menu-principal').toggleClass('visible-md');
			$(this).closest('.menu-mobile').toggleClass('menu-open');
			$(this).toggleClass('trigger-open');
			return false;
		});

		/*
		$('body').on('click','.resetButton', function(){
			var sform = $('#searchform');
			sform.find('input, select').each(function(){
				if($(this).attr('type') != 'hidden'){
					$(this).val('');
				}
				setTimeout(function(){
					sform.submit();
				}, 500);
			});
		});*/
		// setTimeout(function(){
		// var $allVideos = $('.entry').find("iframe[src*='//www.youtube.com']");
		// $allVideos.each(function() {
		//     $(this)
		//     // and remove the hard coded width/height
		//     .removeAttr('height')
		//     .removeAttr('width')
		//     .wrap('<div class="youtube-wrap" />');
		// });
		// }, 2000);

		$('#street_lightbox_trigger').on('click', function(){

			var street_lightbox = lity();
			street_lightbox('#street_lightbox');
			init_street_view('gstreet_lightbox');
			return false;
			street_lightbox.opener();

		});
		$('#map_lightbox_trigger').on('click', function(){

			var map_lightbox = lity();
			map_lightbox('#map_lightbox');
			init_map('gmap_lightbox');
			return false;
			map_lightbox.opener();

		});




	// Applies to all select boxes that have no value for their first option
	/*$("select:has(option[value=]:first-child)").on('change', function() {
	    $(this).toggleClass("empty", $.inArray($(this).val(), ['', null]) >= 0);
	}).trigger('change');*/


});
//alert('pepe');
