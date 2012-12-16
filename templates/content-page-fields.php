<?php while (have_posts()) : the_post(); ?>

  <?php the_content(); ?>

  <?php // Filter Buttons
  $filter_terms = array('Track', 'Collection', 'Movie', 'Phone Book');
  telco_filter_buttons($filter_terms); ?>

  <div class="tab-content">
    <?php foreach ($filter_terms as $post_type) :

      // Get custom posts
      $post_type = str_replace(' ', '_', strtolower($post_type) );
      $post_field = telco_get_post_types($post_type);
      $custom_posts = get_posts($post_field['args']); ?>

      <section class="tab-pane fade" id="<?php echo $post_type; ?>">
        <table class="table table-counter table-sortable">
          <thead>
            <tr>
              <?php foreach($post_field['headings'] as $heading) : ?>
                <th><?php echo $heading; ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach($custom_posts as $custom_post) :
            $post_info = telco_get_post_info($custom_post, $post_type); ?>
            <tr>
              <?php $i = 1;
              foreach($post_info as $value) : ?>
                <td>
                  <?php if( $value == '✓' ) {
                    echo '<span class="present">' . $value . '</span>';
                  } elseif( $value == '&times;' ) {
                    echo '<span class="missing">' . $value . '</span>';
                  } else {
                    echo $value;
                  } ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </section>
    <?php endforeach; ?>

  </div>

  <?php $post_field = telco_get_post_types($post);
  $custom_posts = get_posts($post_field['args']); ?>

  <table class="table table-counter table-sortable">
    <thead>
      <tr>
        <?php foreach($post_field['headings'] as $heading) : ?>
          <th><?php echo $heading; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach($custom_posts as $custom_post) :
      $post_type = get_field('post_type');
      $post_info = telco_get_post_info($custom_post, $post_type); ?>
      <tr>
        <?php $i = 1;
        foreach($post_info as $value) : ?>
          <td>
            <?php if( $value == '✓' ) {
              echo '<span class="present">' . $value . '</span>';
            } elseif( $value == '&times;' ) {
              echo '<span class="missing">' . $value . '</span>';
            } else {
              echo $value;
            } ?>
          </td>
        <?php endforeach; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php endwhile; ?>
