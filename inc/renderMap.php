<?php
function renderMap($lat, $lon){
    if(isset($lat) && isset($lon)):
        ?>
        <script type="text/javascript">
            const lat = <?php echo $lat; ?>;
            const lon = <?php echo $lon; ?>;
            //console.log(lat);
            //console.log(lon);
        </script>
        <?php wp_enqueue_script('renderMap'); ?>

        <?php /*
        <div id="gmap_canvas" style="width:100%;height:300px;"></div>
        */ ?>

        <div id="modal-lightbox" class="modal main-modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title"><?php echo __('Localizacion en el mapa', 'tnb') ?></p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div id="gmap_lightbox" style="width:100%;height:80vh;"></div>
            </section>
          </div>
        </div>

        <div id="modal-streetview" class="modal main-modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title"><?php echo __('Google Street View', 'tnb') ?></p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div id="gstreet_lightbox" style="width:100%;height:80vh;"></div>
            </section>
          </div>
        </div>

    <?php endif; ?>
<?php } ?>
