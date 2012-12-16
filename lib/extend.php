<?php

/* Register custom post types
-------------------------------------------------- */

// Track
function telco_track_init() {
  $labels = array(
    'name' => _x('Track Index', 'post type general name'),
    'singular_name' => _x('Track', 'post type singular name'),
    'add_new' => _x('Add New', 'track'),
    'all_items' => __('All Tracks'),
    'add_new_item' => __('Add New Track'),
    'edit_item' => __('Edit Track'),
    'new_item' => __('New Track'),
    'view_item' => __('View Track'),
    'search_items' => __('Search Tracks'),
    'not_found' =>  __('No tracks found'),
    'not_found_in_trash' => __('No tracks found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Tracks'
  );
  $supports = array(
    'title',
    'editor',
    'author'
  );
  $args = array(
    'labels' => $labels,
    'description' => 'Single audio tracks to be used in collections',
    'public' => true,
    'menu_position' => 5,
    'rewrite' => array('slug' => 'tracks'),
    'supports' => $supports,
    'has_archive' => true
  );
  register_post_type('track',$args);
}
add_action('init', 'telco_track_init');

// Collection
function telco_collection_init() {
  $labels = array(
    'name' => _x('Collection Registry', 'post type general name'),
    'singular_name' => _x('Collection', 'post type singular name'),
    'add_new' => _x('Add New', 'collection'),
    'all_items' => __('All Collections'),
    'add_new_item' => __('Add New Collection'),
    'edit_item' => __('Edit Collection'),
    'new_item' => __('New Collection'),
    'view_item' => __('View Collection'),
    'search_items' => __('Search Collections'),
    'not_found' =>  __('No collections found'),
    'not_found_in_trash' => __('No collections found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Collections'
  );
  $supports = array(
    'title',
    'editor',
    'author'
  );
  $args = array(
    'labels' => $labels,
    'description' => 'A collection of shorter tracks',
    'public' => true,
    'menu_position' => 5,
    'rewrite' => array('slug' => 'collections'),
    'supports' => $supports,
    'has_archive' => true
  );
  register_post_type('collection',$args);
}
add_action('init', 'telco_collection_init');

// Movie
function telco_movie_init() {
  $labels = array(
    'name' => _x('Movie Store', 'post type general name'),
    'singular_name' => _x('Movie', 'post type singular name'),
    'add_new' => _x('Add New', 'movie'),
    'all_items' => __('All Movies'),
    'add_new_item' => __('Add New Movie'),
    'edit_item' => __('Edit Movie'),
    'new_item' => __('New Movie'),
    'view_item' => __('View Movie'),
    'search_items' => __('Search Movies'),
    'not_found' =>  __('No movies found'),
    'not_found_in_trash' => __('No movies found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Movies'
  );
  $supports = array(
    'title',
    'editor'
  );
  $args = array(
    'labels' => $labels,
    'description' => 'Live performances, commercials, etc.',
    'public' => true,
    'menu_position' => 5,
    'rewrite' => array('slug' => 'movies'),
    'supports' => $supports,
    'has_archive' => true
  );
  register_post_type('movie',$args);
}
add_action('init', 'telco_movie_init');

// Phone Book
function telco_phone_book_init() {
  $labels = array(
    'name' => _x('Phone Book', 'post type general name'),
    'singular_name' => _x('Character', 'post type singular name'),
    'add_new' => _x('Add New', 'character'),
    'all_items' => __('All Characters'),
    'add_new_item' => __('Add New Character'),
    'edit_item' => __('Edit Character'),
    'new_item' => __('New Character'),
    'view_item' => __('View Character'),
    'search_items' => __('Search Characters'),
    'not_found' =>  __('No characters found'),
    'not_found_in_trash' => __('No characters found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Phone Book'
  );
  $supports = array(
    'title',
    'editor',
    'author'
  );
  $args = array(
    'labels' => $labels,
    'description' => 'A rolodex of characters',
    'public' => true,
    'menu_position' => 5,
    'rewrite' => array('slug' => 'phone-book'),
    'supports' => $supports,
    'has_archive' => true
  );
  register_post_type('phone_book', $args);
}
add_action('init', 'telco_phone_book_init');

/* Register custom taxonomies
-------------------------------------------------- */

// Track Type
function telco_track_type_init() {
  $labels = array(
    'name' => _x( 'Track Types', 'track_types' ),
    'singular_name' => _x( 'Track Type', 'track_types' ),
    'search_items' => _x( 'Search Track Types', 'track_types' ),
    'popular_items' => _x( 'Popular Track Types', 'track_types' ),
    'all_items' => _x( 'All Track Types', 'track_types' ),
    'parent_item' => _x( 'Parent Track Type', 'track_types' ),
    'parent_item_colon' => _x( 'Parent Track Type:', 'track_types' ),
    'edit_item' => _x( 'Edit Track Type', 'track_types' ),
    'update_item' => _x( 'Update Track Type', 'track_types' ),
    'add_new_item' => _x( 'Add New Track Type', 'track_types' ),
    'new_item_name' => _x( 'New Track Type', 'track_types' ),
    'separate_items_with_commas' => _x( 'Separate track types with commas', 'track_types' ),
    'add_or_remove_items' => _x( 'Add or remove track types', 'track_types' ),
    'choose_from_most_used' => _x( 'Choose from the most used track types', 'track_types' ),
    'menu_name' => _x( 'Track Types', 'track_types' ),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_in_nav_menus' => true,
    'show_ui' => true,
    'show_tagcloud' => true,
    'hierarchical' => true,
    'rewrite' => true,
    'query_var' => true
  );
  register_taxonomy( 'track_types', array('track'), $args );
}
add_action('init', 'telco_track_type_init');

// Collection Type
function telco_collection_type_init() {
  $labels = array(
    'name' => _x( 'Collection Types', 'collection_types' ),
    'singular_name' => _x( 'Collection Type', 'collection_types' ),
    'search_items' => _x( 'Search Collection Types', 'collection_types' ),
    'popular_items' => _x( 'Popular Collection Types', 'collection_types' ),
    'all_items' => _x( 'All Collection Types', 'collection_types' ),
    'parent_item' => _x( 'Parent Collection Type', 'collection_types' ),
    'parent_item_colon' => _x( 'Parent Collection Type:', 'collection_types' ),
    'edit_item' => _x( 'Edit Collection Type', 'collection_types' ),
    'update_item' => _x( 'Update Collection Type', 'collection_types' ),
    'add_new_item' => _x( 'Add New Collection Type', 'collection_types' ),
    'new_item_name' => _x( 'New Collection Type', 'collection_types' ),
    'separate_items_with_commas' => _x( 'Separate collection types with commas', 'collection_types' ),
    'add_or_remove_items' => _x( 'Add or remove collection types', 'collection_types' ),
    'choose_from_most_used' => _x( 'Choose from the most used collection types', 'collection_types' ),
    'menu_name' => _x( 'Collection Types', 'collection_types' ),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_in_nav_menus' => true,
    'show_ui' => true,
    'show_tagcloud' => true,
    'hierarchical' => true,
    'rewrite' => true,
    'query_var' => true
  );
  register_taxonomy( 'collection_types', array('collection'), $args );
}
add_action('init', 'telco_collection_type_init');
