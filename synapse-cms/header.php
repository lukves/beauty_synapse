
<?php include_once(dirname(__FILE__).'/stage_init.php'); ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo($obj->synapse_title); echo(" - "); echo($obj->synapse_slogan); ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo($obj->synapse_dir); ?>/css/fonts.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo($obj->synapse_dir); ?>/vertical_msgs/styles/accordion.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo($obj->synapse_dir); ?>/css/like_style.css">

	<script src="<?php echo($obj->synapse_dir); ?>/js/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php echo($obj->synapse_dir);?>/js/lorie_400.font.js" type="text/javascript"></script>
	
	<script language="javascript" src="<?php echo($obj->synapse_dir); ?>/js/plugins.js" type="text/javascript"></script>
	<script language="javascript" src="<?php echo($obj->synapse_dir); ?>/js/databs.js" type="text/javascript"></script>
	<script src="<?php echo($obj->synapse_dir); ?>/js/helper.js" type="text/javascript"></script>
	<script src="<?php echo($obj->synapse_dir); ?>/js/checkform.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo($obj->synapse_dir); ?>js/js-mcrypt/Serpent.js"></script>
	<script type="text/javascript" src="<?php echo($obj->synapse_dir); ?>js/js-mcrypt/rijndael.js"></script>
	<script type="text/javascript" src="<?php echo($obj->synapse_dir); ?>js/js-mcrypt/mcrypt.js"></script>
	
        <!-- ========== IE FIX ========== -->
        <!--[if IE]><link rel="stylesheet" type="text/css" href="./synapse-cms/vertical_msgs/styles/accordion_ie.css" /><![endif]-->
    
        <!-- ========== IE6-8 TARGET FALLBACK ========== -->
        <script type="text/javascript" src="./synapse-cms/vertical_msgs/js/jquery-1.6.1.min.js"></script>
        <!--[if (gte IE 6)&(lte IE 8)]>
        <script type="text/javascript" src="./synapse-cms/vertical_msgs/js/ie-target.js"></script>
        <script type="text/javascript" src="./synapse-cms/vertical_msgs/js/selectivizr-min.js"></script>
        <noscript><link rel="stylesheet" href="./synapse-cms/vertical_msgs/styles/accordion.css" /></noscript>
        <![endif]-->

	<script type="text/javascript" src="<?php echo($obj->synapse_dir); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo($obj->synapse_dir); ?>/js/jquery.colorbox.js"></script>
	<script type="text/javascript" src="<?php echo($obj->synapse_dir); ?>/js/app.js"></script>
	
	<?php if ($obj->wisiwig==1) { ?>
		<script src="<?php echo($obj->synapse_dir); ?>/js/tinymce/js/tiny_mce/tiny_mce.js"></script>
	<?php } ?>
	
<?php include_once($obj->synapse_path.'/plugins.php'); ?>

