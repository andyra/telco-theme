<?php while (have_posts()) : the_post(); ?>
  <h1><?php the_title(); ?></h1>

  <?php // Video
  $column_class = ( count(get_field('video')) > 1 ? 'span6' : 'span12' );

  while (the_repeater_field('video')) :
    $video = telco_get_video_info($post); ?>
    <section class="movie <?php echo $column_class; ?>">
      <?php if( $video['caption'] ) : ?>
        <h3><?php echo $video['caption']; ?></h3>
      <?php endif; ?>
      <iframe width="420" height="315" src="<?php echo $video['url']; ?>" frameborder="0" allowfullscreen></iframe>
    </section>
  <?php endwhile; ?>

<?php endwhile; ?>
