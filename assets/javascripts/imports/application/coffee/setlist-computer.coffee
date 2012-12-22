jQuery(document).ready ($) ->

  # Setlist Computer
  if $("body").hasClass("setlist-computer")
    $(":range").rangeinput()
    leadSheetsLink = $(".view-lead-sheets")
    leadSheetBaseUrl = leadSheetsLink.attr("href")

    # Create random setlist
    $(".computer button").click (e) ->
      e.preventDefault()

      # clean up any existing setlist info
      $(".setlist").hide()
      $(".lead-sheets").hide()
      $(".setlist li").remove()
      $(".lead-sheets li").remove()

      # get the values set from the dom
      numSongs = $("input[name=\"songs\"]").val()
      numBleeds = $("input[name=\"bleeds\"]").val()
      numStrategies = $("input[name=\"strategies\"]").val()

      # set defaults if anything strange is entered
      numSongs = 0  if isNaN(numSongs)
      numBleeds = 0  if isNaN(numBleeds)
      numStrategies = 0  if isNaN(numStrategies)

      # create empty arrays
      allSongs = []
      allStrategies = []
      randomSongs = []
      randomSetlist = []

      # add all songs to an array
      $(".all-songs li").each ->
        allSongs.push $(this).html()


      # add all strategies into an array
      $(".all-strategies li").each ->
        allStrategies.push $(this).text()


      # shuffle songs and strategies
      allSongs.sort ->
        0.5 - Math.random()

      allStrategies.sort ->
        0.5 - Math.random()


      # Add songs to the random song array
      i = 0

      while i < numSongs
        item = allSongs[i]

        # Add bleeds
        item = item + " <span class=\"bleed\">⤵</span>"  if i < numBleeds
        randomSongs.push item
        randomSongs.sort ->
          0.5 - Math.random()

        i++
      i = 0

      while i < numSongs
        item = randomSongs[i]

        # Add strategies
        item = item + " <span class=\"strategy\">" + allStrategies[i] + "</span>"  if i < numStrategies
        randomSetlist.push item
        randomSetlist.sort ->
          0.5 - Math.random()

        i++

      # Add the array elements to the list
      for i of randomSetlist
        song = randomSetlist[i]
        $(".setlist ol").append "<li>" + song + "</li>"
      $(".setlist").fadeIn()

      # generate URL for lead sheets
      tracks = []
      $(".setlist .track-id").each ->
        tracks.push $(this).text()

      url = leadSheetBaseUrl + "?tracks=" + tracks
      leadSheetsLink.attr "href", url
