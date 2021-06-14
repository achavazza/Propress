<?php
$mapGPS = get_post_meta($post->ID, '_prop_map', true);
?>
<?php if(isset($mapGPS['latitude']) && isset($mapGPS['longitude']) && !empty($mapGPS['latitude']) && !empty($mapGPS['longitude'])): ?>
<div class="card block">
    <div class="card-header">
        <h3 class="card-header-title"><?php echo __('Ubicación', 'tnb'); ?></h3>
    </div>
    <div class="card-content">
        <div id="gmap_canvas" style="width:100%;height:300px;"></div>
    </div>
</div>
<?php endif; ?>
