# @codekit-prepend "quantize.coffee"

# color-tunes.coffee, Copyright 2012 Shao-Chung Chen.
# Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)

class ColorTunes
  @getColorMap: (canvas, sx, sy, w, h, nc=8) ->
    pdata = canvas.getContext("2d").getImageData(sx, sy, w, h).data
    pixels = []
    for y in [sy...(sy + h)] by 1
      indexBase = (y * w * 4)
      for x in [sx...(sx + w)] by 1
        index = (indexBase + (x * 4))
        pixels.push [pdata[index], pdata[index+1], pdata[index+2]] # [r, g, b]
    (new MMCQ).quantize pixels, nc

  @colorDist: (a, b) ->
    square = (n) -> (n * n)
    (square(a[0] - b[0]) + square(a[1] - b[1]) + square(a[2] - b[2]))

  @launch: (image, canvas) ->
    $(image).on "load", ->
      image.height = Math.round (image.height * (300 / image.width))
      image.width = 300

      canvas.width = image.width
      canvas.height = image.height + 150
      canvas.getContext("2d").drawImage image, 0, 0, image.width, image.height

      bgColorMap = ColorTunes.getColorMap canvas, 0, 0, (image.width * 0.5), (image.height), 4
      bgPalette = bgColorMap.cboxes.map (cbox) -> { count: cbox.cbox.count(), rgb: cbox.color }
      bgPalette.sort (a, b) -> (b.count - a.count)
      bgColor = bgPalette[0].rgb

      fgColorMap = ColorTunes.getColorMap canvas, 0, 0, image.width, image.height, 10
      fgPalette = fgColorMap.cboxes.map (cbox) -> { count: cbox.cbox.count(), rgb: cbox.color }
      fgPalette.sort (a, b) -> (b.count - a. count)

      maxDist = 0
      for color in fgPalette
        dist = ColorTunes.colorDist bgColor, color.rgb
        if dist > maxDist
          maxDist = dist
          fgColor = color.rgb

      maxDist = 0
      for color in fgPalette
        dist = ColorTunes.colorDist bgColor, color.rgb
        if dist > maxDist and color.rgb != fgColor
          maxDist = dist
          fgColor2 = color.rgb

      rgbToCssString = (color) ->
        "rgba(#{color[0]}, #{color[1]}, #{color[2]}, 1)"

      $("body, .wrap").css "background-color", "#{rgbToCssString bgColor}"
      $("ol li").css "color", "#{rgbToCssString fgColor2}"
      $("h2").css "color", "#{rgbToCssString fgColor}"

      $('.palette li:eq(0) .swatch').css "background-color", "#{rgbToCssString bgColor}"
      $('.palette li:eq(1) .swatch').css 'background-color', "#{rgbToCssString fgColor}"
      $('.palette li:eq(2) .swatch').css "background-color", "#{rgbToCssString fgColor2}"

$(document).ready ->
  $(".cover-picker").on "click", (event) ->
    coverAnchor = @
    canvas = document.getElementById "album-artwork"
    image = new Image
    src = $(".cover-picker img").attr('src')
    image.src = src
    ColorTunes.launch image, canvas