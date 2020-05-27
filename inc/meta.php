<div class="meta">
	<em>Posted on:</em> <?php the_time('F jS, Y') ?>
	<em>by</em> <?php the_author() ?>
	<?php the_time(get_option('date_format')) ?>
	<hr />
	Posted in <?php the_category(', ') ?> |
	<?php the_tags('Tags: ', ', ', '<br />'); ?>
	<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
</div>
