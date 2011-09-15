<?php

  $galeryDir = "gallery";           // Original images directory (No trailing slash!)
  $thumbsDir = "$galeryDir/thumbs"; // Thumbnails directory (No trailing slash!)
  $logFile   = "gallery-log.txt";   // Directory/Name of log file
  $thumbSize = 100;                 // Thumbnail width/height


  // *** DO NOT EDIT ANYTHING BELOW HERE UNLESS YOU ARE A PHP NINJA ***


  // START FUNCTIONS

  function createThumb($source,$dest,$thumb_size) {
    // Modified from http://www.findmotive.com/2006/08/29/create-square-image-thumbnails-with-php/
    $size = getimagesize($source);
    $width = $size[0];
    $height = $size[1];

    if ($width > $height) {
      $x = ceil(($width - $height) / 2 );
      $width = $height;
    } elseif($height > $width) {
      $y = ceil(($height - $width) / 2);
      $height = $width;
    }

    $new_im = ImageCreatetruecolor($thumb_size,$thumb_size);

    if (strrpos($source,'.jpg') == true) {
      $im = imagecreatefromjpeg($source);
    } elseif(strrpos($source,'.gif') == true) {
      $im = imagecreatefromgif($source);
    } elseif(strrpos($source,'.png') == true) {
      $im = imagecreatefrompng($source);
    } else {
      echo("<!-- Not a valid format. -->");
    }

    imagecopyresampled($new_im,$im,0,0,$x,$y,$thumb_size,$thumb_size,$width,$height);
    imagejpeg($new_im,$dest,80); // Thumbnail quality
  }
  
  function isImage($filename) {
    // Verifies that a file is an image
    $imgExt = array('jpg', 'gif', 'png'); // Define image types

    foreach ($imgExt as $ext) 
      if (strrpos($filename, ".$ext")) {
        return true;
      } else {
        return false;
      }
  }

  // END FUNCTIONS


  // Create log file if it does not exist, otherwise open log for writing
  if (file_exists($logFile) == false) {
    $log = fopen($logFile, "a");
    fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $logFile\n\n");
  } else {
    $log = fopen($logFile, "a");
  }

  // Create image directory if it doesn't exist
  if (file_exists($galeryDir) == false) {
    mkdir($galeryDir);
    fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $galeryDir\n");
  }

  // Create thumbnail directory if it doesn't exist
  if (file_exists($thumbsDir) == false) {
    mkdir($thumbsDir);
    fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $thumbsDir\n");
  }
  
  // Beer! The cause of, and solution to, all of lifes problems!
  
  // Opening markup
  echo("<!-- Start CK-Gallery v .82 - Created by, Chris Kankiewicz [http://web-geek.net/ck-gallery] -->\n");
  echo("<div id=\"gallery-wrapper\">\n  <div id=\"ck-gallery\">\n");
  
  $dir = opendir($galeryDir);
  while (($file = readdir($dir)) !== false) {
    // Converts file extensions to all lowercase
    if (strrpos($file,'.JPG',1) || strrpos($file,'.GIF',1) || strrpos($file,'.PNG',1)) {
      $srcfile = "$galeryDir/$file";
      $filearray = explode(".",$file);
      $pos = count($filearray) - 1;
      $filearray[$pos] = strtolower($filearray[$pos]);
      $file = implode(".",$filearray);
      $dstfile = "$galeryDir/$file";
      rename($srcfile,$dstfile); // I hate Windows
      fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  RENAMED: $srcfile to $dstfile\n");
    }
    // Create thumbnail if it doesn't already exist
    if (file_exists("$thumbsDir/$file") == false) {
      if (isImage($file)) {
        createThumb("$galeryDir/$file", "$thumbsDir/$file",$thumbSize);
        fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $thumbsDir/$file\n");
      }
    }
    // Create XHTML compliant markup
    if (isImage($file)) {
      $noExt = substr($file,0,strrpos($file,'.'));
      $altText = str_replace("_"," ",$noExt);
      echo "    <div class=\"gallery-box\" style=\"float: left;\"><a href=\"$galeryDir/$file\" title=\"$altText\" class=\"thickbox\" rel=\"photo-gallery\"><img src=\"$thumbsDir/$file\" alt=\"$altText\" style=\"margin: 5px;\" /></a></div>\n";
    }
  }

  // Closing markup
  echo("    <div class=\"clear\" style=\"clear: both;\"></div>\n");
  echo("    <div id=\"credit\" style=\"float: right;\"><small>Powered by <a href=\"http://web-geek.net/ck-gallery\" onclick=\"window.open(this.href); return false;\" onkeypress=\"window.open(this.href); return false;\">CK-Gallery</a>");
  if(file_exists("thickbox.js") || file_exists("thickbox/thickbox.js")) { // Checks if site is using Thickbox
    echo(" &amp; <a href=\"http://jquery.com/demo/thickbox\" onclick=\"window.open(this.href); return false;\" onkeypress=\"window.open(this.href); return false;\">Thickbox</a></small></div>\n");
  } else {
    echo("</small></div>\n");
  }
  echo("    <div class=\"clear\" style=\"clear: both;\"></div>\n  </div>\n</div>\n");
  echo("<!-- End CK-Gallery - Licensed under the GNU Public License version 3.0 -->");
  
  // Clean up thumbnail directory
  $dir = opendir($thumbsDir);
  while (($file = readdir($dir)) !== false) {
    if ($file !== "." && $file !== "..") {
      $size = getimagesize("$thumbsDir/$file");
      if (file_exists("$galeryDir/$file") == false || $size[0] !== $thumbSize) {
        unlink("$thumbsDir/$file");
        fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  REMOVED: $thumbsDir/$file\n");
      }
    }
  }

  fclose($log); // Close log

?>