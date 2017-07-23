<footer class="entry-footer"><div class="entry-meta">
	<?php harmonica_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in: %s', 'harmonica' ) ) ); ?>
	<?php harmonica_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged: %s', 'harmonica' ) ) ); ?>		
</div></footer>