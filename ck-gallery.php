<?php // CK-Gallery by Chris Kankiewicz <http://wwww.web-geek.com/ck-gallery>

  $galleryDir = "gallery";            // Original images directory (No trailing slash!)
  $thumbsDir  = "$galleryDir/thumbs"; // Thumbnails directory (No trailing slash!)
  $logFile    = "gallery-log.txt";    // Directory/Name of log file
  $thumbSize  = 100;                  // Thumbnail width/height in pixels
  $imgPerPage = 0;                    // Images per page (0 disables pagination)


  // *** DO NOT EDIT ANYTHING BELOW HERE UNLESS YOU ARE A PHP NINJA ***


  // START FUNCTIONS

  function createThumb($source,$dest,$thumb_size) {
  // Create thumbnail, modified from function found on http://www.findmotive.com/tag/php/
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

    @$imgInfo = getimagesize($source);

    if ($imgInfo[2] == IMAGETYPE_JPEG) {
      $im = imagecreatefromjpeg($source);
      imagecopyresampled($new_im,$im,0,0,$x,$y,$thumb_size,$thumb_size,$width,$height);
      imagejpeg($new_im,$dest,80); // Thumbnail quality (Value from 1 to 100)
    } elseif ($imgInfo[2] == IMAGETYPE_GIF) {
      $im = imagecreatefromgif($source);
      imagecopyresampled($new_im,$im,0,0,$x,$y,$thumb_size,$thumb_size,$width,$height);
      imagegif($new_im,$dest);
    } elseif ($imgInfo[2] == IMAGETYPE_PNG) {
      $im = imagecreatefrompng($source);
      imagecopyresampled($new_im,$im,0,0,$x,$y,$thumb_size,$thumb_size,$width,$height);
      imagepng($new_im,$dest);
    }
  }

  function isImage($fileName) {
  // Verifies that a file is an image
    if ($fileName !== '.' && $fileName !== '..') {
      @$imgInfo = getimagesize($fileName);

      $imgType = array(
        IMAGETYPE_JPEG,
        IMAGETYPE_GIF,
        IMAGETYPE_PNG,
      );

      if (in_array($imgInfo[2],$imgType))
        return true;
      return false;
    }
  }

  // END FUNCTIONS


  // Create log file if it does not exist, otherwise open log for writing
  if (!file_exists($logFile)) {
    $log = fopen($logFile, "a");
    fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $logFile\r\n\r\n");
  } else {
    $log = fopen($logFile, "a");
  }

  // Create image directory if it doesn't exist
  if (!file_exists($galleryDir)) {
    mkdir($galleryDir);
    fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $galleryDir\r\n");
  }

  // Create thumbnail directory if it doesn't exist
  if (!file_exists($thumbsDir)) {
    mkdir($thumbsDir);
    fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $thumbsDir\r\n");
  }

  // Clean up thumbnail directory
  if ($dirHandle = opendir($thumbsDir)) {
    while (($file = readdir($dirHandle)) !== false) {
      if (isImage("$thumbsDir/$file")) {
        $size = getimagesize("$thumbsDir/$file");
        if (!file_exists("$galleryDir/$file") || $size[0] !== $thumbSize) {
          unlink("$thumbsDir/$file");
          fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  REMOVED: $thumbsDir/$file\r\n");
        }
      }
    }
  closedir($dirHandle);
  }

  // Alcohol! The cause of, and solution to, all of life's problems!

  // Create array from gallery directory
  if ($dirHandle = opendir($galleryDir)) {
    while (($file = readdir($dirHandle)) !== false) {
      if (isImage("$galleryDir/$file")) {
        $images[] = $file;
      }
    }
  closedir($dirHandle);
  }

  // Page varriables
  $totalImages = count($images);
  if ($imgPerPage <= 0 || $imgPerPage >= $totalImages) {
    $imgStart = 0;
    $imgEnd = $totalImages;
  } elseif ($imgPerPage > 0 && $imgPerPage < $totalImages) {
    $totalPages = ceil($totalImages / $imgPerPage);
    if ($_GET['page'] < 1) {
      $currentPage = 1;
    } elseif ($_GET['page'] > $totalPages) {
      $currentPage = $totalPages;
    } else {
      $currentPage = $_GET['page'];
    }
    $imgStart = ($currentPage - 1) * $imgPerPage;
    $currentPage * $imgPerPage > $totalImages ? $imgEnd = $totalImages : $imgEnd = $currentPage * $imgPerPage;
  }

  // Opening markup
  echo("<!-- Start CK-Gallery v1.0.1 - Created by, Chris Kankiewicz [http://web-geek.net/ck-gallery] -->\r\n");
  echo("<div id=\"gallery-wrapper\">\r\n  <div id=\"ck-gallery\">\r\n");

  for ($x = $imgStart; $x < $imgEnd; $x++) {
    $filePath = "$galleryDir/$images[$x]";

    // Convert file name and extension for processing
    if (ctype_upper(pathinfo($filePath,PATHINFO_EXTENSION))
    || strpos(basename($filePath),' ') !== false
    || strpos($filePath,'.jpeg') !== false) {

      $source = "$filePath";
      $fileParts = pathinfo($filePath); // Create array of file parts
      $ext = $fileParts['extension']; // Original extension
      $name = basename($filePath, ".$ext"); // Original file name without extension
      $dir = $fileParts['dirname']; // Directory path

      // Change extension to all lowercase
      if (ctype_upper($ext)) {
        $ext = strtolower($ext);
      }

      // Convert .jpeg to .jpg
      if ($ext == 'jpeg') {
        $ext = 'jpg';
      }

      // Replace spaces with underscores
      if (strpos($name,' ') !== false) {
        $extOld = $fileParts['extension'];
        $name = str_replace(' ','_',basename($filePath, ".$extOld"));
      }

      $destination = "$dir/$name.$ext";

      // Rename file and array element
      if (rename($source,"$dir/$name.tmp")) {
        if (rename("$dir/$name.tmp",$destination)) {
          $images[$x] = "$name.$ext";
          fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  RENAMED: $source to $destination\r\n");
        }
      }
    }

    $filePath = "$galleryDir/$images[$x]";
    $thumbPath = "$thumbsDir/$images[$x]";

    // Create thumbnail if it doesn't already exist
    if (!file_exists("$thumbPath")) {
      createThumb("$filePath","$thumbPath",$thumbSize);
      fwrite($log,date("Y-m-d")." @ ".date("H:i:s")."  CREATED: $thumbsDir/$images[$x]\r\n");
    }
    // Create XHTML compliant markup
    $noExt = substr($images[$x],0,strrpos($images[$x],'.'));
    $altText = str_replace("_"," ",$noExt);
    echo "    <div class=\"gallery-box\" style=\"float: left;\"><a href=\"$filePath\" title=\"$altText\" class=\"thickbox\" rel=\"photo-gallery\"><img src=\"$thumbPath\" alt=\"$altText\" style=\"margin: 5px;\" /></a></div>\r\n";
  }

  // Clear float, create horizontal rule
  echo("    <div class=\"clear\" style=\"clear: both;\"></div><div class=\"hr\"><hr /></div>\r\n");

  // If pagination enabled, create page navigation
  if ($imgPerPage > 0 && $imgPerPage < $totalImages) {
    $pageName = basename($_SERVER["PHP_SELF"]); // Get current page file name
    echo("    <ul id=\"ck-pagination\" style=\"margin: 0 !important; padding: 0 !important;\">\r\n");

    // Previous arrow
    $previousPage = $currentPage - 1;
    echo("      <li style=\"float: left; list-style: none; margin: 0 5px 0 0 !important;\"".($currentPage > 1 ? "><a href=\"$pageName?page=$previousPage\">&lt;</a>" : " class=\"inactive\">&lt;")."</li>\r\n");

    // Page links
    for ($x = 1; $x <= $totalPages; $x++) {
      echo("      <li style=\"float: left; list-style: none; margin: 0 5px 0 0 !important;\"".($x == $currentPage ? " class=\"current-page\">$x" : "><a href=\"$pageName?page=$x\">$x</a>")."</li>\r\n");
    }

    // Next arrow
    $nextPage = $currentPage + 1;
    echo("      <li style=\"float: left; list-style: none; margin: 0 5px 0 0 !important;\"".($currentPage < $totalPages ? "><a href=\"$pageName?page=$nextPage\">&gt;</a>" : " class=\"inactive\">&gt;")."</li>\r\n");

    echo("    </ul>\r\n");
  }

  // Closing markup
  echo("    <div id=\"credit\" style=\"float: right;\">Powered by <a href=\"http://web-geek.net/ck-gallery\" target=\"_blank\">CK-Gallery</a>");
  // Display Thickbox link if site is using Thickbox
  if(file_exists("thickbox.js") || file_exists("thickbox/thickbox.js")) {
    echo(" &amp; <a href=\"http://jquery.com/demo/thickbox\" target=\"_blank\">Thickbox</a></div>\r\n");
  } else {
    echo("</div>\r\n");
  }
  echo("    <div class=\"clear\" style=\"clear: both;\"></div>\r\n  </div>\r\n</div>\r\n");
  echo("<!-- End CK-Gallery - Licensed under the GNU Public License version 3.0 -->\r\n");

  fclose($log); // Close log

?>