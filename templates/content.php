<?php if (!have_posts()) :
  get_template_part('snippets/no-results');
endif; ?>

<?php while (have_posts()) : the_post(); ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">

      <?php // Archive
      if( is_archive() || is_search() ) : ?>
        <header>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <?php get_template_part('snippets/entry-meta'); ?>
        </header>
        <?php the_excerpt(); ?>

      <?php // Image
      elseif( in_category('image') ) : ?>
        <header class="offset">
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <?php get_template_part('snippets/entry-meta'); ?>
        </header>
        <div class="image">
          <?php $image = get_field('image', $post->ID); ?>
          <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo get_the_title(); ?>">
        </div>

      <?php // Ideas
      else : ?>
        <header class="offset">
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <?php get_template_part('snippets/entry-meta'); ?>
        </header>
        <?php if( get_the_content() ) { ?>
          <div class="content">
            <?php the_excerpt( 'Continue reading <span class="meta-nav">&rarr;</span>' ); ?>
          </div>
        <?php }
      endif; ?>
    </div>
  </article>

<?php endwhile; ?>

<?php get_template_part('snippets/pagination'); ?>
