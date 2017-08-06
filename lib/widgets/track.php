<?php   
add_action('init', 'tracks');   
function tracks()    
{   
  $labels = array(   
    'name' => '[迹]',   
    'singular_name' => '一篇[迹]',   
    'add_new' => '留下[迹]',   
    'add_new_item' => '留下[迹]',   
    'edit_item' => '重述',   
    'new_item' => '崭新的[迹]',   
    'view_item' => '回首[迹]',   
    'search_items' => '搜寻[迹]',   
    'not_found' =>  '找不到[迹]',   
    'not_found_in_trash' => '找不到被遗弃的[迹]',    
    'parent_item_colon' => '',   
    'menu_name' => '[迹]'   
  
  );   
  $args = array(   
    'labels' => $labels,   
    'public' => true,   
    'publicly_queryable' => true,   
    'show_ui' => true,    
    'show_in_menu' => true,    
    'query_var' => true,   
    'rewrite' => true,   
    'capability_type' => 'post',   
    'has_archive' => true,    
    'hierarchical' => false,   
    'menu_position' => null,   
    'supports' => array('title','editor','author')   
  );    
  register_post_type('track',$args);   
}   
?>