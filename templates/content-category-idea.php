<?php if (!have_posts()) :
  get_template_part('snippets/no-results');
endif; ?>

<?php while (have_posts()) : the_post(); ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php roots_post_inside_before(); ?>
    <div class="entry-content">
      <header class="offset">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php get_template_part('snippets/entry-meta'); ?>
      </header>
      <?php if( get_the_content() ) { ?>
        <div class="content">
          <?php the_excerpt( 'Continue reading <span class="meta-nav">&rarr;</span>' ); ?>
        </div>
      <?php } ?>
    </div>
    <footer>
      <?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(); ?></p><?php } ?>
    </footer>
  </article>

<?php endwhile; ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ($wp_query->max_num_pages > 1) { ?>
  <nav id="post-nav" class="pager">
    <div class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></div>
    <div class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></div>
  </nav>
<?php } ?>
