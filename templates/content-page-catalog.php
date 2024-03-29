<section class="tab-content">
  <?php // Get list of terms to filter by
  $filter_terms = telco_get_terms('catalog', 'all');

  foreach ($filter_terms as $filter_term) :

    // Get posts from the term
    $filter_term = strtolower($filter_term);
    $catalog_objects = telco_get_posts_with_term('catalog', $filter_term); ?>

    <div class="<?php echo telco_filter_tab_classes($filter_term); ?>" id="<?php echo $filter_term; ?>">
      <ul class="thumbnails">

      <?php foreach ($catalog_objects as $post) :
        $collection = telco_get_collection_info($post); ?>
        <li>
          <a class="thumbnail" href="<?php echo $collection['permalink']; ?>">
            <img src="<?php echo $collection['album_art']['medium']; ?>" alt="<?php echo $collection['title']; ?>">
            <figcaption><?php echo $collection['title']; ?></figcaption>
          </a>
        </li>
      <?php endforeach; ?>

      </ul>
    </div>
  <?php endforeach; ?>
</section>
