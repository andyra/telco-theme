<?php while (have_posts()) : the_post(); ?>
  <h1><?php the_title(); ?></h1>

  <?php $video_url = telco_get_video_url($post->ID); ?>

  <section class="movie">
    <div class="wrapper">
      <iframe src="<?php echo $video_url; ?>" frameborder="0" width="420" height="315" allowfullscreen></iframe>
    </div>
  </section>

<?php endwhile; ?>
