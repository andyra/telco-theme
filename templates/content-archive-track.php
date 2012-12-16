<div class="tab-content">
  <?php // Get list of terms to filter by
  $filter_terms = telco_get_terms('track_types', 'all');

  foreach ($filter_terms as $filter_term) :

    // Get posts from the term
    $filter_term = strtolower($filter_term);
    $tracks = telco_get_posts_with_term('track', $filter_term);

    // Get the track titles
    $clean_tracklists = telco_clean_tracklists(); ?>

    <section class="tab-pane fade" id="<?php echo $filter_term; ?>">
      <table class="table table-striped table-counter table-sortable">
        <thead>
          <tr>
            <th class="title">Title</th>
            <th class="count">№</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($tracks as $track_object) :
          $track = telco_get_track_info($track_object);
          $instances = telco_count_instances( $track['title'], $clean_tracklists ); ?>
          <tr>
            <td class="title"><a href="<?php echo $track['permalink']; ?>"><?php echo $track['title']; ?></a></td>
            <td class="count"><?php echo $instances; ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>

  <?php endforeach; ?>
</div>
