<?php while (have_posts()) : the_post(); ?>

  <?php $id_a_kid = telco_get_ways_to_id_a_kid($post->ID); ?>

  <section class="letter">
    <?php echo get_field('content'); ?>
  </section>

  <ol>
    <?php foreach( $id_a_kid['ways'] as $way ) :
      echo '<li>' . $way . '</li>';
    endforeach; ?>
  </ol>

<?php endwhile; ?>
