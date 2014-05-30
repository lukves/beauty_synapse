
<?php


  $css_display  = "";

  /* Search in ./bindata/files/$LOGINUSER/ */
  
  $mdn = $obj->upload_dir."/".$_SESSION['loginuser']."/";
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
		$t1 = ".css";
		//// test for BAD words
		if (strpos($dirArray[$index],$t1)!==false) {
			$css_display .= <<<MESSAGE_DISPLAY
				<option value="$dirArray[$index]">$dirArray[$index]</option>
MESSAGE_DISPLAY;
		}
	}
  }
  
  echo($css_display);

?>
