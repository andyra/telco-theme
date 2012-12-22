<?php while (have_posts()) : the_post(); ?>
  <h1><?php the_title(); ?></h1>

  <?php while (the_repeater_field('video')) :
    $video = telco_get_video_info($post); ?>

    <section class="movie">
      <div class="wrapper">
        <iframe
          width="420"
          height="315"
          src="<?php echo $video['url']; ?>"
          frameborder="0"
          allowfullscreen>
        </iframe>
      </div>
      <?php if( $video['caption'] ) : ?>
        <h3><?php echo $video['caption']; ?></h3>
      <?php endif; ?>
    </section>

  <?php endwhile; ?>

<?php endwhile; ?>
