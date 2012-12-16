<?php while (have_posts()) : the_post(); ?>

  <?php $track = telco_get_track_info($post); ?>
  <?php $instances = telco_get_track_instances( $track['title'] ); ?>

    <h1>"<?php the_title(); ?>" <small><?php echo $track['term']; ?></small></h1>

    <?php // Instances ?>
    <section class="track-instances">
      <h2 class="section-heading">Appears on:</h2>

      <?php if( $instances ) : ?>
        <ul class="instances unstyled">

        <?php foreach( $instances as $instance ) :
          // $track_metadata = $instance['metadata'];
          ?>
          <li>
            <a class="album-cover" href="<?php echo $instance['collection_permalink']; ?>" title="View <?php echo $instance['collection_title']; ?>">
              <img src="<?php echo $instance['collection_album_art']; ?>" alt="">
            </a>
            <div>
              <a href="<?php echo $instance['collection_permalink']; ?>"><?php echo $instance['collection_title']; ?></a>
              <span><?php // echo $track_metadata['duration']; ?></span>
            </div>
          </li>
        <?php endforeach; ?>
        </ul>

      <?php else :
        get_template_part('snippets/no-results');
      endif; ?>
    </section>

    <?php // Lyrics ?>
    <section class="track-lyrics">
      <h2 class="section-heading">Lyrics</h2>
      <?php if( $track['lyrics'] ) :
        echo $track['lyrics'];
      else :
        get_template_part('snippets/no-results');
      endif; ?>
    </section>

    <?php // Lead Sheet ?>
    <section class="lead-sheets">
      <h2 class="section-heading">Lead Sheet</h2>
      <?php if( $track['lead_sheet'] ) : ?>
        <ul class="lead-sheet">
        <?php foreach( $track['lead_sheet'] as $lead_sheet ) : ?>
          <li>
            <?php if( $lead_sheet['section_name'] ) {
              echo '<h3>' . $lead_sheet['section_name'] . '</h3>';
            }
            if( $lead_sheet['chords'] ) {
              echo '<p>' . $lead_sheet['chords'] . '</p>';
            } ?>
          </li>
        <?php endforeach;
      else :
        get_template_part('snippets/no-results');
      endif; ?>
    </section>

    <?php // Annotations ?>
    <section class="annotations">
      <h2 class="section-heading">Annotations</h2>
      <?php if( $track['annotations'] ) : ?>
        <ul class="thumbnails">

        <?php foreach( $track['annotations'] as $annotation ) :
          $file = $annotation['file']; ?>

          <li>
            <?php $file_info = telco_get_file_info( $file['url'] );
            if( $file_info['type'] == 'image' ) : ?>
              <a class="thumbnail fancybox" href="<?php echo $file['url'] ?>" title="<?php echo $file['title']; ?>">
                <img src="<?php echo $file['url'] ?>" alt="<?php echo $file['title']; ?>">
                <figcaption><?php echo $file_info['name']; ?></figcaption>
              </a>
            <?php else : ?>
              <a class="thumbnail" target="_blank" href="<?php echo $file['url'] ?>" title="<?php echo $file['title']; ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-pdf.png" alt="<?php echo $file['title']; ?>">
                <figcaption><?php echo $file_info['name']; ?></figcaption>
              </a>
            <?php endif; ?>
          </li>

        <?php endforeach; ?>

        </ul>
      <?php else :
        get_template_part('snippets/no-results');
      endif; ?>
    </section>

<?php endwhile;?>
