// Generated by CoffeeScript 1.4.0
(function() {

  jQuery(document).ready(function($) {
    var leadSheetBaseUrl, leadSheetsLink;
    if ($("body").hasClass("setlist-computer")) {
      $(":range").rangeinput();
      leadSheetsLink = $(".view-lead-sheets");
      leadSheetBaseUrl = leadSheetsLink.attr("href");
      return $(".computer button").click(function(e) {
        var allSongs, allStrategies, i, item, numBleeds, numSongs, numStrategies, randomSetlist, randomSongs, song, tracks, url;
        e.preventDefault();
        $(".setlist").hide();
        $(".lead-sheets").hide();
        $(".setlist li").remove();
        $(".lead-sheets li").remove();
        numSongs = $("input[name=\"songs\"]").val();
        numBleeds = $("input[name=\"bleeds\"]").val();
        numStrategies = $("input[name=\"strategies\"]").val();
        if (isNaN(numSongs)) {
          numSongs = 0;
        }
        if (isNaN(numBleeds)) {
          numBleeds = 0;
        }
        if (isNaN(numStrategies)) {
          numStrategies = 0;
        }
        allSongs = [];
        allStrategies = [];
        randomSongs = [];
        randomSetlist = [];
        $(".all-songs li").each(function() {
          return allSongs.push($(this).html());
        });
        $(".all-strategies li").each(function() {
          return allStrategies.push($(this).text());
        });
        allSongs.sort(function() {
          return 0.5 - Math.random();
        });
        allStrategies.sort(function() {
          return 0.5 - Math.random();
        });
        i = 0;
        while (i < numSongs) {
          item = allSongs[i];
          if (i < numBleeds) {
            item = item + " <span class=\"bleed\">⤵</span>";
          }
          randomSongs.push(item);
          randomSongs.sort(function() {
            return 0.5 - Math.random();
          });
          i++;
        }
        i = 0;
        while (i < numSongs) {
          item = randomSongs[i];
          if (i < numStrategies) {
            item = item + " <span class=\"strategy\">" + allStrategies[i] + "</span>";
          }
          randomSetlist.push(item);
          randomSetlist.sort(function() {
            return 0.5 - Math.random();
          });
          i++;
        }
        for (i in randomSetlist) {
          song = randomSetlist[i];
          $(".setlist ol").append("<li>" + song + "</li>");
        }
        $(".setlist").fadeIn();
        tracks = [];
        $(".setlist .track-id").each(function() {
          return tracks.push($(this).text());
        });
        url = leadSheetBaseUrl + "?tracks=" + tracks;
        return leadSheetsLink.attr("href", url);
      });
    }
  });

  /* --------------------------------------------
       Begin audio.coffee
  --------------------------------------------
  */


  jQuery(document).ready(function($) {
    var a, audio, audioLink, currentSong, first;
    if ($("body").hasClass("home")) {
      a = audiojs.createAll();
      audio = a[0];
      audioLink = $("audio").attr("src");
      audio.load(audioLink);
      $(".audiojs .scrubber").each(function() {
        return $(this).add(".audiojs .time").add(".audiojs .error-message").wrapAll("<div class=\"info\" />");
      });
      currentSong = $("audio").data("title");
      $(".audiojs .info").prepend("<div class=\"title\">" + currentSong + "</div>");
    }
    if ($("body").hasClass("single-collection") || $("body").hasClass("tes")) {
      a = audiojs.createAll({
        trackEnded: function() {
          var next;
          next = $("ol li.playing").next();
          if (!next.length) {
            next = $("ol li").first();
          }
          next.addClass("playing").siblings().removeClass("playing");
          $(".audiojs .title").text(next.find(".title").text());
          audio.load($("a", next).attr("data-src"));
          return audio.play();
        }
      });
      audio = a[0];
      first = $("ol li a").attr("data-src");
      $("ol li").first().addClass("playing");
      audio.load(first);
      $("ol li").click(function(e) {
        e.preventDefault();
        $(this).addClass("playing").siblings().removeClass("playing");
        audio.load($("a", this).attr("data-src"));
        return audio.play();
      });
      $(".audiojs .scrubber").each(function() {
        return $(this).add(".audiojs .error-message").wrapAll("<div class=\"info\" />");
      });
      currentSong = $(".tracklist .playing .title").text();
      $(".audiojs .info").prepend("<div class=\"title\">" + currentSong + "</div>");
      $(".audiojs .time").insertAfter($(".audiojs .title"));
      return $(".tracklist a").click(function() {
        currentSong = $(this).find(".title").text();
        return $(".audiojs .title").text(currentSong);
      });
    }
  });

  /* --------------------------------------------
       Begin main.coffee
  --------------------------------------------
  */


  jQuery(document).ready(function($) {
    $(".video-background").mb_YTPlayer();
    if (!$("body").hasClass("blog")) {
      $(".menu-dispatch").removeClass("active");
    }
    $(".table-sortable").tablesorter({
      sortList: [[0, 0]],
      cssAsc: "sorted ascending",
      cssDesc: "sorted descending"
    });
    $(".toggle-tracklist").click(function(e) {
      var buttonText;
      buttonText = ($(".tracklist").is(":visible") ? "⬇ Show playlist" : "⬆ Hide playlist");
      $(".toggle-tracklist").text(buttonText);
      return $(".tracklist").slideToggle("fast");
    });
    if ($("body").hasClass("single-movie")) {
      $("#content").fitVids();
    }
    $(".fancybox").fancybox({
      helpers: {
        title: {
          type: "inside"
        }
      }
    });
    $("a.distribute").click(function(e) {
      var collectionTitle;
      e.preventDefault();
      $(".request").fadeToggle("fast");
      $("html, body").animate({
        scrollTop: $(".request .letter").offset().top
      }, "slow");
      collectionTitle = $(".request .letter h1").text();
      return $("#input_1_3").attr("value", collectionTitle);
    });
    if ($("body").hasClass("single-collection")) {
      $("#input_1_2_1_container label").insertBefore("#input_1_2_1_container input");
      $("#input_1_2_3_container label").insertBefore("#input_1_2_3_container input");
      $("#input_1_2_4_container label").insertBefore("#input_1_2_4_container select");
      return $("#input_1_2_5_container label").insertBefore("#input_1_2_5_container input");
    }
  });

  /* --------------------------------------------
       Begin application.coffee
  --------------------------------------------
  */


}).call(this);
