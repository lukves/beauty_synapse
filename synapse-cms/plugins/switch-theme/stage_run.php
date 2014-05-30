	
	<?php
		// spustam sessions, velmi dolezite
		// ak nie si prihlaseny z predoslej stranky
		if(!isset($_SESSION['loginuser'])) {
		die("<div id=logo> </div>
		<div id=prihlasenie> 
		Access denied!
		</div>");
		} else $myuser = mysql_real_escape_string($_SESSION['loginuser']); 
	?>
	
<?php
 // $_SERVER['SERVER_NAME'].
if ($obj->isadmin($myuser)==1) {
  /*
   * if is request for change template
   * 		is very dangerous becouse is write to config
   * 		
   */

  echo("<center><b><big>Change Template</big></b></center>");

  $mdn= "./t/";
  $myDirectory = opendir($mdn.".");
  // get each entry
  while($entryName = readdir($myDirectory)) {
	$adirArray[] = $entryName;
  }
  closedir($myDirectory);
  // count elements in array
  $indexCount	= count($adirArray);
  //Print ("$indexCount files<br>\n");
  sort($adirArray);
  // loop through the array of files and print them all
  for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArray[$index]", 0, 1) != ".") { // don't list hidden files
			if (is_dir($mdn."/".$adirArray[$index])) {
			   /*
				* list templates from the templates folder
				*/
				if ( (!empty($_GET['theme']))&&($_GET['theme']==$adirArray[$index]) )
				{
					//read the entire string
					$str=implode("\n",file('./config.php'));

					$fp=fopen('./config.php','w');
					$str=str_replace($obj->template,$_GET['theme'],$str);

					//now, TOTALLY rewrite the file
					fwrite($fp,$str,strlen($str));
				}
				$template_display .= <<<MESSAGE_DISPLAY
MESSAGE_DISPLAY;
				// Loading plugin from $mdn/$dirArray[$index] <br>
				$pag = $mdn."/".$adirArray[$index]."/info.php";
				//echo($pag);
				include($pag); echo("<br><hr><br><br>");
			}
		}
  }
	echo($template_display);
} else echo ("<div id=prihlasenie>Access denied!</div>");
?>

