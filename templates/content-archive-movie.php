<?php while (have_posts()) : the_post(); ?>

  <?php $movie = telco_get_movie_info($post); ?>

  <li>
    <a href="<?php echo $movie['permalink']; ?>" title="<?php echo $movie['title']; ?>">
      <img src="<?php echo $movie['album_art']; ?>" alt="<?php echo $movie['title']; ?>">
      <dl>
        <dt><?php echo $movie['title']; ?></dt>
        <dd class="date"><?php echo $movie['date']; ?></dd>
      </dl>
    </a>
  </li>

<?php endwhile; ?>
