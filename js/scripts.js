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

	$('#street_lightbox_trigger').on('click', function(){
		const street_lightbox = lity();
		street_lightbox('#street_lightbox');
		init_street_view('gstreet_lightbox');
		return false;
		street_lightbox.opener();
	});
	$('#map_lightbox_trigger').on('click', function(){
		const map_lightbox = lity();
		map_lightbox('#map_lightbox');
		init_map('gmap_lightbox');
		return false;
		map_lightbox.opener();
	});
	*/
	$('#map_lightbox').on('shown.bs.modal', function () {
		init_map('gmap_lightbox');
		//console.log('map');
	});
	$('#street_lightbox').on('shown.bs.modal', function () {
		init_street_view('gstreet_lightbox');
		//console.log('street');
	});

});


var nav = document.querySelector('nav');
//var navHeight = nav.offsetHeight;

window.addEventListener('scroll', function () {
	if (window.pageYOffset > 90) {
		nav.classList.add('fixed-top')
		//nav.classList.remove('navbar-dark')
		//nav.classList.add('bg-light','navbar-light')
	} else {
		nav.classList.remove('fixed-top')
		//nav.classList.remove('bg-light','navbar-light')
		//nav.classList.add('navbar-dark')
	}
});
