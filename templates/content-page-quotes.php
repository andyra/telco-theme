<?php while (have_posts()) : the_post(); ?>

  <h1><?php the_title(); ?></h1>

  <?php foreach( get_field('quotes') as $quote ) : ?>
    <blockquote>
      "<?php echo $quote['quote']; ?>"
      <cite>&mdash; <?php echo $quote['author']; ?></cite>
    </blockquote>
  <?php endforeach; ?>

<?php endwhile; ?>
