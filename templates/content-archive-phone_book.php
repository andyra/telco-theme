<?php while (have_posts()) : the_post(); ?>

  <?php $character = telco_get_character_info($post); ?>

  <li>
    <a class="thumbnail" href="<?php echo $character['permalink']; ?>" title="<?php echo $character['name']; ?>">
      <img src="<?php echo $character['photo']['medium']; ?>" alt="">
      <figcaption><?php echo $character['name']; ?></figcaption>
    </a>
  </li>

<?php endwhile; ?>
