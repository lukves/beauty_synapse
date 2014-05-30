<?php 

if (file_exists(dirname(__FILE__).'/'.'config.php')) {
  include_once('./synapse-cms/header.php'); 

	// this is important!!!
  $_SESSION['loader']=1;

  // $_SERVER['SERVER_NAME'].
  
  $mdn= "./t/";
  $myDirectory = opendir($mdn.".");
  // get each entry
  while($entryName = readdir($myDirectory)) {
	$dirArray[] = $entryName;
  }
  closedir($myDirectory);
  // count elements in array
  $indexCount	= count($dirArray);
  //Print ("$indexCount files<br>\n");
  sort($dirArray);
  // loop through the array of files and print them all
  for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArray[$index]", 0, 1) != ".") { // don't list hidden files
			if (is_dir($mdn."/".$dirArray[$index])) {
				$template_display .= <<<MESSAGE_DISPLAY
MESSAGE_DISPLAY;
				// Loading plugin from $mdn/$dirArray[$index] <br>
				$pag = $mdn."/".$dirArray[$index]."/index.php";
				//echo($pag);
				$testpag = "./t//".$obj->template."/index.php";
				//echo($testpag);
				if ($pag==$testpag) include($pag);
			}
		}
  }
  echo($template_display);
} else {
	include(dirname(__FILE__).'/'.'synapse-cms/setup-config.php');
}

?>
