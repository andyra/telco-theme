<?php // Template Name: Catalog ?>

<h1><?php the_title(); ?></h1>

<?php // Filter Buttons
$filter_terms = telco_get_terms('catalog', 'all');
telco_filter_buttons($filter_terms); ?>

<?php get_template_part('templates/content', 'page-catalog'); ?>
