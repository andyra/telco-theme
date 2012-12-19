jQuery(document).ready(function($) {

  // T.E.S. video background
  if( $(".video-background").length ) {
    $(".video-background").mb_YTPlayer();
  }

  // Tabs
  if( $('.filter') ) {
    $('.filter a[href="#all"]').addClass('active').tab('show');
    $('#all').addClass('fade in');

    // Add fade classes to tabs (they're being stripped for some reason)
    $('a[data-toggle="tab"]').on('shown', function (e) {
      $('.tab-content .active').addClass('fade in');
    });
  }

  // "Dispatch" menu item is being weird.
  // Strip the active tag when it shouldn't be there
  if( !$('body').hasClass('blog') ) {
    $('.menu-dispatch').removeClass('active');
  }

  // Reveal the collection request form
  if( $('a.distribute').length ) {
    $('a.distribute').click(function(e) {
      e.preventDefault();
      $('.request').fadeToggle('fast');
      $('html, body').animate({ scrollTop:$('.request .letter').offset().top }, 'slow');
      var collectionTitle = $('.request .letter h1').text();
      $('#input_1_3').attr('value', collectionTitle);
    });
  }

  // Table Sorter
  if( $('.table-sortable').length ) {
    $('.table-sortable').tablesorter({
      sortList: [[0,0]],
      cssAsc:  'sorted ascending',
      cssDesc: 'sorted descending',
    });
  }

  // Toggle playlist
  if( $('.toggle-tracklist') ) {
    $('.toggle-tracklist').click(function(e) {
      var buttonText = $(".tracklist").is(':visible') ? '⬇ Show playlist' : '⬆ Hide playlist';
      $('.toggle-tracklist').text(buttonText);
      $('.tracklist').slideToggle('fast');
    });
  }

  // FitVid on single movie
  if( $('body').hasClass('single-movie') ) {
    $('#content').fitVids();
  }

  // FancyBox
  if( $('.fancybox').length ) {
    $(".fancybox").fancybox({
      helpers : {
        title: {
          type: 'inside'
        }
      }
    });
  }

  // Audio player: home
  if( $('body').hasClass('home') ) {
    var a = audiojs.createAll();

    // Load in the first track
    var audio = a[0];
    audioLink = $('audio').attr('src');
    audio.load(audioLink);

    // Wrap info elements in a container
    $('.audiojs .scrubber').each(function() {
      $(this).add('.audiojs .time')
             .add('.audiojs .error-message')
             .wrapAll('<div class="info" />');
    });

    // Add currently loaded song to audio player
    var currentSong = $('audio').data('title');
    $('.audiojs .info').prepend('<div class="title">' + currentSong + '</div>');
  }

  /* Audio playlist: TES, single collection
  ================================================== */
  if( $('body').hasClass('single-collection') || $('body').hasClass('tes') ) {
    // Setup the player to autoplay the next track
    var a = audiojs.createAll({
      trackEnded: function() {
        var next = $('ol li.playing').next();
        if (!next.length) next = $('ol li').first();
        next.addClass('playing').siblings().removeClass('playing');
        $('.audiojs .title').text( next.find('.title').text() );
        audio.load($('a', next).attr('data-src'));
        audio.play();
      }
    });

    // Load in the first track
    var audio = a[0];
        first = $('ol li a').attr('data-src');
    $('ol li').first().addClass('playing');
    audio.load(first);

    // Load in a track on click
    $('ol li').click(function(e) {
      e.preventDefault();
      $(this).addClass('playing').siblings().removeClass('playing');
      audio.load($('a', this).attr('data-src'));
      audio.play();
    });

    // Wrap info elements in a container
    $('.audiojs .scrubber').each(function() {
      $(this).add('.audiojs .error-message')
             .wrapAll('<div class="info" />');
    });

    // Add currently loaded song to audio player
    var currentSong = $('.tracklist .playing .title').text();
    $('.audiojs .info').prepend('<div class="title">' + currentSong + '</div>');

    // Move the time element after the title
    $('.audiojs .time').insertAfter($('.audiojs .title'));

    // Update the current song when a new one is clicked
    $('.tracklist a').click(function() {
      var currentSong = $(this).find('.title').text();
      $('.audiojs .title').text(currentSong);
    });
  }

  // Rearrange Gravity form inputs
  if( $('body').hasClass('single-collection') ) {
    $('#input_1_2_1_container label').insertBefore('#input_1_2_1_container input');
    $('#input_1_2_3_container label').insertBefore('#input_1_2_3_container input');
    $('#input_1_2_4_container label').insertBefore('#input_1_2_4_container select');
    $('#input_1_2_5_container label').insertBefore('#input_1_2_5_container input');
  }

  /* Setlist Computer
  ================================================== */
  if( $('body').hasClass('setlist-computer') ) {
    $(":range").rangeinput();

    var leadSheetsLink = $('.view-lead-sheets');
    var leadSheetBaseUrl = leadSheetsLink.attr('href');

    // Create random setlist
    $('.computer button').click(function(e) {
      e.preventDefault();

      // clean up any existing setlist info
      $('.setlist').hide();
      $('.lead-sheets').hide();
      $('.setlist li').remove();
      $('.lead-sheets li').remove();

      // get the values set from the dom
      var numSongs      = $('input[name="songs"]').val();
      var numBleeds     = $('input[name="bleeds"]').val();
      var numStrategies = $('input[name="strategies"]').val();

      // set defaults if anything strange is entered
      if( isNaN(numSongs) )      { numSongs = 0; }
      if( isNaN(numBleeds) )     { numBleeds = 0; }
      if( isNaN(numStrategies) ) { numStrategies = 0; }

      // create empty arrays
      var allSongs = [];
      var allStrategies = [];
      var randomSongs = [];
      var randomSetlist = [];

      // add all songs to an array
      $('.all-songs li').each(function() {
        allSongs.push( $(this).html() );
      });

      // add all strategies into an array
      $('.all-strategies li').each(function() {
        allStrategies.push( $(this).text() );
      });

      // shuffle songs and strategies
      allSongs.sort(function()      { return 0.5 - Math.random() });
      allStrategies.sort(function() { return 0.5 - Math.random() });

      // Add songs to the random song array
      for( var i = 0; i < numSongs; i++ ) {
        var item = allSongs[i];

        // Add bleeds
        if( i < numBleeds ) {
          item = item + ' <span class="bleed">⤵</span>';
        }
        randomSongs.push(item);
        randomSongs.sort(function() { return 0.5 - Math.random() });
      }

      for( var i = 0; i < numSongs; i++ ) {
        var item = randomSongs[i];

        // Add strategies
        if( i < numStrategies ) {
          item = item + ' <span class="strategy">' + allStrategies[i] + '</span>';
        }

        randomSetlist.push(item);
        randomSetlist.sort(function() { return 0.5 - Math.random() });
      }

      // Add the array elements to the list
      for( i in randomSetlist ) {
        var song = randomSetlist[i];
        $('.setlist ol').append('<li>' + song + '</li>');
      }

      $('.setlist').fadeIn();

      // generate URL for lead sheets
      var tracks = [];
      $('.setlist .track-id').each(function() {
        tracks.push( $(this).text() );
      });

      url = leadSheetBaseUrl + '?tracks=' + tracks;
      leadSheetsLink.attr('href', url);

    });
  }

  /* View Setlist Lead Sheets
  -------------------------------------------------- */

  // $('.view-lead-sheets').click(function(e) {
  //   e.preventDefault();

  //   var tracks = [];
  //   $('.setlist .track-id').each(function() {
  //     tracks.push( $(this).text() );
  //   });

  //   // convert from javascript to JSON string
  //   tracks = JSON.stringify(tracks);

  //   // send the track IDs to a php function
  //   $.ajax({
  //     type: 'POST',
  //     url: 'http://localhost:8888/telefone/wp-admin/admin-ajax.php',
  //     dataType: 'JSON',
  //     cache: false,
  //     data: {
  //       'action': 'get_lead_sheets',
  //       'tracks': tracks
  //     },
  //     success: function(data) {
  //       console.log(data);
  //       var leadSheets = $(data);

  //       leadSheets.each(function() {
  //         title = $(this)[0]['title'];
  //         permalink = $(this)[0]['permalink'];
  //         leadSheet = $(this)[0]['lead_sheet'];

  //         $('.lead-sheets ul').append(
  //           '<li class="letter">' +
  //           '<h3><a href="' + permalink + '" title="View song">' + title + '</a></h3>' +
  //           '<div class="lead-sheet"></div>' +
  //           '</li>'
  //         );

  //         leadSheet.each(function{

  //         });
  //       });
  //       $('.lead-sheets').fadeIn();

  //     },
  //     error: function(errorThrown){
  //       alert('error');
  //       console.log(errorThrown);
  //     }

  //   });

  //   return false;
  // });

});
