# @codekit-prepend "quantize.coffee"
# @codekit-prepend "color-tunes.coffee"


$(document).ready ->
  $(".cover-picker").on "click", (event) ->
    coverAnchor = @

    canvas = document.getElementById "album-artwork"
    image = new Image

    src = $(".cover-picker img").attr('src')

    image.src = src

    ColorTunes.launch image, canvas
