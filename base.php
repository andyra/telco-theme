<?php get_template_part('snippets/head'); ?>
<body <?php body_class(); ?>>
  <div class="wrap">
    <?php get_template_part('snippets/header'); ?>
    <div class="content">
      <?php include roots_template_path(); ?>
    </div>
    <?php get_template_part('snippets/footer'); ?>
  </div>
</body>
</html>
