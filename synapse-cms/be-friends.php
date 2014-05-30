<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php session_start(); ?>
<html>
<head>
  
  <title>Synapse-CMS: Be Friends</title>
  
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 

  <meta name="description" content="Lukove">

  <link rel="shortcut icon" href="me-sketch.png">  
</head>

<style type="text/css"></style>
<link rel="stylesheet" type="text/css" href="css/empty-login.css">
<body style="background-image: url(); background-color: rgb(200, 200, 200); color: rgb(0, 0, 0);" alink="#ee0000" link="#0000ee" vlink="#551a8b">
	<?php
	if (isset($_POST['synapse-title'])) $title = htmlspecialchars($_POST['synapse-title']);
	if (isset($_POST['synapse-bodytext'])) $bodytext = htmlspecialchars($_POST['synapse-bodytext']);
	if (isset($_POST['synapse-sendto'])) $sendto = htmlspecialchars($_POST['synapse-sendto']);
	
	if ( (isset($title)) && (isset($sendto)) ) {
		if (file_exists(dirname(__FILE__).'/'.'stage_init.php')) include(dirname(__FILE__).'/'.'stage_init.php'); else 
			if (file_exists('./synapse-cms/stage_init.php')) include('./synapse-cms/stage_init.php');
		
		$obj->preview_type = 1;	

		if (!empty($_POST['login_username'])) $_SESSION['loginuser']= $obj->write_login($_POST);
	
		if ($_SESSION['loginuser']!=null) {
			$obj->write_post_friendship_data($_POST);
		} else {
			echo($obj->display_post_login($title, $bodytext, $sendto));
		}
    } else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"/index.php\">Refresh Page</a></b></center></div></div>");
	?>
<br><br><br><br><br>

</body>

</html>
