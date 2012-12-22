jQuery(document).ready ($) ->

  $(".view-lead-sheets").click (e) ->
    e.preventDefault()
    tracks = []
    $(".setlist .track-id").each ->
      tracks.push $(@).text()

    # convert from javascript to JSON string
    tracks = JSON.stringify(tracks)

    # send the track IDs to a php function
    $.ajax
      type: "POST"
      url: "http://localhost:8888/telefone/wp-admin/admin-ajax.php"
      dataType: "JSON"
      cache: false
      data:
        action: "get_lead_sheets"
        tracks: tracks

      success: (data) ->
        console.log data
        leadSheets = $(data)
        leadSheets.each ->
          title = $(@)[0]["title"]
          permalink = $(@)[0]["permalink"]
          leadSheet = $(@)[0]["lead_sheet"]
          $(".lead-sheets ul").append "<li class=\"letter\">" + "<h3><a href=\"" + permalink + "\" title=\"View song\">" + title + "</a></h3>" + "<div class=\"lead-sheet\"></div>" + "</li>"
          leadSheet.each ->
            # do stuff

        $(".lead-sheets").fadeIn()

      error: (errorThrown) ->
        alert "error"
        console.log errorThrown

    false
