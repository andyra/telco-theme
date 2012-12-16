<?php while (have_posts()) : the_post(); ?>

  <div>
    <nav role="navigation">
      <?php wp_nav_menu(array('theme_location' => 'handbook_navigation', 'walker' => new Roots_Navbar_Nav_Walker(), 'menu_class' => 'nav list-numbered')); ?>
    </nav>
    <section class="letter">
    	<h2><?php the_title(); ?></h2>
      <?php the_content(); ?>
    </section>
  </div>

<?php endwhile; ?>
