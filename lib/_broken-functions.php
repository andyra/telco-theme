<?php

/*
 * These modules do not work with the current
 * version of PHP on FatCow, but I wish they did.
 */


/* Get Track ID3 Metadata
-------------------------------------------------- */

function telco_get_track_metadata($track_link) {
  // clean up track link
  $track_link = urldecode($track_link);
  // Link must be relative *without a leading slash*, which is stupid.
  $track_link = str_replace('/assets', 'assets', $track_link);

  // Note that $track_link needs to be a relative URL for the ID3 library to work
  // Initialize getID3 engine and pull the ID3 info from the track link
  $getID3       = new getID3;
  $track_ID3    = $getID3->analyze($track_link);

  $duration     = $track_ID3['playtime_string'];
  $file_size    = $track_ID3['filesize'] / 1000000 . 'MB';
  $format       = strtoupper( $track_ID3['fileformat'] );
  $bitrate      = round( $track_ID3['audio']['bitrate'] / 1000 ) . 'kbps';
  $bitrate_mode = strtoupper( $track_ID3['audio']['bitrate_mode'] );
  $sample_rate  = round($track_ID3['audio']['bitrate'] / 1000);
  $codec        = $track_ID3['audio']['codec'];

  if( !$duration ) { $duration = '&mdash;'; }

  $track_metadata  = array(
    'duration'      => $duration,
    'file_size'     => $file_size,
    'format'        => $format,
    'bitrate'       => $bitrate,
    'bitrate_mode'  => $bitrate_mode,
    'sample_rate'   => $sample_rate,
    'codec'         => $codec,
  );

  return $track_metadata;
}

/* Get MIME type
 * Can't use this until a PEAR module is installed on the server
-------------------------------------------------- */

function BROKEN_telco_get_file_type($file_url) {
  $file_info = new finfo(FILEINFO_MIME_TYPE);
  $file_type = $file_info->buffer( file_get_contents($file_url) );

  return $file_type;
}
