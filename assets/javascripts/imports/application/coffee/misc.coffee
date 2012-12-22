jQuery(document).ready ($) ->

  # T.E.S. video background
  if $(".video-background").length
    $(".video-background").mb_YTPlayer()

  # "Dispatch" menu item is being weird.
  # Strip the active tag when it shouldn't be there
  $(".menu-dispatch").removeClass "active"  unless $("body").hasClass("blog")

  # Reveal the collection request form
  if $("a.distribute").length
    $("a.distribute").click (e) ->
      e.preventDefault()
      $(".request").fadeToggle "fast"
      $("html, body").animate
        scrollTop: $(".request .letter").offset().top
      , "slow"
      collectionTitle = $(".request .letter h1").text()
      $("#input_1_3").attr "value", collectionTitle


  # Table Sorter
  if $(".table-sortable").length
    $(".table-sortable").tablesorter
      sortList: [[0, 0]]
      cssAsc: "sorted ascending"
      cssDesc: "sorted descending"


  # Toggle playlist
  if $(".toggle-tracklist")
    $(".toggle-tracklist").click (e) ->
      buttonText = (if $(".tracklist").is(":visible") then "⬇ Show playlist" else "⬆ Hide playlist")
      $(".toggle-tracklist").text buttonText
      $(".tracklist").slideToggle "fast"


  # FitVid on single movie
  $("#content").fitVids()  if $("body").hasClass("single-movie")

  # FancyBox
  if $(".fancybox").length
    $(".fancybox").fancybox helpers:
      title:
        type: "inside"

  # Rearrange Gravity form inputs
  if $("body").hasClass("single-collection")
    $("#input_1_2_1_container label").insertBefore "#input_1_2_1_container input"
    $("#input_1_2_3_container label").insertBefore "#input_1_2_3_container input"
    $("#input_1_2_4_container label").insertBefore "#input_1_2_4_container select"
    $("#input_1_2_5_container label").insertBefore "#input_1_2_5_container input"

# View Setlist Lead Sheets
#  --------------------------------------------------

# $('.view-lead-sheets').click(function(e) {
#   e.preventDefault();

#   var tracks = [];
#   $('.setlist .track-id').each(function() {
#     tracks.push( $(this).text() );
#   });

#   // convert from javascript to JSON string
#   tracks = JSON.stringify(tracks);

#   // send the track IDs to a php function
#   $.ajax({
#     type: 'POST',
#     url: 'http://localhost:8888/telefone/wp-admin/admin-ajax.php',
#     dataType: 'JSON',
#     cache: false,
#     data: {
#       'action': 'get_lead_sheets',
#       'tracks': tracks
#     },
#     success: function(data) {
#       console.log(data);
#       var leadSheets = $(data);

#       leadSheets.each(function() {
#         title = $(this)[0]['title'];
#         permalink = $(this)[0]['permalink'];
#         leadSheet = $(this)[0]['lead_sheet'];

#         $('.lead-sheets ul').append(
#           '<li class="letter">' +
#           '<h3><a href="' + permalink + '" title="View song">' + title + '</a></h3>' +
#           '<div class="lead-sheet"></div>' +
#           '</li>'
#         );

#         leadSheet.each(function{

#         });
#       });
#       $('.lead-sheets').fadeIn();

#     },
#     error: function(errorThrown){
#       alert('error');
#       console.log(errorThrown);
#     }

#   });

#   return false;
# });
