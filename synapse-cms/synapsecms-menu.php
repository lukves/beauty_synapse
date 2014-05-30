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

    // $menu is array of (MenuItem, HyperlinkToPage)

    /*

    $menu = array(  'Login' => 'index.php',
		    'Register' => 'index.php',
		    'ContactUs' => 'index.php'
		 );

    foreach ($menu as $item) {
    }

    */


//include(dirname(__FILE__).'/'.'synapsecms-users.php'); 

class Synapse_menu extends Synapse_users {

	// BEGIN OF

	var $synapse_dir;
	
	//var $adminemail;

	var $host;
	var $username;
	var $password;
	var $table;

function __construct() {
    //print "SYNAPSE-CMS <br>";  // Initialize 
    // !!! Important setting a synapse_dir variable !!! //
    //$this->synapse_path=dirname(__FILE__)."/";
    // !!! Important !!! //
       
    //$this->connect_db();
}


public function display_admin_editmenu() {
	$user = mysql_real_escape_string($_SESSION['loginuser']);
	if ($this->isadmin($user)==1) {
			$entry_display = <<<ADMIN_FORM
				<div id="menu-bar" align="center">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
				<tr>
				<td onclick="loadURL('admin_global.php');"><a href="/index.php?page=adminsettings&work=global">Global Settings</a></td>
				<td onclick="loadURL('admin_editmenu.php');"><a href="admin_editmenu.php">Edit Menu</a></td>
				<td onclick="loadURL('index.php');"><a href="/index.php?page=adminsettings&work=plugins">Plugins</a></td>
				<td onclick="loadURL('admin_regusers.php');"><a href="admin_regusers.php">Registered Users</a></td>
				<td onclick="loadURL('admin_msgs.php');"><a href="admin_msgs.php">Manage Messages</a></td>
				</tr>
				</tbody>
				</table>
				</div>
				<br>
				<br>
				<br>
				<div style="text-align: center;" class="messagepanel">
				<center>
				<br>
				<b>Create a New item to selected Menu by ID</b>
				<form NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="">
				<table cellpadding="0" cellspacing="3" border="0">
				<tr>
					<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Menu ID</label></td>
					<td><input type="text" id="buttonka-text" class="bginput" style="font-size: 11px" name="msg_ident" id="navbar_username" size="10" accesskey="u" tabindex="101" value="" /></td>
				</tr>
				<tr>
					<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black; white-space: nowrap;"><label for="navbar_username">Menu Item</label></td>
					<td><input type="text" id="buttonka-text" class="bginput" style="font-size: 11px" name="msg_menuitem" id="navbar_username" size="10" accesskey="u" tabindex="101" value="" /></td>
				</tr>
				<tr>
					<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Menu Link</label></td>
					<td><input type="text" id="buttonka-text" class="bginput" style="width: 512px; font-size: 11px" name="msg_menulink" id="navbar_username" size="10" accesskey="u" tabindex="101" value="" /></td>
				</tr>
				<tr>
					<td><input id="buttonka" type="submit" name="task" value="Create Menu Item" tabindex="104" title="Create a new Item of your selected Menu." accesskey="s" /></td>
				</tr>
				</table>
				</form>
				<hr>
				<br>
ADMIN_FORM;
				$this->switch_menu_table();
				$q = "SELECT * FROM menu ORDER BY created DESC LIMIT 2048";
				$r = mysql_query($q);
				if ( $r !== false && mysql_num_rows($r) > 0 ) {
				while ( $a = mysql_fetch_assoc($r) ) {
					$menuitem = stripslashes($a['Menuitem']);
					$menulink = stripslashes($a['Menulink']);
					$menuident = stripslashes($a['Menuident']);
					$ident = stripslashes($a['Ident']);
					$crea = stripslashes($a['Created']);
			
					$entry_display .= "<b>{$ident}, {$menuitem}, {$menulink}</b><br>";
				}
				}
				$entry_display .= <<<ADMIN_FORM
					<br>
					</center>
					</div>
ADMIN_FORM;
				echo $entry_display;
				// executive part
				if ($_POST['task']=="Create Menu Item") $this->write_menu_data($_POST);
				
	} else echo("<br><center><b>Please, login as administrator, for Edit Menu..</b></center><br>");
}

// NOTE: write data..message..
public function write_menu_data($p) {
	$this->switch_menu_table();
	
	//var_dump($_POST);
	
    if ( $_POST['msg_menuitem'] )
      $menuitem = mysql_real_escape_string($_POST['msg_menuitem']);
    if ( $_POST['msg_menulink'])
      $menulink = mysql_real_escape_string($_POST['msg_menulink']);
	if ( $_POST['msg_ident'])
      $ident = mysql_real_escape_string($_POST['msg_ident']);
	
	//if ($_SESSION['loginuser'])
    //  $user = mysql_real_escape_string($_SESSION['loginuser']);
	
	//echo ("{$title} : {$bodytext} : {$user}<br>");
	 
	if ( $menuitem && $menulink && $ident ) { // && $user
		$t1 = "<?";
		$t2 = "<script";
		//// test for BAD words
		if (strpos($bodytext,$t1)!==false) {
			return false;
		} else if (strpos($bodytext,$t2)!==false) {
			return false;
		} else {
			$created = time();
			$sql = "INSERT INTO menu VALUES('$menuitem','$menuitem','$menulink','','','0','$ident','$created')";
			mysql_query($sql);
			echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"admin_editmenu.php\">Menu item created. Refresh Page</a></b></center></div></div>");
			return true;
		}
    } else {
      return false;
    }
}

// NOTE: print a menu
public function display_menus($id, $page) {
	$this->switch_menu_table();
	
	$entry_display = <<<ADMIN_FORM
ADMIN_FORM;

    $q = "SELECT * FROM menu ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$i=0;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$menuitem = stripslashes($a['Menuitem']);
			$menulink = stripslashes($a['Menulink']);
			$menuident = stripslashes($a['Menuident']);
			$ident = stripslashes($a['Ident']);
			$crea = stripslashes($a['Created']);
			
			if ($ident==$id) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<li 
MESSAGE_DISPLAY;
				if ($menuident==$page) {
					$entry_display .= "class=\"current\""; 
					
				}
				$entry_display .= "><a href=\"{$menulink}\"><b>{$menuitem}</b></a></li>";
				$i++;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
ADMIN_FORM;

	if ($i==0) {
		$entry_display .= <<<ADMIN_FORM
			<li><a href="{$this->synapse_dir}README"><b>Nothing menu items defined..</b></a></li>
ADMIN_FORM;
		if ($_SESSION['loginuser']) {
			$user = mysql_real_escape_string($_SESSION['loginuser']);
			$entry_display .= "<li><b><a href=\"/index.php?page=logout\"><b>Logout</b></a></li>";
			if ($this->isadmin($user)==1) {
				$entry_display .= "<li class=\"current\"><a href=\"{$this->synapse_dir}admin_editmenu.php\"><b>Create Menu</b></a></li>";
			}
		} else {
			$entry_display .= "<li"; if ($page=="register") $entry_display .= " class=\"current\""; $entry_display .= "><a href=\"index.php?page=register\"><b>Register</b></a></li>";
			$entry_display .= "<li"; if ($page=="login") $entry_display .= " class=\"current\""; $entry_display .= "><a href=\"index.php?page=login\"><b>Login</b></a></li>";
		}
	}

	return $entry_display;
}	
  
private function connect_db() {
    mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
}


public function switch_menu_table() {
	mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

    return $this->build_menu_db();
  }
  
  
/* Menuitem - item name 
 * Menuident - type of menu
 * Menulink - link to page, or code 
 * Lang - language of item menu 
 * Inform - title, or information about link and itemmenu
 * Lasttime - last time of clickto menu 
 * Ident	- id of menu, for more menus
 * Created 
 **/
private function build_menu_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS menu (
Menuitem		VARCHAR(150),
Menuident		VARCHAR(150),
Menulink		VARCHAR(150),
Lang			VARCHAR(150),
Inform		    		TEXT,
Lasttime		VARCHAR(150),
Ident			VARCHAR(150),
Created			VARCHAR(100)
)
MySQL_QUERY;

    return mysql_query($sql);
}

	// END OF  
}
 
   $menu = new Synapse_menu();
   
   $menu->adminemail = $obj->adminemail;
   $menu->synapse_dir = $obj->synapse_dir;

   $menu->host = $obj->host;
   $menu->username = $obj->username;
   $menu->password = $obj->password;
   $menu->table = $obj->table; 
 
?>
