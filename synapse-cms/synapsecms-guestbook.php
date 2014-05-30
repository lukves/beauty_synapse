<?php

/**
The MIT License (MIT)

Copyright (c) 2013 Lukas Veselovsky

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
**/

class Synapse_guestbook {

	// BEGIN OF

	var $synapse_dir;

	var $host;
	var $username;
	var $password;
	var $table;

	
function __construct() {
    //print "SYNAPSE-CMS-GUESTBOOK <br>";  // Initialize 
}
	
// NOTE: zobraz login dialog..
//		<div class="toolbar">
//		<button type="button" class="fbutton" accesskey="b" id="addbbcode0_0" style="width: 30px" onclick="bbstyle(0, 0); return false"><span style="font-weight: bold"> B </span></button>
//		<button type="button" class="fbutton" accesskey="i" id="addbbcode2_0" style="width: 30px" onclick="bbstyle(2, 0); return false"><span style="font-style:italic"> i </span></button>
//		<button type="button" class="fbutton" accesskey="u" id="addbbcode4_0" style="width: 30px" onclick="bbstyle(4, 0); return false"><span style="text-decoration: underline"> U </span></button>
//		<button type="button" class="fbutton" accesskey="s" id="addbbcode8_0" style="width: 30px" onclick="bbstyle(8, 0); return false"><span style="text-decoration: line-through"> S </span></button>
//		<button type="button" class="fbutton" style="width: 50px" onclick="inputimg_url(0); return false"><span> IMAGE </span></button>
//		<button type="button" class="fbutton" style="width: 50px" onclick="input_url(0); return false"><span> URL </span></button>
//		<button type="button" class="fbutton" id="addbbcode6_0" style="width: 60px" onclick="bbstyle(6, 0); return false"><span> BREAK </span></button>
//		</div>
public function display_guestform() {
	return $entry_display = <<<ADMIN_FORM
	<div style="text-align: center;" class="messagepanel">
	<center>
		<br>
		<form  NAME="formular" action="/index.php?page=guestbook" method="post" onsubmit="bbstyle(-1,0)">
		
		<table>
		<tr>
		<td align="left">
		<br />
		<label for="msg_title">Title:</label>
		<input name="msg_title" id="msg_title" type="text" maxlength="98%" />
		<div class="clear"></div>
	 
		<br />
		<label for="msg_title">Username:</label>
		<input name="msg_username" id="msg_username" type="text" maxlength="150" />
		<div class="clear"></div>
	 
		<br />
		<label for="msg_title">EMail:</label>
		<input name="msg_email" id="msg_email" type="text" maxlength="150" />
		<div class="clear"></div>
	 
		<img src="{$this->synapse_dir}cool-php-captcha/captcha.php" id="captcha" /><br/>
		<br/>
		<a href="#" onclick=" document.getElementById('captcha').src='{$this->synapse_dir}cool-php-captcha/captcha.php?'+Math.random(); document.getElementById('captcha-form').focus();" id="change-image">Not readable? Change text.</a><br/><br/>
		<input type="text" name="captcha" id="captcha-form" /></ br>
	 
		<br />
		<label for="msg_bodytext">Body Text:</label>
		<textarea class="msgarea" name="msg_bodytext" id="text0" style="width: 98%;"></textarea>
		<input type="submit" name="guest_btn" value="Post Message" />
		<div class="clear"></div>
		</td>	
		</tr>
		</table>
		</form>
	</center>
	</div>
ADMIN_FORM;
}

// NOTE: zobraz uvodnu stranku..
public function display_guestmessages() {

    if ($_POST) {
		if (!empty($_POST['guest_btn'])) {
			if (!empty($_REQUEST['captcha'])) {
							if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
								$captcha_message = "Invalid captcha";
								$style = "background-color: #FF606C";
							} else {
								$captcha_message = "Valid captcha";
								$style = "background-color: #CCFF99";
								// Guestbook Formular
								// Captcha is OK, then Send a Message to Guestbook DB
								$this->write_data();
							}
							$request_captcha = htmlspecialchars($_REQUEST['captcha']);
								echo <<<HTML
								        <div id="result" style="$style">
											<h2>$captcha_message</h2>
										</div>
HTML;
							unset($_SESSION['captcha']);
			}
		}
    }


    $this->switch_guestbook_table();
    $q = "SELECT * FROM guestbook ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
	$numbers=10;
	$entry_display = <<<ADMIN_FORM
			<br>
			<ul class="messages">
ADMIN_FORM;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
	while ( $a = mysql_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        // bodytext
        $bodytext = stripslashes($a['bodytext']);
		//$bodytext = $this->spracuj_form($bodytext);
		// others
		$user = stripslashes($a['username']);
		$ema = stripslashes($a['email']);
		$crea = stripslashes($a['created']);
		// $crea = stripslashes($a['created']);
		//echo ("$vypocet . ");
		if ( ($id > ($_SESSION['pageid']*$numbers - $numbers)) && ($id <= ($_SESSION['pageid']*$numbers )) ) {
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
			$entry_display .= <<<ADMIN_FORM
					<li class="messages" onmouseover="" onmouseout="" onclick="">
ADMIN_FORM;
			// $entry_display .= "<a href=\"#\">";		

			$entry_display .= <<<ADMIN_FORM
						<h2>$title</h2>
						<p>
						<table border="0" width="100%">
						<tr>
						<td align=left>
						<i><span style="color:black">Public written by {$user}, {$datum}</span></i>
						</td>
						<td align=right>
						<form  NAME="formular" action="{$this->synapse_dir}message.php?created=$crea" method="post">
						<button type="submit" style="border: 0; background: transparent">
							<img src="{$this->synapse_dir}themes/images/interface/sharebut.png" width="24" height="24" alt="submit" />
						</button>
						</form>
						</td>
						</tr>
						</table>
						</p>
					<p><div id="alt">$bodytext</div></p>
					</li>
					
ADMIN_FORM;
					// </a>
		}
		$id++;
	}
	}
	$entry_display .= <<<ADMIN_FORM
			</ul>
			<br>
ADMIN_FORM;
	$entry_display.= $this->display_guestform();
	echo($entry_display);
}
	
public function write_data() {
    $this->switch_guestbook_table();
	
    //var_dump($_POST);
	
    if ( $_POST['msg_title'] )
      $title = mysql_real_escape_string($_POST['msg_title']);
    if ( $_POST['msg_username'] )
      $username = mysql_real_escape_string($_POST['msg_username']);
    if ( $_POST['msg_email'])
      $email = mysql_real_escape_string($_POST['msg_email']);
	if ( $_POST['msg_bodytext'])
      $bodytext = mysql_real_escape_string($_POST['msg_bodytext']);
	//if ($_SESSION['loginuser'])
    //  $user = mysql_real_escape_string($_SESSION['loginuser']);
	
	echo ("{$title} : {$bodytext} : {$user}<br>");
	 
	if ( $title && $bodytext && $username && $email ) {
		$created = time();
		//echo ($created);
		$sql = "INSERT INTO guestbook VALUES('$title','$bodytext','$username','$email','$created')";
		return mysql_query($sql);
	}
}

public function connect_db() {
    mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
}

private function switch_guestbook_table() {
    mysql_select_db($this->table) or die("Could not select database. " . mysql_error());
	
    return $this->build_guestbook_db();
}

private function build_guestbook_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS guestbook (
title	    VARCHAR(150),
bodytext	    	TEXT,
username    VARCHAR(150),
email	    VARCHAR(150),
created		VARCHAR(100)
)
MySQL_QUERY;
    return mysql_query($sql);
}

}


// END OF  

// auto load db config for synapsecms-guestbook
      $guest = new Synapse_guestbook();
      
      $guest->synapse_dir = $obj->synapse_dir;

      $guest->host = $obj->host;
      $guest->username = $obj->username;
      $guest->password = $obj->password;
      $guest->table = $obj->table;


?>
