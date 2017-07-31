<?php
echo '<header class="entry-header">';
get_template_part( 'partials/entry', 'title' ); 
if ( 'post' == get_post_type() ) : 
	get_template_part( 'partials/entry', 'byline' ); 
endif; 
if (!is_single()) {
get_template_part( 'partials/entry', 'image' ); 
}
echo '</header><!-- .entry-header -->';
?>	