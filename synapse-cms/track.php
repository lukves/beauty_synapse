<?php
// set your custom message
if (!empty($obj->track)) {
	$message =<<<DISPLAY_MESSAGE
			<a href="http://www.toplist.sk/" target="_top"><img
			src="http://toplist.sk/count.asp?id={$obj->track}" alt="TOPlist" border="0"></a>
DISPLAY_MESSAGE;
	echo ($message);
}
?>
