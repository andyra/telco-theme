<?php while (have_posts()) : the_post(); ?>

  <?php // Initialize page
  $video = telco_get_background_video($post);
  $collection = telco_get_collection_info( get_field('broadcast') ); ?>

  <a href="<?php echo $video['url']; ?>" class="video-background hide {<?php echo $video['params']; ?>}">This Evening's Show</a>

  <h1><?php the_title(); ?></h1>
  <h2><?php echo $collection['performance_date']; ?></h2>

  <p class="description">Join us on <?php echo $collection['location']; ?> with your host <?php echo $collection['band']; ?>. <?php echo $collection['description']; ?></p>

  <section class="playlist">
    <audio preload="none"></audio>
    <ol class="tracklist">
    <?php foreach( $collection['tracklist'] as $track_item ) :
      $track = telco_get_track_info( $track_item['track'] );
      $track_link = $track_item['link'];
      $track_bleed = $track_item['bleed']; ?>
      <li>
        <a href="#" data-src="<?php echo $track_link; ?>">
          <span class="title"><?php echo $track['title']; ?></span>
          <?php if($track_bleed) echo '<span class="bleed">⤵</span>'; ?>
        </a>
      </li>
    <?php endforeach; ?>
    </ol>
    <div class="toggle-tracklist" href="#">⬇ Show Playlist</div>
  </section>

<?php endwhile; ?>
