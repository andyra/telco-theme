<?php while (have_posts()) : the_post(); ?>

  <section class="message">
    <?php the_content(); ?>
    <p>Sincerely,<br>&mdash; Ray A. Wister</p>
  </section>

  <section class="goods">
    <h2>Goods</h2>
  </section>

  <section class="services">
    <h2>Services</h2>
  </section>

  <div>
    <section class="letter">

      <?php // Message ?>


      <?php // This Evening's Show ?>
      <section class="tes">
        <?php $broadcast = telco_get_latest_broadcast(); ?>
        <h3><span>Tune</span> <span>In</span> <span>To</span> <span><?php echo $broadcast['location']; ?></span>:</h3>
        <a href="<?php echo home_url(); ?>/tes/" title="Listen to This Evening's Show!">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tes.png">
        </a>
      </section>

      <?php // ID-a-Kid ?>
      <section class="id-a-kid">
        <?php $id = get_id_by_slug('id-a-kid');
        $id_a_kid = telco_get_ways_to_id_a_kid($id); ?>
        <h3><span><?php echo $id_a_kid['count']; ?></span> <span>Ways</span> <span>to</span> <span>ID-a-KID</span>:</h3>
        <p>Have you seen an 80 year-old kid in your vicinity? Check our handy <a href="<?php echo get_template_directory_uri(); ?>/id-a-kid/" title="How to Identify an 80 year-old kid">ID-a-Kid Guide</a> to see if you have one of these nuisances in your own backyard.</p>
      </section>

      <?php // Recent Goods ?>
      <section class="recent">
        <h3><span>Recent</span> <span>Goods</span>:</h3>
        <?php $recent_catalog = telco_recent_catalog_items(); ?>
        <ul class="unstyled">
          <?php foreach( $recent_catalog as $post ) {
            $collection = telco_get_collection_info($post); ?>
            <li>
              <a href="<?php echo $collection['permalink']; ?>">
                <img src="<?php echo $collection['album_art']['thumbnail']; ?>" alt="">
                <div>
                  <?php echo $collection['title']; ?>
                  <span><em><?php echo $collection['term']; ?>: </em><?php echo $collection['performance_date']; ?></span>
                </div>
              </a>
            </li>
          <?php } ?>
          <li><a class="pull-right" href="<?php echo get_template_directory_uri(); ?>/catalog/" title="">✆ View All</a></li>
        </ul>
      </section>

      <?php // Employee Services ?>
      <?php if( is_user_logged_in() ) : ?>
        <section>
          <h3><span>Employee</span> <span>Services</span>:</h3>
          <?php wp_nav_menu(array('theme_location' => 'home_navigation', 'walker' => new Roots_Nav_Walker(), 'menu_class' => 'nonen')); ?>
        </section>
      <?php endif; ?>
    </section>

    <aside>

      <?php // Today's Track ?>
      <section class="todays-track">
        <h3><span>Song</span> <span>For</span> <span><?php echo date('l') . '</span> <span>' . date('M') . '</span> <span>' . date('jS'); ?></span></h3>
        <div class="player">
          <?php $todays_track = telco_get_todays_track(); ?>
          <audio preload="none" src="<?php echo $todays_track['link']; ?>" data-title="<?php echo $todays_track['track']['title']; ?>"></audio>
          <p>From "<a href="<?php echo $todays_track['collection']['permalink']; ?>"><?php echo $todays_track['collection']['title']; ?></a>"</p>
        </div>
      </section>

      <?php // Today's Quote ?>
      <section class="todays-quote">
        <h3><span>Today's</span> <span>Quote</span>:</h3>
        <blockquote>
          <?php $todays_quote = telco_get_todays_quote(); ?>
          <span class="quote left">"</span><em><?php echo $todays_quote['quote']; ?></em><span class="quote right">"</span>
          <cite>&mdash; <?php echo $todays_quote['author']->post_title; ?></cite>
        </blockquote>
      </section>

      <?php // 80 Year-Old Kid
      $kid = false;
      if($kid == true) : ?>
        <section class="id-a-kid">
          <h3><span>Spot</span> <span>an</span> <span>80</span> <span>Year-Old</span> <span>Kid</span>:</h3>
          <blockquote>
            <?php $todays_quote = telco_get_todays_quote(); ?>
            <span class="quote left">"</span><em><?php echo $todays_quote['quote']; ?></em><span class="quote right">"</span>
            <cite>&mdash; <?php echo $todays_quote['author']->post_title; ?></cite>
          </blockquote>
        </section>
      <?php endif; ?>

      <?php // A Word From Our Sponsors ?>
      <section class="sponsor">
        <h3><span>A</span> <span>Word</span> <span>From</span> <span>Our</span> <span>sponsors</span></h3>
        <?php $random_ad = telco_get_random_ad(); ?>
        <a class="fancybox" href="<?php echo $random_ad['image']['sizes']['large']; ?>" title="<?php echo $random_ad['title']; ?>">
          <img src="<?php echo $random_ad['image']['sizes']['medium']; ?>" alt="<?php echo $random_ad['title']; ?>">
        </a>
      </section>

    </aside>

  </div>

<?php endwhile; ?>
