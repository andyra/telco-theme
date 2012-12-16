<?php while (have_posts()) : the_post(); ?>

  <div>
    <section class="computer <?php echo strtolower( get_field('model') ); ?>">

      <header>
        <hgroup>
          <h2><?php echo get_field('model'); ?></h2>
          <h3><?php echo get_field('model'); ?></h3>
        </hgroup>
      </header>

      <form>
        <div>
          <div class="control-group">
            <input type="range" name="songs" min="1" max="40" step="1" value="0" />
            <label>Songs</label>
          </div>
          <div class="control-group">
            <input type="range" name="bleeds" min="0" max="40" step="1" value="0" />
            <label>Bleeds</label>
          </div>
          <div class="control-group">
            <input type="range" name="strategies" min="0" max="40" step="1" value="0" />
            <label>Strategies</label>
          </div>
        </div>
      </form>

      <footer>
        <button type="submit">Compute</button>
        <label>Compute</label>
      </footer>
    </section>

    <section class="setlist hide">
      <ol></ol>
      <footer>
        <div class="btn-group">
          <a class="view-lead-sheets btn" href="<?php echo get_permalink(); ?>lead-sheets/" target="_blank">View Lead Sheets</a>
          <!-- <a class="make-playlist btn" href="#">Make Playlist</a> -->
        </div>
      </footer>
    </section>
  </div>

  <section class="lead-sheets hide">
    <h2>Lead Sheets</h2>
    <ul class="unstyled"></ul>
  </section>

  <div class="all-items hide">
    <ol class="all-strategies">
      <?php $all_strategies = get_field('strategies');
      $items = explode ("\n", $all_strategies);
      foreach ($items as $item) {
        echo '<li>' . $item . '</li>';
      } ?>
    </ol>

    <ol class="all-songs">
      <?php $tracks = get_posts(array(
        'post_type'   => 'track',
        'taxonomy'    => 'track_types',
        'term'        => 'song',
        'status'      => 'publish',
        'orderby'     => 'rand',
        'numberposts' => -1,
      ));

      foreach( $tracks as $post ) {
        $track = telco_get_track_info($post); ?>
        <li><?php echo $track['title']; ?><span class="track-id hide"><?php echo $post->ID; ?></span></li>
      <?php } ?>
    </ol>
  </div>

<?php endwhile; ?>
