
// @codekit-prepend '_jquery.select2.js';

$(document).ready(function() {

  /* Change labels when a collection is set to 'broadcast'
  -------------------------------------------------- */
  function updateBroadcastLabels() {
    var collectionType = $('#acf-collection_info tbody td:eq(2) option:selected').text();
    var band = $('.acf-th-band');
    var location = $('.acf-th-location');

    if( collectionType == 'Broadcast' ) {
          band.text('Radio Host');
      location.text('Radio Station');
    }
    else if( collectionType == 'Play' ) {
          band.text('Troupe');
      location.text('Location');
    }
    else {
          band.text('Band');
      location.text('Location');
    }
  }

  // When page loads, set the labels
  updateBroadcastLabels();

  // When select box is changed, set the labels
  $('#acf-collection_info tbody td:eq(2) select').change(function() {
    updateBroadcastLabels();
  })

});

/* Add Select2 to ACF
-------------------------------------------------- */

$(document).live('acf/setup_fields', function(e, div){

  $('table .row').each(function() {
    $(this).find('select').select2({width:'100%'});
  });

});
