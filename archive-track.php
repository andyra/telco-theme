<h1>Track Index</h1>

<?php // Filter Buttons
$filter_terms = telco_get_terms('track_types', 'all');
telco_filter_buttons($filter_terms); ?>

<?php get_template_part('templates/content', 'archive-track'); ?>
