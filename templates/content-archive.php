<?php while (have_posts()) : the_post(); ?>

  <tr>
    <td><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></td>
    <td><?php the_date(); ?></td>
  </tr>

<?php endwhile; ?>
