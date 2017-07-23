<?php
if ( have_posts() ) : 		

	do_action( 'harmonica_before_loop');	

	/* Start the Loop */ 
	while ( have_posts() ) : the_post(); 
	?>
		<article <?php harmonica_attr( 'post' ); ?>><div class="entry-wrap">
			<?php 
			do_action( 'harmonica_before_entry' ); 
			do_action( 'harmonica_entry' );
			do_action( 'harmonica_after_entry' ); 
			?>
		</div></article>				
	<?php
	endwhile; 
	
	do_action( 'harmonica_after_loop');			

else : 
		get_template_part( 'partials/no-results', 'archive' ); 
endif;	
?>