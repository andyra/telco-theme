jQuery(document).ready ($) ->

  # Audio player: home
  if $("body").hasClass("home")
    a = audiojs.createAll()

    # Load in the first track
    audio = a[0]
    audioLink = $("audio").attr("src")
    audio.load audioLink

    # Wrap info elements in a container
    $(".audiojs .scrubber").each ->
      $(this).add(".audiojs .time").add(".audiojs .error-message").wrapAll "<div class=\"info\" />"


    # Add currently loaded song to audio player
    currentSong = $("audio").data("title")
    $(".audiojs .info").prepend "<div class=\"title\">" + currentSong + "</div>"

  # Audio playlist: TES, single collection
  #  ==================================================
  if $("body").hasClass("single-collection") or $("body").hasClass("tes")

    # Setup the player to autoplay the next track
    a = audiojs.createAll(trackEnded: ->
      next = $("ol li.playing").next()
      next = $("ol li").first()  unless next.length
      next.addClass("playing").siblings().removeClass "playing"
      $(".audiojs .title").text next.find(".title").text()
      audio.load $("a", next).attr("data-src")
      audio.play()
    )

    # Load in the first track
    audio = a[0]
    first = $("ol li a").attr("data-src")
    $("ol li").first().addClass "playing"
    audio.load first

    # Load in a track on click
    $("ol li").click (e) ->
      e.preventDefault()
      $(this).addClass("playing").siblings().removeClass "playing"
      audio.load $("a", this).attr("data-src")
      audio.play()


    # Wrap info elements in a container
    $(".audiojs .scrubber").each ->
      $(this).add(".audiojs .error-message").wrapAll "<div class=\"info\" />"


    # Add currently loaded song to audio player
    currentSong = $(".tracklist .playing .title").text()
    $(".audiojs .info").prepend "<div class=\"title\">" + currentSong + "</div>"

    # Move the time element after the title
    $(".audiojs .time").insertAfter $(".audiojs .title")

    # Update the current song when a new one is clicked
    $(".tracklist a").click ->
      currentSong = $(this).find(".title").text()
      $(".audiojs .title").text currentSong
