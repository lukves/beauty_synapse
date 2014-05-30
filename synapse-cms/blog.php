
<?php 
	if (file_exists(dirname(__FILE__).'/'.'stage_init.php')) include(dirname(__FILE__).'/'.'stage_init.php'); else 
		if (file_exists('./synapse-cms/stage_init.php')) include('./synapse-cms/stage_init.php');
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo($obj->synapse_title); ?> - blog</title>

	<link rel="stylesheet" type="text/css" href="./synapse-cms/css/fonts.css"/>

<link rel="stylesheet" href="css/blog.css" type="text/css" />
<link rel="stylesheet" href="./synapse-cms/css/blog.css" type="text/css" />
<style>

body {
margin:0px;
background-color: #a5a5a5;
background-image:url("blog.jpg");
background-attachment: fixed;
background-repeat: repeat;
}

.item-list .icon{color:#555;float:right;padding-left:0.25em;clear:right;}.item-list .title{font-weight:bold;}.item-list ul{margin:0 0 0.75em 0;padding:0;}.item-list ul li{margin:0 0 0.25em 1.5em;padding:0;list-style:disc;}ol.task-list li.active{font-weight:bold;}.form-item{margin-top:1em;margin-bottom:1em;}tr.odd .form-item,tr.even .form-item{margin-top:0;margin-bottom:0;white-space:nowrap;}tr.merge-down,tr.merge-down td,tr.merge-down th{border-bottom-width:0 !important;}tr.merge-up,tr.merge-up td,tr.merge-up th{border-top-width:0 !important;}.form-item input.error,.form-item textarea.error,.form-item select.error{border:2px solid red;}.form-item .description{font-size:0.85em;}.form-item label{display:block;font-weight:bold;}.form-item label.option{display:inline;font-weight:normal;}.form-checkboxes,.form-radios{margin:1em 0;}.form-checkboxes .form-item,.form-radios .form-item{margin-top:0.4em;margin-bottom:0.4em;}.marker,.form-required{color:#f00;}.more-link{text-align:right;}.more-help-link{font-size:0.85em;text-align:right;}.nowrap{white-space:nowrap;}.item-list .pager{clear:both;text-align:center;}.item-list .pager li{background-image:none;display:inline;list-style-type:none;padding:0.5em;}.pager-current{font-weight:bold;}.tips{margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-size:0.9em;}

.pager-item {margin-right:10px; margin-bottom:20px; position:relative;}
.pager-item {background:rgba(246,246,246,.5); border:1px solid rgba(146,146,146,.5); border-radius:3px; box-shadow:inset 1px 1px 3px rgba(0,0,0,.1); line-height:20px; height:20px; padding:5px 26px 5px 5px; outline:none;}
.pager-item:active,.pager-item:focus {background:rgb(255,255,255);}
.pager-item:active {border: 0; background: transparent;}
</style>
<body>
<?php
	$obj->preview_type = 0;
	
	$usr = htmlspecialchars($_GET['user']);
	
	//$crea=$_SESSION['created'];

	if(isset($_GET['user'])) {
		$avat = $obj->getimgavatar($usr); 
	} else { include("./synapse-cms/error.php"); die(""); }
		//die("<div id=logo> </div><div id=prihlasenie> Nepovolený vstup! </div>"); 
?>	
<div id="cage">
<div id="center">
<div id="sidebar"><span class="title"><a href="/"><?php echo($usr); ?></a></span><br>
<br>
<a href="index.php"><img src="<?php echo($avat); ?>" width=48px; height=48px;></a>
<br>
<br>
<?php echo($obj->getinform($usr)); ?><br>
<br>

<?php 

if (file_exists(dirname(__FILE__).'/'.'contacts.php')) include(dirname(__FILE__).'/'.'contacts.php'); else 
		if (file_exists('./synapse-cms/contacts.php')) include('./synapse-cms/contacts.php');

function list_my_image_files($dir)
{
  
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
		$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {
		  if ( (strpos($file, ".png")!==false)  ||  (strpos($file, ".jpg")!==false) || (strpos($file, ".JPG")!==false) )  if ($id<=100) echo ' <a href="'.$dir.$file.'"><img  HSPACE=5 VSPACE=5 ALIGN=LEFT border=5; width=102px; height=76px; src="'.$dir.$file.'"></a> ';
          $id++;
		}
      }
	   if ($id > 100) echo '<br><b>Next Page</b> .... ';
      closedir($handle);
    }
  }
}

?>

<br>
<br>
</div>
<div id="content">
<div id="entry">
<div id="postnotes">
<?php echo($obj->display_zero($usr)); ?>
<br />
<br />
<br />
<?php
	if ($obj->isvisible($usr)==1) {
		$mypath = "./bindata/files/" . $usr . "/";
		list_my_image_files ("$mypath");
	}
?>
<br />
<br />
<br />
<br />
</div>
</div>
</div>
</body>
</html>
