<?php 

class harmonica_sidebar_links extends WP_Widget {

	function __construct() {
        $widget_ops = array( 'classname' => 'widget_harmonica_sidebar_links', 'description' => __('Displays your links by using the Link page.', 'harmonica') );
        parent::__construct( 'widget_harmonica_sidebar_links', __('Sidebar Links','harmonica'), $widget_ops );
    }
	
	function widget($args, $cnstance) {
	
		// Outputs the content of the widget
		extract($args); // Make before_widget, etc available.
		
		$widget_title = null; 
		
		$widget_title = esc_attr(apply_filters(__( 'widget_title'), $cnstance[__('widget_title')]));
		
		echo $before_widget;
		
		if (!empty($widget_title)) {
			echo $before_title . $widget_title . $after_title;
		}
		else {
			echo $before_title . __('Links') . $after_title;
		}
			?>
			<div class="harmonica-links">
				<?php 
					$page_id = get_page_id(links);
					$page_data = get_page($page_id);
					$content = apply_filters('the_content', $page_data->post_content);					
			        preg_match_all("/\[\+(.*)\+\]/", $content, $name);
					preg_match_all("/\{\+(.*)\+\}/", $content, $link);
				    $o = 0;
					$n1 = count($name[0]);
					for ($i = 0; $i < $n1; $i++) {
						$sidebar_links = $sidebar_links . '<a href="' . $link[1][$i] . '" target="_blank" class="sidebar-links sidebar-link-' . ++$o . ' sidebar-link-position-' . $o . '">' . $name[1][$i] . '</a>';
					};
					echo $sidebar_links;
				?>
			</div>
					
		<?php echo $after_widget; 
	}
	
	
	function update($new_instance, $old_instance) {
		$cnstance = $old_instance;
		
		$cnstance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		//update and save the widget
		return $cnstance;
		
	}
	
	function form($cnstance) {
		
		// Set defaults
		if(!isset($cnstance["widget_title"])) { $cnstance["widget_title"] = ''; }
	
		// Get the options into variables, escaping html characters on the way
		$widget_title = esc_attr($cnstance['widget_title']);
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('widget_title')); ?>"><?php  _e('Title', 'harmonica'); ?>:
			<input id="<?php echo esc_attr($this->get_field_id('widget_title')); ?>" name="<?php echo esc_attr($this->get_field_name('widget_title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($widget_title); ?>" /></label>
		</p>
						
		<?php
	}
}
register_widget('harmonica_sidebar_links'); ?>