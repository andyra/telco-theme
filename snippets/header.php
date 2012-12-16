<header class="header">
  <a class="logo" href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
  <nav>
    <button class="nav-toggle" data-toggle="collapse" data-target="header .nav-mobile">Menu</button>
    <?php if( !is_user_logged_in() ) :
      wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-mobile collapse'));
    else :
      wp_nav_menu(array('theme_location' => 'employee_navigation', 'menu_class' => 'nav nav-mobile collapse'));
    endif; ?>
  </nav>
</header>
