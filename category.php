<h1>NW Dispatch: <?php single_cat_title(); ?></h1>

<div class="filter-categories">
  <a class="btn category-all" href="<?php echo home_url(); ?>/dispatch/">All</a>
  <?php $category = get_the_category();
  $category = $category[0]->cat_name;
  $terms = telco_get_terms('category', 'only terms');
  foreach ($terms as $term) :
    $term_slug = strtolower($term);
    $term_slug = str_replace(' ', '-', $term_slug);

    if( $category == $term ) {
      $active = ' active';
    } else {
      $active = '';
    }

    echo '<a class="btn category-' . $term_slug . $active . '" href="' . home_url() . '/dispatch/' . $term_slug . '">' . $term . '</a>';
  endforeach; ?>
</div>

<?php
if (is_category('idea'))      : get_template_part('templates/content', 'category-idea');
elseif (is_category('image')) : get_template_part('templates/content', 'category-image')
endif; ?>
