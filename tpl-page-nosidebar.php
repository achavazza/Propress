<?php
/*
Template Name: No sidebar
Template Post Type: post, page, propiedad
*/
get_header(); ?>
<?php include('inc/slider.php'); ?>
<div class="grid">
	<?php //the_breadcrumb(); ?>
	<h2 class="h2 title title-primary"><?php the_title(); ?></h2>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="entry">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
