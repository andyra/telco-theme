<h1>Collection Registry</h1>

<?php // Filter Buttons
$filter_terms = telco_get_terms('collection_types', 'all');
telco_filter_buttons($filter_terms); ?>

<?php get_template_part('templates/content', 'archive-collection'); ?>
