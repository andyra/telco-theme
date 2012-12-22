jQuery(document).ready ($) ->

  # T.E.S. video background
  $(".video-background").mb_YTPlayer()


  # Toggle playlist
  $(".toggle-tracklist").click (e) ->
    buttonText = (if $(".tracklist").is(":visible") then "⬇ Show playlist" else "⬆ Hide playlist")
    $(".toggle-tracklist").text buttonText
    $(".tracklist").slideToggle "fast"


  # Strip the active tag when it shouldn't be there
  $(".menu-dispatch").removeClass "active" unless $("body").hasClass("blog")


  # Table Sorter
  $(".table-sortable").tablesorter
    sortList: [[0, 0]]
    cssAsc: "sorted ascending"
    cssDesc: "sorted descending"


  # FitVid on single movie
  $("#content").fitVids() if $("body").hasClass("single-movie")


  # FancyBox
  $(".fancybox").fancybox helpers:
    title:
      type: "inside"


  # Reveal the collection request form
  $("a.distribute").click (e) ->
    e.preventDefault()
    $(".request").fadeToggle "fast"
    $("html, body").animate
      scrollTop: $(".request .letter").offset().top
    , "slow"
    collectionTitle = $(".request .letter h1").text()
    $("#input_1_3").attr "value", collectionTitle


  # Rearrange Gravity form inputs
  if $("body").hasClass("single-collection")
    $("#input_1_2_1_container label").insertBefore "#input_1_2_1_container input"
    $("#input_1_2_3_container label").insertBefore "#input_1_2_3_container input"
    $("#input_1_2_4_container label").insertBefore "#input_1_2_4_container select"
    $("#input_1_2_5_container label").insertBefore "#input_1_2_5_container input"
