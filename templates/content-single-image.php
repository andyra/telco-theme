<?php while (have_posts()) : the_post(); ?>

  <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <header>
      <h1><?php the_title(); ?></h1>
      <?php get_template_part('snippets/entry-meta'); ?>
    </header>
    <?php $image = get_field('image'); ?>
    <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php the_title(); ?>">
  </article>

<?php endwhile; ?>
