<?php ob_start("ob_gzhandler"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>CK Gallery</title>
  <link href="gallery.css" rel="stylesheet" type="text/css" media="screen" />
  <!-- THICKBOX -->
  <script type="text/javascript" src="thickbox/jquery.js"></script>
  <script type="text/javascript" src="thickbox/thickbox.js"></script>
  <link rel="stylesheet" href="thickbox/thickbox.css" type="text/css" media="screen" />
  <!-- /THICKBOX -->
</head>

<body>

<?php include_once('ck-gallery.php'); ?>

</body>

</html>
<?php ob_flush(); ?>