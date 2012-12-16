<?php get_template_part('snippets/archive-header'); ?>

<table class="table table-striped table-counter table-sortable">
  <thead>
    <tr>
      <th class="title">Title</th>
      <th class="date">Date</th>
    </tr>
  </thead>
  <tbody>
    <?php get_template_part('templates/content', 'archive'); ?>
  </tbody>
</table>
