<?php

/**
 * Synapse-CMS stage_buttons
 * 	php web framework for create social network
 *
 * @author Lukas Veselovsky
 * @copyright 2013 Lukas Veselovsky lukves@gmail.com
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 **/

 if ($_SESSION['loginuser']==null) {
 
      $message_display = <<<MESSAGE_DISPLAY
<style type="text/css">
.menupanel {
	font-size: 12px;
	float: right;
	width: 150px;
	padding: 0.1em;
	margin: 0.1em;
/*	border-bottom: 1px dotted black; */
	color: black;
/*	background-color: #ebebeb; */
}	
</style>
MESSAGE_DISPLAY;
	echo ("$message_display");
	echo("<input id=\"bregister\" type=\"submit\" style=\"border: 0; background: transparent;\" name=\"task\" value=\"Register\" tabindex=\"201\">");echo("&nbsp;");
	echo("<input id=\"blogin\" type=\"submit\" style=\"border: 0; background: transparent;\" name=\"task\" value=\"Login\" tabindex=\"202\">"); 
 } else {
       $message_display = <<<MESSAGE_DISPLAY
<style type="text/css">
.menupanel {
	font-size: 12px;
	float: right;
	width: 200px;
	padding: 0.1em;
	margin: 0.1em;
/*	border-bottom: 1px dotted black; */
	color: black;
/*	background-color: #ebebeb; */
}	
</style>
MESSAGE_DISPLAY;
	echo ("$message_display");
	echo("<input type=\"submit\" style=\"border: 0; background: transparent;\" name=\"task\" value=\"Logout\" tabindex=\"202\">");
	echo("<input type=\"submit\" style=\"border: 0; background: transparent;\" name=\"task\" value=\"Settings\" tabindex=\"202\">");
	//echo("<input type=\"submit\" name=\"task\" value=\"$\" tabindex=\"202\"><br>");
	//echo ($_SESSION['loginuser']);
 }
?>
