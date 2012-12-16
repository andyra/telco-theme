<?php

// Remove unsued dashboard widgets
function telco_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset( $wp_meta_boxes[get_current_screen()->id]['normal']['core']['authordiv'] );
}
add_action('wp_dashboard_setup', 'telco_dashboard_widgets');

// Remove unused page/post meta boxes
function remove_meta_boxes() {
  // posts
  remove_meta_box('authordiv','post','normal');         // Author
  remove_meta_box('postcustom','post','normal');        // Custom Fields
  remove_meta_box('postexcerpt','post','normal');       // Excerpt
  remove_meta_box('slugdiv','post','normal');           // Slug
  remove_meta_box('tagsdiv-post_tag','post','normal');  // Tags
  remove_meta_box('trackbacksdiv','post','normal');     // Trackbacks
  // pages
  remove_meta_box('authordiv','page','normal');         // Author
  remove_meta_box('commentsdiv','page','normal');       // Comments
  remove_meta_box('postcustom','page','normal');        // Custom Fields
  remove_meta_box('commentstatusdiv','page','normal');  // Discussion
  remove_meta_box('slugdiv','page','normal');           // Slug
  remove_meta_box('trackbacksdiv','page','normal');     // Trackbacks
}
add_action('admin_init','remove_meta_boxes');

// Hide unused posts types from the admin menu
function telco_remove_menus() {
  remove_menu_page('link-manager.php'); // Links
  remove_menu_page('edit-comments.php'); // Comments
  remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
}
add_action( 'admin_menu', 'telco_remove_menus' );

// Remove unused post types in the admin bar
function telco_remove_admin_bar_items() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('new-page');
  $wp_admin_bar->remove_menu('new-media');
  $wp_admin_bar->remove_menu('new-link');
  $wp_admin_bar->remove_menu('new-user');
}
add_action( 'wp_before_admin_bar_render', 'telco_remove_admin_bar_items' );
