<?php

/* Get Track Info
-------------------------------------------------- */

function telco_get_track_info($post) {

  // Title and Permalink
  $title = get_the_title($post->ID);
  $id = $post->ID;
  $permalink = get_permalink($post->ID);

  // Track Type
  // Get the ID from the taxonomy field, then get the term object,
  // which we pull the actual info from. A weird way of doing it.
  $term_id = get_field('track_type', $post->ID);
  $term_id = (int)$term_id[0];
  $term = get_term( $term_id, 'track_types' );
  $term = $term->name;
  $term_permalink = get_term_link( $term_id, 'track_types' );

  $lyrics = get_field('lyrics', $post->ID);
  $lead_sheet = get_field('lead_sheet', $post->ID);
  $annotations = get_field('annotations', $post->ID);

  // Defaults
  if( !$track_type )  { $track_type = 'I can\'t figure out what kind of track this is'; }
  if( !$term )        { $term = null;
                        $term_permalink = null; }

  $track = array(
    'title'                   => $title,
    'id'                      => $id,
    'permalink'               => $permalink,
    'lyrics'                  => $lyrics,
    'lead_sheet'              => $lead_sheet,
    'annotations'             => $annotations,
    'term'                    => $term,
    'term_permalink'          => $term_permalink,
  );

  return $track;
}

/* Get Track Instances
-------------------------------------------------- */

function telco_get_track_instances($this_track_title) {
  $collections = get_posts(array(
    'post_type'       => 'collection',
    'post_status'     => 'publish',
    'numberposts'     => -1,
  ));
  $instances = array();

  // Get the tracklist on each collection
  // Check to see if the track we've passed in matches any tracks on this album
  if( $collections ) {
    foreach ($collections as $collection_object) {
      $tracklist = get_field('tracklist', $collection_object->ID);

      foreach($tracklist as $track) :
        $track_title = get_the_title($track['track']->ID);

        // If the current track IS on the current collection
        if( $track_title == $this_track_title ) :
          $collection  = telco_get_collection_info($collection_object);

          $instance = array(
            'collection_title'      => $collection['title'],
            'collection_permalink'  => $collection['permalink'],
            'collection_album_art'  => $collection['album_art']['thumbnail'],
            'number'                => array_search($track, $tracklist) + 1,
            'download_link'         => get_template_directory_uri() . $track['link'],
            // 'metadata'              => telco_get_track_metadata( $track['link'] ),
          );
          array_push($instances, $instance);

        endif;
      endforeach;
    }
  } else {
    $instances = null;
  }
  return $instances;
}

/* Count Track Instances
-------------------------------------------------- */

function telco_clean_tracklists() {
  $collections = get_posts(array(
    'post_type'       => 'collection',
    'post_status'     => 'publish',
    'numberposts'     => -1,
  ));
  $clean_tracklists = array();

  foreach( $collections as $collection ) {
    $collection = telco_get_collection_info($collection);
    $clean_tracklist = array();

    foreach( $collection['tracklist'] as $track ) {
      $title = get_the_title($track['track']->ID);
      array_push($clean_tracklist, $title);
    }

    array_push($clean_tracklists, $clean_tracklist);
  }

  return $clean_tracklists;
}

function telco_count_instances($this_track_title, $clean_collections) {
  $instances = 0;

  foreach( $clean_collections as $clean_collection ) :
    foreach($clean_collection as $clean_track) {
      if( $clean_track == $this_track_title ) { $instances++; }
    }
  endforeach;

  return $instances;
}

/* Get Collection info
-------------------------------------------------- */

function telco_get_collection_info($post) {

  // Title and permalink
  $permalink = get_permalink($post->ID);
  $slug = basename( get_permalink($post->ID) );
  $title = get_the_title($post->ID);
  $publish_date = get_the_date('F j, Y', $post->ID);

  // Basic collection info
  if( get_field('collection_info', $post->ID) ) :
    while(the_repeater_field('collection_info', $post->ID) ) {
      $album_art = get_sub_field('album_art');
      $album_art = $album_art['sizes'];
      $description = get_sub_field('description');
      $listing_id  = get_sub_field('listing_id');

      $collection_type = get_sub_field('collection_type');
      if( isset($collection_type) ) {
        $collection_type = strip_tags( strtolower( $collection_types ) );
      } else {
        $collection_type == 'none';
      }

      // Collection Type
      // Get the ID from the taxonomy field, then get
      // the term object, which we pull the actual info from. STUPID.
      $term_id = get_sub_field('collection_type', $post->ID);
      $term_id = (int)$term_id[0];
      $term = get_term( $term_id, 'collection_types' );
      $term = $term->name;
      $term_permalink = get_term_link( $term_id, 'collection_types' );
    }
  endif;

  // Performance Info
  if( get_field('performance_info', $post->ID) ) :
    while(the_repeater_field('performance_info', $post->ID) ) {
      $band = get_sub_field('band');
      $location = get_sub_field('location');
      $performance_date = get_sub_field('date');
    }
  endif;

  // Tracklist
  if( get_field('tracklist', $post->ID) ) :
    $tracklist = get_field('tracklist', $post->ID);
  endif;

  // Zip Link
  $zip_script = get_template_directory_uri() . '/wp-content/themes/telco/lib/zip.php';
  $zip_link   = $zip_script . '?file=' . $slug;

  // Used only for movies
  // (since album art for collections are buried in a repeater field)
  if( get_field('video_still', $post->ID) ) :
    $album_art = get_field('video_still', $post->ID);
    $album_art = $album_art['sizes'];
  endif;

  // Distribution
  $distribution_method = get_field('distribution_method', $post->ID);

  // Set up defaults
  if( !$band )                { $band = 'NW'; }
  if( !$performance_date )    { $performance_date = $publish_date; }
  if( !$distribution_method ) { $distribution_method = 'mail'; }
  if( !$album_art ) {
    $album_art = array(
      'thumbnail' => get_template_directory_uri() . '/assets/images/default-collection-thumbnail.jpg',
      'medium'    => get_template_directory_uri() . '/assets/images/default-collection-medium.jpg',
      'large'     => get_template_directory_uri() . '/assets/images/default-collection-medium.jpg',
    );
  }

  if( $term == 'Album' ) {
    $band_heading =     'Primary Certificate Holder';
    $date_heading =     'Date of Publishment';
    $location_heading = 'Locale';
  }

  if( $term == 'Broadcast' ) {
    $band_heading =     'Radio Host';
    $date_heading =     'Broadcast Date';
    $location_heading = 'FM band (Hz)';
  }

  if( $term == 'Play' ) {
    $band_heading =     'Troupe';
    $date_heading =     'Exhibition Date';
    $location_heading = 'Locale';
  }

  if( $term == 'Show' ) {
    $band_heading =     'Primary Certificate Holder';
    $date_heading =     'Exhibition Date';
    $location_heading = 'Locale';
  }

  // Set Movies to have a pseuo-term
  if( get_post_type($post->ID) == 'movie' ) {
    $term = 'Movie';
  }

  // Set up array to be returned
  $collection = array(
    'album_art'           => $album_art,
    'band'                => $band,
    'band_heading'        => $band_heading,
    'date_heading'        => $date_heading,
    'description'         => $description,
    'distribution_method' => $distribution_method,
    'listing_id'          => $listing_id,
    'location'            => $location,
    'location_heading'    => $location_heading,
    'performance_date'    => $performance_date,
    'permalink'           => $permalink,
    'publish_date'        => $publish_date,
    'slug'                => $slug,
    'term'                => $term,
    'term_permalink'      => $term_permalink,
    'title'               => $title,
    'tracklist'           => $tracklist,
    'zip_link'            => $zip_link,
  );

  return $collection;
}

/* Page Style: background image
-------------------------------------------------- */

function telco_page_style() {
  $background = get_field('background');
  $background = $background[0];
  $image = $background['image'];
  $opacity = $background['opacity'];
  $position = $background['position'];

  if( !$opacity ) { $opacity == 1; }

  if( is_singular('collection') && $image ) { ?>
  <style type="text/css">
    #container:after {
      content: "";
      background: url('<?php echo $image; ?>');
      background-attachment: fixed;
      background-repeat: repeat;
      opacity: <?php echo $opacity; ?>;
      filter: alpha( opacity=<?php echo $opacity * 100; ?>);
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      position: fixed;
      z-index: -1;
      <?php if( $position == 'cover' ) echo 'background-size: cover;'; ?>
      <?php if( $position == 'contain' ) echo 'background-size: contain;'; ?>
    }
  </style>
  <?php }
}
add_filter('wp_head','telco_page_style');

/* Body classes
-------------------------------------------------- */

function telco_body_classes($classes) {

  // Page style: text color
  if( get_field('text_color') == 'light' ) {
    $classes[] = "dark-theme";
  }

  // Add post/page slug
  if(is_single() || is_page() && !is_front_page() ) {
    $classes[] = basename( get_permalink() );
  }

  return $classes;
}
add_filter('body_class','telco_body_classes');

/* Get Movie Info
-------------------------------------------------- */

function telco_get_movie_info($post) {

  // Title and permalink
  $title     = get_the_title($post);
  $permalink = get_permalink($post);

  // Album Art
  if( get_field('album_art', $post->ID) ) {
    $video_still = wp_get_attachment_image_src( get_field('video_still'), 'thumbnail' );
    $video_still = $video_still[0];
  }

  // Defaults
  if( !$video_still ) { $video_still = 'http://placehold.it/320x320'; }

  // Set up array to be returned
  $movie = array(
    'video_still' => $video_still,
    'permalink'   => $permalink,
    'title'       => $title,
    'date'        => get_the_date('m/d/y', $post->ID)
  );

  return $movie;
}

/* Get YouTube Video Info
-------------------------------------------------- */

function telco_get_video_info($post) {

  // Set up the url for the embed code
  $youtube_id = get_sub_field('youtube_id');
  $url        = 'http://www.youtube.com/v/' . $youtube_id . '?rel=0&amp;hd=1&amp;showsearch=0&amp;version=3&amp;showinfo=0&amp;modestbranding=1';

  // Caption
  $caption = get_sub_field('caption');

  $video = array(
    'caption' => $caption,
    'url'     => $url,
  );

  return $video;
}

/* Get Phone Book Character info
-------------------------------------------------- */

function telco_get_character_info($post) {

  $permalink = get_permalink($post->ID);

  // Set up contact variables
  if( get_field('personal_info', $post->ID) ) :
    while( the_repeater_field('personal_info', $post->ID) ) {
      $photo = get_sub_field('photo');
      $photo = $photo['sizes'];
      $title = get_sub_field('title');
      $age = get_sub_field('age');
      $dob = date('o') - $age;
      $gender = get_sub_field('gender');
      $cdl = get_sub_field('cdl');
    }
  endif;

  if( get_field('field_notes') ) :
    $field_notes = get_field('field_notes');
  endif;

  if( get_field('mentioned_in') ) :
    $mentions = get_field('mentioned_in');
  endif;

  // Defaults
  if( !$photo ) {
    $photo = array(
      'thumbnail' => get_template_directory_uri() . '/assets/images/default-character-thumbnail.png',
      'medium'    => get_template_directory_uri() . '/assets/images/default-character-medium.png',
      'large'     => get_template_directory_uri() . '/assets/images/default-character-medium.png'
    );
  }
  $name = get_the_title($post->ID);

  // Set up array to be returned
  $character = array(
    'permalink'   => $permalink,
    'name'        => $name,
    'photo'       => $photo,
    'title'       => $title,
    'age'         => $age,
    'dob'         => $dob,
    'gender'      => $gender,
    'cdl'         => $cdl,
    'field_notes' => $field_notes,
    'mentions'    => $mentions,
  );

  return $character;
}

/* Filter buttons
-------------------------------------------------- */

function telco_filter_buttons($filter_terms) { ?>

  <nav class="btn-group filter" data-toggle="buttons-radio">
    <?php foreach ($filter_terms as $filter_term) :
      // Create a css class without spaces, all lowercase
      $filter_term_slug = str_replace(' ', '_', strtolower($filter_term) );
      echo '<a class="btn" href="#' . $filter_term_slug . '" data-toggle="tab">' . $filter_term . '</a>';
    endforeach; ?>
  </nav>

<?php }

/* Get Archive Tabs
 * Expects a taxonomy (required).
 * For tab panes, set $all to true (optional)
-------------------------------------------------- */

function telco_get_terms($taxonomy, $all) {
  $tabs = array();

  // Add "Movies" to array and then use
  // collection_types for the rest
  if( $taxonomy == 'catalog' ) {
    array_push($tabs, 'Movie');
    $taxonomy = 'collection_types';
  }

  $terms = get_terms($taxonomy, array(
    'orderby'     => 'slug',
    'order'       => 'ASC',
    'hide_empty'  => 0
  ));

  foreach( $terms as $term ) {
    array_push($tabs, $term->name);
  }
  sort($tabs);

  // Add an "All" pseudo-term
  if( $all == 'all' ) {
    array_unshift($tabs, 'All');
  }

  return $tabs;
}

/* Get filter tab content
-------------------------------------------------- */

function telco_get_posts_with_term($post_type, $filter_term) {
  // Make sure filter term is lowercase
  $filter_term = strtolower($filter_term);

  // Collections
  if ($post_type == 'collection') :
    if ($filter_term == 'all') :
      $args = array(
        'post_type'   => 'collection',
        'numberposts' => -1,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
      );
    else :
      $args = array(
        'post_type'   => 'collection',
        'numberposts' => -1,
        'taxonomy'    => 'collection_types',
        'term'        => $filter_term,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
      );
    endif;

  // Tracks
  elseif ($post_type == 'track') :
    if ($filter_term == 'all') :
      $args = array(
        'post_type' => 'track',
        'numberposts' => -1,
      );
    else :
      $args = array(
        'post_type' => 'track',
        'taxonomy' => 'track_types',
        'term' => $filter_term,
        'numberposts' => -1,
      );
    endif;

  // Catalog
  elseif ($post_type == 'catalog') :
    if ($filter_term == 'all') :
      $args = array(
        'post_type'   => array('collection','movie'),
        'numberposts' => -1,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
      );
    elseif ($filter_term == 'movie') :
      $args = array(
        'post_type'   => 'movie',
        'numberposts' => -1,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
      );
    else :
      $args = array(
        'post_type'   => 'collection',
        'numberposts' => -1,
        'taxonomy'    => 'collection_types',
        'term'        => $filter_term,
        'orderby'     => 'post_date',
        'order'       => 'DESC',
      );
    endif;

  endif;

  // Return filtered posts
  $filtered_posts = get_posts($args);
  return $filtered_posts;
}

/* Song of the Day
-------------------------------------------------- */

function telco_get_todays_track() {

  // Get all the published collections
  $args = array(
    'post_type'   => 'collection',
    'post_status' => 'publish',
    'numberposts' => -1,
  );
  $collections = get_posts($args);
  $linklist = array();

  while( empty($linklist) ) :
    // Choose a random collection
    $random = telco_get_random_item($collections, true);
    $collection = $random['value'];
    $collection = telco_get_collection_info($collection);
    $random_index = $random['index'];

    // Get the tracklist for said collection
    $tracklist = $collection['tracklist'];

    // Find only the tracks that have links and add them to the link list
    foreach( $tracklist as $track ) {
      if( $track['link'] ) {
        array_push($linklist, $track);
      }
    }

    // If this random collection has no links...
    if( empty($linklist) ) {
      // Remove it from the array...
      unset( $collections[$random_index] );
      // and reorder the array to start with 0
      $collections = array_values($collections);
    }
    else {
      // If there is something in the link list
      $track_item = telco_get_random_item($linklist);
      $track = telco_get_track_info( $track_item['track'] );
      $link = $track_item['link'];
    }
  endwhile;

  $todays_track = array(
    'link'           => $link,
    'track'          => $track,
    'collection'     => $collection,
  );

  return $todays_track;

}

/* Get random array item per time interval
-------------------------------------------------- */

function telco_get_random_item($array, $return_index = false) {
  $time_base = date('z'); // the day of the year
  $time_base = intval( $time_base );

  // By using the modulus operator we get a pseudo random index position
  // that is between zero and the maximal value.
  $count = count($array);
  $index = ($time_base % $count);
  $value = $array[$index];

  if( $return_index == true ) {
    // Return the random item and its index in the parent array
    $item = array(
      'index' => $index,
      'value' => $value
    );
  } else {
    $item = $value;
  }

  return $item;
}

/* Get most recent catalog items
-------------------------------------------------- */

function telco_recent_catalog_items() {
  $args = array(
    'numberposts' => 4,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => array('collection','movie'),
    'post_status' => 'publish'
  );
  $recent_catalog_items = get_posts( $args );
  return $recent_catalog_items;
}

/* Get random ads for the home page
-------------------------------------------------- */

function telco_get_random_ad() {

  // First, get all the posts in the 'image' category
  $catID = get_cat_ID( 'Image' );
  $args = array(
    'post_type'   => 'post',
    'post_status' => 'publish',
    'order'       => 'DESC',
    'category'    => $catID,
  );
  $posts = get_posts( $args );
  $images = array();
  $image_posts = array();

  // Only get posts that actually have images
  foreach( $posts as $post ) {
    if( get_field('image', $post->ID) ) {
      array_push($image_posts, $post);
    }
  }

  // Pick a random image post
  $key = array_rand($image_posts);
  $image_post = $image_posts[$key];

  $image = get_field('image', $image_post->ID);
  $title = get_the_title($image_post->ID);

  $random_ad = array(
    'image' => $image,
    'title' => $title,
  );

  return $random_ad;
}

/* Get Quote
-------------------------------------------------- */

function telco_get_todays_quote() {
  $page = get_page_by_title( 'Quotes' );
  $quotes = get_field('quotes', $page->ID);
  $todays_quote = telco_get_random_item($quotes);

  return $todays_quote;
}

/* T.E.S. background video params
-------------------------------------------------- */

function telco_get_background_video($post) {
  $background = get_field('background', $post->ID);
  $background = $background[0];

  $url = $background['video'];
  $opacity = $background['opacity'];

  // Quality: ‘default’ // or “small”, “medium”, “large”, “hd720”, “hd1080”, “highres”;
  $params = "
    isBgndMovie: {
      width: 'window',
      mute: true
    },
    opacity: '" . $opacity . "',
    ratio: '4/3',
    optimizeDisplay: true,
    loop: true,
    showControls: false,
    quality: 'large',
    bufferImg: '" . get_template_directory_uri() . "/assets/images/animations/glitter.gif',
  ";
  $params = preg_replace('/\s+/', '', $params);

  $video = array(
    'url' => $url,
    'params' => $params,
  );

  return $video;
}

/* Get latest broadcast
-------------------------------------------------- */

function telco_get_latest_broadcast() {
  $collections = get_posts(array(
    'post_type'     => 'collection',
    'post_status'   => 'publish',
    'numberposts'   => -1,
    'orderby'       => 'post_date',
    'order'         => 'DESC',
  ));

  foreach( $collections as $collection ) {
    $collection = telco_get_collection_info($collection);

    // Get the most recent radio broadcast
    if( $collection['term'] == 'Broadcast' ) {
      $latest_broadcast = $collection;
      break;
    }
  }
  return $latest_broadcast;
}

/* Phone Book posts per page
-------------------------------------------------- */

function telco_phone_book_posts_per_page( $query ) {
  if( $query->query_vars['post_type'] == 'phone_book' ) {
    $query->query_vars['posts_per_page'] = -1;
  }

  return $query;
}

if( !is_admin() ) {
  add_filter( 'pre_get_posts', 'telco_phone_book_posts_per_page' );
}

/* Get ways to ID-a-Kid
-------------------------------------------------- */

function telco_get_ways_to_id_a_kid($post_id) {
  if( get_field('id_a_kid', $post_id) ) :
    $ways = get_field('id_a_kid', $post_id);
    $ways = explode("\n", $ways);
  else :
    $ways = 'There are no ways to identify an 80 year-old kid.';
  endif;

  $count = count($ways);

  $id_a_kid = array(
    'ways'  => $ways,
    'count' => $count
  );

  return $id_a_kid;
}

/* Get Field Types
-------------------------------------------------- */

function telco_get_post_types($post_type) {
  $args = array(
    'post_type'   => $post_type,
    'numberposts' => -1,
    'orderby'     => 'title',
    'order'       => 'ASC'
  );

  // Headings
  if( $post_type == 'track' ) :
    $headings = array( 'Title', 'Type', 'Lyrics', 'Lead Sheet', 'Annotations' );
  elseif( $post_type == 'collection' ) :
    $headings = array( 'Title', 'Type', 'Art', 'Desc.', 'ID', 'Band', 'Location', 'Date', 'Tracks' );
  elseif( $post_type == 'movie' ) :
    $headings = array('Title', 'Link', 'Still' );
  elseif( $post_type == 'phone_book') :
    $headings = array( 'Name', 'Photo', 'Title', 'Age', 'Gender', 'CDL#', 'Field Notes', 'Mentioned In' );
  endif;

  $post_field = array(
    'args'     => $args,
    'headings' => $headings,
  );

  return $post_field;
}

function telco_get_post_info($post, $post_type) {
  // Tracks
  if( $post_type == 'track' ) :
    $track = telco_get_track_info($post);

    $lyrics      = ($track['lyrics'])      ? '✓' : '&times;';
    $lead_sheet  = ($track['lead_sheet'])  ? '✓' : '&times;';
    $annotations = ($track['annotations']) ? '✓' : '&times;';

    $post_info = array(
      'title'       => $track['title'],
      'term'        => $track['term'],
      'lyrics'      => $lyrics,
      'lead_sheet'  => $lead_sheet,
      'annotations' => $annotations,
    );

  // Collections
  elseif( $post_type == 'collection' ) :
    $collection = telco_get_collection_info($post);

    $album_art        = ($collection['album_art'])        ? '✓' : '&times;';
    $description      = ($collection['description'])      ? '✓' : '&times;';
    $listing_id       = ($collection['listing_id'])       ? '✓' : '&times;';
    $band             = ($collection['band'])             ? '✓' : '&times;';
    $location         = ($collection['location'])         ? '✓' : '&times;';
    $performance_date = ($collection['performance_date']) ? '✓' : '&times;';
    $tracklist        = ($collection['tracklist'])        ? '✓' : '&times;';

    $post_info = array(
      'title'            => $collection['title'],
      'term'             => $collection['term'],
      'album_art'        => $album_art,
      'description'      => $description,
      'listing_id'       => $listing_id,
      'band'             => $band,
      'location'         => $location,
      'performance_date' => $performance_date,
      'tracklist'        => $tracklist,
    );

  // Movies
  elseif( $post_type == 'movie' ) :
    $movie = telco_get_movie_info($post);

    $permalink   = ($movie['permalink'])   ? '✓' : '&times;';
    $video_still = ($movie['video_still']) ? '✓' : '&times;';

    $post_info = array(
      'title'        => $movie['title'],
      'permalink'    => $permalink,
      'video_still'  => $video_still,
    );

  // Phone Book
  elseif( $post_type == 'phone_book') :
    $character = telco_get_character_info($post);

    $photo       = ($character['photo'])       ? '✓' : '&times;';
    $title       = ($character['title'])       ? '✓' : '&times;';
    $age         = ($character['age'])         ? '✓' : '&times;';
    $gender      = ($character['gender'])      ? '✓' : '&times;';
    $cdl         = ($character['cdl'])         ? '✓' : '&times;';
    $field_notes = ($character['field_notes']) ? '✓' : '&times;';
    $mentions    = ($character['mentions'])    ? '✓' : '&times;';

    $post_info = array(
      'name'         => $character['name'],
      'photo'        => $photo,
      'title'        => $title,
      'age'          => $age,
      'gender'       => $gender,
      'cdl'          => $cdl,
      'field_notes'  => $field_notes,
      'mentions'     => $mentions,
    );
  endif;

  return $post_info;
}

?>
