<?php
function renderMap($lat, $lon){
    if(isset($lat) && isset($lon)):
        ?>
        <script type="text/javascript">
        const lat = <?php echo $lat; ?>;
        const lon = <?php echo $lon; ?>;
        console.log(lat);
        console.log(lon);
        </script>
        <?php /*
        <script type="text/javascript" src="<?php echo 'http://maps.google.com/maps/api/js?&key='.GMAPS_KEY ?>"></script>
        */
        //wp_enqueue_script('map');
        wp_enqueue_script('renderMap');
        ?>
        <script type="text/javascript">
        /*
        function init_map(map_div){
        // Options
        var myOptions = {
        zoom:16,
        center:new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>)
    };
    // Setting map using options
    map = new google.maps.Map(document.getElementById(map_div), myOptions);
    // Setting marker to our GPS coordinates
    marker = new google.maps.Marker({map: map,clickable: false,position: new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>)});
}
// Initializes google map
//google.maps.event.addDomListener(window, 'load', init_map);
function init_street_view(map_div) {
var fenway = {lat: <?php echo $lat; ?>, lng: <?php echo $lon; ?>};
var map = new google.maps.Map(document.getElementById(map_div), {
center: fenway,
zoom: 16
});
var panorama = new google.maps.StreetViewPanorama(
document.getElementById(map_div), {
position: fenway,
pov: {
heading: 0,
pitch: 0
}
});
map.setStreetView(panorama);
}

$(function(){
$(window).on('load',function(){
init_map('gmap_canvas');
})
});
*/
</script>
<div id="gmap_canvas" style="width:100%;height:300px;"></div>

<div id="map_lightbox" class="modal map-modal">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo __('Localizacion en el mapa', 'tnb') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="gmap_lightbox" style="width:100%;height:80vh;"></div>
            </div>
        </div>
    </div>
</div>
<div id="street_lightbox" class="modal map-modal">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo __('Google Street View', 'tnb') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="gstreet_lightbox" style="width:100%;height:80vh;"></div>
            </div>
        </div>
    </div>
</div>

<?php /*
migrando a bootstrap
<div id="map_lightbox" class="lity-hide">
<div id="gmap_lightbox" style="width:100%;height:500px;"></div>
</div>
<div id="street_lightbox" class="lity-hide">
<div id="gstreet_lightbox" style="width:100%;height:500px;"></div>
</div>
*/ ?>
<?php
endif;
}
?>
