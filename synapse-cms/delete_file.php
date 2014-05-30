<?php

    session_start();
		// spustam sessions, velmi dolezite
		// ak nie si prihlaseny z predoslej stranky
		if(!isset($_SESSION['loginuser'])) {
		die("<div id=logo> </div>
		<div id=prihlasenie> 
		Nepovolený vstup!
		</div>");
		} else $myuser = $_SESSION['loginuser']; 
	
	$file = $_GET['filename'];
	if(file_exists("../".$file)) {
	unlink("../".$file);
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
	else { 
		//include("header.php");
		echo "Error in Delete file !!!"; }

?>
