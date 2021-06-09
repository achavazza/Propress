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

$notification_form = get_option('tnb_extra_options')['tnb_options_notification_form'];
$contact_form      = get_option('tnb_extra_options')['tnb_options_contact_form'];

$prop_title        = get_the_title();
$prop_img          = get_the_post_thumbnail_url(null, 'thumbnail');
$prop_address      = $data['_prop_address'][0];
$prop_sale         = ($data['_prop_price_sale'][0]!= 0) ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
$prop_rent         = ($data['_prop_price_rent'][0]!= 0) ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
$prop_link         = get_the_permalink();
$prop_extra        = $data['_prop_extra'][0];

$mapGPS            = get_post_meta($post->ID, '_prop_map', true);

$prop_rooms        = $data['_prop_rooms'][0];
$prop_sup          = $data['_prop_sup'][0];
$prop_dormrooms    = $data['_prop_dormrooms'][0];
$prop_bathrooms    = $data['_prop_bathrooms'][0];
//$prop_garage     = $data['_prop_garage'][0];
//$prop_time       = $data['_prop_time'][0];

$prop_feat         = $data['_prop_featured'][0];
$prop_phrase       = phrases()[$data['_prop_phrase'][0]];
$prop_currency     = currency()[$data['_prop_currency'][0]];
//$cur_symbol      = $prop_currency ? '$' : 'U$S';

$prop_loc          = get_location($post);
$type              = get_the_terms($post, 'tipo')[0];
$operation         = get_the_terms($post, 'operacion')[0];


?>
<div class="section section-primary bg-dark">
	<div class="container">
		<?php echo get_search_form(); ?>
	</div>
</div>

<div class="section">
	<div class="container">
		<?php include('inc/featured-image.php'); ?>
	</div>
</div>
<div class="container">
	<div class="row">
		<?php //the_breadcrumb(); ?>
		<?php if (have_posts()) :?>

			<div class="col-md-8">
			<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<div class="clearfix mb-1">
						<h2 class="h2 prop-title float-left">
							<?php if($prop_address): ?>
								<?php echo $prop_address; ?>
								<?php echo $prop_extra ? sprintf('<span class="em"> - %s</span>', $prop_extra) : ''; ?>
							<?php else: ?>
								<?php echo get_the_title(); ?>
							<?php endif; ?>
						</h2>
						<h3 class="h3 float-right">
							<?php //echo $prop_loc ? ' &mdash; '.$prop_loc : ''; ?>
							<?php echo sprintf('<span class="sub-title">%s</span>', $prop_loc ? $prop_loc : '') ?>
						</h3>
					</div>
					<span class="price">
						<?php if(!$prop_sale && !$prop_rent):
								echo sprintf('<strong>Precio: %s</strong>', __('Consultar'));
								if($contact_form):
									echo '&nbsp;';
									echo '&nbsp;';
									echo '<span class="base-font-size">';
									echo '<a class="btn btn-primary" data-lity="" href="#contact_form" style="padding:7px">Informarme el precio</a>';
									echo '</span>';
								endif;
							else:
								if($prop_rent):
									$val = $prop_currency.' '.$prop_rent;
									echo sprintf('<span class="price rent-price" title="Precio de alquiler">%s</span>', $val);
									//<strong>Alquiler: </strong>
									//<?php echo '$'.$prop_rent
								endif;
								if($prop_sale && $prop_rent):
									echo ' | ';
								endif;
								if($prop_sale):
									$val = $prop_currency.' '.$prop_sale;
									echo sprintf('<span class="price sale-price" title="Precio de venta">%s</span>', $val);
									//<strong>Venta: </strong>
									//<?php echo $cur_symbol.' '.$prop_sale
								endif;

								if($notification_form):
									echo '&nbsp;';
									echo '&nbsp;';
									echo '<span class="base-font-size">';
									echo '<a class="btn btn-primary" data-lity="" href="#notificacion" style="padding:7px">Avisarme si baja el precio</a>';
									echo '</span>';
								endif;
							endif;
							?>

					</span>

					<hr />
					<ul class="prop-list prop-list-left">
			            <li>
			                <?php if(!$type):?>
			                <a href="<?php echo get_bloginfo('home').'/?s=' ?>" title="<?php echo __('Tipo de propiedad') ?>">
			                    <span class="block align-center">
			                        <i class="icon cofasa-linear icon-l icon-property"></i>
			                    </span>
			                    &nbsp;
			                    <?php echo 'Propiedad' ?>
			                </a>
			                <?php else: ?>
			                <a href="<?php echo get_term_link($type); ?>" title="<?php echo __('Tipo de propiedad') ?>">
			                    <span class="block align-center">
									<i class="icon cofasa-img-icons icon-l icon-property"></i>
			                    </span>
			                    &nbsp;
			                    <?php echo $type->name; ?>
			                </a>
			                <?php endif; ?>
			            </li>
						<?php if($prop_dormrooms): ?>
			            <li>
			                <span title="<?php echo __('Dormitorios') ?>">
			                    <span class="block align-center">
									<i class="icon cofasa-img-icons icon-l icon-bed"></i>
			                    </span>
			                    &nbsp;

			                    <?php
			                        if(!$prop_dormrooms):
			                            $prop_dormrooms = 0;
			                        endif;
			                        $dorms = intval($prop_dormrooms);
			                        echo sprintf(ngettext("%d Dormitorio", "%d Dormitorios", $dorms), $dorms);
			                    ?>
			                </span>
			            </li>
						<?php endif; ?>
						<?php if($prop_bathrooms): ?>
			            <li>
			                <span title="<?php echo __('Baños') ?>">
			                    <span class="block align-center">
									<i class="icon cofasa-img-icons icon-l icon-bath"></i>
			                        <!-- <i class="icon cofasa-linear icon-l icon-bath"></i> -->
			                    </span>
			                    &nbsp;
			                    <?php
			                        //if(!$prop_bathrooms):
			                        //    $prop_bathrooms = 0;
			                        //endif;
			                        $baths = intval($prop_bathrooms);
			                        echo sprintf(ngettext("%d Baño", "%d Baños", $baths), $baths);
			                    ?>
			                </span>
			            </li>
						<?php endif; ?>
			        </ul>
					<hr />


					<?php
					$content = get_the_content();
					$content_desktop = apply_filters("the_content", $content);
					?>
					<?php if($content): ?>
						<div class="card">
							<div class="card-title">
								<h3 class="h5 my-3"><?php echo __('Descripción de la propiedad') ?></h3>
							</div>
							<div class="card-body">
								<div class="entry">
									<?php echo wpautop($content_desktop); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>


					<?php
						if(has_term('alquiler','operacion')):
						$page_link = tnb_post_by_slug('requisitos');
							if($page_link):
							?>
							<div class="panel panel-primary uppercase bold">
								Consulte <a class="underline" href="<?php echo $page_link ?>" target="_blank">aquí</a> los requisitos para alquilar con <b>COFASA</b>
							</div>
							<?php
							endif;
						endif;
					?>

					<?php
					$tax_title       = get_post_meta($post->ID, '_prop_tax_title', true);
					$tax_desc        = get_post_meta($post->ID, '_prop_tax_desc', true);
					if($tax_desc): ?>
					<div class="panel">
						<div class="panel-head panel-primary">
							<?php if($tax_title && $tax_title != '0,00'): ?>
								<h3 class="h5 my-3"><?php echo sprintf(__('$ %s Gastos iniciales'), $tax_title); ?></h3>
							<?php else: ?>
								<h3 class="h5 my-3"><?php echo __('Gastos iniciales') ?></h3>
							<?php endif; ?>
						</div>
						<div class="panel-content">
							<?php echo wpautop($tax_desc, true); ?>
						</div>
					</div>
					<?php endif; ?>

					<?php
					$tax_month_title       = get_post_meta($post->ID, '_prop_tax_month_title', true);
					$tax_month_desc        = get_post_meta($post->ID, '_prop_tax_month_desc', true);
					if($tax_month_desc): ?>
					<div class="panel">
						<div class="panel-head panel-primary">
							<?php if($tax_month_title && $tax_month_title != '0,00'): ?>
								<h3 class="h5 my-3"><?php echo sprintf(__('$ %s Gastos mensuales'), $tax_month_title); ?></h3>
							<?php else: ?>
								<h3 class="h5 my-3"><?php echo __('Gastos mensuales') ?></h3>
							<?php endif; ?>
						</div>
						<div class="panel-content">
							<?php echo wpautop($tax_month_desc, true); ?>
						</div>
					</div>
					<?php endif; ?>

					<?php
					//$rent_values       = get_post_meta($post->ID, '_prop_rent', true);
					//$rent_values_desc  = $data['_prop_rent_desc'][0];

					//pr($data);
					//pr($rent_values);

					$rent_values       = get_post_meta($post->ID, '_prop_rent', true);
					//$rent_values_desc  = get_post_meta($post->ID, '_prop_rent_desc', true);

					//pr(array_key_exists('value', $rent_values[0]));
					//pr($rent_values);
					if($rent_values && array_key_exists('value', $rent_values[0])):
					?>
					<div class="panel">
						<div class="panel-head">
							<h3 class="h5 my-3"><?php echo __('Importe') ?></h3>
						</div>
						<div class="panel-content">
							<?php /*
							<?php if($rent_values_desc): ?>
								<?php echo wpautop($rent_values_desc) ?>
							<?php endif; ?>
							*/ ?>
							<ul class="">
								<?php
								foreach($rent_values as $value):
									echo sprintf('<li>%s: $ %d</li>', $value['concept'], $value['value']);
								endforeach;
								?>
							</ul>
						</div>
					</div>
					<?php endif; ?>

					<div class="card mb-3">
						<div class="card-header">
							<h3 class="h5 my-3"><?php echo __('Detalles', 'tnb'); ?></h3>
						</div>
						<div class="card-body">
							<?php
								$stat             = status();
								$prop_statuses    = get_post_meta($post->ID, '_prop_status', true);

								$services         = services();
								$prop_services    = get_post_meta($post->ID, '_prop_services', true);

								$front            = front();
								$prop_front       = get_post_meta($post->ID, '_prop_front', true);

								$orientation      = orientation();
								$prop_orientation = get_post_meta($post->ID, '_prop_orientation', true);

								//$prop_features    = get_service_list();
								$features = get_the_terms($post, 'features');
							?>
							<ul class="list-unstyled feature-list">
								<?php /*
								AMBIENTES
								<?php if($prop_rooms): ?>
									<li>
										<?php echo sprintf(__('Ambientes: %s'), $prop_rooms) ?>
									</li>
								<?php endif; ?>
								*/ ?>
								<?php if($prop_sup): ?>
									<li>
										<?php
										$prop_sup_val = $prop_sup. ' m<sup>2</sup>';
										echo '<i class="cofasa-img-icons icon-star"></i>';
										echo sprintf(__('Superficie: %s'), $prop_sup_val) ?>
									</li>
								<?php endif; ?>
								<?php if($prop_dormrooms): ?>
									<li>
										<?php
										echo '<i class="cofasa-img-icons icon-star"></i>';
										echo sprintf(__('Dormitorios: %s'), $prop_dormrooms) ?>
									</li>
								<?php endif; ?>
								<?php if($prop_bathrooms): ?>
									<li>
										<?php
										echo '<i class="cofasa-img-icons icon-star"></i>';
										echo sprintf(__('Baños: %s'), $prop_bathrooms)
										?>
									</li>
								<?php endif; ?>
								<?php

									if($features){
										$i = 0;
										foreach($features as $feature){
											if($feature){
												echo '<li>';
												echo '<i class="cofasa-img-icons icon-star"></i>';
												echo $feature->name.': ' . __('Si');
												echo '</li>';
												$i++;
											}
										}
									}
								?>
								<?php if($prop_front): ?>
									<li>
										<?php
											$val_front = isset( $front[ $prop_front ] ) ? $front[ $prop_front ] : ' ';
											echo '<i class="cofasa-img-icons icon-star"></i>';
											echo sprintf(__('Ubicación: %s'), $val_front);
										?>
									</li>
								<?php endif; ?>
								<?php if($prop_orientation): ?>
									<li>
										<?php
											$val_orientation = isset( $orientation[ $prop_orientation ] ) ? $orientation[ $prop_orientation ] : ' ';
											echo '<i class="cofasa-img-icons icon-star"></i>';
											echo sprintf(__('Orientación: %s'), $val_orientation);
										?>
									</li>
								<?php endif; ?>
								<?php
									if($prop_services){
										$i = 0;
										foreach($services as $k => $service){
											if($service){
												echo '<li>';
												echo '<i class="cofasa-img-icons icon-star"></i>';
												echo $service;
												echo ': ';
												echo in_array($k, $prop_services) ? __('Si') : __('No');
												echo '</li>';
												$i++;
											}
										}
									}
								?>
							</ul>
						</div>
					</div>
					<?php if(isset($mapGPS['latitude']) && isset($mapGPS['longitude']) && !empty($mapGPS['latitude']) && !empty($mapGPS['longitude'])): ?>
					<div class="card mb-3">
						<div class="card-header">
							<h3 class="h5 my-3"><?php echo __('Ubicación', 'tnb'); ?></h3>
						</div>
						<div class="card-body">
							<?php renderMap($mapGPS['latitude'],$mapGPS['longitude']); ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<?php include (TEMPLATEPATH . '/inc/agents.php' ); ?>
				<?php include (TEMPLATEPATH . '/inc/related.php' ); ?>

			</div>
			<?php if($notification_form): ?>
				<div id="notificacion" class="lity-hide email-form">
					<h3 class="meta">Consultar por:</h4>
					<h4 class="title-alt"><?php the_title(); ?></h4>
						<?php echo do_shortcode($notification_form, true); ?>
				</div>
			<?php endif; ?>
			<?php if($contact_form): ?>
				<div id="contact_form" class="lity-hide email-form">
					<h3 class="meta">Consultar por:</h4>
					<h4 class="title-alt"><?php the_title(); ?></h4>
						<?php echo do_shortcode($contact_form, true); ?>
				</div>
			<?php endif; ?>
		<?php endwhile;?>
	<?php endif; ?>
	<div class="col-md-4">
		<?php get_sidebar('propiedad'); ?>
	</div>
	</div>
</div>
<?php
	//wp_enqueue_script('lity');
	include('inc/photoswipe-gallery.php');
	get_footer();
?>
