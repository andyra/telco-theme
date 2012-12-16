<?php while (have_posts()) : the_post(); ?>

  <section class="color-tunes">
    <div class="cover-picker">
      <img id='source-image' src="<?php echo get_template_directory_uri(); ?>/assets/images/test/01.jpg">
    </div>
    <div class="playlist">
      <h2>Beautiful Bonzai Trees</h2>
      <ol>
        <li>Craig steps up his game</li>
        <li>Lonely miser of fortune</li>
        <li>Cable TV</li>
        <li>Do ya wanne be a grandma?</li>
        <li>Some like it square</li>
      </ol>
      <canvas id="album-artwork" width="300" height="450"></canvas>
    </div>
  </section>

<?php endwhile; ?>
