<footer class="entry-footer"><div class="entry-meta">
	<?php harmonica_post_terms( array( 'taxonomy' => 'category', 'text' => __( '<i class="fa fa-tags" aria-hidden="true"></i> %s', 'harmonica' ) ) ); ?>
	<?php harmonica_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( '<i class="fa fa-archive" aria-hidden="true"></i> %s', 'harmonica' ) ) ); ?>		
</div></footer>