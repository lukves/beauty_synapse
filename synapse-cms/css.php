	<link rel="stylesheet" type="text/css" href="<?php echo($obj->synapse_dir); ?>/css/defaults.css">
	<link rel="stylesheet" type="text/css" href="<?php echo($obj->synapse_dir); ?>/css/addons.css">
	
<?php


  /* Search in ./synapse-cms/themes */
  
  $mdn = $obj->synapse_dir."/themes/";
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
				<link rel="alternate stylesheet" type="text/css" title="$dirArray[$index]" href="$mdn/$dirArray[$index]">
MESSAGE_DISPLAY;
		}
	}
  }
  
  /* Search in ./themes */
  
  $mdn = "./themes/";
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
				<link rel="alternate stylesheet" type="text/css" title="$dirArray[$index]" href="$mdn/$dirArray[$index]">
MESSAGE_DISPLAY;
		}
	}
  }
  
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
				<link rel="alternate stylesheet" type="text/css" title="$dirArray[$index]" href="$mdn/$dirArray[$index]">
MESSAGE_DISPLAY;
		}
	}
  }

  echo($css_display);

?>
