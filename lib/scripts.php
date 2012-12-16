<?php

/* Telco Scripts
-------------------------------------------------- */

function telco_scripts() {
  //  Styles
  wp_enqueue_style('telco_style', get_template_directory_uri() . '/assets/stylesheets/telco.min.css', false, '0020', null);

  // jQuery (called from Google's CDN with a local fallback in the header)
  if( !is_admin() ) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', '', '', false);
  }

  // Comments
  if( is_single() && comments_open() && get_option('thread_comments') ) {
    wp_enqueue_script('comment-reply');
  }

  // Setlist Computer styles and tools
  if( is_page('Setlist Computer') ) {
    wp_register_script('telco_range_input', 'http://cdn.jquerytools.org/1.2.7/form/jquery.tools.min.js', 'jquery', null, false);
    wp_enqueue_script('telco_range_input');
  }

  // ColorTunes
  // wp_register_script('telco_ct_quantize', get_template_directory_uri() . '/assets/javascripts/colortunes/quantize.js', 'jquery', '1', false);
  // wp_enqueue_script('telco_ct_quantize');

  // wp_register_script('telco_ct_colortunes', get_template_directory_uri() . '/assets/javascripts/colortunes/color-tunes.js', 'telco_ct_quantize', '1', false);
  // wp_enqueue_script('telco_ct_colortunes');

  wp_register_script('telco_ct_application', get_template_directory_uri() . '/assets/javascripts/colortunes/application.js', 'telco_ct_colortunes', '1', false);
  wp_enqueue_script('telco_ct_application');

  // Compiled scripts
  wp_register_script('telco_compiled_scripts', get_template_directory_uri() . '/assets/javascripts/scripts.min.js', 'jquery', '00002', false);
  // wp_enqueue_script('telco_compiled_scripts');

}
add_action('wp_enqueue_scripts', 'telco_scripts', 100);

/* Admin Scripts
-------------------------------------------------- */

function telco_admin_scripts() {
  if( is_admin() ) {
    // Styles
    wp_enqueue_style('telco_admin_style', get_stylesheet_directory_uri() .'/assets/stylesheets/admin.min.css', false, '1.0', 'all');

    // Register
    wp_register_script('telco_admin_jquery', get_template_directory_uri() . '/assets/javascripts/jquery-1.7.1.min.js', false, null, false); // jQuery 1.7.1 required for Select2 (12/5/12)
    wp_register_script('telco_admin_js', get_template_directory_uri() . '/assets/javascripts/admin.min.js', array('telco_admin_jquery'), false, true );

    // Enqueue
    wp_enqueue_script('telco_admin_jquery');
    wp_enqueue_script('telco_admin_js');
  }
}
add_action('admin_enqueue_scripts', 'telco_admin_scripts');

/* Login Scripts
-------------------------------------------------- */

function telco_login_styles() {
  wp_enqueue_style('telco_login_style', get_template_directory_uri() . '/assets/stylesheets/login.min.css', false, null);
}
add_action('login_head', 'telco_login_styles');
