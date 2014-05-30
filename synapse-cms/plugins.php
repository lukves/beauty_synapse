<?php

  $mdn= $obj->synapse_path."plugins/";
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
				$plugins_display .= <<<MESSAGE_DISPLAY
MESSAGE_DISPLAY;
				// Loading plugin from $mdn/$dirArray[$index] <br>
				$plug = $mdn."/".$dirArray[$index]."/index.php";
				if (file_exists($plug)) include_once($plug);
			}
		}
  }
  echo($plugins_display);

?>
