	
	<?php
		// spustam sessions, velmi dolezite
		// ak nie si prihlaseny z predoslej stranky
		if(!isset($_SESSION['loginuser'])) {
		die("<div id=logo> </div>
		<div id=prihlasenie> 
		Access denied!
		</div>");
		} else $myuser = mysql_real_escape_string($_SESSION['loginuser']); 
		
	echo($obj->display_header());

	echo $display =<<<DISPLAY_ITEM
	<center>
	<br />
<iframe src="./synapse-cms/plugins/audioplayer/files.php" scrolling=no frameborder="0" width="800" height="900">
</iframe>
<br />
<br />
<br />
DISPLAY_ITEM;
$obj->upload_myfile(0);
?>
</center>
