<?php /*

<div class="navigation">
	<div class="next-posts"><?php next_posts_link('&laquo; Anterior') ?></div>
	<div class="prev-posts"><?php previous_posts_link('Siguiente &raquo;') ?></div>
</div>
*/ ?>

<nav class="pagination" role="navigation" aria-label="pagination">
<?php echo pagenavi(); ?>
</nav>
