<?php
get_header();

//pr(get_post_meta ($post->ID));
//$mapGPS  = get_post_meta ($post->ID, '_prop_map', true );
//$address = get_post_meta ($post->ID, '_prop_address', true);
//$extra   = get_post_meta ($post->ID, '_prop_extra', true);
//$price   = get_post_meta ($post->ID, '_prop_price', true);

//var_dump(get_post_meta($post->ID, '_prop_features'));
//pr(get_service_list());

$data              = get_post_meta($post->ID);


$prop_title        = get_the_title();
$prop_img          = get_the_post_thumbnail_url(null, 'thumbnail');
$prop_address      = $data['_prop_address'][0];
$prop_extra        = $data['_prop_extra'][0];
$prop_feat         = $data['_prop_featured'][0];

$prop_link         = get_the_permalink();
$mapGPS            = get_post_meta($post->ID, '_prop_map', true);

//ahora estan parts/price-block.php
//$prop_sale         = ($data['_prop_price_sale'][0]!= 0) ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
//$prop_rent         = ($data['_prop_price_rent'][0]!= 0) ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
//$prop_currency     = currency()[$data['_prop_currency'][0]];
//$cur_symbol      = $prop_currency ? '$' : 'U$S';

$type              = get_the_terms($post, 'tipo')[0];
$ops               = get_the_terms($post, 'operacion')[0];
$prop_loc          = get_location($post);
$prop_phrase       = phrases()[$data['_prop_phrase'][0]];

$notification_form = get_option('tnb_extra_options')['tnb_options_notification_form'];
$contact_form      = get_option('tnb_extra_options')['tnb_options_contact_form'];

?>
<div class="search-panel">
	<div class="container">
		<?php echo get_search_form(); ?>
	</div>
</div>

<div class="block">
	<div class="container">
	</div>
</div>
<div class="container">
    <?php the_breadcrumb(); ?>
	<div class="columns">
		<div class="column is-three-quarters">
			<?php include('inc/featured-image.php'); ?>

			<?php if (have_posts()) :?>
			<?php /*
            <div class="column is-three-quarters">
            */ ?>
			<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="card block">
					<div class="card-content">
					<div class="media">
					<div class="media-content">
						<h2 class="title is-3">
							<?php if($prop_address): ?>
								<?php echo $prop_address; ?>
								<?php echo $prop_extra ? sprintf('<span class="em"> - %s</span>', $prop_extra) : ''; ?>
							<?php else: ?>
								<?php echo get_the_title(); ?>
							<?php endif; ?>
						</h2>
						<h3 class="subtitle is-4">
							<?php //echo $prop_loc ? ' &mdash; '.$prop_loc : ''; ?>
							<?php echo sprintf('<span class="sub-title">%s</span>', $prop_loc ? $prop_loc : '') ?>
						</h3>
                        <?php
                        //$args = $data;
                        //pase todos los contenidos a un template
                        get_template_part('parts/price','block', $data) ?>
                    </span>
					</div>
                    <div class="media-right">
                        <a class="prop-icon-type" href="<?= isset($type) ? get_term_link($type) : get_bloginfo('home').'/?s='; ?>" title="<?php echo __('Tipo de propiedad') ?>">
                            <span class="material-icons md-36" <?= isset($type) ? $type->name : __('Propiedad', 'tnb'); ?>>business</span>
                            <span>
                                <?= $type->name  ?>
                            </span>
                        </a>
                    </div>
					</div>
                    <div>
                        <nav class="level">
                        <div class="level-left">
                        <?php if(!$prop_sale && !$prop_rent):
                            if($contact_form):
                                echo '<div class="level-item">';
                                echo '<a class="button is-primary modal-button" data-target="#contact_form">Informarme el precio</a>';
                                echo '</div>';
                                //echo '<a class="btn btn-primary" data-lity="" href="#contact_form" style="padding:7px">Informarme el precio</a>';
                            endif;
                        else:
                            if($notification_form):
                                echo '<div class="level-item">';
                                echo '<a class="button is-primary modal-button" data-target="#notificacion">Avisarme si baja el precio</a>';
                                //echo '<a class="btn btn-primary" data-lity="" href="#notificacion" style="padding:7px">Avisarme si baja el precio</a>';
                                echo '</div>';
                            endif;
                        endif;
                        ?>
                        </div>
                        </nav>
                    </div>
					</div>
					</div>

                    <?php
                    // caracteristicas de la propiedad
                    get_template_part('parts/props/prop','features') ?>

					<?php
                    // contenido de la page
                    // lo que se tipee aparece aqui
					$content = get_the_content();
					$content_desktop = apply_filters("the_content", $content);
					?>
					<?php if($content): ?>
                        <div class="card block">
    						<div class="card-header">
								<h3 class="card-header-title">
                                    <?php echo __('Descripción de la propiedad') ?>
                                </h3>
							</div>
							<div class="card-content">
								<div class="entry">
									<?php echo wpautop($content_desktop); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>


					<?php
                        // requisitos
                        // si tiene una page con requisitos, se importa aqui
						if(has_term('alquiler','operacion')):
						$page_link = tnb_post_by_slug('requisitos');
							if($page_link): ?>
							<div class="panel">
								Consulte <a class="underline" href="<?php echo $page_link ?>" target="_blank">aquí</a> los requisitos para alquilar con <b>COFASA</b>
							</div>
							<?php
							endif;
						endif;
					?>

                    <?php
                    // impuestos y gastos adicionales de la propiedad
                    get_template_part('parts/props/prop','taxes') ?>

                    <?php
                    // detalles
                    // descripcion de servicios y detalles de la propieadd
                    get_template_part('parts/props/prop','details') ?>

                    <?php
                    // map
                    // mapa de donde esta ubicada la propiedad
                    get_template_part('parts/props/prop','map') ?>

                    <?php
                    // function necesaria porque se levanta en featured_image y prop-map
                    renderMap($mapGPS['latitude'],$mapGPS['longitude']); ?>

                    <?php /*
					<?php if(isset($mapGPS['latitude']) && isset($mapGPS['longitude']) && !empty($mapGPS['latitude']) && !empty($mapGPS['longitude'])): ?>
					<div class="card block">
						<div class="card-header">
							<h3 class="card-header-title"><?php echo __('Ubicación', 'tnb'); ?></h3>
						</div>
						<div class="card-content">
							<?php renderMap($mapGPS['latitude'],$mapGPS['longitude']); ?>
						</div>
					</div>
					<?php endif; ?>
                    */ ?>
				</div>
			</div>
			<?php if($notification_form): ?>
				<div id="notificacion" class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">
                                Consultar por:
                                <?php the_title(); ?>
                            </p>
                          <button class="delete" aria-label="close"></button>
                      </header>
                      <section class="modal-card-body">
                          <?php echo do_shortcode($notification_form, true); ?>
                      </section>
                    </div>
				</div>
			<?php endif; ?>
			<?php if($contact_form): ?>
				<div id="contact_form" class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">
                                Consultar por:
                                <?php the_title(); ?>
                            </p>
                          <button class="delete" aria-label="close"></button>
                      </header>
                      <section class="modal-card-body">
                          <?php echo do_shortcode($contact_form, true); ?>
                      </section>
                    </div>
				</div>
			<?php endif; ?>
		<?php endwhile;?>
	<?php endif; ?>
		<div class="column is-one-quarter">
            <?php include (TEMPLATEPATH . '/inc/agents.php' ); ?>
			<?php get_sidebar('propiedad'); ?>
		</div>
	</div>
</div>
<div class="section">
    <div class="container">
        <?php include (TEMPLATEPATH . '/inc/related.php' ); ?>
    </div>
</div>
<?php
	//wp_enqueue_script('lity');
	include('inc/photoswipe-gallery.php');
	get_footer();
?>
