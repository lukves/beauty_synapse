<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

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
	 
	/*
	** PUBLIC SYNAPSE-CMS-USERS API
	**
	** public function issecure($myuser)
	** public function issecureuser($myuser)
	** public function isadmin($myuser)
	** public function update_usersettings($p)
	** public function update_passwordsettings($p)
	** public function getadmin()
	** public function getinform($myuser)
	** public function getimgavatar($myuser)
	** public function getavatar($myuser)
	** public function getemail($myuser)
	** public function howmanyfriends()
	** public function howmanychannels()
	** public function isuserexist($myuser)
	** public function isvisible($myus)
	** public function lasttime_test($tim)
	** public function display_admin_global()
	** public function display_admin_regusers()
	** public function display_channels()
	** public function display_blogchannels()
	** public function display_blogusers()
	** public function display_channels_options()
	** public function display_contacts()
	** public function display_login()
	** public function display_post_login($title, $bodytext, $sendto)
	** public function display_register()
	**
	** public function write_channel_registration($p)
	** public function write_registration($p)
	** public function write_login($p)
	** public function switch_users_table()
	** public function backup_tables($host,$user,$pass,$name,$tables = '*')
	**
	** PRIVATE SYNAPSE-CMS-USERS API
	**
	** private function userRegister($rusername,$rpassword,$rcpassword,$remail,$rvisib)
	** private function userLogin($rusername,$rpassword)
	** private function build_users_db()
	**
	************
	** now connect_db is call in class constructor, and not directly from your php file
	** connect_db is now private part of this class..
	**
	** private function connect_db()
	************
	**
	**/

define('SALT_LENGTH', 15);

require_once dirname(__FILE__).'/'.'lib/Crypt.php';

class Synapse_users extends Crypt {
// class Synapse_users {

	var $synapse_index = "/index.php"; // {$_SERVER['PHP_SELF']}

	// BEGIN OF

	// Select crypto system MD5, or CryptoLib
	var $synapse_password = "k4hvdq9tj9";
	var $synapse_password_after = 1391296382;


	// more Hash are supported via php hash() function
	// default is "md5", you can use another one like "sha"
	var $password_type = "md5";

	//
	// type of databse with Name and Surname
	// or witthout this variables
	//
	// privacy_mode == 1 is as default with MD5 for passwords
	// privacy_mode == 0 is with HashMe function with uses salt + password
	// and need enhaced database
	//
	// Prefered mode is 0 with password+salt, its more secure
	//
	var $privacy_mode = 0;

	//
	// type of error output
	// if 0 then die
	// if 1 then setup-config.php
	//
	var $error_output = 1;
	
	var $synapse_dir;
	
	var $adminemail;

	var $security;

	// is open to Register a channel?
	var $reg_type;
  
	var $host;
	var $username;
	var $password;
	var $table;
	
function __construct() {
    //print "SYNAPSE-CMS-USERS <br>";  // Initialize 
	
	// important part is connect to database
	// !!! config.php must be loaded before this !!!	
	//$this->synapse_dir = $obj->synapse_dir;
	//$this->adminemail = $obj->adminemail;
	
	//$this->host = $obj->host;
    //$this->username = $obj->username;
    //$this->password = $obj->password;
    //$this->table = $obj->table;
	
	//$this->connect_db();   
	//print "done\n";
}

function HashMe($phrase, &$salt = null)
{
	$key = '!@#$%^&*()_+=-{}][;";/?<>.,';
	
    if ($salt == '')
    {
        $salt = substr(hash('sha256',uniqid(rand(), true).$key.microtime()), 0, SALT_LENGTH); // 15
    }
    else
    {
        $salt = substr($salt, 0, SALT_LENGTH); // 15
    }

    return hash('sha256', $salt . $key .  $phrase);
}

public function issecure($myuser, $code) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcemail = $a['email'];
		
	// ak existuje pouzivatel v poli pouzivatelov
	//if (isset($this->adminemail[$rcemail])) {
		// over heslo, a ak je spravne
		//if ( $this->adminemail[$rcemail] == "admin" ) {
		//	return 0;
		//} else if ( $this->adminemail[$rcemail] == "private" ) {
			// test for code
			if (isset($this->security[$rcemail])) {
				if ( $this->security[$rcemail] == $code ) {
					return 1;
				}
			}
		//}
	//}
	
	return 0;
}	

public function issecureuser($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcemail = $a['email'];
		
	// ak existuje pouzivatel v poli pouzivatelov
	//if (isset($this->adminemail[$rcemail])) {
		// over heslo, a ak je spravne
		//if ( $this->adminemail[$rcemail] == "admin" ) {
		//	return 0;
		//} else if ( $this->adminemail[$rcemail] == "private" ) {
			// test for code
			if (isset($this->security[$rcemail])) {
					return 1;
			}
		//}
	//}
	
	return 0;
}	

public function isadmin($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcemail = $a['email'];
		
	// ak existuje pouzivatel v poli pouzivatelov
	if (isset($this->adminemail[$rcemail])) {
		// over heslo, a ak je spravne
		if ( $this->adminemail[$rcemail] == "admin" ) {
			return 1;
		} else if ( $this->adminemail[$rcemail] == "private" ) {
			return 2;
		}
	}
	
	return 0;
}	

// NOTE: update user informations in database  
public function update_usersettings($p) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	if (!empty($_POST['usersettings_opt'])) { 
		$usropt = $_POST['usersettings_opt'];
		
		$this->switch_users_table();
		$q = "UPDATE users SET Avatar='$usropt' WHERE Username = '$myuser'";
		$r = mysql_query($q);
	}
	
	if (!empty($_POST['usersettings_name'])) { 
		$usrname = $_POST['usersettings_name'];
		
		$this->switch_users_table();
		$q = "UPDATE users SET Name='$usrname' WHERE Username = '$myuser'";
		$r = mysql_query($q);
	}
	
	if (!empty($_POST['usersettings_surname'])) { 
		$usrsname = $_POST['usersettings_surname'];
		
		$this->switch_users_table();
		$q = "UPDATE users SET Surname='$usrsname' WHERE Username = '$myuser'";
		$r = mysql_query($q);
	}
	
	//if (!empty($_POST['usersettingsbg_opt'])) { 
		//$usrbgopt = $_POST['usersettingsbg_opt'];
		
		//$_SESSION['bodycss']=$usrbgopt;
				
		//$this->switch_users_table();
		//$q = "UPDATE users SET Avatar='$usropt' WHERE Username = '$myuser'";
		//$r = mysql_query($q);
	//}
	
	if (!empty($_POST['usersettings_info'])) { 
		$infopt = $_POST['usersettings_info'];
		
		$this->switch_users_table();
		$q = "UPDATE users SET Inform='$infopt' WHERE Username = '$myuser'";
		$r = mysql_query($q);
	}
	
	echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div>");
}

// NOTE: update user password informations in database  
public function update_passwordsettings($p) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	if ( (!empty($_POST['reg_password'])) && (!empty($_POST['reg_repassword'])) ) { 
		$pwdopt = $_POST['reg_password'];
		$repwdopt = $_POST['reg_repassword'];
		
		if ($pwdopt==$repwdopt) {
			if ( ( time() >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
				// $pwdopt = md5($pwdopt);
				$salt = '';
				if ($this->privacy_mode == 1) {
					if ($this->password_type == "md5") $pwdopt = md5($pwdopt); 
							else $pwdopt = hash($this->password_type, $pwdopt);
				} else $pwdopt = $this->HashMe($pwdopt, $salt);
						
				
				// crypt or decrypt
				//inicializácia vnorenej-triedy
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if (isset($this->synapse_password)) $this->Key  = $this->synapse_password; //kľúč
				$rpassword = $this->encrypt($pwdopt); // zasifruje lubovolny retazec
				
				$this->switch_users_table();
				$q = "UPDATE users SET Password='$rpassword' WHERE Username = '$myuser'";
				$r = mysql_query($q);
				$rtime = time();
				$q = "UPDATE users SET Created='$rtime' WHERE Username = '$myuser'";
				$r = mysql_query($q);
				if ($this->privacy_mode == 0) {
					$q = "UPDATE users SET Salt='$salt' WHERE Username = '$myuser'";
					$r = mysql_query($q);
				}
			} else {
				// $rpassword = md5($pwdopt);
				$salt = '';
				if ($this->privacy_mode == 1) {
					if ($this->password_type == "md5") $rpassword = md5($pwdopt); 
						else $rpassword = hash($this->password_type, $pwdopt);
				} else $rpassword = $this->HashMe($pwdopt, $salt);
						
				$this->switch_users_table();
				$q = "UPDATE users SET Password='$rpassword' WHERE Username = '$myuser'";
				$r = mysql_query($q);
				if ($this->privacy_mode == 0) {
					$q = "UPDATE users SET Salt='$salt' WHERE Username = '$myuser'";
					$r = mysql_query($q);
				}
				//$rtime = time();
				//$q = "UPDATE users SET Created='$rtime' WHERE Username = '$myuser'";
				//$r = mysql_query($q);
			}
			echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Password Changed! Refresh Page</a></b></center></div></div>");
		}
	}
}

public function getadmin() {
	$this->switch_users_table();
    
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ($this->isadmin($user)==1) {
				return $user;
			}
		}
	}
	return null;
}

public function getinform($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT inform FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcinf = $a['inform'];
	
	return $rcinf;
}

public function getcreated($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT created FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcinf = $a['created'];
	
	return $rcinf;
}

public function getname($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT name FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcinf = $a['name'];
	
	return $rcinf;
}

public function getsurname($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT surname FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcinf = $a['surname'];
	
	return $rcinf;
}

public function getimgavatar($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT avatar FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcavat =  "./bindata/files/" . $myuser . "/" .  $a['avatar'];
	
	if (!file_exists( $rcavat )) {
		return "./bindata/me-sketch.png";
	} 
	else return $rcavat;
}

public function getavatar($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT avatar FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcavat =  $a['avatar'];

	return $rcavat;
}

public function getemail($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcinf = $a['email'];
	
	return $rcinf;
}

public function getpassword($myuser) {
	$this->switch_users_table();

	$checkem = mysql_query("SELECT password FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcinf = $a['password'];
	
	return $rcinf;
}

// how many users
public function howmanyfriends() {
	$this->switch_users_table();
    
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=0;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ($this->isvisible($user)==0) {
				$id++;
			}
		}
	}
	return $id;
}

// how many channels
public function howmanychannels() {
	$this->switch_users_table();
    
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=0;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ($this->isvisible($user)==1) {
				$id++;
			}
		}
	}
	return $id;
}


// Display all users with their short informations
// about avatar, info
public function display_users() {
	$this->switch_users_table();
	
	$entry_display = <<<MESSAGE_FORM
MESSAGE_FORM;
	
	//if ($_SESSION['loginuser'])
	//		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
					$txt = $this->getinform($user);
					$av = $this->getimgavatar($user);
					
					if ($this->isvisible($user)==1) {
						$hyper = "<a href=\"index.php?channel=$user\">{$user}</a>";
					} else $hyper = "<a href=\"".$this->synapse_dir."blog.php?user={$user}\">{$user}</a>";
			
					$entry_display .= <<<MESSAGE_FORM
						<br>
						<div class="tweet"> 
						<img class="avatar" src="{$av}" alt="twitter"> 
						<img class="bubble" src="./synapse-cms/themes/images/interface/speech_bubble.png" alt="bubble">
						
						<div class="text" style="width: 85%;"> 
						<h2>{$user}</h2>
						<br>
						{$txt} 
						<br>
						<br>
						<span>Link to {$hyper} pressentation page.</span> 
						<br>
						</div>
					
						</div>
						<br>
MESSAGE_FORM;
			
		}
	}
	return $entry_display;
}

public function isuserexist($myuser) {
	$this->switch_users_table();
    
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ($user==$myuser) {
				return 1;
			}
		}
	}
	return 0;
}

// NOTE: jedna sa o klasicke konto alebo o informacny odberovy kanal..
public function isvisible($myus) {
	$this->switch_users_table($p);
 
	$checkem = mysql_query("SELECT visible FROM users WHERE Username='$myus'");	
	$a = mysql_fetch_assoc($checkem);
	$rcvisib = $a['visible'];
	
	if ($rcvisib=="0") return 0; else return 1;
}

// last refresh, compare to times
public function lasttime_test($tim) {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$this->switch_users_table($p);
 
	$checkem = mysql_query("SELECT lasttime FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rctime = $a['lasttime'];
	
	if ($tim > $rctime) return 1; else return 0;
}

// NOTE: zobrazi registrovanych uzivatelov..
public function display_admin_global() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$this->switch_users_table();
	$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcemail = $a['email'];
		
	// ak existuje pouzivatel v poli pouzivatelov
	if (isset($this->adminemail[$rcemail])) {
		// over heslo, a ak je spravne
		if ( $this->adminemail[$rcemail] == "admin" ) {
			$entry_display = <<<ADMIN_FORM
			<br>
			<br>
			You are admin and you can create dump of Users database:<br>
			<form NAME="formular" action="{$this->synapse_index}" method="post" onsubmit="">
				<input type="submit" name="task" value="Create Database Dump" />
			</form>
			<br>
ADMIN_FORM;
		echo($entry_display);
		}
	}
}

// NOTE: zobrazi dialog pre vymazanie uzivatela..
public function display_delete_account() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	//$this->switch_users_table();
	//$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	//$a = mysql_fetch_assoc($checkem);
	//$rcemail = $a['email'];
		
	// ak existuje pouzivatel v poli pouzivatelov
	if ($_SESSION['loginuser']) {
			$entry_display = <<<ADMIN_FORM
			<br>
			<br>
			<big>Be carefully, this operation will PERMANENTLY DELETE your account:</big><br>
			<form NAME="formular" action="{$this->synapse_index}" method="post" onsubmit="">
				<input type="submit" name="deleteaccount_btn" value="Delete My Account" />
			</form>
			<br>
ADMIN_FORM;
		echo($entry_display);
		}
}

public function update_deleteaccount($p) {
	if ($_SESSION['loginuser']) {
		$usr = $_SESSION['loginuser'];
	
		$this->switch_users_table();
		$q = "DELETE FROM users WHERE username = '$usr'";
		$r = mysql_query($q);
		
		$_SESSION['loginuser'] = null; 
		unset($_SESSION['loadpage']);
		
		echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">User Deleted !!! Thanks for using {$this->synapse_title}</a></b></center></div></div>");
		return true;
	}
}

public function update_delete_user($usr) {
	if ($_SESSION['loginuser']) {
		// $usr = $_SESSION['loginuser'];
	
		$this->switch_users_table();
		$q = "DELETE FROM users WHERE username = '$usr'";
		$r = mysql_query($q);
		
		$_SESSION['loginuser'] = null; 
		unset($_SESSION['loadpage']);
		
		echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">User Deleted !!! Thanks for using {$this->synapse_title}</a></b></center></div></div>");
		return true;
	}
}

// NOTE: zobrazi registrovanych uzivatelov..
public function display_admin_regusers() {
	$this->switch_users_table();
			
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
	$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
	$a = mysql_fetch_assoc($checkem);
	$rcemail = $a['email'];
		
	// ak existuje pouzivatel v poli pouzivatelov
	if (isset($this->adminemail[$rcemail])) {
		// over heslo, a ak je spravne
		if ( $this->adminemail[$rcemail] == "admin" ) {
			$entry_display = <<<ADMIN_FORM
				<div id="menu-bar" align="center">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
				<tr>
				<td onclick="loadURL('admin_global.php');"><a href="/index.php?page=adminsettings&work=global">Global Settings</a></td>
				<td onclick="loadURL('admin_editmenu.php');"><a href="admin_editmenu.php">Edit Menu</a></td>
				<td onclick="loadURL('index.php');"><a href="/index.php?page=adminsettings&work=plugins">Plugins</a></td>
				<td onclick="loadURL('');"><a href="index.php?plugin=switch-theme">Change Template</a></td>
				<td onclick="loadURL('admin_regusers.php');"><a href="admin_regusers.php">Registered Users</a></td>
				<td onclick="loadURL('admin_msgs.php');"><a href="admin_msgs.php">Manage Messages</a></td>
				</tr>
				</tbody>
				</table>
				</div>
				<br>
				<br>
				<ul class="messages">
ADMIN_FORM;
			// begin fill table of users
			$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
			$r = mysql_query($q);
	
			if ( $r !== false && mysql_num_rows($r) > 0 ) {
				while ( $a = mysql_fetch_assoc($r) ) {
					$usr = stripslashes($a['Username']);
					$em = stripslashes($a['Email']);
					$crea = stripslashes($a['Created']);
					$entry_display .= <<<MESSAGE_DISPLAY
						<li class="messages" onmouseover="" onmouseout="" onclick="">
							<p>$usr : $em : $crea</p>
						</li>
MESSAGE_DISPLAY;
				}
			}
			// end fill table of users
			$entry_display .= <<<ADMIN_FORM
				</ul>
				<br>
				<br>
ADMIN_FORM;
			return $entry_display;
		}  else {
			$entry_display = <<<ADMIN_FORM
				<br><br><br><br><center><big><b>You are not ADMIN !!!</big></b></center>
ADMIN_FORM;
			return $entry_display;
		}
	} else {
		$entry_display = <<<ADMIN_FORM
			<br><br><br><br><center><big><b>You dont have ADMIN privilegies !!!</big></b></center>
ADMIN_FORM;
		return $entry_display;
	}
}

// NOTE: print a channels..
public function display_channels() {
	$this->switch_users_table();
	
	$entry_display = <<<ADMIN_FORM
			<span style="font-weight: bold;">Public Channels</span><br>
ADMIN_FORM;

    $q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ( ($this->isvisible($user)==1)&&($this->isadmin($user)!=2) ) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<a href="/index.php?channel=$user">$user</a><br>
MESSAGE_DISPLAY;
			}
		}
	}
	
$entry_display .= <<<ADMIN_FORM
			<br><span style="font-weight: bold;">Private Channels</span><br>
ADMIN_FORM;
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ( ($this->isvisible($user)==1)&&($this->isadmin($user)==2) ) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<a href="/index.php">$user</a><br>
MESSAGE_DISPLAY;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		<br>
ADMIN_FORM;
	return $entry_display;
}


// NOTE: print a channels..
public function display_channels_clean() {
	$this->switch_users_table();
	
	$entry_display = <<<ADMIN_FORM
ADMIN_FORM;

    $q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ( ($this->isvisible($user)==1)&&($this->isadmin($user)!=2) ) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<a href="/index.php?channel=$user">$user</a><br>
MESSAGE_DISPLAY;
			}
		}
	}
	
$entry_display .= <<<ADMIN_FORM
			<br>
ADMIN_FORM;
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ( ($this->isvisible($user)==1)&&($this->isadmin($user)==2) ) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<a href="/index.php">$user</a><br>
MESSAGE_DISPLAY;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		<br>
ADMIN_FORM;
	return $entry_display;
}

// NOTE: print a channels.. with links to blog
public function display_blogchannels() {
	$this->switch_users_table();
	
	$entry_display = <<<ADMIN_FORM
	<style type="text/css">
#browser-link {
overflow: auto;
float: left;
margin-top: 5px;
margin-left: 10px;
width: 95%;
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
}
</style>
ADMIN_FORM;

    $q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$inf = stripslashes($a['Inform']);
			$crea = stripslashes($a['Created']);
			
			if ( ($this->isvisible($user)==1)&&($this->isadmin($user)!=2) ) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<a id="browser-link"  href="/index.php?blog=$user"><b>$user</b> - $inf</a>
MESSAGE_DISPLAY;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		<br>
ADMIN_FORM;
	return $entry_display;
}

// NOTE: print a users.. with links to blog
public function display_blogusers() {
	$this->switch_users_table();
	
	$entry_display = <<<ADMIN_FORM
	<style type="text/css">
#browser-link {
overflow: auto;
float: left;
margin-top: 5px;
margin-left: 10px;
width: 95%;
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
}
</style>
ADMIN_FORM;

    $q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$inf = stripslashes($a['Inform']);
			$crea = stripslashes($a['Created']);
			
			if ($this->isvisible($user)==0) {
				// index.php?blog=
				$entry_display .= <<<MESSAGE_DISPLAY
					<a id="browser-link"  href="/blog.php?user=$user"><b>$user</b> - $inf</a>
MESSAGE_DISPLAY;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		<br>
ADMIN_FORM;
	return $entry_display;
}

// NOTE: print a channels..
public function display_channels_options() {
	$this->switch_users_table();
	
	$entry_display = <<<ADMIN_FORM
			<span style="font-weight: bold;">Categories</span><br>
			<select name='cat' id='cat' class='postform'>
			<option value='-1'>Select Category</option>
ADMIN_FORM;

    $q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ($this->isvisible($user)==1) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<option class="level-0" value="$id">$user</option>
MESSAGE_DISPLAY;
			    $id++;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		</select>
		<br>
		<script type='text/javascript'>
		/* <![CDATA[ */
		var dropdown = document.getElementById("cat");
		function onCatChange() {
			if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
				location.href = "/index.php?channel="+dropdown.options[dropdown.selectedIndex].text;
			}
		}
		dropdown.onchange = onCatChange;
		/* ]]> */
		</script>
ADMIN_FORM;
	return $entry_display;
}

// NOTE: zobraz contacts dialog..
public function display_contacts() {
	$this->switch_users_table();
    
    $entry_display = <<<ADMIN_FORM
		<div style="text-align: center;" class="messagepanel">
		<center>
		<br>
		<b><big>YOUR ADMINISTRATORS</big></b><br><br>
ADMIN_FORM;
    
	$q = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$em = stripslashes($a['Email']);
			$crea = stripslashes($a['Created']);
			
			if ($this->isadmin($user)==1) {
					$entry_display .= <<<ADMIN_FORM
						<table>
						<tr>
						<td align=left>
						<form NAME="formular" action="/{$this->synapse_dir}post-message.php" method="post" onsubmit="">
						<input type="hidden" name="synapse-title" value="Message from Contacts">
						<input type="hidden" name="synapse-sendto" value="$user">
						<b>$user</b> <input type="text" name="synapse-bodytext" value="">
						<!--><input id="buttonka" type="submit" value="Send Message" /><!-->
						<button class="buttonka" id="intro">Send Message</button>	
						</form>
						</td>
						<td align=right>
						<form NAME="formular" action="/{$this->synapse_dir}be-friends.php" method="post" onsubmit="">
						<input type="hidden" name="synapse-title" value="friendship">
						<input type="hidden" name="synapse-sendto" value="$user">
						<input type="hidden" name="synapse-bodytext" value="I want be Your friend!">
						<!--><input id="buttonka" type="submit" value="Be Friends" /><!-->
						<button class="buttonka" id="intro">Be Friends</button>
						</form>
						</td>
						</tr>
						</table>
						<br><hr><br>
ADMIN_FORM;
			}
		}
	}
	
	$entry_display .= <<<ADMIN_FORM
		</center>
		</div>
ADMIN_FORM;
	return $entry_display;
}

// NOTE: zobraz login dialog..
public function display_login() {
	return $entry_display = <<<ADMIN_FORM
	<div style="text-align: center;" class="messagepanel">
	<center>
		<br>
		<form NAME="formular" action="{$this->synapse_index}" method="post" onsubmit="return check_loginform()">
		<table cellpadding="0" cellspacing="3" border="0">
		<tr>
			<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black; white-space: nowrap;"><label for="navbar_username">Nick</label></td>

			<td><input type="text" class="bginput" style="font-size: 11px" name="login_username" id="navbar_username" size="10" accesskey="u" tabindex="101" value="User Name" onfocus="if (this.value == 'User Name') this.value = '';" /></td>
		</tr>
		<tr>
			<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Password</label></td>
			<td><input type="password" class="bginput" style="font-size: 11px" name="login_password" id="navbar_password" size="10" tabindex="102" /></td>
		</tr>
		<tr>
			<td style="width: 90px; font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password"></label></td>
			<td>
			<button class="buttonka" id="intro">Sign in</button>
			</td>
		</tr>

		</table>
		</form>
		<br /><br />
	</center>
	</div>
ADMIN_FORM;
}

// NOTE: zobraz login dialog s odoslanim prijatych dat pre spravicku..
public function display_post_login($title, $bodytext, $sendto) {
	return $entry_display = <<<ADMIN_FORM
	
	<div id="baner"> </div>	
	<div id="prihlasenie">
	<big><b>$title</b></big>
	<form NAME="formular" action="/{$this->synapse_dir}post-message.php" method="post" onsubmit="return check_loginform()">
	
	<table>
	<tbody><tr><td><label for="meno">Nick</label></td><td>&nbsp;<input id="meno" name="login_username" type="text"></td></tr>
	<tr><td><label for="heslo">Password</label></td><td>&nbsp;<input id="heslo" name="login_password" type="password"><br></td></tr>
	</tbody></table>	
	
	<input style="background: none repeat scroll 0% 0% rgb(249, 249, 249);" value="Sign in" type="submit">
	
	
		<input type="hidden" name="synapse-title" value="$title">
		<input type="hidden" name="synapse-bodytext" value="$bodytext">
		<input type="hidden" name="synapse-sendto" value="$sendto">

	</form>
	</div>
ADMIN_FORM;
}

/**
 	<div style="text-align: center;" class="loginpanel">
	<center>
		<br>
		<form NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return check_loginform()">
		<table cellpadding="0" cellspacing="3" border="0">
		<tr>
			<td class="smallfont" style="white-space: nowrap;"><label for="navbar_username">Nick</label></td>

			<td><input type="text" class="bginput" style="font-size: 11px" name="login_username" id="navbar_username" size="10" accesskey="u" tabindex="101" value="User Name" onfocus="if (this.value == 'User Name') this.value = '';" /></td>
		</tr>
		<tr>
			<td class="smallfont"><label for="navbar_password">Password</label></td>
			<td><input type="password" class="bginput" style="font-size: 11px" name="login_password" id="navbar_password" size="10" tabindex="102" /></td>
			<td><input id="buttonka" type="submit" value="Sign in" tabindex="104" title="Enter your username and password in the boxes provided to login, or click the 'register' button to create a profile for yourself." accesskey="s" /></td>
		</tr>

		</table>
		
		<input type="hidden" name="synapse-title" value="$title">
		<input type="hidden" name="synapse-bodytext" value="$bodytext">
		<input type="hidden" name="synapse-sendto" value="$sendto">
		
		</form>
		<br /><br />
	</center>
	</div>

 */

// NOTE: zobraz register dialog..
public function display_register() {
	$entry_display = <<<ADMIN_FORM

		<br />
	
		<div style="text-align: center;" class="messagepanel">
		<center>
				<br>
				<form NAME="formular" action="{$this->synapse_index}" method="post" onsubmit="return check_regform()">
				<input type="hidden" name="asked_work" value="##REGISTERCHANNEL##">
				<table style=" text-align: left; width: 70%;" border="0" cellpadding="2" cellspacing="2">
				<tbody>
				<tr>
					<td style="vertical-align: top;">
						<table cellpadding="0" cellspacing="3" border="0">
						<tr>
							<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Name</label></td>
							<td><input type="text" class="bginput" style="font-size: 11px" name="reg_name" id="login_name" maxlength="150" size="10" tabindex="102" /></td>
						</tr>
						<tr>
							<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Surname</label></td>
							<td><input type="text" class="bginput" style="font-size: 11px" name="reg_surname" id="login_surname" maxlength="150" size="10" tabindex="103" /></td>
						</tr>
						<tr>
							<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black; white-space: nowrap;"><label for="navbar_username">Nick</label></td>
							<td><input type="text" class="bginput" style="font-size: 11px" name="reg_username" id="login_username" maxlength="150" size="10" accesskey="u" tabindex="101" value="User Name" onfocus="if (this.value == 'User Name') this.value = '';" /></td>
						</tr>
						<tr>
							<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black; white-space: nowrap;"><label for="navbar_username">Email</label></td>
							<td><input type="text" class="bginput" style="font-size: 11px" name="reg_email" id="login_email" maxlength="150" size="10" accesskey="u" tabindex="101" value="@" onfocus="if (this.value == '@') this.value = '';" /></td>
						</tr>
						<tr>
							<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Password</label></td>
							<td><input type="password" class="bginput" style="font-size: 11px" name="reg_password" id="login_password" maxlength="150" size="10" tabindex="102" /></td>
							<td><input type="password" class="bginput" style="font-size: 11px" name="reg_repassword" id="login_repassword" maxlength="150" size="10" tabindex="103" /></td>
						</tr>
						</table>
					</td>
					<td style="vertical-align: top;"><br>
						<img src="{$this->synapse_dir}cool-php-captcha/captcha.php" id="captcha" /><br/>
						<br/>
						<a href="#" onclick=" document.getElementById('captcha').src='{$this->synapse_dir}cool-php-captcha/captcha.php?'+Math.random(); document.getElementById('captcha-form').focus();" id="change-image">Not readable? Change text.</a><br/><br/>
						<input type="text" class="bginput" name="captcha" id="captcha-form" /></ br>
						<br>
						<input  class="buttonka" id="intro" type="submit" name="register_button" value="Register" />
ADMIN_FORM;
					// <button class="buttonka" id="intro" name="register_button">Register</button>
		if ($this->reg_type==0) {
				$entry_display .= <<<ADMIN_FORM
						<br />
						<input class="secondary" type="submit" name="register_button" value="Ask for Register Channel" style="width: 250px; height: 32px; font-size: 14px;" />
ADMIN_FORM;
					// <button class="secondary" id="intro" name="register_button" style="width: 250px; height: 32px; font-size: 14px;">Ask for Register Channel</button>
		}
$entry_display .= <<<ADMIN_FORM
					</td>
				</tr>
				</tbody>
				</table>
				</form>
				<br /><br />
		</center>
		</div>	
ADMIN_FORM;
		return $entry_display;
}

/* backup the db OR just a table
 * 
 * backup_tables('localhost','username','password','blog');
 * 
 **/
public function backup_tables($host,$user,$pass,$name,$tables = '*')
{
  
  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
  
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = ereg_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  
  //save file
  $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
  fwrite($handle,$return);
  fclose($handle);
}

public function write_channel_registration($p) {
	//echo ("{$_POST['login_username']} : {$_POST['login_password']} : {$_POST['login_repassword']} : {$_POST['login_email']}<br>");
	$rv = "1";
	return $this->userRegister("-", "-", $_POST['insert_friend'],$_POST['reg_password'],$_POST['reg_password'],$_POST['reg_email'],$rv);
}
	
public function write_registration($p) {
	$rv = "0";
	//echo ("{$_POST['login_username']} : {$_POST['login_password']} : {$_POST['login_repassword']} : {$_POST['login_email']}<br>");
	return $this->userRegister($_POST['reg_name'], $_POST['reg_surname'], $_POST['reg_username'],$_POST['reg_password'],$_POST['reg_repassword'],$_POST['reg_email'],$rv);
}

private function userRegister($rname, $rsurname, $rusername,$rpassword,$rcpassword,$remail,$rvisib) {
	$this->switch_users_table();
	/*
	$entry_display = <<<ADMIN_FORM
				<div class="hehe"><div class="smallfont"><center><b><a href="index.php">Registration of user</a></b></center></div></div>
ADMIN_FORM;
			echo ($entry_display);
	*/
    //$con = mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
	//if (!$con)
    //{
    //die('Could not connect: ' . mysql_error());
    //}
	//mysql_select_db($this->table) or die('Could not connect: ' . mysql_error());
	
	//$this->build_logins_db();
	
	//echo ("{$rusername} : {$rpassword} : {$rcpassword} : {$remail}<br>");
	
	// test for incorect chars in regname like :,;,/,?
	if ( (strpos($rusername,":")!==false)||(strpos($rusername,";")!==false)||(strpos($rusername,"?")!==false)||(strpos($rusername,"<")!==false)||(strpos($rusername,">")!==false)||
		 (strpos($rusername,",")!==false)||(strpos($rusername,"/")!==false)||(strpos($rusername,".")!==false)||(strpos($rusername,"-")!==false)||(strpos($rusername,"+")!==false)||
		 (strpos($rusername,"=")!==false)||(strpos($rusername,"!")!==false)||(strpos($rusername,"@")!==false)||(strpos($rusername,"#")!==false)||(strpos($rusername,"$")!==false)||
		 (strpos($rusername,"%")!==false)||(strpos($rusername,"^")!==false)||(strpos($rusername,"&")!==false)||(strpos($rusername,"*")!==false)||(strpos($rusername,"(")!==false)||
		 (strpos($rusername,")")!==false)||(strpos($rusername,"|")!==false)||(strpos($rusername,"{")!==false)||(strpos($rusername,"}")!==false)||(strpos($rusername,"'")!==false)||
		 (strpos($rusername,"~")!==false)||(strpos($rusername,"_")!==false) ) {
			$entry_display = <<<ADMIN_FORM
				<div class="hehe"><div class="smallfont"><center><b><a href="index.php">Registration Failed, Incorect Format. Refresh Page</a></b></center></div></div><script>reloadPage();</script>
ADMIN_FORM;
			echo ($entry_display);
			return null;
	}
	
    if ($rname==NULL||$rsurname==NULL||$rusername==NULL||$rpassword==NULL||$rcpassword==NULL||$remail==NULL)
    {
	//checks to make sure no fields were left blank
	echo "A field was left blank.";
	return null;
    } else if($rpassword != $rcpassword) {
        // the passwords are not the same!  
        echo "Passwords do not match";
	return null; 
    } else {
		$salt = '';
        //passwords match! We continue...
        
        if ( ( time() >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
				// $rpassword = md5($rpassword);
				if ($this->privacy_mode == 1) {
					if ($this->password_type == "md5") $rpassword = md5($rpassword); 
							else $rpassword = hash($this->password_type, $rpassword);
				} else $rpassword = $this->HashMe($rpassword, $salt);
				
						
				// crypt or decrypt
				//inicializácia vnorenej-triedy
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if (isset($this->synapse_password)) $this->Key  = $this->synapse_password; //kľúč
				$rpassword = $this->encrypt($rpassword); // zasifruje lubovolny retazec
		} else $rpassword = md5($rpassword);
        
        $checkname = mysql_query("SELECT username FROM users WHERE Username='$rusername'");
        $checkname= mysql_num_rows($checkname);
        $checkemail = mysql_query("SELECT email FROM users WHERE Email='$remail'");
        $checkemail = mysql_num_rows($checkemail);
        
	if (($checkemail>0) || ($checkname>0)) {
	// oops...someone has already registered with that username or email!

		$entry_display = <<<ADMIN_FORM
		<div class="hehe"><div class="smallfont"><center><b><a href="index.php">The username or email is already in use. Refresh Page</a></b></center></div></div><script>reloadPage();</script>
ADMIN_FORM;
		echo ($entry_display);
	} else {
		// noone is using that email or username!  We continue...
		$rusername = strip_tags($rusername);
		$rpassword = strip_tags($rpassword);
		$remail = strip_tags($remail);
		$rcreated = time();
		
		//echo ("{$rusername} : {$rpassword} : {$rcpassword} : {$remail}<br>");
		
		//$rvisib = "0";
		
        if ($this->privacy_mode == 0) mysql_query("INSERT INTO users VALUES ('$rusername', '$rpassword', '$salt', '$remail', '$rname', '$rsurname', '$rvisib', '', '', '','$rcreated')");
				else mysql_query("INSERT INTO users VALUES ('$rusername', '$rpassword', '$remail', '$rvisib', '', '', '','$rcreated')");

		// Send Info Mail to New Registered User
		mail ($remail, "Registration to Synapse.", "You are regitered with username: $rusername and password: $rcpassword to Synapse social network portal. Good Luck.");
		
		// Send Info Mail About New Registered User to Administrator
		mail ($this->adminemail, "New User to Synapse", "New user was register to Synapse with username: $rusername with email: $remail , thats all.");
		
		
		// create backup of table with new user
		$this->backup_tables($this->host,$this->username,$this->password,'users'); 
				
		
		$entry_display = <<<ADMIN_FORM
		<div class="hehe"><div class="smallfont"><center><b><a href="index.php">Registration of {$rusername} with {$remail} Successfull. Refresh Page</a></b></center></div></div><script>reloadPage();</script>
ADMIN_FORM;
		echo ($entry_display);
	}
  }
}

public function write_login($p) {
	//echo ("{$_POST['login_username']} : {$_POST['login_password']} : {$_POST['login_repassword']} : {$_POST['login_email']}<br>");
	return $this->userLogin($_POST['login_username'],$_POST['login_password']);
}

private function userLogin($rusername,$rpassword) {
    //$con = mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
	//if (!$con)
    //{
    //die('Could not connect: ' . mysql_error());
    //}
	//mysql_select_db($this->table) or die('Could not connect: ' . mysql_error());
	
	//$this->build_logins_db();
	
	//echo ("{$rusername} : {$rpassword} : {$rcpassword} : {$remail}<br>");
	
	$this->switch_users_table();
	
    if ($rusername==NULL||$rpassword==NULL)
    {
		//checks to make sure no fields were left blank
		echo "A field was left blank.";    
	}
		//find user in database
        $checkname = mysql_query("SELECT username FROM users WHERE Username='$rusername'");
        $checkname= mysql_num_rows($checkname);
		
	if ($checkname>0) {			
			if ( ( $this->getcreated($rusername) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
				//make hash of submited pass
				// $rpassword = md5($rpassword);// crypt or decrypt
				if ($this->privacy_mode == 1) {
					if ($this->password_type == "md5") $rpassword = md5($rpassword); 
						else $rpassword = hash($this->password_type, $rpassword);
				} else { 
					$checksalt = mysql_query("SELECT salt FROM users WHERE Username='$rusername'");	
					$a = mysql_fetch_assoc($checksalt);
					$salt = $a['salt'];
					$rpassword = $this->HashMe($rpassword, $salt);
				}
	
				//
				//inicializácia vnorenej-triedy
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if (isset($this->synapse_password)) $this->Key  = $this->synapse_password; //kľúč
				$rpassword = $this->encrypt($rpassword); // zasifruje lubovolny retazec
			} else $rpassword = md5($rpassword);
			
			
			// password compare
			$checkpass = mysql_query("SELECT password FROM users WHERE Username='$rusername'");	
			$a = mysql_fetch_assoc($checkpass);
			$rcpassword = $a['password'];
			//echo ("<center><big>====== {$rusername} :: {$rcpassword} =====</big></center>");
			if($rpassword == $rcpassword) {
				// all good.. lets go.
				//$_SESSION['refreshid']=5;
				//return $rusername;
				//setcookie("refreshid",0);
				//$_COOKIE['refreshid'] = 5;
				//$_COOKIE['loginuser'] = $rusername;
				//setcookie("loginuser",$rusername);
		$entry_display = <<<ADMIN_FORM
				<div class="hehe"><div class="smallfont"><center><b><a href="index.php">You are login as {$rusername} ! Refresh Page</a></b></center></div></div><script>reloadPage();</script>
ADMIN_FORM;
		echo ("$entry_display");
				return $rusername;
			} else { 
				$entry_display = <<<ADMIN_FORM
				<div class="hehe"><div class="smallfont"><center><b><a href="index.php">Failed Password. Refresh Page</a></b></center></div></div><script>reloadPage();</script>
ADMIN_FORM;
				echo ("$entry_display");
				return null; 
			}
	} else { 
				$entry_display = <<<ADMIN_FORM
				<div class="hehe"><div class="smallfont"><center><b><a href="index.php">Submited $rusername was NOT exist!</a></b></center></div></div><script>reloadPage();</script>
ADMIN_FORM;
				echo ("$entry_display");
				return null; 
	}
}
  
private function error_config() {
//    if (file_exists('./config.php')) include('./synapse-cms/error.php'); else
//	include("./synapse-cms/setup-config.php");
	// include("./synapse-cms/error.php");
}
  
private function connect_db() {
    if ($this->error_output==0) { mysql_connect($this->host,$this->username,$this->password) or die( "Could not connect. " . mysql_error() ); } else
		{ mysql_connect($this->host,$this->username,$this->password) or include('./synapse-cms/error.php'); }
}


public function switch_users_table() {
	mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

    return $this->build_users_db();
  }
  
private function build_users_db() {

	if ($this->privacy_mode == 0) {
		
		// registration with Name and Surname
		
		$sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS users (
Username	VARCHAR(150),
Password	VARCHAR(150),
Salt		VARCHAR(150),
Email		VARCHAR(150),
Name			VARCHAR(150),
Surname			VARCHAR(150),
Visible		VARCHAR(150),
Avatar		VARCHAR(150),
Inform		    	TEXT,
Lasttime	VARCHAR(150),
Created		INT(24)
)
MySQL_QUERY;

		return mysql_query($sql);
		
	} else {

		// for witthout register Name and Surname and other private variables
		
		$sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS users (
Username	VARCHAR(150),
Password	VARCHAR(150),
Email		VARCHAR(150),
Visible		VARCHAR(150),
Avatar		VARCHAR(150),
Inform		    	TEXT,
Lasttime	VARCHAR(150),
Created		INT(24)
)
MySQL_QUERY;

		return mysql_query($sql);
		
	}
}


	// END OF
  
}
 
?>
