<div class="tab-content">
  <?php // Get list of terms to filter by
  $filter_terms = telco_get_terms('collection_types', 'all');

  foreach ($filter_terms as $filter_term) :

    // Get posts from the term
    $filter_term = strtolower($filter_term);
    $collections = telco_get_posts_with_term('collection', $filter_term); ?>

    <section class="<?php echo telco_filter_tab_classes($filter_term); ?>" id="<?php echo $filter_term; ?>">
      <ul class="archive-list unstyled">

      <?php foreach ($collections as $collection_object) :
        $collection = telco_get_collection_info($collection_object); ?>
        <li>
          <a href="<?php echo $collection['permalink']; ?>" data-date="<?php echo $collection['publish_date']; ?>">
            <img src="<?php echo $collection['album_art']['thumbnail']; ?>" alt="<?php echo $collection['title']; ?>">
            <dl>
              <dt><?php echo $collection['title']; ?></dt>
              <dd class="date"><?php echo $collection['publish_date']; ?></dd>
            </dl>
          </a>
        </li>
      <?php endforeach ?>

      </ul>
    </section>

  <?php endforeach; ?>
</div>
