/*********************************************
*  TITLE:    ck-gallery.php                  *
*  AUTHOR:   Chris Kankiewicz                *
*  EMAIL:    Chris@Web-Geek.net              *
*  URL:      http://web-geek.net/ck-gallery  *
*********************************************/


Introduction
----------------------------------------

  CK-Gallery is a simple, yet powerful, PHP photo gallery that will basically
  manage itself for you. CK-Gallery supports .jpg, .gif & .png image types, and
  will automatically creates thumbnails on the fly. The main feature of this
  gallery is it automatically outputs XHTML compliant markup for inclusion on a
  web page. The CK-Gallery will also automatically prune it's thumbnails, so
  when you delete an image from the images folder, it will delete the
  corresponding thumbnail. The gallery also creates a log file for reference and
  debugging.  The CK-Gallery is licensed under the GNU General Public License
  version 3.0.

  With the update to version 1.0.0 CK-Gallery now has dynamic pagination.  This
  will let users with larger galleries split the gallery up into several smaller
  pages and allow visitors to easily navigate to those pages via a small
  navigation bar below the gallery.  Among other changes, GZ compression was
  implemented on the default index.php file included with the gallery, reducing
  bandwidth and improving script execution speed significantly when active.


Requirements
----------------------------------------

  Due to some of the functions used, you must have PHP version 4.0.6 or higher
  on Linux, or version 4.3.0 on Windows. Also, you must have the PHP GD version
  2.0.1 or later installed (2.0.28 or later is recommended).

  The lowest PHP version this script has been successfully tested on was a Linux
  system running PHP version 4.3.11 and PHP GD version 2.0.28, if you've got it
  to run on a lower version I'd like to know, please contact me.

  For more information on PHP GD, please see http://us.php.net/gd


Included Files
----------------------------------------

  changelog.txt   - Project change log
  ck-gallery.php  - Main script
  gallery/        - Default image directory
  gallery.css     - Gallery style sheet
  gpl_v3.txt      - Software license
  images/         - Thickbox images
  index.php       - Contains the page markup
  thickbox/       - Thickbox files
  readme.txt      - This readme file


Simple Installation
----------------------------------------

  1. Upload the entire contents of this directory to your web server in the
     directory where you would like the gallery to be displayed.
     Example: http://www.domain-name.com/photo-gallery/
  2. Upload your images to the /gallery directory.
  3. Open your web browser and navigate to the directory where you installed the
     gallery and the script should generate thumbnails and display your pictures


Install to Pre-Existing Web Page
----------------------------------------

  1. If you wish to change the name or location of the images folder, thumbnails
     folder, or log file, or you would like to enable pagination, open
     ck-gallery.php and edit the variables found in the top of the script.
  2. Upload ck-gallery.php to your web server.
  3. Insert the following code to your page where you would like the gallery
     to be displayed: <?php include_once('path-to-file/ck-gallery.php'); ?>
  4. If using pagination, copy the "Pagination" portion of gallery.css into your
     own style sheet and edit it to your liking.
  5. Open up your browser and navigate to your page, this will create the
     directory structure for you if it doesn't already exist.
  6. Upload your images to the images directory ("/gallery" by default).
  7. Refresh the page in your browser and the script should generate thumbnails
     and display your pictures.


Customizing your Gallery
----------------------------------------

  The CK-Gallery comes with class and id elements already in place, this allows
  for customization of the look and feel of your gallery.  All you have to do is
  edit the CSS style sheet, or create your own, and you'll be off in no time.

  This is the typical structure of the XHTML output:

  <div id="gallery-wrapper">
    <div id="ck-gallery">
      <div class="gallery-box"><a href="#"><img src="#" alt="#" /></a></div>
      <div class="gallery-box"><a href="#"><img src="#" alt="#" /></a></div>
      <div class="gallery-box"><a href="#"><img src="#" alt="#" /></a></div>
    </div>
  </div>

  Also, here's the pagination navigation structure:

  <ul>
    <li class="inactive">&lt;</li>
    <li class="current-page"><a href="?page=1">1</a></li>
    <li><a href="?page=2">2</a></li>
    <li><a href="?page=3">3</a></li>
    <li><a href="?page=4">4</a></li>
    <li><a href="?page=2">&gt;</a></li>
  </ul>


Pagination
----------------------------------------

  To enable pagination, open ck-gallery.php, find "$imgPerPage = 0;" at the top
  and set this value to the number of images you would like to display per page.

  NOTE: If pagination is enabled, the script will generate thumbnails on a
  per-page basis.  You do not have to worry about this though, the first time a
  visitor visits a page without thumbnails, it will automatically generate the
  thumbnails, however this may cause the page to take several seconds to load
  while this processes.


Enabling GZip Compression
----------------------------------------

  In order to improve the performance and reduce the bandwidth of your gallery,
  it's recomended that you enable gzip compression on the page for which your
  gallery is being displayed. In order to accomplish this, place the following
  code at the very beginning of the page to which the gallery will be displayed:

    <?php substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ?
    ob_start("ob_gzhandler") : ob_start(); ?>

  This code must be the very fist thing the browser loads or it will cause
  errors. See the index.php file included with the gallery for an example of how
  this code is layed out.

  NOTE: This is already enabled in the default index.php, if you are getting
  errors related to this, remove the first line of index.php and please send me
  an email noting your version of PHP and any other relevant info.


Shout Outs
----------------------------------------

  Thanks go out to Dual <http://dualisanoob.com> for inadvertently inspiring me
  to get up off my ass and program this.

  Also, thanks to Penguin <http://www.blastwavelabs.com> for answering questions
  throughout the entire development process and for some bug testing.

  Thanks also to Nak <http://www.wetwarehacks.com> for rigorous beta testing
  that helped me iron out a number of bugs and fix backwards capabilities.

  Lastly, thanks to the StackOverflow.com community for help here and there.


Questions/Comments
----------------------------------------

  If you have any questions or comments, please contact me.

    EMAIL: Chris@Web-Geek.net
    AIM:   PHLAK2600
    MSN:   Chris@ChronoStudios.com
    YIM:   ChrisKankiewicz


Legal Crap
----------------------------------------

  The CK-Gallery is licensed under the GNU General Public License version 3.0.

  Copyright (C) 2008 Chris Kankiewicz

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Thick box is not owned, operated, developed or maintained by Chris Kankiewicz
  and is in no way affiliated with CK-Gallery. For more information on Thickbox,
  please visit <http://jquery.com/demo/thickbox>.