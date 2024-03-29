/* ==============================================================================
 * quantize.js
 * =========================================================================== */
(function() {
  var ColorTunes, MMCQ, PriorityQueue;

  PriorityQueue = (function() {

    function PriorityQueue(comparator) {
      this.comparator = comparator;
      this.contents = [];
      this.sorted = false;
    }

    PriorityQueue.prototype.sort = function() {
      this.contents.sort(this.comparator);
      return this.sotred = true;
    };

    PriorityQueue.prototype.push = function(obj) {
      this.contents.push(obj);
      return this.sorted = false;
    };

    PriorityQueue.prototype.peek = function(index) {
      if (index == null) {
        index = this.contents.length - 1;
      }
      if (!this.sorted) {
        this.sort();
      }
      return this.contents[index];
    };

    PriorityQueue.prototype.pop = function() {
      if (!this.sorted) {
        this.sort();
      }
      return this.contents.pop();
    };

    PriorityQueue.prototype.size = function() {
      return this.contents.length;
    };

    PriorityQueue.prototype.map = function(func) {
      return this.contents.map(func);
    };

    return PriorityQueue;

  })();

  MMCQ = (function() {
    var ColorBox, ColorMap, cboxFromPixels, getColorIndex, getHisto, medianCutApply,
      _this = this;

    MMCQ.sigbits = 5;

    MMCQ.rshift = 8 - MMCQ.sigbits;

    function MMCQ() {
      this.maxIterations = 1000;
      this.fractByPopulations = 0.75;
    }

    getColorIndex = function(r, g, b) {
      return (r << (2 * MMCQ.sigbits)) + (g << MMCQ.sigbits) + b;
    };

    ColorBox = (function() {

      function ColorBox(r1, r2, g1, g2, b1, b2, histo) {
        this.r1 = r1;
        this.r2 = r2;
        this.g1 = g1;
        this.g2 = g2;
        this.b1 = b1;
        this.b2 = b2;
        this.histo = histo;
      }

      ColorBox.prototype.volume = function(forced) {
        if (!this._volume || forced) {
          this._volume = (this.r2 - this.r1 + 1) * (this.g2 - this.g1 + 1) * (this.b2 - this.b1 + 1);
        }
        return this._volume;
      };

      ColorBox.prototype.count = function(forced) {
        var b, g, index, numpix, r, _i, _j, _k, _ref, _ref1, _ref2, _ref3, _ref4, _ref5;
        if (!this._count_set || forced) {
          numpix = 0;
          for (r = _i = _ref = this.r1, _ref1 = this.r2; _i <= _ref1; r = _i += 1) {
            for (g = _j = _ref2 = this.g1, _ref3 = this.g2; _j <= _ref3; g = _j += 1) {
              for (b = _k = _ref4 = this.b1, _ref5 = this.b2; _k <= _ref5; b = _k += 1) {
                index = getColorIndex(r, g, b);
                numpix += this.histo[index] || 0;
              }
            }
          }
          this._count_set = true;
          this._count = numpix;
        }
        return this._count;
      };

      ColorBox.prototype.copy = function() {
        return new ColorBox(this.r1, this.r2, this.g1, this.g2, this.b1, this.b2, this.histo);
      };

      ColorBox.prototype.average = function(forced) {
        var b, bsum, g, gsum, hval, index, mult, r, rsum, total, _i, _j, _k, _ref, _ref1, _ref2, _ref3, _ref4, _ref5;
        if (!this._average || forced) {
          mult = 1 << (8 - MMCQ.sigbits);
          total = 0;
          rsum = 0;
          gsum = 0;
          bsum = 0;
          for (r = _i = _ref = this.r1, _ref1 = this.r2; _i <= _ref1; r = _i += 1) {
            for (g = _j = _ref2 = this.g1, _ref3 = this.g2; _j <= _ref3; g = _j += 1) {
              for (b = _k = _ref4 = this.b1, _ref5 = this.b2; _k <= _ref5; b = _k += 1) {
                index = getColorIndex(r, g, b);
                hval = this.histo[index] || 0;
                total += hval;
                rsum += hval * (r + 0.5) * mult;
                gsum += hval * (g + 0.5) * mult;
                bsum += hval * (b + 0.5) * mult;
              }
            }
          }
          if (total) {
            this._average = [~~(rsum / total), ~~(gsum / total), ~~(bsum / total)];
          } else {
            this._average = [~~(mult * (this.r1 + this.r2 + 1) / 2), ~~(mult * (this.g1 + this.g2 + 1) / 2), ~~(mult * (this.b1 + this.b2 + 1) / 2)];
          }
        }
        return this._average;
      };

      ColorBox.prototype.contains = function(pixel) {
        var b, g, r;
        r = pixel[0] >> MMCQ.rshift;
        g = pixel[1] >> MMCQ.rshift;
        b = pixel[2] >> MMCQ.rshift;
        return ((this.r1 <= r && r <= this.r2)) && ((this.g1 <= g && g <= this.g2)) && ((this.b1 <= b && b <= this.b2));
      };

      return ColorBox;

    })();

    ColorMap = (function() {

      function ColorMap() {
        this.cboxes = new PriorityQueue(function(a, b) {
          var va, vb;
          va = a.count() * a.volume();
          vb = b.count() * b.volume();
          if (va > vb) {
            return 1;
          } else if (va < vb) {
            return -1;
          } else {
            return 0;
          }
        });
      }

      ColorMap.prototype.push = function(cbox) {
        return this.cboxes.push({
          cbox: cbox,
          color: cbox.average()
        });
      };

      ColorMap.prototype.palette = function() {
        return this.cboxes.map(function(cbox) {
          return cbox.color;
        });
      };

      ColorMap.prototype.size = function() {
        return this.cboxes.size();
      };

      ColorMap.prototype.map = function(color) {
        var i, _i, _ref;
        for (i = _i = 0, _ref = this.cboxes.size(); _i < _ref; i = _i += 1) {
          if (this.cboxes.peek(i).cbox.contains(color)) {
            return this.cboxes.peek(i).color;
          }
          return this.nearest(color);
        }
      };

      ColorMap.prototype.cboxes = function() {
        return this.cboxes;
      };

      ColorMap.prototype.nearest = function(color) {
        var dist, i, minDist, retColor, square, _i, _ref;
        square = function(n) {
          return n * n;
        };
        minDist = 1e9;
        for (i = _i = 0, _ref = this.cboxes.size(); _i < _ref; i = _i += 1) {
          dist = Math.sqrt(square(color[0] - this.cboxes.peek(i).color[0]) + square(color[1] - this.cboxes.peek(i).color[1]) + square(color[2] - this.cboxes.peek(i).color[2]));
          if (dist < minDist) {
            minDist = dist;
            retColor = this.cboxes.peek(i).color;
          }
        }
        return retColor;
      };

      return ColorMap;

    })();

    getHisto = function(pixels) {
      var b, g, histo, histosize, index, pixel, r, _i, _len;
      histosize = 1 << (3 * MMCQ.sigbits);
      histo = new Array(histosize);
      for (_i = 0, _len = pixels.length; _i < _len; _i++) {
        pixel = pixels[_i];
        r = pixel[0] >> MMCQ.rshift;
        g = pixel[1] >> MMCQ.rshift;
        b = pixel[2] >> MMCQ.rshift;
        index = getColorIndex(r, g, b);
        histo[index] = (histo[index] || 0) + 1;
      }
      return histo;
    };

    cboxFromPixels = function(pixels, histo) {
      var b, bmax, bmin, g, gmax, gmin, pixel, r, rmax, rmin, _i, _len;
      rmin = 1e6;
      rmax = 0;
      gmin = 1e6;
      gmax = 0;
      bmin = 1e6;
      bmax = 0;
      for (_i = 0, _len = pixels.length; _i < _len; _i++) {
        pixel = pixels[_i];
        r = pixel[0] >> MMCQ.rshift;
        g = pixel[1] >> MMCQ.rshift;
        b = pixel[2] >> MMCQ.rshift;
        if (r < rmin) {
          rmin = r;
        } else if (r > rmax) {
          rmax = r;
        }
        if (g < gmin) {
          gmin = g;
        } else if (g > gmax) {
          gmax = g;
        }
        if (b < bmin) {
          bmin = b;
        } else if (b > bmax) {
          bmax = b;
        }
      }
      return new ColorBox(rmin, rmax, gmin, gmax, bmin, bmax, histo);
    };

    medianCutApply = function(histo, cbox) {
      var b, bw, doCut, g, gw, index, lookaheadsum, maxw, partialsum, r, rw, sum, total, _i, _j, _k, _l, _m, _n, _o, _p, _q, _ref, _ref1, _ref10, _ref11, _ref12, _ref13, _ref14, _ref15, _ref16, _ref17, _ref2, _ref3, _ref4, _ref5, _ref6, _ref7, _ref8, _ref9;
      if (!cbox.count()) {
        return;
      }
      if (cbox.count() === 1) {
        return [cbox.copy()];
      }
      rw = cbox.r2 - cbox.r1 + 1;
      gw = cbox.g2 - cbox.g1 + 1;
      bw = cbox.b2 - cbox.b1 + 1;
      maxw = Math.max(rw, gw, bw);
      total = 0;
      partialsum = [];
      lookaheadsum = [];
      if (maxw === rw) {
        for (r = _i = _ref = cbox.r1, _ref1 = cbox.r2; _i <= _ref1; r = _i += 1) {
          sum = 0;
          for (g = _j = _ref2 = cbox.g1, _ref3 = cbox.g2; _j <= _ref3; g = _j += 1) {
            for (b = _k = _ref4 = cbox.b1, _ref5 = cbox.b2; _k <= _ref5; b = _k += 1) {
              index = getColorIndex(r, g, b);
              sum += histo[index] || 0;
            }
          }
          total += sum;
          partialsum[r] = total;
        }
      } else if (maxw === gw) {
        for (g = _l = _ref6 = cbox.g1, _ref7 = cbox.g2; _l <= _ref7; g = _l += 1) {
          sum = 0;
          for (r = _m = _ref8 = cbox.r1, _ref9 = cbox.r2; _m <= _ref9; r = _m += 1) {
            for (b = _n = _ref10 = cbox.b1, _ref11 = cbox.b2; _n <= _ref11; b = _n += 1) {
              index = getColorIndex(r, g, b);
              sum += histo[index] || 0;
            }
          }
          total += sum;
          partialsum[g] = total;
        }
      } else {
        for (b = _o = _ref12 = cbox.b1, _ref13 = cbox.b2; _o <= _ref13; b = _o += 1) {
          sum = 0;
          for (r = _p = _ref14 = cbox.r1, _ref15 = cbox.r2; _p <= _ref15; r = _p += 1) {
            for (g = _q = _ref16 = cbox.g1, _ref17 = cbox.g2; _q <= _ref17; g = _q += 1) {
              index = getColorIndex(r, g, b);
              sum += histo[index] || 0;
            }
          }
          total += sum;
          partialsum[b] = total;
        }
      }
      partialsum.forEach(function(d, i) {
        return lookaheadsum[i] = total - d;
      });
      doCut = function(color) {
        var cbox1, cbox2, count2, d2, dim1, dim2, i, left, right, _r, _ref18, _ref19;
        dim1 = color + '1';
        dim2 = color + '2';
        for (i = _r = _ref18 = cbox[dim1], _ref19 = cbox[dim2]; _r <= _ref19; i = _r += 1) {
          if (partialsum[i] > (total / 2)) {
            cbox1 = cbox.copy();
            cbox2 = cbox.copy();
            left = i - cbox[dim1];
            right = cbox[dim2] - i;
            if (left <= right) {
              d2 = Math.min(cbox[dim2] - 1, ~~(i + right / 2));
            } else {
              d2 = Math.max(cbox[dim1], ~~(i - 1 - left / 2));
            }
            while (!partialsum[d2]) {
              d2++;
            }
            count2 = lookaheadsum[d2];
            while (!count2 && partialsum[d2 - 1]) {
              count2 = lookaheadsum[--d2];
            }
            cbox1[dim2] = d2;
            cbox2[dim1] = cbox1[dim2] + 1;
            // console.log("cbox counts: " + (cbox.count()) + ", " + (cbox1.count()) + ", " + (cbox2.count()));
            return [cbox1, cbox2];
          }
        }
      };
      if (maxw === rw) {
        return doCut("r");
      }
      if (maxw === gw) {
        return doCut("g");
      }
      if (maxw === bw) {
        return doCut("b");
      }
    };

    MMCQ.prototype.quantize = function(pixels, maxcolors) {
      var cbox, cmap, histo, iter, pq, pq2,
        _this = this;
      if ((!pixels.length) || (maxcolors < 2) || (maxcolors > 256)) {
        console.log("invalid arguments");
        return false;
      }
      histo = getHisto(pixels);
      cbox = cboxFromPixels(pixels, histo);
      pq = new PriorityQueue(function(a, b) {
        var va, vb;
        va = a.count();
        vb = b.count();
        if (va > vb) {
          return 1;
        } else if (va < vb) {
          return -1;
        } else {
          return 0;
        }
      });
      pq.push(cbox);
      iter = function(lh, target) {
        var cbox1, cbox2, cboxes, ncolors, niters;
        ncolors = 1;
        niters = 0;
        while (niters < _this.maxIterations) {
          cbox = lh.pop();
          if (!cbox.count()) {
            lh.push(cbox);
            niters++;
            continue;
          }
          cboxes = medianCutApply(histo, cbox);
          cbox1 = cboxes[0];
          cbox2 = cboxes[1];
          if (!cbox1) {
            console.log("cbox1 not defined; shouldn't happen");
            return;
          }
          lh.push(cbox1);
          if (cbox2) {
            lh.push(cbox2);
            ncolors++;
          }
          if (ncolors >= target) {
            return;
          }
          if ((niters++) > _this.maxIterations) {
            console.log("infinite loop; perhaps too few pixels");
            return;
          }
        }
      };
      iter(pq, this.fractByPopulations * maxcolors);
      pq2 = new PriorityQueue(function(a, b) {
        var va, vb;
        va = a.count() * a.volume();
        vb = b.count() * b.volume();
        if (va > vb) {
          return 1;
        } else if (va < vb) {
          return -1;
        } else {
          return 0;
        }
      });
      while (pq.size()) {
        pq2.push(pq.pop());
      }
      iter(pq2, maxcolors - pq2.size());
      cmap = new ColorMap;
      while (pq2.size()) {
        cmap.push(pq2.pop());
      }
      return cmap;
    };

    return MMCQ;

  }).call(this);

  /* ==============================================================================
   * color-tunes.js
   * =========================================================================== */

  ColorTunes = (function() {

    function ColorTunes() {}

    ColorTunes.getColorMap = function(canvas, sx, sy, w, h, nc) {
      var index, indexBase, pdata, pixels, x, y, _i, _j, _ref, _ref1;
      if (nc == null) {
        nc = 8;
      }
      pdata = canvas.getContext("2d").getImageData(sx, sy, w, h).data;
      pixels = [];
      for (y = _i = sy, _ref = sy + h; _i < _ref; y = _i += 1) {
        indexBase = y * w * 4;
        for (x = _j = sx, _ref1 = sx + w; _j < _ref1; x = _j += 1) {
          index = indexBase + (x * 4);
          pixels.push([pdata[index], pdata[index + 1], pdata[index + 2]]);
        }
      }
      return (new MMCQ).quantize(pixels, nc);
    };

    ColorTunes.colorDist = function(a, b) {
      var square;
      square = function(n) {
        return n * n;
      };
      return square(a[0] - b[0]) + square(a[1] - b[1]) + square(a[2] - b[2]);
    };

    ColorTunes.launch = function(image) {

      var canvas = document.createElement('canvas');

      return $(image).on("load", function() {
        var backgroundColor, bgColorMap, bgPalette, color, dist, foregroundColor, accentColor, fgColorMap, fgPalette, maxDist, rgbToCssString, _i, _j, _len, _len1;
        image.height = Math.round(image.height * (300 / image.width));
        image.width = 300;
        canvas.width = image.width;
        canvas.height = image.height + 150;
        canvas.getContext("2d").drawImage(image, 0, 0, image.width, image.height);
        bgColorMap = ColorTunes.getColorMap(canvas, 0, 0, image.width * 0.5, image.height, 4);
        bgPalette = bgColorMap.cboxes.map(function(cbox) {
          return {
            count: cbox.cbox.count(),
            rgb: cbox.color
          };
        });
        bgPalette.sort(function(a, b) {
          return b.count - a.count;
        });
        backgroundColor = bgPalette[0].rgb;
        fgColorMap = ColorTunes.getColorMap(canvas, 0, 0, image.width, image.height, 10);
        fgPalette = fgColorMap.cboxes.map(function(cbox) {
          return {
            count: cbox.cbox.count(),
            rgb: cbox.color
          };
        });
        fgPalette.sort(function(a, b) {
          return b.count - a.count;
        });
        maxDist = 0;
        for (_i = 0, _len = fgPalette.length; _i < _len; _i++) {
          color = fgPalette[_i];
          dist = ColorTunes.colorDist(backgroundColor, color.rgb);
          if (dist > maxDist) {
            maxDist = dist;
            foregroundColor = color.rgb;
          }
        }
        maxDist = 0;
        for (_j = 0, _len1 = fgPalette.length; _j < _len1; _j++) {
          color = fgPalette[_j];
          dist = ColorTunes.colorDist(backgroundColor, color.rgb);
          if (dist > maxDist && color.rgb !== foregroundColor) {
            maxDist = dist;
            accentColor = color.rgb;
          }
        }

        rgbToCssString = function(color, opacity) {
          return "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + "," + opacity + ")";
        };

        // Check the contrast between foreground and background
        contrastBetween = function(foregroundColor, backgroundColor) {
          var Li, L2, contrast;

          L1 = 0.2126 * Math.pow(foregroundColor[0]/255, 2.2) +
               0.7152 * Math.pow(foregroundColor[1]/255, 2.2) +
               0.0722 * Math.pow(foregroundColor[2]/255, 2.2);
          L2 = 0.2126 * Math.pow(backgroundColor[0]/255, 2.2) +
               0.7152 * Math.pow(backgroundColor[1]/255, 2.2) +
               0.0722 * Math.pow(backgroundColor[2]/255, 2.2);

          if (L1 > L2) {
            contrast = (L1 + 0.05) / (L2 + 0.05);
          } else {
            contrast = (L2 + 0.05) / (L1 + 0.05);
          }

          if (contrast < 5) {
            return 'low';
          }
          return 'normal';
        }

        isDark = function(color) {
          var yiq = ((color[0] * 299) +
                     (color[1] * 587) +
                     (color[2] * 114)) / 1000;

          return (yiq <= 128) ? 'dark' : 'light;';
        }

        getDefaultColors = function(color) {
          if (contrastBetween(color, backgroundColor) == 'low') {
            var defaultColor = (isDark(backgroundColor) == 'dark') ? [222, 224, 223] : [54,58,57];
            return defaultColor;
          }
          return color;
        }

        // Set default colors if there's not enough contrast
        foregroundColor = getDefaultColors(foregroundColor);
        accentColor = getDefaultColors(accentColor);

        // Create style rules
        var style =
            'body { background-color: ' + rgbToCssString(backgroundColor, 1) + '}' +
            'h1, .tracklist li { color: ' + rgbToCssString(foregroundColor, 1) + '}' +
            '.tracklist li:before, .tracklist .duration, .tracklist .bleed, .audiojs .title { color: ' + rgbToCssString(accentColor, 1) + '}' +
            '.audiojs { background-color: ' + rgbToCssString(accentColor, .1) + '}' +
            '.audiojs .played { color: ' + rgbToCssString(accentColor, .5) + '}' +
            '.audiojs .duration { color: ' + rgbToCssString(accentColor, .75) + '}' +
            '.audiojs .play-pause p { border-right-color: ' + rgbToCssString(accentColor, .5) + '}';
            '.audiojs .play-pause p:hover { border-right-color: ' + rgbToCssString(accentColor, 1) + '}';


        if (isDark(backgroundColor) == 'dark') {
          style += 'h1 { text-shadow: 0 -1px 0 rgba(0,0,0,.5); }';
        } else {
          style += 'h1 { text-shadow: 0 1px 0 rgba(255,255,255,.5); }';
        }

        // Create style tag and insert in head
        var styleTag = document.createElement("style");
            styleTag.type = "text/css";
            styleTag.innerHTML = style; // Replace with CSS code.
        $('head').append(styleTag);

        return;
      });
    };

    return ColorTunes;

  })();

  // Get the image to match the colors to
  $(document).ready(function() {
    var image, imageSource

    image = new Image;
    imageSource = $(".album-art img").attr('src');
    if (imageSource != undefined) {
      image.src = imageSource;
      ColorTunes.launch(image);
    }
  });

}).call(this);
