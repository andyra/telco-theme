<?php while (have_posts()) : the_post(); ?>

  <?php // Convert URL parameter string to array of integers
  $tracks = str_getcsv($_GET['tracks']);
  $track_ids = array_map(
    create_function('$value', 'return (int)$value;'),
    $tracks
  ); ?>

  <div>

    <section class="setlist">
    	<h1>Setlist</h1>
      <ol>
        <?php // Display lead sheets
        foreach($track_ids as $id) {
          $track = get_post($id);
          $track = telco_get_track_info($track); ?>
          <li<?php if(!$track['lead_sheet']) { echo ' class="disabled"'; } ?>><?php echo $track['title']; ?></li>
        <?php } ?>
      </ol>
    </section>

    <div>
      <?php // Display lead sheets
      $count = 0;
      foreach($track_ids as $id) :
        $track = get_post($id);
        $track = telco_get_track_info($track);

        if( $track['lead_sheet'] ) :
          $count++; ?>
          <ul class="lead-sheet">
            <h2><?php echo $track['title']; ?></h2>
            <?php foreach( $track['lead_sheet'] as $lead_sheet ) : ?>
              <li>
                <?php if( $lead_sheet['section_name'] ) {
                  echo '<h3>' . $lead_sheet['section_name'] . '</h3>';
                }
                if( $lead_sheet['chords'] ) {
                  echo '<p>' . $lead_sheet['chords'] . '</p>';
                } ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

      <?php endforeach; ?>

      <?php if($count == 0) :
        get_template_part('snippets/no-results');
      endif; ?>
    </div>
  </div>

<?php endwhile; ?>
