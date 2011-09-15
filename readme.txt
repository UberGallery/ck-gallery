/*********************************************
*  Title:    ck-gallery.php                  *
*  Version:  .73                             *
*  Author:   Chris Kankiewicz                *
*  Email:    chris@web-geek.net              *
*  URL:      http://web-geek.net/ck-gallery  *
*********************************************/


Introduction
----------------------------------------

  CK-Gallery is a simple, yet powerful PHP photo gallery that will basically 
  manage itself for you. CK-Gallery supports .jpg, .gif & .png image types, and 
  will automatically creates thumbnails on the fly. The main feature of this 
  gallery is it automatically outputs XHTML compliant markup for inclusion on a 
  webpage. The CK-Gallery will also automatically prune it’s thumbnails, so when 
  you delete an image from the images folder, it will delete the corresponding 
  thumbnail. The gallery also creates a log file for reference and debugging.
  The CK-Gallery is licensed under the GNU General Public License version 3.0.


Included Files
----------------------------------------

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
  2. Upload your images to the gallery/ directory.
  3. Navigate to the directory where you installed the gallery and the script 
     should generate thumbnails and display your pictures.


Custom Install to Pre-Existing Webpage 
----------------------------------------

  1. If you wish to change the name or loacation of the images, thumbs, or log 
     file, open ck-gallery.php and edit the $gallerydir, $thumbsdir, and 
     $logfile variables found at the top of the script.
  2. Upload ck-gallery.php to your web server.
  3. Insert the following code to your page where you would like the gallery 
     to be displayed: <?php include_once('path-to-file/ck-gallery.php'); ?>
  4. Open up your browser and navigate to your page, this will create the 
     directory structure for you if it doesn't already exist.
  5. Upload your images to the images directory ("/gallery" by default).
  6. Refresh the page in your browser and the script should generate thumbnails 
     and display your pictures.
  
  
Customizing your Gallery
----------------------------------------
  
  The CK-Gallery comes with style elements already set up, this allows for 
  customization of the look and feel of your gallery.  All you have to do is 
  add a CSS stylesheet and you’ll be off in no time.

  This is the typical structure of the HTML output:

  <div id="gallery-wrapper">
    <div id="ck-gallery">
      <div class="gallery-box"><a href="#"><img src="#" alt="#" /></a></div>
      <div class="gallery-box"><a href="#"><img src="#" alt="#" /></a></div>
      <div class="gallery-box"><a href="#"><img src="#" alt="#" /></a></div>
    </div>
  </div>
  
    
Questions/Comments
----------------------------------------

  If you have any questions or comments, please send me an email.
    
    Chris@Web-Geek.net
  
  
Shout Outs
----------------------------------------

  Thanks go out to Dual <http://dualisanoob.com> for inadvertently inspiring me 
  to get up off my ass and program this.
  
  Also, thanks to Penguin <http://www.blastwavelabs.com> for answering questions
  throughout the entire development process!


Legal Crap
----------------------------------------

  The CK-Gallery is licensed under the GNU General Public License version 3.0.
  
  Copyright (C) 2008  Chris Kankiewicz

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
  
  
  For legal details on Thickbox, please visit http://jquery.com/demo/thickbox
  

Changelog
----------------------------------------

  [ Changes to .73 ]

    - Changed project license to GNU Public License version 3.0
      http://www.opensource.org/licenses/gpl-3.0.html
    - Updated CK-Gallery reference URL
    - Added this readme.txt file
  
  
  [ Changes to .72 ]

    - Log file now keeps old info for future viewing
    - Log file will not be written to if the script doesn't do anything