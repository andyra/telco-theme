<?php while (have_posts()) : the_post(); ?>


  <div class="container">
    <h1 style="margin-top: 40px;">
      <a href="http://github.com/dannvix/ColorTunes"><span style="color: #d0104c;">Color</span><span style="color: #373c38;">Tunes</span></a>
    </h1>

    <ul class="cover-picker unstyled clearfix">
      <li>
        <a href="#4times"><img src="images/4times.jpg" alt="4 TIMES by Koda Kumi" /></a>
        <span class="cover-title">4 TIMES</span>
        <span class="cover-artist">Koda Kumi</span>
      </li>
      <li>
        <a href="#fame"><img src="images/fame.jpg" alt="F.A.M.E. by Chris Brown" /></a>
        <span class="cover-title">F.A.M.E.</span>
        <span class="cover-artist">Chris Brown</span>
      </li>
      <li>
        <a href="#transatlanticism"><img src="images/transatlanticism.jpg" alt="Transatlanticism by Death Cab for Cutie" /></a>
        <span class="cover-title">Transatlanticism</span>
        <span class="cover-artist">Death Cab for Cutie</span>
      </li>
      <li>
        <a href="#sixrules"><img src="images/sixrules.jpg" alt="Six Rules by PSY" /></a>
        <span class="cover-title">Six Rules Part 1</span>
        <span class="cover-artist">PSY</span>
      </li>
      <li>
        <a href="#thefame"><img src="images/thefame.jpg" alt="The Fame by Lady Gaga" /></a>
        <span class="cover-title">The Fame</span>
        <span class="cover-artist">Lady Gaga</span>
      </li>
    </ul>
    <div class="playlist-indicator hidden"></div>
  </div>

  <div class="playlist closed hidden transition transition-height">
    <div class="playlist-inner clearfix">
      <div class="playlist-options">
        <ul class="nav nav-pills">
          <li class="active"><a href="#">Songs</a></li>
          <li><a href="#">In Store</a></li>
        </ul>
      </div>
      <div class="album-cover pull-right">
        <canvas id="album-artwork" width="300" height="450"></canvas>
      </div>
      <div class="album-info">
        <h3 class="album-title">4 TIMES</h3>
        <ul class="album-actions  unstyled">
          <li>Play</li>
          <li>Shuffle</li>
          <li>Options</li>
        </ul>
        <h4 class="album-artist"><span class="artist-name">Koda Kumi</span> <span class="released-on">(2011)</span></h4>
        <ol class="album-tracks">
          <li>
            <h5 class="track-title">Introduction ~sunny time~</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">0:41</span>
          </li>
          <li>
            <h5 class="track-title">Poppin' love cocktail feat. TEEDA</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">5:00</span>
          </li>
          <li>
            <h5 class="track-title">Interlude ～sunset time～</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">0:37</span>
          </li>
          <li>
            <h5 class="track-title">IN THE AIR</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">4:08</span>
          </li>
          <li>
            <h5 class="track-title">Interlude ～midnight time～</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">0:28</span>
          </li>
          <li>
            <h5 class="track-title">V.I.P</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">3:05</span>
          </li>
          <li>
            <h5 class="track-title">Interlude ～time to... love～</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">0:36</span>
          </li>
          <li>
            <h5 class="track-title">KO-SO-KO-SO</h5>
            <span class="track-ratings"></span>
            <span class="track-playtime">3:19</span>
          </li>
        </ol>
      </div>
    </div>
  </div>


<?php endwhile; ?>
