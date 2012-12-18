<?php while (have_posts()) : the_post(); ?>

  <?php $collection = telco_get_collection_info($post); ?>

  <h1><?php the_title(); ?></h1>

  <section class="main">

    <audio class="audio-player" preload="none">
      Audio Player
    </audio>


    <?php // Tracklist
      // See if there are any links here
      foreach( $collection['tracklist'] as $track_item ) :
        $track = telco_get_track_info( $track_item['track'] );
        $track_link = $track_item['link'];
        if( $track_link != '' ) {
          $tracklist_has_links = true;
          break;
        }
      endforeach; ?>

      <ol class="tracklist list-striped">
      <?php foreach( $collection['tracklist'] as $track_item ) :
        $track = telco_get_track_info( $track_item['track'] );
        // $track_metadata = telco_get_track_metadata($track_item['link']); ?>

        <li>
        <?php if( is_user_logged_in() && $track_item['link'] ) : ?>
          <a href="#" data-src="<?php echo $track_item['link']; ?>">
            <span class="title"><?php echo $track['title']; ?></span>
          </a>
        <?php else : ?>
          <span class="title"><?php echo $track['title']; ?></span>
        <?php endif ?>
          <?php if( $track_item['bleed'] ) echo '<span class="bleed">⤵</span>'; ?>
          <span class="duration"><?php // echo $track_metadata['duration']; ?></span>
        </li>
      <?php endforeach; ?>
      <?php if( is_user_logged_in() && $tracklist_has_links ) : ?>
        <div class="download-all">
          <a href="<?php echo $collection['zip_link']; ?>" title="Download <?php echo $collection['title']; ?>">⬇ Download All Tracks</a>
        </div>
      <?php endif; ?>
      </ol>

    </section>

    <aside>
      <figure class="album-art">
        <img src="<?php echo $collection['album_art']['medium']; ?>" alt="">
        <canvas id="album-artwork"></canvas>
      </figure>
      <a class="btn btn-large" href="#">Download Album</a>
    </aside>

<?php endwhile; ?>
