<?php while (have_posts()) : the_post(); ?>

  <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <header>
      <h1><?php the_title(); ?></h1>
      <?php get_template_part('snippets/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
      <?php comments_template('/snippets/comments.php'); ?>
    </footer>
  </article>

<?php endwhile; ?>
