<?php
wp_enqueue_script('slider');

$slider = get_option('slider_options');
$slider_metabox = $slider['slider_option_metabox'];

if(!empty($slider_metabox)): ?>
	<div id="slides">
	<ul>
	<?php
	foreach($slider_metabox as $slide):
		//pr($slide);
		$img_id  = $slide['_slides_image_id'];
		$img     = $slide['_slides_imaged'];
		$text    = $slide['_slides_text'];
		$text1   = $slide['_slides_text1'];
		$text2   = $slide['_slides_text2'];
		//$tax_id  = $slide['_slides_taxonomy_select'];
		$meta_id = $slide['_slides_related_post'];

		pr($tax_id);
		$thumbnail = wp_get_attachment_image_src($img_id, 'slide');
		?>
		<li class="slide">
			<div class="pane" style="<?php echo 'background-image: url(' . $thumbnail[0] . ')' ?>" >
				<?php if(isset($text) && !empty($text)): ?>
					<span class="lead"><?php echo $text ?></span>
				<?php endif; ?>
				<h2 class="main-text">
					<?php if(isset($text1) && !empty($text1)): ?>
						<div class="first-line"><?php echo $text1 ?></div>
					<?php endif; ?>
					<?php if(isset($text2) && !empty($text2)): ?>
						<div class="second-line"><?php echo $text2 ?></div>
					<?php endif; ?>
				</h2>
				<?php if(isset($meta_id) && !empty($meta_id)): ?>
					<a class="btn btn-accent" href="<?php echo get_permalink( $meta_id ) ?>"><?php echo __('Ver más') ?></a>
				<?php endif; ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
	</div>
<?php endif; ?>
