<?php // Template Name: ID-a-Kid ?>

<?php $id_a_kid = telco_get_ways_to_id_a_kid($post->ID); ?>
<h1><?php echo $id_a_kid['count'] . ' ' . get_the_title(); ?></h1>
<?php get_template_part('templates/content', 'page-id-a-kid'); ?>
