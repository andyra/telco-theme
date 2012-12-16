<h1>
  <?php if (is_archive()) :
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    if ($term) :
      echo $term->name;
    elseif (is_post_type_archive()) :
      echo get_queried_object()->labels->name;
    elseif (is_day()) :
      printf(__('Daily Archives: %s', 'roots'), get_the_date());
    elseif (is_month()) :
      printf(__('Monthly Archives: %s', 'roots'), get_the_date('F Y'));
    elseif (is_year()) :
      printf(__('Yearly Archives: %s', 'roots'), get_the_date('Y'));
    elseif (is_author()) :
      global $post;
      $author_id = $post->post_author;
      printf(__('Author Archives: %s', 'roots'), get_the_author_meta('display_name', $author_id));
    else :
      single_cat_title();
    endif;
  endif; ?>
</h1>
