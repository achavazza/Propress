<?php
/*
Template Name: Contacto
Template Post Type: page
*/
get_header(); ?>

<div class="grid">
<?php //the_breadcrumb(); ?>
<h2 class="h2 title title-primary"><?php the_title(); ?></h2>
<div class="row">
	<div class="triad-2">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?>id="post-<?php the_ID(); ?>">
			<?php //include (TEMPLATEPATH . '/inc/meta.php' ); ?>
			<div class="entry">
				<?php the_content(); ?>
			</div>
			<?php //wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
			<?php //edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			<div class="panel panel-alt">
				<?php include ('inc/admin/contact-form.php' ); ?>
			</div>
		</div>

		<?php //comments_template(); ?>
		<?php endwhile; endif; ?>
	</div>
	<div class="triad-1" id="sidebar">
		<?php
		//pr($options);
		$options  = get_option('ctheme_options');
		$address  = $options['_site_address'];
		$phone    = $options['_site_phone'];
		$facebook = $options['_site_facebook'];
		$twitter  = $options['_site_twitter'];
		$email    = $options['_site_email'];
		$mapGPS   = $options['_site_map'];

		if(isset($options) && !empty($options)):
			echo '<div class="panel panel-alt">';

			echo '<h3 class="title-alt">Datos de contacto</h3>';
			echo '<dl class="dl-list">';
			if(isset($address) && !empty($address)):
				echo '<dt>Dirección</dt>';
				echo '<dd>'.$address.'</dd>';
			endif;
			if(isset($phone) && !empty($phone)):
				echo '<dt>Teléfono</dt>';
				echo '<dd>'.$phone.'</dd>';
			endif;
			/*
			if(isset($email) && !empty($email)):
				echo '<dt>Email</dt>';
				echo '<dd>'.$email.'</dd>';
			endif;
			*/
			echo '</dl>';


			if(isset($mapGPS) && !empty($mapGPS)){
				renderMap($mapGPS['latitude'],$mapGPS['longitude']);
			}

			echo '</div>';
		endif;
		//$mapGPS  = get_post_meta ($post->ID, '_prop_map', true );
		?>
		<?php //get_sidebar(); ?>
	</div>
</div>
</div>
<?php get_footer(); ?>
