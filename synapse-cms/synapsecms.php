<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
The MIT License (MIT)

Copyright (c) 2013 - 2014  Lukas Veselovsky

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


include(dirname(__FILE__).'/'.'synapsecms-users.php'); 

//// include("./synapse-cms/synapsecms-users.php");

	// !!! GetText localisation support with GET[] paramater  //
	//$locale = "de_DE";
	if (isSet($_SESSION["locale"])) $locale=$_SESSION["locale"]; else $locale = "en_US";
	if (isSet($_GET["locale"])) {$locale = $_GET["locale"];$_SESSION["locale"]=$locale;}

include(dirname(__FILE__).'/'.'php-mo.php');

    phpmo_convert( dirname(__FILE__).'/locale/'.$locale.'/LC_MESSAGES/messages.po', [ dirname(__FILE__).'/locale/'.$locale.'/LC_MESSAGES/messages.mo' ] );
	
	/// if (file_exists(dirname(__FILE__).'/locale/'.$locale.'/LC_MESSAGES/messages.po')) { echo("exists"); }
	
	putenv("LC_ALL=$locale");
	setlocale(LC_ALL, $locale);
	bindtextdomain("messages", "./synapse-cms/locale/");
	textdomain("messages");
		
	//echo _("Initialize Localisation");

/*
// what if we want to extend more then one class?
Abstract class ExtensionBridge
{
    // array containing all the extended classes
    private $_exts = array();
    public $_this;
       
    function __construct(){$_this = $this;}
   
    public function addExt($object)
    {
        $this->_exts[]=$object;
    }
   
    public function __get($varname)
    {
        foreach($this->_exts as $ext)
        {
            if(property_exists($ext,$varname))
            return $ext->$varname;
        }
    }
   
    public function __call($method,$args)
    {
        foreach($this->_exts as $ext)
        {
            if(method_exists($ext,$method))
            return call_user_method_array($method,$ext,$args);
        }
        throw new Exception("This Method {$method} doesn't exists");
    }   
}

    // parent::addExt(new Ext1());
    // parent::addExt(new Ext2());
*/

class Synapse extends Synapse_users {

// BEGIN OF

  //
  // Synapse Inherit Variables
  //
  
  // if mode=0 then crypt/decrypt is disabled
  // if mode=1 then crypt/decrypt is enabled - all bodytext and title are crypted and decrypted with
  // current user password
  
  // crypt files 1/0
  var $synapse_crypt_files = 0;
  
  // crypt password with central password 1/0
  var $synapse_crypt = 1;
  var $synapse_crypt_pwd; //= "k4hvdq9tj9";
  var $synapse_crypt_after = 1384200000;
  
  // if edit mode = 0 then store data in mysql db
  // if edit mode = 1 then store data in files
  var $editmode = 0;
  
  var $template;

  var $wisiwig = 0;
  
	// we support www.toplist.sk track system  
  var $track;

  var $reloadpage = 0;
  
  var $prefix = 1;

  var $synapse_version = "Release26";
  var $synapse_info = "May-2014";
  var $synapse_license = "MIT License";

  // synapse title and slogan
  var $synapse_title;
  var $synapse_slogan;
  
  
  var $listimages;
  
  // is extra public mode? not admin and not channel, 
  // ordinary user can post to zeropage.. if publicity=1
  var $publicity;
  // can user delete his message?
  var $delecity = 0;
  
  var $recyclecity = 1;

  // change background in actions 
  var $themecity = 0;

  var $mediafile = 0;
  
  // enable favourites..
  // var $sharecity;

  var $upload_dir = "./bindata/files/";

  var $synapse_path;

  var $synapse_bodycss;
  
  // 1=enable striptags, 0=disable striptags in display_messages
  var $striptags = 1;
  
  //var $adminemail;
  
  var $preview_jquery = 0;
  
  var $preview_type;
  
  // header is a friends option switcher
  
  // if preview_header = 1 then is normal header
  // if preview_header = 2 then is only visible friends switcher
  // other is pure clean
  var $preview_header = 0;
  
  // this some like header - footer is a form dialog
  var $preview_footer = 0;
  
  // how long is reply command line
  var $inside_area = 300;   // 650px
    
  //var $reg_type;
  
  var $lines = 20;
  var $lines_vert = 20;
  
  var $readmore_lines =199;
  var $readmore = false;

  var $vara, $varb, $varc, $vard;
  
  //var $host;
  //var $username;
  //var $password;
  //var $table;

  //var $loginuser;
  //var $admin;
  //var $pageid;
  
function __construct() {
    //print "SYNAPSE-CMS <br>";  // Initialize 
	
	// * type of switch css to display of messages
	if (empty($_SESSION['pwtp'])) $this->preview_type = 3; else $this->preview_type = $_SESSION['pwtp'];
	
    // !!! Important setting a synapse_dir variable !!! //
    $this->synapse_path=dirname(__FILE__)."/";
}
  
/* @info  this function, parse page before put to the screen for better view */
function spracuj_form($stranka) {
  $stranka = stripslashes($stranka);
  //$nahrad_co = array("[hr]");
  //$nahrad_cim = array("<hr>");
  $stranka = str_replace("[hr]", "", $stranka);
  $stranka = str_replace("<hr>", "", $stranka);
  $stranka = str_replace("</hr>", "", $stranka);
  $stranka = str_replace("</>", "", $stranka);
  $stranka = str_replace("<//>", "", $stranka);
  $stranka = preg_replace("#\<a href\=\"(.*?)\"\>(.*?)\<\/a\>#", "\\1", $stranka);
  // others
  $stranka = str_replace("[br]", "<br>", $stranka);
  $stranka = str_replace("[/br]", "</br>", $stranka);
  $stranka = preg_replace("#\[i\](.*?)\[/i\]#si", "<i>\\1</i>", $stranka);
  $stranka = preg_replace("#\[b\](.*?)\[/b\]#si", "<b>\\1</b>", $stranka);
  $stranka = preg_replace("#\[img\](.*?)\[/img\]#si", "<img src=\"\\1\" width=\"320\" height=\"240\" border=\"0\">", $stranka);
  $stranka = preg_replace("#\[url=(.*?)\](.*?)\[/url\]#si", "<a href=\"\\1\">\\2</a>", $stranka);
  $stranka = preg_replace("#\[red\](.*?)\[/red\]#si", "<font color=\"red\">\\1</font>", $stranka);
  $stranka = preg_replace("#\[green\](.*?)\[/green\]#si", "<font color=\"green\">\\1</font>", $stranka);
  $stranka = preg_replace("#\[blue\](.*?)\[/blue\]#si", "<font color=\"blue\">\\1</font>", $stranka);
  $stranka = preg_replace("#\[farba=\#(.*?)\](.*?)\[/farba\]#si", "<font color=\"#\\1\">\\2</font>", $stranka);
  $stranka = preg_replace("#\[vlavo\](.*?)\[/vlavo\](.*?)<br />#si", "<div align=\"left\">\\1</div>", $stranka);
  $stranka = preg_replace("#\[stred\](.*?)\[/stred\](.*?)<br />#si", "<div align=\"center\">\\1</div>", $stranka);
  $stranka = preg_replace("#\[vpravo\](.*?)\[/vpravo\](.*?)<br />#si", "<div align=\"right\">\\1</div>", $stranka);
  $stranka = preg_replace("#([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "<a href=\"mailto:\\1@\\2\">\\1@\\2</a>", $stranka);
  $stranka = preg_replace("#\*\*([[:digit:]]{1,2})\*#si", "<img src=\"smajliky/\\1.gif\" alt=\"Smajlik\" border=\"0\">", $stranka);
  
  $stranka = preg_replace("#\[style\](.*?)\[/style\]#si", "<style>\\1</style>", $stranka);
  
	// youtube iframe support
  $stranka = preg_replace("#\[iframe\](.*?)\[/iframe\]#si", "<iframe width=\"560\" height=\"315\" src=\"\\1\" frameborder=\"0\" allowfullscreen></iframe>", $stranka);
  
  return $stranka;
}

	function get_bodytext($bla, $crea, $usr) {
		//echo($crea."---".$usr."---");
		// crypt or decrypt
		if ( ($this->synapse_crypt==1)&&($crea>=$this->synapse_crypt_after) ) {

			$kluc = "";
			if ( ( $this->getcreated($usr) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				$this->Key  = $this->synapse_password; //kľúč
				$kluc = $this->decrypt($this->getpassword($usr)); // desifruje lubovolny zasifrovany retazec
			}
			//inicializácia vnorenej-triedy
			//$crypt = new Crypt();
			$this->Mode = Crypt::MODE_HEX; // druh šifrovania
			if ( ( $this->getcreated($usr) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
				$this->Key  = $kluc; //kľúč
			} else {
				if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($usr); //kľúč
			}
			
			//$encrypted = $crypt->encrypt('lubovolny retazec'); // zasifruje lubovolny retazec
			$bla = $this->decrypt($bla); // desifruje lubovolny zasifrovany retazec
		}
		// test for log string
		if ($this->readmore==true) {
			if (mb_strlen($bla) >= $this->readmore_lines) { $txt = mb_substr($bla, 0, $this->readmore_lines); $txt .= "<br><br><div class=\"navig\"><a href=\"index.php?message=$crea\">Read the full post</a></div><br>"; return  $txt; } else { return $bla; } 
		} else return $bla;
	}

	function get_titletext($bla, $crea, $usr) {
		//echo($crea."---".$usr."---");
		// crypt or decrypt
		if ( ($this->synapse_crypt==1)&&($crea>=$this->synapse_crypt_after) ) {
		$kluc = "";
		if ( ( $this->getcreated($usr) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				$this->Key  = $this->synapse_password; //kľúč
				$kluc = $this->decrypt($this->getpassword($usr)); // desifruje lubovolny zasifrovany retazec
		}
		//inicializácia vnorenej-triedy
		//$crypt = new Crypt();
		$this->Mode = Crypt::MODE_HEX; // druh šifrovania
		if ( ( $this->getcreated($usr) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
			$this->Key  = $kluc; //kľúč
		} else {
			if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($usr); //kľúč
		}
			
		//$encrypted = $crypt->encrypt('lubovolny retazec'); // zasifruje lubovolny retazec
		$bla = $this->decrypt($bla); // desifruje lubovolny zasifrovany retazec}
		}
		
		return $bla;
	}

	
	// FILE / DATABASE ABSTRACTION LAYER
	
	public function display_bodytext($crea) {
		if ($this->editmode==0) {
			$this->switch_data_table();
		
			$q = mysql_query("SELECT Bodytext FROM data WHERE Created='$crea'");	
			$a = mysql_fetch_assoc($q);
			return $pgtxt = $a['Bodytext'];
		} else {
			$data = "";
			$handle = fopen("pages/bodytext-".$crea.".php","r"); 
			while (!feof($handle)) 
			{ 
				$data .= fgets($handle, 512);  
			} 
			fclose($handle);
			return $data; 
		}
	}
	
	public function display_title($crea) {
		if ($this->editmode==0) {
			$this->switch_data_table();
		
			$q = mysql_query("SELECT Title FROM data WHERE Created='$crea'");	
			$a = mysql_fetch_assoc($q);
			return $pgtxt = $a['Title'];
		} else {
			$data = "";
			$handle = fopen("pages/title-".$crea.".php","r"); 
			while (!feof($handle)) 
			{ 
				$data .= fgets($handle, 512);  
			} 
			fclose($handle);
			return $data; 
		}
	}
	
	public function display_user($crea) {
		if ($this->editmode==0) {
			$this->switch_data_table();
		
			$q = mysql_query("SELECT Username FROM data WHERE Created='$crea'");	
			$a = mysql_fetch_assoc($q);
			return $pgtxt = $a['Username'];
		} else {
			$data = "";
			$handle = fopen("pages/username-".$crea.".php","r"); 
			while (!feof($handle)) 
			{ 
				$data .= fgets($handle, 512);  
			} 
			fclose($handle);
			return $data; 
		}
	}

///////

function display_insertcode_dialog($uziv) {
		return $display_entry =<<<DISPLAY
		<br>
		<form method="post" action="index.php?user={$uziv}" >
			<table>
				<tr><td><label for="meno"></label></td><td>&nbsp;<input type="text" style="width: 240px;" id="search" name="search"></td><td><input type="submit" style="background: #F9F9F9;" name="insertcodeBtn" value="Insert Code"></td></tr>
			</table>	
		</form>
		<br>
DISPLAY;
	// <input type="hidden" name="user" value="{$uziv}">
}

function list_image_files($dir)
{
  $message_display = <<<MESSAGE_DISPLAY
		<br>
		<div class="outer">
		<ul id="menu-ho">
MESSAGE_DISPLAY;
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
		$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {
			$rul = $dir . "/" . $file;
			// decrypt if needed
			if (strpos($file, ".sif")!==false) { 
				$this->decrypt_file($rul , $_SESSION['loginuser'] );
				$rul = preg_replace('/\.sif$/','',$rul);
			}
			// preview image
			if ( (strpos($file, ".png")!==false)  ||  (strpos($file, ".jpg")!==false)
			 ||  (strpos($file, ".PNG")!==false)  ||  (strpos($file, ".JPG")!==false) )  if ($id<=5) {
				$message_display .= <<<MESSAGE_DISPLAY
					<li>
					<a href="$dir/$file">
					<img  HSPACE=5 VSPACE=5 ALIGN=LEFT border=5; width=102px; height=76px; src="{$rul}" alt="painting" title="painting" >
					<span>
						<b class="h2">{$file}</b><br />
						
						Picture file.
					</span>
					</a>
				</li>
MESSAGE_DISPLAY;
		  } // <b class="h3">$dir</b><br />
          $id++;
		}
      }
	   //if ($id > 100) echo '<br><b>Next Page</b> .... ';
      closedir($handle);
    }
  }
  $message_display .= <<<MESSAGE_DISPLAY
		</ul>
		</div>
		<br>
		<br>
MESSAGE_DISPLAY;
  echo($message_display);
}

function list_image_files_box($dir)
{
  $message_display = <<<MESSAGE_DISPLAY
		<ul>
MESSAGE_DISPLAY;
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
		$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {
			$rul = $dir . "/" . $file;
			// decrypt if needed
			if (strpos($file, ".sif")!==false) { 
				$this->decrypt_file($rul , $_SESSION['loginuser'] );
				$rul = preg_replace('/\.sif$/','',$rul);
			}
			// preview image
			if ( (strpos($file, ".png")!==false)  ||  (strpos($file, ".jpg")!==false)
			 ||  (strpos($file, ".PNG")!==false)  ||  (strpos($file, ".JPG")!==false)
			 ||  (strpos($file, ".bmp")!==false)  ||  (strpos($file, ".BMP")!==false)
			 ||  (strpos($file, ".jpeg")!==false)  ||  (strpos($file, ".JPEG")!==false)			 )  if ($id<=5) {
				$message_display .= <<<MESSAGE_DISPLAY
					<li>
					<a href="$dir/$file">
					<span>
					<img  HSPACE=15 VSPACE=15 ALIGN=LEFT border=5; width=320px; height=240px; src="{$rul}" alt="painting" title="painting" >
					<br>
						<b class="h2">{$file}</b>
					</span><br />
					</a>
					</li>
MESSAGE_DISPLAY;
		  } // <b class="h3">$dir</b><br />
          $id++;
		}
      }
	   //if ($id > 100) echo '<br><b>Next Page</b> .... ';
      closedir($handle);
    }
  }
  $message_display .= <<<MESSAGE_DISPLAY
		</ul>
MESSAGE_DISPLAY;
  echo($message_display);
}

function list_files_ex($dir, $uziv, $security, $search, $issearch, $mix )
{
  
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/ && (strstr($file, ".xxx")===false))
        {
			if ( (($issearch!=0)&&(strpos($file, $search)!==false)) || ($issearch==0) ) { 	
					if  ( ( $mix ==1) && ( (strpos($file, ".png")!==false)  
						||  (strpos($file, ".jpg")!==false) 
						|| (strpos($file, ".jpeg")!==false) 
						|| (strpos($file, ".PNG")!==false) 
						|| (strpos($file, ".JPG")!==false) ) ) { 
								echo ' <a href="'.$dir.$file.'"><img  HSPACE=5; VSPACE=5; ALIGN=center; border=5; width=448px; height=336px; src="'.$dir.$file.'"></a><br>';
								echo '<div id="picture-link">'.$file.'</div><br/>'."\n";
					} else
					if  ( $mix ==2) { 
					     if ( (strpos($file, ".wma")!==false)  
						 || (strpos($file, ".WMA")!==false)  
						 || (strpos($file, ".mp3")!==false) 
						 || (strpos($file, ".MP3")!==false) 
						 || (strpos($file, ".flac")!==false) 
						 || (strpos($file, ".FLAC")!==false) )  
							echo '<a id="browser-link" style="
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="player.php?user='.$uziv.'&playlist='.$file.'">'.$file.'</a> <br/>'."\n";
					} else
					if (strstr($file, ".xspf")!==false) {
						if ($security==0) echo '<a id="browser-link" style="
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="player.php?user='.$uziv.'&playlist='.$file.'">'.$file.'</a> <br/>'."\n";
						else echo '<a id="browser-link" style="

border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="player.php?user='.$uziv.'&playlist='.$file.'">'.$file.'</a> <a style="float: left; border: none; border-radius: none;" href="zmaz_subor.php?nazov='.$dir.$file.'"><img style="border:0 ;width:23px ;height:23px; margin-top:5px;" src="style/trash.png"></a><br/>'."\n";
					} else {
						if ($security==0) echo '<a id="browser-link" style="
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="'.$dir.$file.'">'.$file.'</a> <br/>'."\n";
						else echo '<a id="browser-link" style="

border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="'.$dir.$file.'">'.$file.'</a> <a style="float: left; border: none; border-radius: none;" href="zmaz_subor.php?nazov='.$dir.$file.'"><img style="border:0 ;width:23px ;height:23px; margin-top:5px;" src="style/trash.png"></a><br/>'."\n";
					if(file_exists($dir.$file.".xxx")) {
						echo("<i><center>");
						$subor = fopen($dir.$file.".xxx","r"); 
						$text = fgets($subor,1000);
						fclose($subor);
						echo($text);
						echo("</i></center>");
					}
				}
			}
		}
      }
      closedir($handle);
    }
  }
}

function list_files($dir, $security, $search, $issearch)
{
  
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {
			if ( (($issearch!=0)&&(strpos($file, $search)!==false)) || ($issearch==0) ) { 	
$style_message = <<<MESSAGE
<style type="text/css">
#browser-link {
overflow: auto;
float: left;
margin-top: 5px;
margin-left: 10px;
width: 95%;
}
</style>
MESSAGE;
echo ($style_message);
				if ($security==0) echo '<a id="browser-link" style="
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="'.$dir.$file.'">'.$file.'</a> <br/>'."\n";
				else echo '<a id="browser-link" style="

border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
"

target="_blank" href="'.$dir.$file.'">'.$file.'</a> <a style="float: left; border: none; border-radius: none;" href="'.$this->synapse_dir.'delete_file.php?filename='.$dir.$file.'"><img style="border:0 ;width:23px ;height:23px; margin-top:5px;" src="'.$this->synapse_dir.'themes/images/interface/trash.png"></a><br/>'."\n";
			}
		}
      }
      closedir($handle);
    }
  }
}

public function fnEncrypt($sValue, $sSecretKey)
{
    return rtrim(
        base64_encode(
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256,
                $sSecretKey, $sValue, 
                MCRYPT_MODE_ECB, 
                mcrypt_create_iv(
                    mcrypt_get_iv_size(
                        MCRYPT_RIJNDAEL_256, 
                        MCRYPT_MODE_ECB
                    ), 
                    MCRYPT_RAND)
                )
            ), "\0"
        );
}

public function fnDecrypt($sValue, $sSecretKey)
{
    return rtrim(
        mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256, 
            $sSecretKey, 
            base64_decode($sValue), 
            MCRYPT_MODE_ECB,
            mcrypt_create_iv(
                mcrypt_get_iv_size(
                    MCRYPT_RIJNDAEL_256,
                    MCRYPT_MODE_ECB
                ), 
                MCRYPT_RAND
            )
        ), "\0"
    );
}


public function fileEncrypt($source, $destination) {
 // $key="passwordDR0wSS@P6660juht";
 $this->Mode = Crypt::MODE_HEX; // druh šifrovania
 $this->Key  = $this->synapse_password; //kľúč
 $kluc = $this->decrypt($this->getpassword($_SESSION['loginuser'])); // desifruje lubovolny zasifrovany retazec

 $key = $kluc;
 $iv="password";
if (extension_loaded('mcrypt') === true)
 {
   if (is_file($source) === true)
     {
      $source = file_get_contents($source);
      $encryptedSource=$this->TripleDesEncrypt($source,$key,$iv);
      if (file_put_contents($destination,$encryptedSource, LOCK_EX) !== false)
       {
        return true;
       }
     return false;
     } else echo("not file");
 return false;
 }
return false;
 }
 
public function fileDecrypt($source, $destination) {
 // $key="passwordDR0wSS@P6660juht";
 $this->Mode = Crypt::MODE_HEX; // druh šifrovania
 $this->Key  = $this->synapse_password; //kľúč
 $kluc = $this->decrypt($this->getpassword($_SESSION['loginuser'])); // desifruje lubovolny zasifrovany retazec

 $key = $kluc;
 $iv="password";
 if (extension_loaded('mcrypt') === true)
 {
 if (is_file($source) === true)
 {
 $source = file_get_contents($source);
 $decryptedSource=self::TripleDesDecrypt($source,$key,$iv);
 if (file_put_contents($destination,$decryptedSource, LOCK_EX) !== false)
 {
 return true;
 }
 echo "no read";
 return false;
 }
 echo "no file";
 return false;
 }
 echo "no mcrypt";
 
return false;
 }
 
/*
 Apply tripleDES algorthim for encryption, append "___EOT" to encrypted file ,
 so that we can remove it while decrpytion also padding 0's
 */
function TripleDesEncrypt($buffer,$key,$iv) {
 $cipher = mcrypt_module_open(MCRYPT_3DES, '', 'cbc', '');
 $buffer.='___EOT';
 // get the amount of bytes to pad
 $extra = 8 - (strlen($buffer) % 8);
 // add the zero padding
 if($extra > 0) {
 for($i = 0; $i < $extra; $i++) {
 $buffer .= '_';
 }
 }
 mcrypt_generic_init($cipher, $key, $iv);
 $result = mcrypt_generic($cipher, $buffer);
 mcrypt_generic_deinit($cipher);
 return base64_encode($result);
 }
 
/*
 Apply tripleDES algorthim for decryption, remove "___EOT" from encrypted file ,
 so that we can get the real data.
 */
function TripleDesDecrypt($buffer,$key,$iv) {
 $buffer= base64_decode($buffer);
 $cipher = mcrypt_module_open(MCRYPT_3DES, '', 'cbc', '');
 mcrypt_generic_init($cipher, $key, $iv);
 $result = mdecrypt_generic($cipher,$buffer);
 $result=substr($result,0,strpos($result,'___EOT'));
 mcrypt_generic_deinit($cipher);
 return $result;
 }
//- See more at: http://howwhywhat.in/how-to-implement-common-file-encryption-and-decryption-between-c-and-php#sthash.5yPSyliW.dpuf

public function decrypt_file($url, $user) {
		// crypt if file is mp3
		if ($this->synapse_crypt_files==1) {
			if (strpos($url, ".sif")!==false) {
				$dest = preg_replace('/\.sif$/','',$url);
				$this->fileDecrypt($url, $dest);
				//$Pass = $this->getpassword($user); //kľúč
				
				//echo $user;
				
				/*
				$f=fopen($url,'rb');
				$data='';
				$size=1024;
				while(!feof($f)) { 
					$data=fread($f,$size);
					//$cdata = fnDecrypt($data, $Pass);
					echo "Decrypred.. ".$data."</br>";   
				}
				fclose($f);  
				//$cdata = $data;
				*/
		        //$data = file_get_contents($url); // (PHP 4 >= 4.3.0, PHP 5) 
				
		        //$url = substr($url,0,-4);
				//echo $url;
				// Remove .sif from the end of string:
				//$url = preg_replace('/\.sif$/','',$url);
				//echo $url;
				//$f = fopen($url,'wb');
				//fwrite($f,$cdata,strlen($cdata));
				//fclose($f); 
				//$f=file_put_contents($url, $cdata); // (PHP 5) 
			}
		}
}

public function crypt_file($url, $user) {
		// crypt if file is mp3
		if ($this->synapse_crypt_files==1) {
			$this->fileEncrypt($url, $url . ".sif");
			//if ( (strpos($url, ".mp3")!==false)  ||  (strpos($url, ".MP3")!==false) ) {
				//echo $url;
				/*
				$f=fopen($url,'rb');
				$data='';
				$size=8192;
				while(!feof($f)) $data.=fread($f,$size);
				fclose($f);  
				//echo $data;
				$cdata = $data;
				*/
		      //  $data = file_get_contents($url); // (PHP 4 >= 4.3.0, PHP 5) 
		       
				//$Pass = $this->getpassword($user); //kľúč
				//$Clear = $data;

				//$cdata = $this->fnEncrypt($Clear, $Pass);
				//echo "Encrypred: ".$cdata."</br>";
				
 			    //inicializácia vnorenej-triedy
				//$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				//if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($user); //kľúč
				//$cdata = $this->encrypt($data); // zasifruje lubovolny retazec
				//$f = fopen($url . ".sif",'wb');
				//fwrite($f,$cdata,strlen($cdata));
				//fclose($f); 
				// $f=file_put_contents($url . ".sif", $cdata); // (PHP 5) 
				// delete file
				//$result=@unlink($this->upload_dir . $myuser . "/" . basename( $_FILES['upfile']['name'] ));
				//if($result==false) echo 'deleting file failed.<br />';
			//}
		}
}

function ismedia($file) {
	if ( (strpos($file, ".wma")!==false)  
						 || (strpos($file, ".WMA")!==false)  
						 || (strpos($file, ".mp3")!==false) 
						 || (strpos($file, ".MP3")!==false) 
						 || (strpos($file, ".flac")!==false) 
						 || (strpos($file, ".FLAC")!==false) )
			return 1; else return 0;
}

function upload_myfile($after) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	// formular
	$message_display = <<<MESSAGE_DISPLAY
		<div style="text-align: center;" class="messagepanel">
		<center>
		<br>
	    <form action="{$_SERVER['PHP_SELF']}" method="post" name="fileForm" id="fileForm" enctype="multipart/form-data">
		<h3>
		Upload file for the $myuser
		</h3>
		<br/> 
		<br/>
        <table>
          <tr>
          <td>
          <input style="border: 2px solid #DFDFDF;" name="upfile" type="file" size="26">
		  <input style="background: #FFFFFF" class="text" type="submit" name="task" value="Upload">
		  </td>
		  </tr>
        </table> 
		</form>
		<br>
		</center>
		</div>
MESSAGE_DISPLAY;
	echo($message_display);
	
	if ( (isset($_POST['task'])) && ($_POST['task']=="Upload") ) {
		if ( $_POST['upfile'] ) $meno = $_POST['upfile'];
		//Windows way
		
		//if ($prefix==0) $pref=$myuser; else $pref="";
		
		$uploadLocation = $this->upload_dir .$meno; // fix and add myuser  $myuser . 
		echo $uploadLocation;
		//Unix, Linux way
		//$uploadLocation = "\tmp";
		$meno = $_SESSION['loginuser'] . '/';
		$target_dir = $uploadLocation . $meno;
		if (!file_exists($target_dir )) {
			mkdir($target_dir);
		}
		$target_path = $target_dir  . basename( $_FILES['upfile']['name']);
		$blacklist = array(".php", ".phtml", ".php3", ".php4", ".php5", ".js", ".shtml", ".pl" ,".py");
		foreach ($blacklist as $file) 
		{
			if(preg_match("/$file\$/i", $_FILES['upfile']['name'])) 
			{
				echo "Error, failed filename.\n";
				exit;
			}
		}
		
		// is media file ? mp3, wav, mpg, ogg
		if ( $this->ismedia(basename($_FILES['upfile']['name'])) == 1 ) {
			// if yes is supported enabled upload
			if ($this->mediafile==1) {
				// upload process
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $target_path)) {
					echo "$Web" . "$WebFolder". $meno .  basename( $_FILES['upfile']['name']);
				} else{
					echo "Error, while Uploading file!";
				} 
				// crypt file
				$this->crypt_file($this->upload_dir . $myuser . "/" . basename( $_FILES['upfile']['name'] ), $myuser );       
				// delete file if is mp3, or other licensed material, becouse only user can decrypt file, its only for his purpose
				$file = basename( $_FILES['upfile']['name'] );
				$result=@unlink($this->upload_dir . $myuser . "/" . basename( $_FILES['upfile']['name'] ));
				if($result==false) echo 'deleting file failed.<br />';
			} else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Upload for Media files is disabled. Refresh Page</a></b></center></div></div><script></script>");
		} else {
				// upload process
				if(move_uploaded_file($_FILES['upfile']['tmp_name'], $target_path)) {
					echo "$Web" . "$WebFolder". $meno .  basename( $_FILES['upfile']['name']);
				} else{
					echo "Error, while Uploading file!";
				}
		}
	}

	if ($after==1) $this->list_image_files ($this->upload_dir . $myuser . "/");
}

function unlink_files($usr)
{
  if ($this->synapse_crypt_files==1) {
	  
	echo (" unlink files.. <br />");
	  
	$dir = $this->upload_dir . $usr . "/";
	  
	if(is_dir($dir))
	{
    if($handle = opendir($dir))
    {
		$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {	
			if (strpos($file, ".sif")!==false) { 
			} else {
				//echo (" Deleting ". $dir . $file . "<br />");
				$result=@unlink($dir . $file );
				//if($result==false) echo 'deleting file failed.<br />'; else echo 'deleting file $file OK<br />';
				
			}
		}
	  }
		closedir($handle);
	 }
	 }
   }
}


function unpack_files($usr)
{
  if ($this->synapse_crypt_files==1) {
	  
	$dir = $this->upload_dir . $usr . "/";
	  
	if(is_dir($dir))
	{
    if($handle = opendir($dir))
    {
		$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {	
			if (strpos($file, ".sif")!==false) { 
				if  ( (strpos($file, ".jpg")!==false)||(strpos($file, ".JPG")!==false)
						||(strpos($file, ".png")!==false)||(strpos($file, ".PNG")!==false) ) { 
							$rul = $dir . $file;
							// $ruldest = preg_replace('/\.sif$/','',$rul);
							$this->decrypt_file($rul , $usr );
				}
			}
		}
	  }
		closedir($handle);
	 }
	 }
   }
}

public function list_decrypt_files($dir)
{ 
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {	if (strpos($file, ".sif")!==false) {
				
					echo $display_entry = <<<DISPLAY_ITEM
				<tr class="container-tr" onmouseover="gviewApp.hoverContainerRow(this, false, true);" onmousemove="gviewApp.hoverContainerRow(this, false, true);" onmouseout="gviewApp.hoverContainerRow(this, false, false);"><td class="container-td container-td-name"><span class="container-nowrap"><span class="goog-inline-block container-icon" style="background-image: url( &quot;https://ssl.gstatic.com/docs/doclist/images/icon_9_generic_list.png&quot;);"></span>
				<span class="goog-inline-block container-spacing">&nbsp;</span>
				<span class="goog-inline-block container-folder-name"><span class="goog-inline-block">&nbsp;</span></span>
				<span class="goog-inline-block container-name">{$file}</span></span></td>
				<td class="container-td container-td-type"><span class="container-nowrap"> Crypted File</span></td>
				<td class="container-td container-td-size"><span class="container-nowrap">-&nbsp;kB</span></td>
				<td class="container-td container-td-action"><span class="container-action container-nowrap"><div class="container-action-flyout"></div></span></td>
				<td style="display: none">
				<p class="container-durl">/index.php?decryptfile={$file}</p>
				</td></tr>  
DISPLAY_ITEM;
				// $this->decrypt_file($this->upload_dir . $_SESSION['loginuser'] . "/" . $file , $_SESSION['loginuser'] );
			} else	
				if ($this->ismedia($file)==1) { 
				
				echo $display_entry = <<<DISPLAY_ITEM
				<tr class="container-tr" onmouseover="gviewApp.hoverContainerRow(this, false, true);" onmousemove="gviewApp.hoverContainerRow(this, false, true);" onmouseout="gviewApp.hoverContainerRow(this, false, false);"><td class="container-td container-td-name"><span class="container-nowrap"><span class="goog-inline-block container-icon" style="background-image: url( &quot;https://ssl.gstatic.com/docs/doclist/images/icon_9_generic_list.png&quot;);"></span>
				<span class="goog-inline-block container-spacing">&nbsp;</span>
				<span class="goog-inline-block container-folder-name"><span class="goog-inline-block">&nbsp;</span></span>
				<span class="goog-inline-block container-name">{$file}</span></span></td>
				<td class="container-td container-td-type"><span class="container-nowrap"> File</span></td>
				<td class="container-td container-td-size"><span class="container-nowrap">-&nbsp;kB</span></td>
				<td class="container-td container-td-action"><span class="container-action container-nowrap"><div class="container-action-flyout"></div></span></td>
				<td style="display: none">
				<p class="container-durl">/index.php?mediafile={$file}</p>
				</td></tr>  
DISPLAY_ITEM;
			}
        }
      }
      closedir($handle);
    }
  }
}

function time_elapsed_A($secs) {
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
        );
       
    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;
       
    return join(' ', $ret);
}   

function time_elapsed_B($secs) {
    $bit = array(
        ' year'        => $secs / 31556926 % 12,
        ' week'        => $secs / 604800 % 52,
        ' day'        => $secs / 86400 % 7,
        ' hour'        => $secs / 3600 % 24,
        ' minute'    => $secs / 60 % 60,
        ' second'    => $secs % 60
        );
       
    foreach($bit as $k => $v){
        if($v > 1)$ret[] = $v . $k . 's';
        if($v == 1)$ret[] = $v . $k;
        }
    array_splice($ret, count($ret)-1, 0, 'and');
    $ret[] = 'ago.';
   
    return join(' ', $ret);
}

/**
// $nowtime = time();
// $oldtime = 1335939007;

// echo "time_elapsed_A: ".time_elapsed_A($nowtime-$oldtime)."\n";
// echo "time_elapsed_B: ".time_elapsed_B($nowtime-$oldtime)."\n";

// time_elapsed_A: 6d 15h 48m 19s
// time_elapsed_B: 6 days 15 hours 48 minutes and 19 seconds ago.
**/

function nicetime($date) {
    if(empty($date)) {
        return "No date provided";
    }
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
   
    $now             = time();
    $unix_date         = strtotime($date);
   
       // check validity of date
    if(empty($unix_date)) {   
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
}

/**
// $date = "2009-03-04 17:45";
// $result = nicetime($date); // 2 days ago
**/


function fill_calendar($t,$f,$s) {
	// if s=0 then is witthout this as sidepanel	
	if ($s==1)
	echo $display_item = <<<DISPLAY
		<div class="aside_expand">
		<aside>
DISPLAY;
	
	if ($f==2) {
		$imgpth=$this->synapse_dir."themes/images/interface/system-users.png";
		echo("<br><div class=\"likeBox\"><div class=\"like\"><span>".$this->howmanyfriends()."</span><a href=\"index.php\" class=\"liketxt\" style=\"left: -30px;\" title=\"Registered users.\"><img src=".$imgpth."></a></div></div><br><br>");	
	}

	echo $display_item = <<<DISPLAY
		<ul>
		<li><strong><a href="#">Now</a></strong>
		</li>
DISPLAY;

	$time_to_handle_for_next_month_conversion = time();

    // Date Conversions
    
    $interpretted_day = date('d', $time_to_handle_for_next_month_conversion);
    $interpretted_month = date('F', $time_to_handle_for_next_month_conversion);
    $interpretted_month_lowercased = strtolower($interpretted_month);
    $interpretted_year = date('Y', $time_to_handle_for_next_month_conversion);

	//var_dump($interpretted_day);
	//var_dump($interpretted_month);
	//var_dump($interpretted_year);


	if ($t==0) 
	switch ($interpretted_month)
	{
		case "December":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-12-{$interpretted_year}&timeline2=30-12-{$interpretted_year}">December {$interpretted_year}</a></li>
DISPLAY;
		case "November":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-11-{$interpretted_year}&timeline2=30-11-{$interpretted_year}">November {$interpretted_year}</a></li>
DISPLAY;
		case "October":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-10-{$interpretted_year}&timeline2=30-10-{$interpretted_year}">October {$interpretted_year}</a></li>
DISPLAY;
		case "September":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-09-{$interpretted_year}&timeline2=30-09-{$interpretted_year}">September {$interpretted_year}</a></li>
DISPLAY;
		case "August":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-08-{$interpretted_year}&timeline2=30-08-{$interpretted_year}">August {$interpretted_year}</a></li>
DISPLAY;
		case "July":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-07-{$interpretted_year}&timeline2=30-07-{$interpretted_year}">July {$interpretted_year}</a></li>
DISPLAY;
		case "June":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-06-{$interpretted_year}&timeline2=30-06-{$interpretted_year}">June {$interpretted_year}</a></li>
DISPLAY;
		case "May":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-05-{$interpretted_year}&timeline2=30-05-{$interpretted_year}">May {$interpretted_year}</a></li>
DISPLAY;
		case "April":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-04-{$interpretted_year}&timeline2=30-04-{$interpretted_year}">April {$interpretted_year}</a></li>
DISPLAY;
		case "March":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-03-{$interpretted_year}&timeline2=30-03-{$interpretted_year}">March {$interpretted_year}</a></li>
DISPLAY;
		case "February":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-02-{$interpretted_year}&timeline2=30-02-{$interpretted_year}">February {$interpretted_year}</a></li>
DISPLAY;
		case "January":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-01-{$interpretted_year}&timeline2=30-01-{$interpretted_year}">January {$interpretted_year}</a></li>
DISPLAY;
		break;
	} else
	switch ($interpretted_month)
	{
		case "January":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-01-{$interpretted_year}&timeline2=30-01-{$interpretted_year}">January {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="January") break;
		case "February":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-02-{$interpretted_year}&timeline2=30-02-{$interpretted_year}">February {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="February") break;
		case "March":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-03-{$interpretted_year}&timeline2=30-03-{$interpretted_year}">March {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="March") break;
		case "April":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-04-{$interpretted_year}&timeline2=30-04-{$interpretted_year}">April {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="April") break;
		case "May":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-05-{$interpretted_year}&timeline2=30-05-{$interpretted_year}">May {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="May") break;
		case "June":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-06-{$interpretted_year}&timeline2=30-06-{$interpretted_year}">June {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="June") break;
		case "July":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-07-{$interpretted_year}&timeline2=30-07-{$interpretted_year}">July {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="July") break;
		case "August":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-08-{$interpretted_year}&timeline2=30-08-{$interpretted_year}">August {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="August") break;
		case "September":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-09-{$interpretted_year}&timeline2=30-09-{$interpretted_year}">September {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="September") break;
		case "October":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-10-{$interpretted_year}&timeline2=30-10-{$interpretted_year}">October {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="October") break;
		case "November":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-11-{$interpretted_year}&timeline2=30-11-{$interpretted_year}">November {$interpretted_year}</a></li>
DISPLAY;
			if ($interpretted_month=="November") break;
		case "December":
			echo $display_item = <<<DISPLAY
				<li><a href="index.php?timeline1=01-12-{$interpretted_year}&timeline2=30-12-{$interpretted_year}">December {$interpretted_year}</a></li>
DISPLAY;
			// if ($interpretted_month=="December") break;
		break;
	}
	
	$interpretted_year=$interpretted_year-1;
	echo $display_item = <<<DISPLAY
		<li><a href="index.php?timeline1=01-12-{$interpretted_year}&timeline2=30-12-{$interpretted_year}">December {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-11-{$interpretted_year}&timeline2=30-11-{$interpretted_year}">November {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-10-{$interpretted_year}&timeline2=30-10-{$interpretted_year}">October {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-09-{$interpretted_year}&timeline2=30-09-{$interpretted_year}">September {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-08-{$interpretted_year}&timeline2=30-08-{$interpretted_year}">August {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-07-{$interpretted_year}&timeline2=30-07-{$interpretted_year}">July {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-06-{$interpretted_year}&timeline2=30-06-{$interpretted_year}">June {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-05-{$interpretted_year}&timeline2=30-05-{$interpretted_year}">May {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-04-{$interpretted_year}&timeline2=30-04-{$interpretted_year}">April {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-03-{$interpretted_year}&timeline2=30-03-{$interpretted_year}">March {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-02-{$interpretted_year}&timeline2=30-02-{$interpretted_year}">February {$interpretted_year}</a></li>
		<li><a href="index.php?timeline1=01-01-{$interpretted_year}&timeline2=30-01-{$interpretted_year}">January {$interpretted_year}</a></li>
DISPLAY;
	echo $display_item = <<<DISPLAY
		<li><a href="index.php">Actual</a></li>
		</ul>
DISPLAY;
	
	if ($f==1) {
		$imgpth=$this->synapse_dir."themes/images/interface/system-users.png";
		echo("<br><br><br><div class=\"likeBox\"><div class=\"like\"><span>".$this->howmanyfriends()."</span><a href=\"index.php\" class=\"liketxt\" style=\"left: -30px;\" title=\"Registered users.\"><img src=".$imgpth."></a></div></div>");	
	}

	// if s=0 then is witthout this as sidepanel	
	if ($s==1)
	echo $display_them =<<<DISPLAY
		</aside>
		</div>
DISPLAY;
}

/**	$min=10000000000000000;
	$max=0;
	
    $this->switch_data_table();
    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$c = stripslashes($a['created']);
			if ($c<=$min) $min=$c;
			if ($c>=$max) $max=$c;
		}
	}
}
	$interpretted_month = date('F', $time_to_handle_for_next_month_conversion);
    $interpretted_month_lowercased = strtolower($interpretted_month);
    $interpretted_year = date('Y', $time_to_handle_for_next_month_conversion);
**/ 

// @info set a avatar and about info in usersettings dialog..
function settings_interface_usersettings($dir)
{
  $message_display = <<<MESSAGE_DISPLAY
		<br>
		<br>
		<div class="messagepanel">
		<br>$dir
		<form NAME="formular" action="index.php" method="post" onsubmit="">
		Choose a background picture: <SELECT NAME="usersettingsbg_opt">
		<option value="" SELECTED></OPTION>
MESSAGE_DISPLAY;
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
		//$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {
		  if ( (strpos($file, ".png")!==false)  ||  (strpos($file, ".jpg")!==false) ) {
		    $message_display .= <<<MESSAGE_DISPLAY
						<option value="$file">$file</OPTION>
MESSAGE_DISPLAY;
		  } // <b class="h3">$dir</b><br />
          //$id++;
		}
      }
	   //if ($id > 100) echo '<br><b>Next Page</b> .... ';
      closedir($handle);
    }
  }
  
  $text= $this->getinform($_SESSION['loginuser']);
  
  $message_display .= <<<MESSAGE_DISPLAY
		</SELECT><br><br><br>
		
		Choose a avatar picture: <SELECT NAME="usersettings_opt">
		<option value="" SELECTED></OPTION>
MESSAGE_DISPLAY;
  if(is_dir($dir))
  {
    if($handle = opendir($dir))
    {
		//$id=0;
      while(($file = readdir($handle)) !== false)
      {
        if($file != "." && $file != ".." && $file != "Thumbs.db"/*pesky windows, images..*/)
        {
		  if ( (strpos($file, ".png")!==false)  ||  (strpos($file, ".jpg")!==false) ) {
		    $message_display .= <<<MESSAGE_DISPLAY
						<option value="$file">$file</OPTION>
MESSAGE_DISPLAY;
		  } // <b class="h3">$dir</b><br />
          //$id++;
		}
      }
	   //if ($id > 100) echo '<br><b>Next Page</b> .... ';
      closedir($handle);
    }
  }
  
  $text= $this->getinform($_SESSION['loginuser']);
  
  $message_display .= <<<MESSAGE_DISPLAY
		</SELECT>
		<br><br><br>
		
		Write short info about you:
		<br>
		<br>
		<textarea name="usersettings_info" style="width: 98%;" id="text0">$text</textarea>
		<br>
		<br>
		<input id="buttonka" type="submit" name="usersettings_btn" value="Apply Settings" />
		</form>
		<br>
		</div>
		<br>
		<br>
MESSAGE_DISPLAY;
  echo($message_display);
}

function settings_interface_password () {
	  $myemail= $this->getemail($_SESSION['loginuser']);
	  $message_display = <<<MESSAGE_DISPLAY
		</SELECT>
		<br><br><br>
		Change a Email and Password:
		<br>
		<br>
		<form NAME="formular" action="index.php" method="post" onsubmit="">
		<table cellpadding="0" cellspacing="3" border="0">
		<tr>
				<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black; white-space: nowrap;"><label for="navbar_username">Email</label></td>
				<td><input type="text" class="bginput" style="font-size: 11px" name="reg_email" id="login_email" maxlength="150" size="10" accesskey="u" tabindex="101" value="$myemail" /></td>
		</tr>
		<tr>
				<td style="font-family:BebasNeueRegular,verdana, sans-serif; color: black;"><label for="navbar_password">Password</label></td>
				<td><input type="password" class="bginput" style="font-size: 11px" name="reg_password" id="login_password" maxlength="150" size="10" tabindex="102" /></td>
				<td><input type="password" class="bginput" style="font-size: 11px" name="reg_repassword" id="login_repassword" maxlength="150" size="10" tabindex="103" /></td>
		</tr>
		</table>
		<br>
		<br>
		<input id="buttonka" type="submit" name="passwordsettings_btn" value="Apply Password" />
		</form>
		<br>
		</div>
		<br>
		<br>
MESSAGE_DISPLAY;
  echo($message_display);
}
  
function admin_interface() {	
	if ($_SESSION['loginuser']) {
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
	// ak existuje pouzivatel v poli pouzivatelov
	if ($this->isadmin($myuser)==1) {
		$message_display = <<<MESSAGE_DISPLAY
			<div id="menu-bar" align="center">
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody>
			<tr>
				<td onclick="loadURL('{$this->synapse_dir}admin_global.php');"><a href="index.php?page=adminsettings&work=global">Global Settings</a></td>
				<td onclick="loadURL('admin_editmenu.php');"><a href="{$this->synapse_dir}admin_editmenu.php">Edit Menu</a></td>
				<td onclick="loadURL('index.php');"><a href="index.php?page=adminsettings&work=plugins">Plugins</a></td>
				<td onclick="loadURL('');"><a href="index.php?plugin=switch-theme">Change Template</a></td>
				<td onclick="loadURL('{$this->synapse_dir}admin_regusers.php');"><a href="{$this->synapse_dir}admin_regusers.php">Registered Users</a></td>
				<td onclick="loadURL('{$this->synapse_dir}admin_msgs.php');"><a href="{$this->synapse_dir}admin_msgs.php">Manage Messages</a></td>
			</tr>
			</tbody>
			</table>
			</div>
MESSAGE_DISPLAY;
		echo($message_display);
		if ( (isset($_GET['page'])) && ($_GET['page']=="adminsettings") ) {
			if ( (isset($_GET['work'])) && ($_GET['work']=="global") ) {
				$this->display_admin_global();
			} else
			if ( (isset($_GET['work'])) && ($_GET['work']=="plugins") ) {
				echo("<br><br>");
				$mdn="{$this->synapse_path}plugins/";
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
								Loading plugin from $mdn/$dirArray[$index] : 
MESSAGE_DISPLAY;
							$plug = $mdn."/".$dirArray[$index]."/index.php";
							if (file_exists($plug)) $plugins_display .= "index.php ";
							$plug = $mdn."/".$dirArray[$index]."/stage_run.php";
							if (file_exists($plug)) $plugins_display .= "stage_run.php ";
							$plug = $mdn."/".$dirArray[$index]."/stage_run-bottom.php";
							if (file_exists($plug)) $plugins_display .= "stage_run-bottom.php ";
							$plugins_display .= "<br><br>";
						}
					}
				}
				echo($plugins_display);
			} 
		}
	} 
	///// else //// 
	if ( ( (isset($_GET['page'])) && ($_GET['page']=="settings") ) || ($_POST['task']=="Settings") ) {
		$message_display = <<<MESSAGE_DISPLAY
				<div id="menu-bar" align="center">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
				<tr>
					<td onclick="loadURL('index.php');"><a href="index.php?page=settings&work=usersettings">User Settings</a></td>
					<td onclick="loadURL('index.php');"><a href="index.php?page=settings&work=password">Change Password</a></td>
					<td onclick="loadURL('index.php');"><a href="index.php?page=settings&work=deleteaccount">Delete My Account</a></td>
				</tr>
				</tbody>
				</table>
				</div>
				<br>
				<br>
MESSAGE_DISPLAY;
			echo($message_display);
		if ( (isset($_GET['work'])) && ($_GET['work']=="usersettings") ) {
			$this->settings_interface_usersettings ($this->upload_dir . $myuser . "/");
		} else if ( (isset($_GET['work'])) && ($_GET['work']=="password") ) {
			$this->settings_interface_password ();
		} else if ( (isset($_GET['work'])) && ($_GET['work']=="deleteaccount") ) {
			$this->display_delete_account ();
		} 
	}
	}
}

function settings_interface() {
	if ($_SESSION['loginuser']) {
			$message_display = <<<MESSAGE_DISPLAY
				<div id="menu-bar" align="center">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
				<tr>
					<td onclick="loadURL('index.php');"><a href="index.php?page=settings&work=usersettings">User Settings</a></td>
					<td onclick="loadURL('index.php');"><a href="index.php?page=settings&work=password">Change Password</a></td>
					<td onclick="loadURL('index.php');"><a href="index.php?page=settings&work=deleteaccount">Delete My Account</a></td>
				</tr>
				</tbody>
				</table>
				</div>
				<br>
MESSAGE_DISPLAY;
			echo($message_display);
	} else echo("<div id=logo> </div>
		<div id=prihlasenie> 
		Access denied!
		</div>");
}

/* @info  send message to global page */
function pin_message() {	
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	if ( $_POST['karma_index'] )
		$crea = mysql_real_escape_string($_POST['karma_index']);
	
	// ak existuje pouzivatel v poli pouzivatelov
	if ( ($this->isadmin($myuser)==1) || ($this->publicity==1) ) {
		$this->switch_data_table();
		$q = "UPDATE data SET sendto='##ALLUSERS##' WHERE created = '$crea'";
		$r = mysql_query($q);
	}
}

/* @info  send message to global page */
function public_message() {	
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	if ( $_POST['reg_password'] )
		$crea = mysql_real_escape_string($_POST['reg_password']);
	
	// ak existuje pouzivatel v poli pouzivatelov
	if ($this->isadmin($myuser)==1) {
		$this->switch_data_table();
		$q = "UPDATE data SET sendto='##ALLUSERS##' WHERE created = '$crea'";
		$r = mysql_query($q);
	}
}

/* @info  delete message */
public function delete_message() {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	if ( $_POST['karma_index'] )
		$crea = mysql_real_escape_string($_POST['karma_index']);
	
	// if exist user? only admin can delete messages
	if ($this->isadmin($myuser)==1) {
		$this->switch_data_table();
		$q = "DELETE FROM data WHERE created = '$crea'";
		$r = mysql_query($q);
	}
}

/* @info  delete message */
public function delete_bookmark() {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	if ( $_POST['karma_index'] )
		$crea = mysql_real_escape_string($_POST['karma_index']);
	
	// if exist user? only admin can delete messages
	if ($this->ismyfavourite($crea)==1) {
		$this->switch_favourites_table();
		$q = "DELETE FROM favourites WHERE created = '$crea'";
		$r = mysql_query($q);
		echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php?page=bookmarks\">Bookmark Deleted! Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
	}
}

/* @info delete message/item from buffer */
public function delete_question($p) {
		$this->switch_buffer_table();
	
		if ( $_POST['insert_friend'] )
			$myfriend = $_POST['insert_friend']; 	
			
		if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

			
		if (( $myuser ) && ($myfriend)) {
				$q = "DELETE FROM buffer WHERE UsernameOne = '$myuser' AND UsernameTwo = '$myfriend'";
				$r = mysql_query($q);
				$q = "DELETE FROM buffer WHERE UsernameOne = '$myfriend' AND UsernameTwo = '$myuser'";
				$r = mysql_query($q);
		}
}


/* @info  how many messages by user */
function howmanymessages($myuser) {
	$this->switch_data_table();
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	$id=0;
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			//$title = stripslashes($a['title']);
			//$bodytext = stripslashes($a['bodytext']);
			$user = stripslashes($a['username']);
			//$sto = stripslashes($a['sendto']);
			//$crea = stripslashes($a['created']);
			if ($user==$myuser) {
				$id++;
			}
		}
	}
	return $id;
}

/* @info  how many channel friendships */
function info_howmany_friendships($myuser) {
	$this->switch_friends_table();
			
	//if ($_SESSION['loginuser'])
	//	$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	//BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
	$id=0;
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				if ($this->isvisible($usry)==0) $id++;
			} else
			if ($myuser==$usry) {
				if ($this->isvisible($usrx)==0) $id++;
			}
		}
	}
	
	return $id;
}

/* @info  how many channel followers */
function info_howmany_channel_following($myuser) {
	$this->switch_friends_table();
			
	//if ($_SESSION['loginuser'])
	//	$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	//BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
	$id=0;
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				if ($this->isvisible($usry)==1) $id++;
			} else
			if ($myuser==$usry) {
				if ($this->isvisible($usrx)==1) $id++;
			}
		}
	}
	
	return $id;
}	

/* @info  insert connection in buffer */
public function accept_question($p) {
		
		if ( $_POST['asked_friend'] )
			$myfriend = $_POST['asked_friend']; 	
			
		if ( $_POST['asked_work'] )
			$wo = $_POST['asked_work']; 
			
		if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
		$passw = "#";
		$ema = "#";
		
		if ($wo=="##PUBLICMESSAGE##") {
			$myfriend=$this->getadmin();
			$askmsg="Ask for Public Message to admin: {$myfriend} !";
			$passw=$_POST['asked_message'];  // use passw var for store a crea variable
		} else
		if ($wo=="##FRIENDSHIP##") {
			$askmsg="Ask for friendship to $myfriend !";
		} else
		if ($wo=="##REGISTERCHANNEL##") {
			$askmsg="Ask for Register channel to administrator.";
			if ( $_POST['reg_username'] ) $myuser = $_POST['reg_username'];
			if ($this->isuserexist($myuser)==1) { 
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\"><br>Fail. User Exists! Refresh Page.</a></b><br><br></center></div></div>");
					return null;
			}
			$myfriend = $this->getadmin();
			if ( $_POST['reg_password'] ) $passw = $_POST['reg_password']; 
			if ( $_POST['reg_email'] ) $ema = $_POST['reg_email']; 
		} else $askmsg="Unknown Ask..";
			
		if ( ( $myuser ) && ($myfriend)  && ($wo) && ($ema) && ($passw) ) {
				// create buffer intem
				$this->switch_buffer_table();
				$q = "SELECT * FROM buffer ORDER BY created DESC LIMIT 2048";
				$r = mysql_query($q);
				//$id=1;
				if ( $r !== false && mysql_num_rows($r) > 0 ) {
					while ( $a = mysql_fetch_assoc($r) ) {
						$one = stripslashes($a['UsernameOne']);
						$two = stripslashes($a['UsernameTwo']);
						if ( (($one==$myuser)&&($two==$myfriend)) || (($two==$myuser)&&($one==$myfriend)) ) return null;
					}
					$message_display = <<<MESSAGE_DISPLAY
					<div class="hehe"><div class="smallfont"><center><b><a href="index.php"><br>$askmsg</a></b><br><br></center></div></div>
MESSAGE_DISPLAY;
				} else {
$message_display = <<<MESSAGE_DISPLAY
					<div class="hehe"><div class="smallfont"><center><b><a href="index.php"><br>$askmsg</a></b><br><br></center></div></div>
MESSAGE_DISPLAY;
				}
				echo($message_display);
				// send message about new friendship
				//$this->switch_data_table();
				//$created = time();
				//$title = "New friends..";
				//$bodytext = "New friendship between <b>$myuser</b> and <b>$myfriend</b> created..";
				///$sendto = "##SYSMESSAGE##";
				//$sql = "INSERT INTO data VALUES('$title','$bodytext','$myuser','$sendto','$created')";
				//mysql_query($sql);
				// ask for friendship
				$this->switch_buffer_table();
				$created = time();
				//$ask = "##FRIENDSHIP##";
				$sql = "INSERT INTO buffer VALUES('$myuser','$myfriend','$wo','$passw','$ema','$created')";
				return mysql_query($sql);
		} else {
			$message_display = <<<MESSAGE_DISPLAY
					<div class="hehe"><div class="smallfont"><center><b><a href="index.php"><br>Fail. Refresh Page.</a></b><br><br></center></div></div>
MESSAGE_DISPLAY;
			echo($message_display);
			return null;
		}
}

function display_followers_notifications($name) {
}

function display_friend_friends($name) {
	$this->switch_friends_table();
			
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
	/// FILL STRUCT WITH MY FRIENDS
	//BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
	$id=1; $usrfronta[1]="";
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				$usrfronta[$id]=$usry;
				$id++;
			} else
			if ($myuser==$usry) {
				$usrfronta[$id]=$usrx;
				$id++;
			}
		}
	}	
		// Find new Friends for Me from my friend friends
		// 
		$q = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
		$r = mysql_query($q);
	
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			$entry_display = <<<MESSAGE_DISPLAY
					<b>Maybe you know someone: <i>
					<i class="icon-chevron-down icon-white"></i>
					<form NAME="formular" action="index.php" method="post" onsubmit="">
					<input type="hidden" name="asked_work" value="##FRIENDSHIP##">
MESSAGE_DISPLAY;
			while ( $a = mysql_fetch_assoc($r) ) {
				$one = stripslashes($a['UsernameOne']);
				$two = stripslashes($a['UsernameTwo']);
				$crea = stripslashes($a['Created']);
				// ak je poziadavka
				if ( ($one == $name)&&($myuser!=$two) ) {
					$test=false;
					foreach ($usrfronta as $usr) {
						if ($two==$usr) $test=true;
					}
					if ($test==false) {
							$usrinf=$this->getinform($usr);
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" style="border: 0; background: transparent;" name="asked_friend" value="$two" title="{$usrinf}" tabindex="202"> |
MESSAGE_DISPLAY;
					}
				} else
				if ( ($two == $name) && ($myuser!=$one) ) {
					$test=false;
					foreach ($usrfronta as $usr) {
						if ($one==$usr) $test=true;
					}
					if ($test==false) {
							$usrinf=$this->getinform($usr);
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" style="border: 0; background: transparent;" name="asked_friend" value="$one" title="{$usrinf}" tabindex="202"> |
MESSAGE_DISPLAY;
					}
				}
			}
			
				$entry_display .= <<<MESSAGE_DISPLAY
					</form>
					</i></b>
MESSAGE_DISPLAY;
			return ( $entry_display );
		}
}

function display_friend_friends_option($name) {
	$this->switch_friends_table();
			
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
	/// FILL STRUCT WITH MY FRIENDS
	//BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
	$id=1; $usrfronta[1]="";
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				$usrfronta[$id]=$usry;
				$id++;
			} else
			if ($myuser==$usry) {
				$usrfronta[$id]=$usrx;
				$id++;
			}
		}
	}	
		// Find new Friends for Me from my friend friends
		// 
		$q = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
		$r = mysql_query($q);
	
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			$entry_display = <<<MESSAGE_DISPLAY
					<form NAME="formular" action="index.php" method="post" onsubmit="">
					<input type="hidden" name="asked_work" value="##FRIENDSHIP##">
					<SELECT  onchange='this.form.submit()'>
					<OPTION value="" SELECTED>Invite Friend</OPTION>
MESSAGE_DISPLAY;
			while ( $a = mysql_fetch_assoc($r) ) {
				$one = stripslashes($a['UsernameOne']);
				$two = stripslashes($a['UsernameTwo']);
				$crea = stripslashes($a['Created']);
				// ak je poziadavka
				if ( ($one == $name)&&($myuser!=$two) ) {
					$test=false;
					foreach ($usrfronta as $usr) {
						if ($two==$usr) $test=true;
					}
					if ($test==false) {
							$usrinf=$this->getinform($two);
							if ($this->isvisible($two)==0) {
							$entry_display .= <<<MESSAGE_DISPLAY
								<OPTION type="submit" style="border: 0; background: transparent;" name="asked_friend" value="$two" title="{$usrinf}" tabindex="202">$two</OPTION>
MESSAGE_DISPLAY;
							} else {
								$entry_display .= <<<MESSAGE_DISPLAY
								<OPTION type="submit" style="border: 0; background: transparent;" name="find_friend" value="$two" title="{$usrinf}" tabindex="202">$two</OPTION>
MESSAGE_DISPLAY;
							}
					}
				} else
				if ( ($two == $name) && ($myuser!=$one) ) {
					$test=false;
					foreach ($usrfronta as $usr) {
						if ($one==$usr) $test=true;
					}
					if ($test==false) {
							$usrinf=$this->getinform($one);
							if ($this->isvisible($one)==0) {
							$entry_display .= <<<MESSAGE_DISPLAY
								<OPTION type="submit" style="border: 0; background: transparent;" name="asked_friend" value="$one" title="{$usrinf}" tabindex="202" value=$one>$one</OPTION>
MESSAGE_DISPLAY;
							} else {
							$entry_display .= <<<MESSAGE_DISPLAY
								<OPTION type="submit" style="border: 0; background: transparent;" name="find_friend" value="$one" title="{$usrinf}" tabindex="202" value=$one>$one</OPTION>
MESSAGE_DISPLAY;
							}
					}
				}
			}
			
				$entry_display .= <<<MESSAGE_DISPLAY
					</SELECT>
					</form>
MESSAGE_DISPLAY;
			return ( $entry_display );
		}
}

// @info zobrazi priatelov, tvojho priatela..
function display_friend_friends_notifications($name) {
	$this->switch_friends_table();
			
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
	/// FILL STRUCT WITH MY FRIENDS
	//BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";

    $usrr = mysql_query($usrq);
	
	$id=1; $usrfronta[1]="";
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				$usrfronta[$id]=$usry;
				$id++;
			} else
			if ($myuser==$usry) {
				$usrfronta[$id]=$usrx;
				$id++;
			}
		}
	}	
		// Find new Friends for Me from my friend friends
		// 
		$q = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
		$r = mysql_query($q);
	
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			if ($this->preview_type==0) {
				$entry_display = <<<MESSAGE_DISPLAY
					<br> <table border="1" width="100%">

					<tr>
					<td align=left><div class="smallfont">Friends of <big>$name</big> (look, is anybody new?, you can ask for friendship...)</div><br>
					<form NAME="formular" action="index.php" method="post" onsubmit="">
MESSAGE_DISPLAY;
			} else { 
				$entry_display = <<<MESSAGE_DISPLAY
					<br> <table border="1" width="100%">
					<tr>
					<td align=left><div class="smallfont">Friends of <big>$name</big> (look, is anybody new?, you can ask for friendship...)</div><br>
					<form NAME="formular" action="index.php" method="post" onsubmit="">
					<input type="hidden" name="asked_work" value="##FRIENDSHIP##">
MESSAGE_DISPLAY;
			}
			while ( $a = mysql_fetch_assoc($r) ) {
				$one = stripslashes($a['UsernameOne']);
				$two = stripslashes($a['UsernameTwo']);
				$crea = stripslashes($a['Created']);
				// ak je poziadavka
				if ( ($one == $name)&&($myuser!=$two) ) {
					$test=false;
					foreach ($usrfronta as $usr) {
						if ($two==$usr) $test=true;
					}
					if ($test==false) {
						if ($this->preview_type==0) {
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" name="asked_friend" value="$two">
MESSAGE_DISPLAY;
						} else {
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" name="asked_friend" value="$two">
MESSAGE_DISPLAY;
						}
					}
				} else
				if ( ($two == $name) && ($myuser!=$one) ) {
					$test=false;
					foreach ($usrfronta as $usr) {
						if ($one==$usr) $test=true;
					}
					if ($test==false) {
						if ($this->preview_type==0) {
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" name="asked_friend" value="$one">
MESSAGE_DISPLAY;
						} else {
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" name="asked_friend" value="$one">
MESSAGE_DISPLAY;
						}
					}
				}
			}
			if ($this->preview_type==0) {
				$entry_display .= <<<MESSAGE_DISPLAY
					</form></td></tr></table>
MESSAGE_DISPLAY;
			} else { 
				$entry_display .= <<<MESSAGE_DISPLAY
					</form></td></tr></table>
MESSAGE_DISPLAY;
			}
			echo ( $entry_display );
		}
}
		

		
/* @info  display notifications, etc. ask for friendship */
public function display_notifications() {
		$this->switch_buffer_table();
			
		if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
		// VIEW FORMULAR WHEN IS ASKED
		$q = "SELECT * FROM buffer ORDER BY created DESC LIMIT 2048";
		$r = mysql_query($q);
	
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			$entry_display = <<<ADMIN_FORM
				<ul class="menu">
ADMIN_FORM;
			while ( $a = mysql_fetch_assoc($r) ) {
				$one = stripslashes($a['UsernameOne']);
				$two = stripslashes($a['UsernameTwo']);
				$wo = stripslashes($a['Work']);
				$pass = stripslashes($a['Password']);
				$ema = stripslashes($a['Email']);
				$crea = stripslashes($a['Created']);
				if ($wo=="##PUBLICMESSAGE##") {
					$askmsg="User $one ask you for public his message (<a href=\"{$this->synapse_dir}message.php?created={$pass}\">{$pass}</a>)<br>";
					$askname="msgaccept";
				} else
				if ($wo=="##FRIENDSHIP##") {
					$askmsg="User $one ask you for friendship";
					$askname="accept";
				} else
				if ($wo=="##REGISTERCHANNEL##") {
					$askmsg="Ask for Register Channel with name $one";
					$askname="chaccept";
				} else {
					$askmsg=$wo;
					$askname="ok";
				}
				// ak je poziadavka
				if ($two == $myuser) {
					if ($this->preview_type==0) {
						$entry_display .= <<<MESSAGE_DISPLAY
							<li class="menu" onmouseover="" onmouseout="" onclick=""><a href="">
							<p>$askmsg</p>
							<form NAME="formular" action="index.php" method="post" onsubmit="">
							
							<input type="hidden" name="insert_friend" value="$one">
							<input type="hidden" name="reg_password" value="$pass">
							<input type="hidden" name="reg_email" value="$ema">
							
							<input type="submit" name="$askname" value="Accept" tabindex="104" title="Accept" accesskey="s" />
							<input type="submit" name="notaccept" value="X" tabindex="104" title="X" accesskey="s" />
							</form>
							</a>
							</li>
MESSAGE_DISPLAY;
					} else {
						$entry_display .= <<<MESSAGE_DISPLAY
							<div class="yt-alert yt-alert-info yt-rounded ">
								<form  NAME="formular" action="index.php" method="post" onsubmit="">
								
								<input type="hidden" name="insert_friend" value="$one">
								<input type="hidden" name="reg_password" value="$pass">
								<input type="hidden" name="reg_email" value="$ema">
								
								<input class="yt-alert-icon leftbut" type="submit" name="$askname" value="Accept" tabindex="104" title="Accept" accesskey="s" />
								<div  class="yt-alert-content">        $askmsg</div>
								<input class="close master-sprite" type="submit" name="notaccept" value="X" tabindex="104" title="Close" accesskey="s" />
								</form>
							</div>
							<br>
MESSAGE_DISPLAY;
					}
				}
			}
			$entry_display .= <<<ADMIN_FORM
				</ul>
ADMIN_FORM;
			echo ( $entry_display );
		}
}
  
/* @info  display all messages - for admin part */
function display_admin_all_messages() {
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
						<td onclick="loadURL('');"><a href="index.php?plugin=switchtheme">Change Template</a></td>
						<td onclick="loadURL('admin_regusers.php');"><a href="admin_regusers.php">Registered Users</a></td>
						<td onclick="loadURL('admin_msgs.php');"><a href="admin_msgs.php">Manage Messages</a></td>
					</tr>
				</tbody>
				</table>
				</div>
				<br><br>
				<ul class="messages">
ADMIN_FORM;
				// begin fill table of all messages
				$this->switch_data_table();
				$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
				$r = mysql_query($q);
	
				if ( $r !== false && mysql_num_rows($r) > 0 ) {
					while ( $a = mysql_fetch_assoc($r) ) {
						$title = stripslashes($a['title']);
						$bodytext = stripslashes($a['bodytext']);
						$user = stripslashes($a['username']);
						$sto = stripslashes($a['sendto']);
						$crea = stripslashes($a['created']);
						$entry_display .= <<<MESSAGE_DISPLAY
							<li class="messages" onmouseover="" onmouseout="" onclick="">
							<p><b>$sto : $user: $title</b><br>$bodytext</p><br>
							</li>
MESSAGE_DISPLAY;
					}
				}
				// end fill table of users
				$entry_display .= <<<ADMIN_FORM
					</ul>
					<br><br>
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

// @info zobrazi odpovede na spravicky.. tzv comments from display_zero
function display_reply_zero($kindex) {
	//if ($_SESSION['loginuser'])
	//	$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	$entry_display = <<<ADMIN_FORM
		<br><br>
		<ul class="messages">
ADMIN_FORM;
			
	// original message
	$this->switch_data_table();
			
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			if ($crea==$kindex) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<li class="messages" onmouseover="" onmouseout="" onclick="">
					<h2>$title</h2>
					<i>
					<span style="color:red">original message by $user</span>
					</i>
					<p>$bodytext</p>
					</li>
MESSAGE_DISPLAY;
			}
		}
	}
	// end of original message
	//
	// begin of reply messages
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
		
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			if ($sto==$kindex) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<li class="messages" onmouseover="" onmouseout="" onclick="">
					<h2>$title</h2>
					<i>
					<span style="color:blue">reply message by $user</span>
					</i>
					<p>$bodytext</p>
					</li>
MESSAGE_DISPLAY;
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		</ul>
		<br><br> <a href="index.php?page=login">login</a>, or <a href="index.php?page=register">register</a> to post comments.
		<br>
ADMIN_FORM;

	return $entry_display;
}	

/* @info  get number of messages */
function howmany_reply_messages($kindex) {
	$this->switch_data_table();
	// begin of reply messages
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
		
	$many = 0;
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			if ($sto==$kindex) {
				$many++;
			}
		}
	}
	return $many;
}
	
/* @info  display reply to messages */
function display_reply_messages() {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	if ( $_POST['karma_index'] )
		$kindex = mysql_real_escape_string($_POST['karma_index']);

	$entry_display = <<<ADMIN_FORM
		<br><br>
		<ul class="messages">
ADMIN_FORM;
			
	// original message
	$this->switch_data_table();
			
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($crea==$kindex) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<li class="messages" onmouseover="" onmouseout="" onclick="">
					<h2>$title</h2>
					<i>
					<span style="color:red">original message by $user</span>
					</i>
					<p>$bodytext</p>
					</li>
MESSAGE_DISPLAY;
			}
		}
	}
	// end of original message
	//
	// begin of reply messages
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
		
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($sto==$kindex) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<li class="messages" onmouseover="" onmouseout="" onclick="">
					<h2>$title</h2>
					<i>
					<span style="color:blue">reply message by $user</span>
					</i>
					<p>$bodytext</p>
					</li>
MESSAGE_DISPLAY;
			}
		}
	}
		
	// begin of Karma Code Widget
	$this->switch_karma_table();
	$km = mysql_query("SELECT yesno FROM karma WHERE id='$kindex' AND username='$myuser'");	
	$row = mysql_fetch_assoc($km);
	$akyesno = $row["yesno"];
						
	// end fill table of users
	$entry_display .= <<<ADMIN_FORM
		</ul>
		<br><br>
		
		<div class="discussion">
		<div class="messagepanel">
ADMIN_FORM;
	if ($akyesno) {
		if (strpos($akyesno,"Yes")!==false) {
			$entry_display .= <<<ADMIN_FORM
				<h2><img src="{$this->synapse_dir}themes/images/interface/plus.gif"> I like your message:</h2>
ADMIN_FORM;
		} else {
			$entry_display .= <<<ADMIN_FORM
				<h2><img src="{$this->synapse_dir}themes/images/interface/minus.gif"> I dont like your message:</h2>
ADMIN_FORM;
		}
	}
	
	$entry_display .= <<<ADMIN_FORM
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="bbstyle(-1,0)">
		<br />
		<div class="toolbar">
		<button type="button" class="fbutton" accesskey="b" id="addbbcode0_0" style="width: 30px" onclick="bbstyle(0, 0); return false"><span style="font-weight: bold"> B </span></button>
		<button type="button" class="fbutton" accesskey="i" id="addbbcode2_0" style="width: 30px" onclick="bbstyle(2, 0); return false"><span style="font-style:italic"> i </span></button>
		<button type="button" class="fbutton" accesskey="u" id="addbbcode4_0" style="width: 30px" onclick="bbstyle(4, 0); return false"><span style="text-decoration: underline"> U </span></button>
		<button type="button" class="fbutton" accesskey="s" id="addbbcode8_0" style="width: 30px" onclick="bbstyle(8, 0); return false"><span style="text-decoration: line-through"> S </span></button>
		<button type="button" class="fbutton" style="width: 50px" onclick="inputimg_url(0); return false"><span> IMAGE </span></button>
		<button type="button" class="fbutton" style="width: 50px" onclick="input_url(0); return false"><span> URL </span></button>
		<button type="button" class="fbutton" id="addbbcode6_0" style="width: 60px" onclick="bbstyle(6, 0); return false"><span> BREAK </span></button>
		</div>
		<br />
		<label for="msg_title">Title:</label>
		<input name="msg_title" id="msg_title" type="text" maxlength="150" />
		<div class="clear"></div>
	 
		<br />
		<label for="msg_bodytext">Body Text:</label>
		<textarea class="msgarea" name="textak" id="text0" style="width: 98%;"></textarea>
		<div class="clear"></div>
		<table>
		<tr>
		<td align="left">
		<input type="hidden" name="msg_sendtouser" value="$kindex">
		<input type="hidden" name="karma_index" value="$kindex">
		<input type="submit" name="reply_btn" value="Create Reply Message" />
		</td>
		</tr>
		</table>
		</form>
		</div>
		</div>
		<br><br>
ADMIN_FORM;
	return $entry_display;
}


/* @info  display reply to messages */
public function display_reply_messages_inside($kindex) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	/*if ( $_POST['karma_index'] )
		$kindex = mysql_real_escape_string($_POST['karma_index']);
	*/

	$entry_display = <<<ADMIN_FORM
		<br>
		<style>
			blockquote {
				background-color: rgb(235, 234, 221);
				background-image: url("./synapse-cms/themes/images/interface/quote.gif");
				background-repeat: no-repeat;
				border-color: rgb(219, 219, 206);
					border-top-color: rgb(219, 219, 206);
					border-right-color-value: rgb(219, 219, 206);
					border-bottom-color: rgb(219, 219, 206);
					border-left-color-value: rgb(219, 219, 206);
					border-left-color-ltr-source: physical;
					border-left-color-rtl-source: physical;
					border-right-color-ltr-source: physical;
					border-right-color-rtl-source: physical;
			}
			blockquote cite {
				font-style: normal;
				font-weight: bold;
				margin-left: 20px;
					margin-left-value: 20px;
					margin-left-ltr-source: physical;
					margin-left-rtl-source: physical;
				display: block;
				font-size: 0.9em;
			}
			
			/* expand text or hidden objects */
			div.expand span.collapsible { display : none; }
			div.expand:hover span.collapsible { display : inline; }
		</style>
ADMIN_FORM;
			
	$this->switch_data_table();		
	
	// original message
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	$ktitle="";
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			if ($crea==$kindex) {
				$ktitle=$title;
			}
		}
	}
	
	
	$test = 0;
	// begin of reply messages
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
		
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 
			
			if ($sto==$kindex) {
				$test = 1;
				$entry_display .= <<<MESSAGE_DISPLAY
					<blockquote>
					<div>
					<cite>$user wrote:</cite>
					$bodytext
					</div>
					</blockquote>
MESSAGE_DISPLAY;
			}
		}
	}
	
	// if find any message then display textarea for input reply from user
	if ($test==1) { 
		$entry_display .= <<<ADMIN_FORM
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="bbstyle(-1,0)">
		
		<input type="hidden" name="msg_sendtouser" value="$kindex">
		<input type="hidden" name="karma_index" value="$kindex">
		
		<input type="hidden" name="msg_title" value="Reply to $ktitle">
		
		<div style="display: inline-block; float: right;">
		
		<div style="float: right;">
		<input type="submit" id="create-reply" name="reply_btn" style="height: 32px;" value="Reply Message" />
		</div>
		
		<div style="float: right;">
		<textarea class="msgarea" name="textak" id="text-id-{$kindex}" style="width: {$this->inside_area}px; height: 24px;"></textarea>
		</div>
		
		</div>
				
		</form>
		<br/>
		<br/>
		<br/>
ADMIN_FORM;
	} else {
	}
	// end fill table of users
	$entry_display .= <<<ADMIN_FORM
		<br>
ADMIN_FORM;
	return $entry_display;
}

public function display_reply_button($kindex) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$this->switch_data_table();
	
	$test = 0;
	// begin of reply messages
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
		
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 
			
			if ($sto==$kindex) {
				$test = 1;
				$entry_display .= <<<MESSAGE_DISPLAY
					<blockquote>
					<div>
					<cite>$user wrote:</cite>
					$bodytext
					</div>
					</blockquote>
MESSAGE_DISPLAY;
			}
		}
	}
	
	// if find any message then display textarea for input reply from user
	if ($test==0) { 
	
	return $entry_display = <<<ADMIN_FORM
		<script>
function input_message(id) {
    var txtarea = document.getElementById('text-id-'+id);
    if (!txtarea) return false;
    
    var v = prompt('Enter URL');
    if (v) {
        txtarea.value += ''+v+'';
    }
}
		</script>
		<div style="display: inline-block;">
		<div class='expand' style="height: 25px;">
				<input type="hidden" class="msgarea" name="textak" id="text-id-{$kindex}" style="width: 99%; height: 32px;">
				<input type="submit" id="create-reply" name="reply_btn" style="" value="Reply Message" onclick="input_message({$kindex});"/>
			<span class="collapsible">
				
					<input type="hidden" name="msg_sendtouser" value="$kindex">
					<input type="hidden" name="karma_index" value="$kindex">
		
					<input type="hidden" name="msg_title" value="Reply to $ktitle">
						
			</span>
			
		</div>
		</div>
ADMIN_FORM;
	}
}
// <form style="display: inline-block;"  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="bbstyle(-1,0)">


/* @info  write data..message.. */
public function write_data($p) {
	$this->switch_data_table();
	
	//var_dump($_POST);
	
    if ( $_POST['msg_title'] )
      $title = mysql_real_escape_string($_POST['msg_title']);
    if ( $_POST['textak'])
      $bodytext = mysql_real_escape_string($_POST['textak']);
	if ( $_POST['msg_sendtouser'])
      $sendto = mysql_real_escape_string($_POST['msg_sendtouser']);
	if ($_SESSION['loginuser'])
      $user = mysql_real_escape_string($_SESSION['loginuser']);
	
	//echo ("{$title} : {$bodytext} : {$user}<br>");
	 
	if ( $title && $bodytext && $user && $sendto) {
		$t1 = "<?";
		$t2 = "<script";
		//// test for BAD words
		if (strpos($bodytext,$t1)!==false) {
			return false;
		} else if (strpos($bodytext,$t2)!==false) {
			return false;
		} else {
			// crypt or decrypt
			if ($this->synapse_crypt==1) {
				$kluc = "";
				if ( ( $this->getcreated($user) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					//inicializácia vnorenej-triedy
					//$crypt = new Crypt();
					$this->Mode = Crypt::MODE_HEX; // druh šifrovania
					$this->Key  = $this->synapse_password; //kľúč
					$kluc = $this->decrypt($this->getpassword($user)); // desifruje lubovolny zasifrovany retazec
				}
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if ( ( $this->getcreated($user) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					$this->Key  = $kluc; //kľúč
				} else {
					if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($user); //kľúč
				}
	
				$title = $this->encrypt($title); // zasifruje lubovolny retazec
				$bodytext = $this->encrypt($bodytext); // zasifruje lubovolny retazec
			}
			// write func
			$created = time();
			$sql = "INSERT INTO data VALUES('$title','$bodytext','$user','$sendto','$created')";
			mysql_query($sql);
			return true;
		}
    } else {
      return false;
    }
  }

public function write_post_friendship_data($p) {
	if (isset($_POST['synapse-title'])) $title = htmlspecialchars($_POST['synapse-title']);
	//if (isset($_POST['synapse-bodytext'])) $bodytext = htmlspecialchars($_POST['synapse-bodytext']);
	if (isset($_POST['synapse-sendto'])) $sendto = htmlspecialchars($_POST['synapse-sendto']);
	
	//$sendto = "##ALLFRIENDS##";
	
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	  
	if ( $title && $myuser && $sendto) {
		// ak to nie je moj priatel a existuje v databaze uzivatelov
		if ( ($sendto!=$myuser) && ($this->ismyfriend($sendto)!=1) && ($this->isuserexist($sendto) == 1) ) {
			// jedna sa o kanal - priame pridanie / alebo uzivatel poziadanie o priatelstvo
			if ($this->isvisible($sendto)==1) {
				// jedna sa o informacny kanal
				$this->switch_friends_table();
				$created = time();
				$sql = "INSERT INTO friends VALUES('$myuser','$sendto','$created')";
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$_SERVER['PHP_SELF']}\">Channel Added. Refresh Page</a></b></center></div></div>");
				return mysql_query($sql);
			} else {
				// jedna sa o uzivatela
				$this->switch_buffer_table();
				$created = time();
				$askmsg="##FRIENDSHIP##";
				$sql = "INSERT INTO buffer VALUES('$myuser','$sendto','$askmsg','#','#','$created')";
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$_SERVER['PHP_SELF']}\">Message Sended. Refresh Page</a></b></center></div></div>");
				return mysql_query($sql);
			}
		}
	} 
	echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$_SERVER['PHP_SELF']}\">Failed. Refresh Page</a></b></center></div></div>");
	return null;
}
  
public function write_post_data($p) {
	$this->switch_data_table();
	
	if (isset($_POST['synapse-title'])) $title = htmlspecialchars($_POST['synapse-title']);
	if (isset($_POST['synapse-bodytext'])) $bodytext = htmlspecialchars($_POST['synapse-bodytext']);
	if (isset($_POST['synapse-sendto'])) $sendto = htmlspecialchars($_POST['synapse-sendto']);
	
	//$sendto = "##ALLFRIENDS##";
	
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	  
	if ( $title && $bodytext && $myuser && $sendto) {
		if ($myuser == $sendto) { $sendto = "##ALLFRIENDS##"; $user=$myuser; } else $user=$sendto;
		
		
		//$test = 0;
		if ($sendto == "##SHARE##") { $sendto = $myuser; //$test = 1; 
										$user=$myuser;
		}
		
		// ak posielam sam sebe spravicku tak ju poslem na svoju nastenku
		// ISVISIBLE robi sarapatu, nejako s tym blbne.. treba to prekontrolovat !!! isvisible
		if ( ($this->ismyfriend($sendto)==1) || ($sendto == "##ALLFRIENDS##") || ($sendto == $myuser) ) { 
			$t1 = "<?";
			$t2 = "<script";
			//// test for BAD words
			if (strpos($bodytext,$t1)!==false) {
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$this->synapse_index}\">Failed. Refresh Page</a></b></center></div></div>");
				return false;
			} else if (strpos($bodytext,$t2)!==false) {
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$this->synapse_index}\">Failed. Refresh Page</a></b></center></div></div>");
				return false;
			} else {
				// crypt or decrypt
				if ($this->synapse_crypt==1) {
					$kluc = "";
					if ( ( $this->getcreated($user) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
						//inicializácia vnorenej-triedy
						//$crypt = new Crypt();
						$this->Mode = Crypt::MODE_HEX; // druh šifrovania
						$this->Key  = $this->synapse_password; //kľúč
						$kluc = $this->decrypt($this->getpassword($user)); // desifruje lubovolny zasifrovany retazec
					}
					//inicializácia vnorenej-triedy
					//$crypt = new Crypt();
					$this->Mode = Crypt::MODE_HEX; // druh šifrovania
					if ( ( $this->getcreated($user) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
						$this->Key  = $kluc; //kľúč
					} else {
						if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($user); //kľúč
					}
	
					$title = $this->encrypt($title); // zasifruje lubovolny retazec
					$bodytext = $this->encrypt($bodytext); // zasifruje lubovolny retazec
				}
				$created = time();
				$sql = "INSERT INTO data VALUES('$title','$bodytext','$myuser','$sendto','$created')";
				mysql_query($sql);
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$this->synapse_index}\">Message Sended. Refresh Page</a></b></center></div></div>");
				return true;
			}
		} else if ($this->ismyfriend($sendto)==0) {
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$this->synapse_index}\">Fail. Not your Friend ! Refresh Page</a></b></center></div></div>");
			}
    } else {
	  echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"{$this->synapse_index}\">Failed. Refresh Page</a></b></center></div></div>");
      return false;
    }
}

/* @info write karma.. */
public function write_karma($p) {
	$this->switch_karma_table($p);
	
	//var_dump($_POST);
	
    if ( $_POST['karma_index'] )
      $kindex = mysql_real_escape_string($_POST['karma_index']);
	if ( $_POST['karma_yesno'])
      $kyesno = mysql_real_escape_string($_POST['karma_yesno']);
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	 
	if ( $myuser && $kyesno && $kindex ) {
		//echo ("KARMA {$kindex} : {$kyesno} : {$user}<br>");
		$created = time();
		$sql = "INSERT INTO karma VALUES('$myuser','$kyesno','$kindex','$created')";
		mysql_query($sql);
		return true;
    } else {
      return false;
    }
  } 

/* @info print a channel messages. */
public function display_channel_messages($chusr) {
	$this->switch_data_table();
	
	$entry_display = <<<ADMIN_FORM
			<span style="font-weight: bold;">Channel Messages:</span><br>
ADMIN_FORM;

    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
		
			if  ( ($this->isvisible($user)==1) && ($chusr==$user) ) {
				if ($sto == "##SYSMESSAGE##") {
				} else 
				if ($sto == "##ALLUSERS##") {
					$entry_display .= <<<MESSAGE_DISPLAY
					<a href="">$title</a><br>
MESSAGE_DISPLAY;
				}
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		<br><br>
ADMIN_FORM;
	return $entry_display;
}
 
/* @info  display titles */
public function display_titles($num) {
	$this->switch_data_table();
	
	$entry_display = <<<ADMIN_FORM
			<span style="font-weight: bold;">Public Messages</span><br>
ADMIN_FORM;

    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
    $id=0;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			$bodytext = $a['bodytext'];
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			if ($sto == "##SYSMESSAGE##") {
			} else if ( ($sto == "##ALLUSERS##") && ($id<=$num) ) {
				$entry_display .= <<<MESSAGE_DISPLAY
					<a href="{$this->synapse_dir}message.php?created=$crea">$title</a><br>
MESSAGE_DISPLAY;
				$id++;
			}
		}
   }
	$entry_display .= <<<ADMIN_FORM
		<a href="">...</a><br>
		<br>
ADMIN_FORM;
	return $entry_display;
}
  

/*
		<article class="hentry" id="post-3193">
          <h1 class="entry-title page-title">New Channels</h1>
          <div class="entry-meta">
            <p> <time class="published" pubdate="pubdate"
                datetime="2011-04-13T11:03:59+00:00"
                title="2011-04-13T11:03:59+00:00">April 13th, 2011</time>
            </p>
          </div>
          <div class="entry-content">
            <p>Follow test</p>
          </div>
        </article>
*/

public function display_fullmessage($msg) {
	$this->switch_data_table();
	$entry_display = <<<ADMIN_FORM
		<br>
		<br>
		<br>

		<ul class="messages">
ADMIN_FORM;
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	//$id=1;
	$numbers=$this->lines;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			// bodytext
			$bodytext = $a['bodytext'];
			
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
		
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);

		
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 
			
			if ($crea==$msg) {
				$entry_display .= <<<ADMIN_FORM
					<li class="messages" onmouseover="" onmouseout="" onclick="">
ADMIN_FORM;
					if ($this->isvisible($user)==1) {
						$hyper = "<a href=\"index.php?channel=$user\">$user</a>";
					} else $hyper = "<a href=\"#\">$user</a>";

					$entry_display .= <<<ADMIN_FORM
						<h2>$title</h2>
						<p>
						<table border="0" width="100%">
						<tr>
						<td align=left>
						<span class="label label-warning pull-right"><i><font size=1>Posted by {$hyper}, <a href="#" title="{$datum}">{$result}</font></i></span>
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
			}
		}
	}
	$entry_display .= <<<ADMIN_FORM
		</ul>
		<br>
		<br>
ADMIN_FORM;
	/*
	*<br>
	*<b><a href="/index.php#top">Top of page</a></b>
	*/
	return $entry_display;
}

// @info zobraz uvodnu stranku..
public function display_blog($theuser) {
	$this->switch_data_table();
	
		$entry_display = <<<ADMIN_FORM
			<br>
ADMIN_FORM;
	
	//$test=0;$ts1=0;$ts2=0;
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {
		//$test=1;
		
		$tm1=mysql_real_escape_string($_GET['timeline1']);	// 1-11-2012
		$tm2=mysql_real_escape_string($_GET['timeline2']);	// 30-11-2012
		
		
		$ts1 = strtotime($tm1);
		$ts2 = strtotime($tm2);
		
		//var_dump($tm1);
		//var_dump($tm2);
		
		//$format="%d/%m/%Y %H:%M:%S";
		//$strf=strftime($format);
		//echo("$strf");
		//$ts = strptime($tm1, $format);
		//$ts1 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts1);
		//$ts = strptime($tm2, $format);
		//$ts2 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts2);
		
		$q = "SELECT * FROM data WHERE created<$ts2 ORDER BY created DESC LIMIT 2048";
	} else $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
	$numbers=$this->lines;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext'];
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			// $crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
		
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
		
			$replies = $this->howmany_reply_messages($crea);
		
			if ($replies>0) $reptxt = "<br><a href=\"index.php?comments=$crea\">comments</a><br>"; else $reptxt = "";
		
			if ( ($sto == "##ALLUSERS##") && ( ($theuser==$user) || ($theuser=="##ZEROPAGE##") ) ) {
				//echo ("$vypocet . ");
				//if ( ($id > ($_SESSION['pageid']*$numbers - $numbers)) && ($id <= ($_SESSION['pageid']*$numbers )) && (($test==0)||(($test==1)&&($crea>=$ts1)&&($crea<=$ts2))) ) {
				if ( ($id > ($_SESSION['pageid']*$numbers - $numbers)) && ($id <= ($_SESSION['pageid']*$numbers )) ) {
					$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
					$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
					$result = $this->nicetime($date); // 2 days ago 
					if ($this->preview_type==1) {
						$avat = $this->getavatar($user);
					$entry_display = <<<ADMIN_FORM
						<br>
						<div class="tweet"> 
						<img class="avatar" src="/{$this->upload_dir}/{$user}/{$avat}" alt="twitter">
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Public written by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
							</div>
ADMIN_FORM;
					} else {
						if ($this->isvisible($user)==1) {
							$hyper = "<a href=\"index.php?channel=$user\">{$user}</a>";
						} else $hyper = "<a href=\"blog.php?user={$user}\">{$user}</a>"; // ".$this->synapse_dir."

						$test=0;
						if (!empty($_POST['insertcode'])) if ($_POST['insertcode']=="Insert Code") if ($crea==$_POST['insertcode_index']) if ($this->issecure($_POST['insertcode_user'], $_POST['insertcode_search'])==1) $test=1;
						
						if ( ($this->isadmin($user)==2)&&($test==0) ) {
							$entry_display .= <<<ADMIN_FORM
								<li class="messages">
								<h2>$title</h2>
								<p>
								<span style="color:gray">Posted by <a href="index.php?preview={$user}">{$user}</a> as Hidden at ${result} without Link to Message</span>
								<div id="alt">
								<big><b>This is Private Channel and for view content of this message you must enter a private code:</b></big>
								<form method="post" action="index.php" >
								<input type="hidden" name="insertcode_user" value="{$user}">
								<input type="hidden" name="insertcode_index" value="{$crea}">
								<table>
								<tr><td><label for="meno"></label></td><td>&nbsp;<input type="text" style="width: 128px;" name="insertcode_search"></td><td><input type="submit" style="background: #F9F9F9;" name="insertcode" value="Insert Code"></td></tr>
								</table>
								</form>
								</div>
								</p>
								</li>	
ADMIN_FORM;
						} else {
							$entry_display .= <<<ADMIN_FORM
								<div class="entry">
								
									<h2><a href="">{$title}</a></h2>
						
									<div class="meta"><p>	
										{$result} 
									</p></div>
						

									<p>{$bodytext} {$reptxt}</p>
					

									<p class="meta">
					
										<a href="" title="Posted by {$hyper} ">{$hyper}</a> 
					
									</p>			    		
			
								</div> <!-- end .entry -->
ADMIN_FORM;
						}
						//</a>
					}
				}
				$id++;
			}
		}
    }
	
	$entry_display .= <<<ADMIN_FORM
		<br><br>
		<center>
ADMIN_FORM;
	
	$entry_display .= <<<ADMIN_FORM
		<div class="item-list"><ul class="pager">
ADMIN_FORM;
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {
		$entry_display .= <<<ADMIN_FORM
			<form  NAME="formular" action="{$_SERVER['PHP_SELF']}?timeline1={$_GET['timeline1']}&timeline2={$_GET['timeline2']}" method="post">
ADMIN_FORM;
	} else $entry_display .= <<<ADMIN_FORM
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">
ADMIN_FORM;
    $x=1;
	while (($x*$numbers - $numbers)<=$id) {
		if ($x==$_SESSION['pageid']) {
			$entry_display .= <<<ADMIN_FORM
			<li class="pager-item" style=""><b>{$x}</b></li>
ADMIN_FORM;
		} else {
		$entry_display .= <<<ADMIN_FORM
			<li class="pager-item"><input type="submit" name="zeropage" value="{$x}" tabindex="201" class="active" title="Go to page {$x}" style="border: 0; background: transparent"></li>
ADMIN_FORM;
		}
		$x++;
	}
	$next = $_SESSION['pageid']+1;
    $entry_display .= <<<ADMIN_FORM
		<li class="pager-ellipsis">...</li>
		<li class="pager-item next"><input type="submit" name="zeropage" value="{$next}" tabindex="201" title="Go to next page" class="active" style="border: 0; background: transparent">next ></input></li>
		<li class="pager-item last"><input type="submit" name="zeropage" value="{$x}" tabindex="201" title="Go to last page" class="active" style="border: 0; background: transparent">last >></input></li>
		</form>
		</ul></div>
		</center>
ADMIN_FORM;
	return $entry_display;
}
  
// @info zobraz uvodnu stranku..
public function display_zero($theuser) {
	$this->switch_data_table();
	
	if ($this->preview_type==1) {
		$entry_display = <<<ADMIN_FORM
			<br>
ADMIN_FORM;
	} else {
		$entry_display = <<<ADMIN_FORM
			<br><ul class="messages">
ADMIN_FORM;
	}
	
	//$test=0;$ts1=0;$ts2=0;
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {
		//$test=1;
		
		$tm1=mysql_real_escape_string($_GET['timeline1']);	// 1-11-2012
		$tm2=mysql_real_escape_string($_GET['timeline2']);	// 30-11-2012
		
		
		$ts1 = strtotime($tm1);
		$ts2 = strtotime($tm2);
		
		//var_dump($tm1);
		//var_dump($tm2);
		
		//$format="%d/%m/%Y %H:%M:%S";
		//$strf=strftime($format);
		//echo("$strf");
		//$ts = strptime($tm1, $format);
		//$ts1 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts1);
		//$ts = strptime($tm2, $format);
		//$ts2 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts2);
		
		$q = "SELECT * FROM data WHERE created<$ts2 ORDER BY created DESC LIMIT 2048";
	} else $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=1;
	$numbers=$this->lines;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext'];
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			// $crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
		
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
		
			$replies = $this->howmany_reply_messages($crea);
		
			if ($replies>0) $reptxt = "<br><a href=\"index.php?comments=$crea\">comments</a><br>"; else $reptxt = "";
		
			if ( ($sto == "##ALLUSERS##") && ( ($theuser==$user) || ($theuser=="##ZEROPAGE##") ) ) {
				//echo ("$vypocet . ");
				//if ( ($id > ($_SESSION['pageid']*$numbers - $numbers)) && ($id <= ($_SESSION['pageid']*$numbers )) && (($test==0)||(($test==1)&&($crea>=$ts1)&&($crea<=$ts2))) ) {
				if ( ($id > ($_SESSION['pageid']*$numbers - $numbers)) && ($id <= ($_SESSION['pageid']*$numbers )) ) {
					$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
					$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
					$result = $this->nicetime($date); // 2 days ago 
					if ($this->preview_type==1) {
						$avat = $this->getavatar($user);
						$entry_display = <<<ADMIN_FORM
						<br>
						<div class="tweet"> 
						<img class="avatar" src="/{$this->upload_dir}/{$user}/{$avat}" alt="twitter">
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Public written by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
							</div>
ADMIN_FORM;
					} else {
						if ($this->isvisible($user)==1) {
							$hyper = "<a href=\"index.php?channel=$user\">{$user}</a>";
						} else $hyper = "<a href=\"blog.php?user={$user}\">{$user}</a>"; // ".$this->synapse_dir."

						$test=0;
						if (!empty($_POST['insertcode'])) if ($_POST['insertcode']=="Insert Code") if ($crea==$_POST['insertcode_index']) if ($this->issecure($_POST['insertcode_user'], $_POST['insertcode_search'])==1) $test=1;
						
						
						
						if ($this->preview_type==100) {
															// if (mb_strlen($bodytext) >= $this->readmore_lines) 
								$short = mb_substr($bodytext, 0, 300);														
								$short .= "...";
								
								$entry_display .= <<<ADMIN_FORM
<div class="col-6 date-outer">
                

<div class="date-posts">
                
<div class="post-outer">
<article class="post hentry" itemscope="itemscope" itemtype="">
<a name="6466048434681024127"></a>
<h1 class="post-title entry-title" itemprop="name">
<a href="">
{$title}
</a>
</h1>
<div class="post-header">
<div class="post-header-line-1">
<table border="0" width="100%">
<tr>
<td align=left>
<span class="post-author vcard">
by
<span class="fn">
<a href="/blog.php?user={$user}" itemprop="author" rel="author" title="author profile">
{$hyper}
</a>
</span>
</span>
<span class="post-timestamp">
on
<a class="timestamp-link" href="" itemprop="url" rel="bookmark" title="permanent link">
<abbr class="published" itemprop="datePublished" title="{$datum}">
{$result}
</abbr>
</a>
</span>
<span class="post-labels">
under
<a href="" rel="tag">
Blogino
</a>
</span>	
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
</div>
</div>


<div class="post-body entry-content" id="post-body-6466048434681024127" itemprop="articleBody">
<div id="short{$id}" style="display: block;">
{$short}
</div>
<div id="long{$id}" style="display: none;">
{$bodytext}
</div>
<br>
<div style="clear: both;"></div>
</div>
<div class="jump-link">
<a href="index.php?message={$crea}" title="" >
Continue reading »
</a>
<p><br></p>
</div>
<div class="post-footer">
<div class="post-footer-line post-footer-line-1">
<span class="post-icons">
</span>
</div>
<div class="post-footer-line post-footer-line-2"></div>
<div class="post-footer-line post-footer-line-3"></div>
</div>
</article>
</div>

</div></div>
ADMIN_FORM;
							} else {
						
						if ( ($this->isadmin($user)==2)&&($test==0) ) {
							$entry_display .= <<<ADMIN_FORM
								<li class="messages">
								<h2>$title</h2>
								<p>
								<span style="color:gray">Posted by <a href="index.php?preview={$user}">{$user}</a> as Hidden at ${result} without Link to Message</span>
								<div id="alt">
								<big><b>This is Private Channel and for view content of this message you must enter a private code:</b></big>
								<form method="post" action="index.php" >
								<input type="hidden" name="insertcode_user" value="{$user}">
								<input type="hidden" name="insertcode_index" value="{$crea}">
								<table>
								<tr><td><label for="meno"></label></td><td>&nbsp;<input type="text" style="width: 128px;" name="insertcode_search"></td><td><input type="submit" style="background: #F9F9F9;" name="insertcode" value="Insert Code"></td></tr>
								</table>
								</form>
								</div>
								</p>
								</li>	
ADMIN_FORM;
						} else {
							$entry_display .= <<<ADMIN_FORM
								<li class="messages">
								<h2>$title</h2>
								<p>
								<table border="0" width="100%">
								<tr>
								<td align=left>
									<span class="label label-warning pull-right"><i><font size=1>Posted by {$hyper}, <a href="#" title="{$datum}">{$result}</font></i></span>
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
							<p><div id="alt">$bodytext $reptxt</div></p>			
							</li>	
ADMIN_FORM;
						}
						}
						//</a>
					}
				}
				$id++;
			}
		}
    }
   	if ($this->preview_type!=1) {
	    $entry_display .= <<<ADMIN_FORM
			</ul>
			<br>
ADMIN_FORM;
	}
	
	$entry_display .= <<<ADMIN_FORM
		<br><br>
		<center>
ADMIN_FORM;
	
	$entry_display .= <<<ADMIN_FORM
		<div class="item-list"><ul class="pager">
ADMIN_FORM;
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {
		$entry_display .= <<<ADMIN_FORM
			<form  NAME="formular" action="{$_SERVER['PHP_SELF']}?timeline1={$_GET['timeline1']}&timeline2={$_GET['timeline2']}" method="post">
ADMIN_FORM;
	} else $entry_display .= <<<ADMIN_FORM
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">
ADMIN_FORM;
    $x=1;
	while (($x*$numbers - $numbers)<=$id) {
		if ($x==$_SESSION['pageid']) {
			$entry_display .= <<<ADMIN_FORM
			<li class="pager-item" style=""><b>{$x}</b></li>
ADMIN_FORM;
		} else {
		$entry_display .= <<<ADMIN_FORM
			<li class="pager-item"><input type="submit" name="zeropage" value="{$x}" tabindex="201" class="active" title="Go to page {$x}" style="border: 0; background: transparent"></li>
ADMIN_FORM;
		}
		$x++;
	}
	$next = $_SESSION['pageid']+1;
    $entry_display .= <<<ADMIN_FORM
		<li class="pager-ellipsis">...</li>
		<li class="pager-item next"><input type="submit" name="zeropage" value="{$next}" tabindex="201" title="Go to next page" class="active" style="border: 0; background: transparent">next ></input></li>
		<li class="pager-item last"><input type="submit" name="zeropage" value="{$x}" tabindex="201" title="Go to last page" class="active" style="border: 0; background: transparent">last >></input></li>
		</form>
		</ul></div>
		</center>
ADMIN_FORM;
	return $entry_display;
}


/* @info  display global page for users who was not login - list mode */
public function display_zero_list($theuser, $tp) {
	$this->switch_data_table();
	if ($this->preview_type==1) {
		$entry_display = <<<ADMIN_FORM
ADMIN_FORM;
	} else {
	$x1=$_SESSION['pageid']-1;
	if ($x1<1) $x1=1;
		$entry_display = <<<ADMIN_FORM
			<center>
ADMIN_FORM;
		if ($tp==1) {
			$entry_display .= <<<ADMIN_FORM
				<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
					<td style="text-align: left;"> <br>
						<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">
						<input type="hidden" type="submit" name="zeropage" value="{$x1}" tabindex="201">
						<button type="submit" style="border: 0; background: transparent">
							<img src="themes/images/linguist-prev.png" alt="submit" />
						</button>
						</form>
					</td>
					<td style="width: 99%; text-align: center;"> <br>
					<br>
ADMIN_FORM;
        }
	}
    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=0;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
	while ( $a = mysql_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        
		// bodytext
        $bodytext = $a['bodytext'];
		if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
		$bodytext = $this->spracuj_form($bodytext);
		
		// others
		$user = stripslashes($a['username']);
		$sto = stripslashes($a['sendto']);
		$crea = stripslashes($a['created']);
		// $crea = stripslashes($a['created']);
		
		if ( ($sto == "##ALLUSERS##") && ( ($theuser==$user) || ($theuser=="##ZEROPAGE##") ) ) {
				//echo ("$vypocet . ");
				if ( $id == $_SESSION['pageid'] ) {
					$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
						$entry_display .= <<<ADMIN_FORM
							<div class="tweet">
								<div class="text"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Public written by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
							</div>
ADMIN_FORM;
				}
				$id++;
		}
	}
   }
   $x2=$_SESSION['pageid']+1;
   $entry_display .= <<<ADMIN_FORM
	            <br>
              <br>
			  <div class="page_of clearfix">
                        <strong>Created by Lukas Veselovsky, lukves@gmail.com</strong>
              </div>
              <br>
              <br>
            
ADMIN_FORM;
		if ($tp==1) {
			$entry_display .= <<<ADMIN_FORM
					</td>
					<td style="text-align: right;">
						<br>
						<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">
						<input type="hidden" type="submit" name="zeropage" value="{$x2}" tabindex="201">
						<button type="submit" style="border: 0; background: transparent">
							<img src="themes/images/linguist-next.png" alt="submit" />
						</button>
						</form>
					</td>
				</tr>
				</tbody>
				</table>
ADMIN_FORM;
		}
		$entry_display .= <<<ADMIN_FORM
			</center>
ADMIN_FORM;
	return $entry_display;
}

/* @info  display page switcher aka pager */
public function display_pager($id, $numb) {

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

    $numbers=$numb;
	//if ($this->preview_type==1) {
	//$entry_display = "";
	//} else 
	
	$entry_display = ""; // </ul>
	
	$entry_display .= <<<ADMIN_FORM
		<br><br>
		<center>
ADMIN_FORM;
	
	$entry_display .= <<<ADMIN_FORM
		<div class="item-list"><ul class="pager">
ADMIN_FORM;
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {
		$entry_display .= <<<ADMIN_FORM
			<form  NAME="formular" action="index.php?timeline1={$_GET['timeline1']}&timeline2={$_GET['timeline2']}" method="post">
ADMIN_FORM;
	} else $entry_display .= <<<ADMIN_FORM
		<form  NAME="formular" action="index.php" method="post">
ADMIN_FORM;
    $x=1;
	while (($x*$numbers - $numbers)<=$id) {
		if ($x==$_SESSION['pageid']) {
			$entry_display .= <<<ADMIN_FORM
			<li class="pager-item" style=""><b>{$x}</b></li>
ADMIN_FORM;
		} else {
		$entry_display .= <<<ADMIN_FORM
			<li class="pager-item"><input type="submit" name="page" value="{$x}" tabindex="201" class="active" title="Go to page {$x}" style="border: 0; background: transparent"></li>
ADMIN_FORM;
		}
		$x++;
	}
	$next = $_SESSION['pageid']+1;
    $entry_display .= <<<ADMIN_FORM
		<li class="pager-ellipsis">...</li>
		<li class="pager-item next"><input type="submit" name="page" value="{$next}" tabindex="201" title="Go to next page" class="active" style="border: 0; background: transparent">next ></input></li>
		<li class="pager-item last"><input type="submit" name="page" value="{$x}" tabindex="201" title="Go to last page" class="active" style="border: 0; background: transparent">last >></input></li>
		</form>
		</ul></div>
		</center>
ADMIN_FORM;

	return $entry_display;
}

public function fill_formopt($frie) {

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	$entry_display = <<<ADMIN_FORM
	<SELECT NAME="msg_sendtouser">
ADMIN_FORM;

	if ($frie) {
		$entry_display .= <<<ADMIN_FORM
			  <OPTION VALUE="{$frie}">{$frie}</OPTION>
ADMIN_FORM;
	} else {
		
		$this->switch_users_table($p);
 
		$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
		$a = mysql_fetch_assoc($checkem);
		$rcemail = $a['email'];
		
		// ak existuje pouzivatel v poli pouzivatelov
		if (isset($this->adminemail[$rcemail])) {
			// over heslo, a ak je spravne
			if ( $this->adminemail[$rcemail] == "admin" ) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All 
Users</OPTION>
ADMIN_FORM;
			} else if ($this->isvisible($myuser)==1) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All Users</OPTION>
ADMIN_FORM;
			}
		} else if ($this->isvisible($myuser)==1) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All Users</OPTION>
ADMIN_FORM;
		} else  // ak je nastaveny portal v rezime rozsirenej publicity, ze aj obycajny uzivatel - nie admin, nie kanal 
				// moze posielat spravicky na volnu nastenku
		if ($this->publicity==1) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All Users</OPTION>
ADMIN_FORM;
		}

	// begin of visible : user with firm/presentation account can not make friend lists, only send Public to ALLUSERS 
	// known as Presentation Page,..
	// for normal user
	if ($this->isvisible($myuser)==0)  {
		$entry_display .= <<<ADMIN_FORM
			<OPTION VALUE="##ALLFRIENDS##" SELECTED>to All Friends</OPTION>
ADMIN_FORM;

	if ($this->issecureuser($myuser)==1) {
		$entry_display .= <<<ADMIN_FORM
			<OPTION VALUE="##SECURE##">to All Friends as Secure</OPTION>
ADMIN_FORM;
	}
	// enf of visible
	
    //BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt
    $this->switch_friends_table();		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) if ($this->isvisible($usry)==0) {
			$entry_display .= <<<ADMIN_FORM
			  <OPTION VALUE="$usry">$usry</OPTION>
ADMIN_FORM;
			}
			if ($myuser==$usry) if ($this->isvisible($usrx)==0) {
			$entry_display .= <<<ADMIN_FORM
			  <OPTION VALUE="$usrx">$usrx</OPTION>
ADMIN_FORM;
			}
		}
	}
	// END 
	} // information channel can post as ##SHOP## public message
	else {
	    $entry_display .= <<<ADMIN_FORM
		<OPTION value="##SHOP##">with shop for All Users</OPTION>
ADMIN_FORM;
	}
  }
	// end of normal user
	$entry_display .= <<<ADMIN_FORM
	</SELECT>
ADMIN_FORM;
	return $entry_display;
}

/* @info  send messages */
public function display_messages_form($id, $numb, $frie) {

	$entry_display = "";

	if ($this->wisiwig==1) {	
			$entry_display .= <<<ADMIN_FORM
<script type="text/javascript">
tinyMCE.init({
        // General options
        // mode : "textareas",
		mode : "specific_textareas",
        editor_selector : "myTextEditor",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
ADMIN_FORM;
	}

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);


	if ($this->preview_jquery==0) {


    $numbers=$numb;
	//if ($this->preview_type==1) {
	//$entry_display = "";
	//} else 
	
	$entry_display .= <<<ADMIN_FORM
		<p>
		<center>
ADMIN_FORM;
	
	$entry_display .= <<<ADMIN_FORM
		<div class="item-list"><ul class="pager">
ADMIN_FORM;
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {
		$entry_display .= <<<ADMIN_FORM
			<form  NAME="formular" action="index.php?timeline1={$_GET['timeline1']}&timeline2={$_GET['timeline2']}" method="post">
ADMIN_FORM;
	} else $entry_display .= <<<ADMIN_FORM
		<form  NAME="formular" action="index.php" method="post">
ADMIN_FORM;
    $x=1;
	while (($x*$numbers - $numbers)<=$id) {
		if ($x==$_SESSION['pageid']) {
			$entry_display .= <<<ADMIN_FORM
			<li class="pager-item" style=""><b>{$x}</b></li>
ADMIN_FORM;
		} else {
		$entry_display .= <<<ADMIN_FORM
			<li class="pager-item"><input type="submit" name="page" value="{$x}" tabindex="201" class="active" title="Go to page {$x}" style="border: 0; background: transparent"></li>
ADMIN_FORM;
		}
		$x++;
	}
	$next = $_SESSION['pageid']+1;
    $entry_display .= <<<ADMIN_FORM
		<li class="pager-ellipsis">...</li>
		<li class="pager-item next"><input type="submit" name="page" value="{$next}" tabindex="201" title="Go to next page" class="active" style="border: 0; background: transparent">next ></input></li>
		<li class="pager-item last"><input type="submit" name="page" value="{$x}" tabindex="201" title="Go to last page" class="active" style="border: 0; background: transparent">last >></input></li>
		</form>
		</ul></div>
		</center>
		</p>
ADMIN_FORM;

	} else $entry_display .= <<<ADMIN_FORM
				 <br /><br /><center><a class="jquery_more" style="font-size: 28px;" href="index.php">click to view another messages</a></center>
ADMIN_FORM;

if ($this->preview_footer!=2) {	
  $entry_display .= <<<ADMIN_FORM
	<br><br>
	<div class="discussion">
	<div class="messagepanel">
	<h2>Write your Message</h2>
	<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="bbstyle(-1,0)">
           <br />
	   <div class="toolbar">
           <button type="button" class="fbutton" accesskey="b" id="addbbcode0_0" style="width: 30px" onclick="bbstyle(0, 0); return false"><span style="font-weight: bold"> B </span></button>
           <button type="button" class="fbutton" accesskey="i" id="addbbcode2_0" style="width: 30px" onclick="bbstyle(2, 0); return false"><span style="font-style:italic"> i </span></button>
           <button type="button" class="fbutton" accesskey="u" id="addbbcode4_0" style="width: 30px" onclick="bbstyle(4, 0); return false"><span style="text-decoration: underline"> U </span></button>
           <button type="button" class="fbutton" accesskey="s" id="addbbcode8_0" style="width: 30px" onclick="bbstyle(8, 0); return false"><span style="text-decoration: line-through"> S </span></button>
           <button type="button" class="fbutton" style="width: 50px" onclick="inputimg_url(0); return false"><span> IMAGE </span></button>
           <button type="button" class="fbutton" style="width: 50px" onclick="input_url(0); return false"><span> URL </span></button>
           <button type="button" class="fbutton" id="addbbcode6_0" style="width: 60px" onclick="bbstyle(6, 0); return false"><span> BREAK </span></button>
	   <button type="button" class="fbutton" id="" style="width: 80px" onclick="input_youtube(0); return false"><span> YOUTUBE </span></button>
           </div>
	   <br />
	  <label for="msg_title">Title:</label>
    	  <input name="msg_title" id="msg_title" type="text" maxlength="150" />
          <div class="clear"></div>
     
	  <br />
      <label for="msg_bodytext">Body Text:</label>
      <textarea class="myTextEditor" name="textak" id="text0" style="width: 98%;"></textarea>
      <div class="clear"></div>
	  <table>
	  <tr>
	  <td align=left>
		<SELECT NAME="msg_sendtouser">
ADMIN_FORM;

	if ($frie) {
		$entry_display .= <<<ADMIN_FORM
			  <OPTION VALUE="{$frie}">{$frie}</OPTION>
ADMIN_FORM;
	} else {
		
		$this->switch_users_table($p);
 
		$checkem = mysql_query("SELECT email FROM users WHERE Username='$myuser'");	
		$a = mysql_fetch_assoc($checkem);
		$rcemail = $a['email'];
		
		// ak existuje pouzivatel v poli pouzivatelov
		if (isset($this->adminemail[$rcemail])) {
			// over heslo, a ak je spravne
			if ( $this->adminemail[$rcemail] == "admin" ) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All 
Users</OPTION>
ADMIN_FORM;
			} else if ($this->isvisible($myuser)==1) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All Users</OPTION>
ADMIN_FORM;
			}
		} else if ($this->isvisible($myuser)==1) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All Users</OPTION>
ADMIN_FORM;
		} else  // ak je nastaveny portal v rezime rozsirenej publicity, ze aj obycajny uzivatel - nie admin, nie kanal 
				// moze posielat spravicky na volnu nastenku
		if ($this->publicity==1) {
				$entry_display .= <<<ADMIN_FORM
					<option value="##ALLUSERS##">to All Users</OPTION>
ADMIN_FORM;
		}

	// begin of visible : user with firm/presentation account can not make friend lists, only send Public to ALLUSERS 
	// known as Presentation Page,..
	// for normal user
	if ($this->isvisible($myuser)==0)  {
		$entry_display .= <<<ADMIN_FORM
			<OPTION VALUE="##ALLFRIENDS##" SELECTED>to All Friends</OPTION>
ADMIN_FORM;

	if ($this->issecureuser($myuser)==1) {
		$entry_display .= <<<ADMIN_FORM
			<OPTION VALUE="##SECURE##">to All Friends as Secure</OPTION>
ADMIN_FORM;
	}
	// enf of visible
	
    //BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt
    $this->switch_friends_table();		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) if ($this->isvisible($usry)==0) {
			$entry_display .= <<<ADMIN_FORM
			  <OPTION VALUE="$usry">$usry</OPTION>
ADMIN_FORM;
			}
			if ($myuser==$usry) if ($this->isvisible($usrx)==0) {
			$entry_display .= <<<ADMIN_FORM
			  <OPTION VALUE="$usrx">$usrx</OPTION>
ADMIN_FORM;
			}
		}
	}
	// END 
	} // information channel can post as ##SHOP## public message
	else {
	    $entry_display .= <<<ADMIN_FORM
		<OPTION value="##SHOP##">with shop for All Users</OPTION>
ADMIN_FORM;
	}
  }
	// end of normal user
	$entry_display .= <<<ADMIN_FORM
	</SELECT>
	</td>
	<td align="left">
	<input id="create-message" style="width: 150px;" type="submit" value="Create Message" />
	</td>
	</tr>
	</table>
	</form>
	</div>
	</div>
	<br />
	<br />
	<b>You can use this replacements for HTML commands and atributes:</b> <i>[url=HTTP://]URL_NAME[/url] [img]URL_TO_IMAGE[/img] [b][/b] [i][/i] [u][/u] [br][/br]</i>
	<br />
	<br />
ADMIN_FORM;
}

	return $entry_display;
}

/* @info  fill SELECT with users */
public function fill_view_option($tp) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	// if tp == 0 then onchange='this.form.submit()'
	if ($tp==0) {
		$entry_display = <<<ADMIN_FORM
			<SELECT style="width: 100px;" NAME="preview" onchange='this.form.submit()'>
ADMIN_FORM;
	} else
	{
		$entry_display = <<<ADMIN_FORM
			<SELECT style="width: 100px;" NAME="preview" onchange=''>
ADMIN_FORM;
	}
		
    //BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt
    $this->switch_friends_table();		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
	// user with firm/presentation account 
	// can 1) send only ALL USERS messages
	// ... 2) send private message to user
	// ... 3) can not make a Friend lists
	if ($this->isvisible($myuser)==0) {
	// Begin of normal user, not presentation account
	if ($_SESSION['viewpage']=="##ALLFRIENDS##") {
		$entry_display .= <<<ADMIN_FORM
			<OPTION VALUE="##ALLFRIENDS##" SELECTED>All Friends</OPTION>
ADMIN_FORM;
	} else {
		$entry_display .= <<<ADMIN_FORM
			<OPTION VALUE="##ALLFRIENDS##">All Friends</OPTION>
ADMIN_FORM;
	}

	}
	
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				if ($_SESSION['viewpage']==$usry) {
					$entry_display .= <<<ADMIN_FORM
						<OPTION VALUE="$usry" onclick="" SELECTED>$usry</OPTION>
ADMIN_FORM;
				} else {
					$entry_display .= <<<ADMIN_FORM
						<OPTION VALUE="$usry" onclick="">$usry</OPTION>
ADMIN_FORM;
				}
			}
			if ($myuser==$usry) {
				if ($_SESSION['viewpage']==$usrx) {
					$entry_display .= <<<ADMIN_FORM
						<OPTION VALUE="$usrx" onclick="" SELECTED>$usrx</OPTION>
ADMIN_FORM;
				} else {
					$entry_display .= <<<ADMIN_FORM
						<OPTION VALUE="$usrx" onclick="">$usrx</OPTION>
ADMIN_FORM;
				}
			}
		}
	}
	// End of
	
	$entry_display .= <<<ADMIN_FORM
		</SELECT>
ADMIN_FORM;

	return $entry_display;
}

/* @info  are you my friend */
public function ismyfriend($test) {
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);

    //BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt
    $this->switch_friends_table();		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				if($usry==$test) return 1;
			}
			if ($myuser==$usry) {
				if ($usrx==$test) return 1;
			}
		}
	}

	return 0;
}


// @info search in public user messages
public function display_search_zero($myuser) {
	$this->switch_data_table();

    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);

	//$id=1;
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
	
	    $message_display = <<<MESSAGE_DISPLAY
			<br>
			<br>
			<ul class="messages">
MESSAGE_DISPLAY;

	while ( $a = mysql_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        // bodytext
        $bodytext = $a['bodytext'];
		
		if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
		
        $bodytext = $this->spracuj_form($bodytext);
		// others
		$user = stripslashes($a['username']);
		$sto = stripslashes($a['sendto']);
			
			//echo($sto);
			
		//echo ("[$user]==[$myuser]<br>");
		// search in selected user with parameter ##ANY##
// style="background-color: red"
		if ( (($myuser == "##ANY##")||($user == $myuser)) && ($sto == "##ALLUSERS##") ) { 
			
			//// test title
			if (strpos($title,$_POST['search_input'])!==false) {
			$message_display .= <<<MESSAGE_DISPLAY
  
  <li class="messages red">
    	<h2>
		  $title
    	</h2>
		<i>$user</i>
	   <p><div id="alt">$bodytext</div></p>
  </li>

MESSAGE_DISPLAY;
			}
			/// test bodytext
			if (strpos($bodytext,$_POST['search_input'])!==false) {
				$message_display .= <<<MESSAGE_DISPLAY
  <li class="messages red">
    	<h2>
		  $title
    	</h2>
		<i>$user</i>
	   <p><div id="alt">$bodytext</div></p>
  </li>
MESSAGE_DISPLAY;
			}
		} 
	}
        $message_display .= <<<MESSAGE_DISPLAY
	</ul>	
MESSAGE_DISPLAY;

    } else {
      $message_display = <<<MESSAGE_DISPLAY

    <h2> This Page Is Under Construction </h2>
    <p>
      No entries have been made on this page. 
      Please check back soon, or click the
      link below to add an entry!
    </p>

MESSAGE_DISPLAY;
    }

  echo($message_display);
}

public function display_search_form($usr) {
	$message_display = <<<MESSAGE_DISPLAY
		<div id="search">
			<form method="post" id="searchform" action="index.php">
				<input type="hidden" name="search_usr" value="{$usr}">
				<input name="search_input" type="text" class="field" name="s" id="s"  value="Search in..." />
				<button type="submit"  style="border: 0; background: transparent; border:none; margin:9px 0px 0px -27px; padding:0px; width:auto;" class="submit btn" name="search_but" value="Yes">
					<img src="{$this->synapse_dir}themes/images/interface/icon-search.png" alt="submit" />
				</button>
			</form>
		</div><!--end #search -->
MESSAGE_DISPLAY;
}

// @info  search messages with string in title, or in body of message
//		  search in login user messages..
public function display_search_items_loginuser($p) {
	$this->switch_data_table();

    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);

	//$id=1;
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
	
	    $message_display = <<<MESSAGE_DISPLAY
			<div class="messagepanel">
			<img src="themes/images/share-enjoy.png"><br><br>
	
			<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return check_searchform()">
				<input type="text" class="bginput" style="font-size: 11px" name="search_input" maxlength="150" size="10"/> <input type="submit" name="search_but" value="Search">
			</form>
			</div>
			<br>
			<br>
			
			<ul class="messages">
MESSAGE_DISPLAY;

	while ( $a = mysql_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        // bodytext
        $bodytext = $a['bodytext'];
        $bodytext = $this->spracuj_form($bodytext);
		// others
		$user = stripslashes($a['username']);

		if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

			
		//echo ("[$user]==[$myuser]<br>");
		if ( $user == $myuser ) { 
			
			//// test title
			if (strpos($title,$_POST['search_input'])!==false) {
			$message_display .= <<<MESSAGE_DISPLAY
  <li class="messages" onmouseover="" onmouseout=""
 onclick="">
    	<h2><div style="background-color: red">
		  $title</div>
    	</h2>
		<i>$user</i>
	    <p><div id="alt">$bodytext</div></p>
  </li>
MESSAGE_DISPLAY;
			}
			/// test bodytext
			if (strpos($bodytext,$_POST['search_input'])!==false) {
				$message_display .= <<<MESSAGE_DISPLAY
  <li class="messages" onmouseover="" onmouseout=""
 onclick="">
    	<h2>
		  $title
    	</h2>
		<i>$user</i>
	    <p><div id="alt"><div style="background-color: red">$bodytext</div></div>
	    </p>
  </li>
MESSAGE_DISPLAY;
			}
		} 
	}
        $message_display .= <<<MESSAGE_DISPLAY
	</ul>	
MESSAGE_DISPLAY;

    } else {
      $message_display = <<<MESSAGE_DISPLAY

    <h2> This Page Is Under Construction </h2>
    <p>
      No entries have been made on this page. 
      Please check back soon, or click the
      link below to add an entry!
    </p>

MESSAGE_DISPLAY;
    }

  echo($message_display);
}

/* @info  search in messages posted by all friends, or in (your) login user messages */
public function display_search_items($p) {
  	$this->switch_data_table();

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);

	$id=1;
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
	
	    $message_display = <<<MESSAGE_DISPLAY

		
		<div class="messagepanel">
		<img src="themes/images/share-enjoy.png"><br><br>
		<table border="0" width="100%">
		<tr>
		<td align=left>
		  <form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return check_searchform()">
		  <input type="text" class="bginput" style="font-size: 11px" name="search_input" maxlength="150" size="10"/> 
		  <input type="submit" name="search_but" value="Search">
		</form>
		</td>
		<td align=right>
		<div class="smallfont">Loged as $myuser</div>
		</td>
		</tr>
		</table> </div>
		<br><br>
	
		<ul class="messages">
	
MESSAGE_DISPLAY;

	while ( $a = mysql_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        // bodytext
        $bodytext = $a['bodytext'];
		
		if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
		
        $bodytext = $this->spracuj_form($bodytext);
		// others
		$user = stripslashes($a['username']);
		$sto = stripslashes($a['sendto']);
		
		if ($sto == "##ALLUSERS##") {
				// preview for all userd
				$vypa=$_SESSION['pageid']*7; 
				$vypb=$vypa-7;
				//echo ("$vypocet . ");
				if ( ($id > $vypb) && ($id <= $vypa ) ) {
					if (strpos($title,$_POST['search_input'])!==false) {
						// background-color: red
						$message_display .= <<<MESSAGE_DISPLAY
							<li class="messages red" onmouseover="" onmouseout="" onclick="">
							  <h2><div style="">$title</div></h2>
							  <span style="color:black">public message for all users by $user</span>
							  <p>$bodytext</p>
							</li>
MESSAGE_DISPLAY;
					}
					/// test bodytext
					if (strpos($bodytext,$_POST['search_input'])!==false) {
						// background-color: red
						$message_display .= <<<MESSAGE_DISPLAY
							<li class="messages red" onmouseover="" onmouseout="" onclick="">
							  <h2>$title</h2>
							  <span style="color:black">public message for all users by $user</span>
							  <p><div style="">$bodytext</div></p>
							</li>
MESSAGE_DISPLAY;
					}
				}
				$id++;
		} else {
			// preview messagef for : All Friends, Post Private, Get Private  
			$this->switch_friends_table();
			$qd = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
			$rd = mysql_query($qd);
			//$id=1;
			$test=0;
			if ( $rd !== false && mysql_num_rows($rd) > 0 ) {
				while ( $ad = mysql_fetch_assoc($rd) ) {
					$one = stripslashes($ad['UsernameOne']);
					$two = stripslashes($ad['UsernameTwo']);
					if ( (($one==$user)&&($two==$myuser)) || (($two==$user)&&($one==$myuser)) ) $test=1;
				}
			}
			$this->switch_data_table();
			
		//echo ("[$user]==[$myuser]<br>");
		if  ( ( $user == $myuser ) || ( $test == 1 ) ) {
			// test ci sa jedna pre vsetkych ktory maju myuser v kontaktoch alebo specialne ci sa jedna
			// o konkretneho usera ktoremu sprava je urcena
			if ( ($sto == "##ALLFRIENDS##") || ($sto == $myuser) || ($myuser == $user) ) {
				$vypa=$_SESSION['pageid']*7; 
				$vypb=$vypa-7;
				//echo title
				if ( ($id > $vypb) && ($id <= $vypa ) ) {
					if (strpos($title,$_POST['search_input'])!==false) {
						// background-color: red
						$message_display .= <<<MESSAGE_DISPLAY
							<li class="messages red" onmouseover="" onmouseout="" onclick="">
							<h2><div style="">$title</div></h2><i>
MESSAGE_DISPLAY;
					   if ($sto == $myuser) {
						$message_display .= <<<MESSAGE_DISPLAY
						<span style="color:red">private message from $user</span>
MESSAGE_DISPLAY;
					   } else if ($sto == "##ALLFRIENDS##") {
						$message_display .= <<<MESSAGE_DISPLAY
						<span style="color:blue">public for all my friends by $user</span>
MESSAGE_DISPLAY;
					   } else {
						$message_display .= <<<MESSAGE_DISPLAY
						<span style="color:gray">my message for $sto</span>
MESSAGE_DISPLAY;
					   }
						$message_display .= <<<MESSAGE_DISPLAY
							</i>
							  <p>$bodytext</p>
							</li>
MESSAGE_DISPLAY;
					} 
					// echo bodytext
					if (strpos($bodytext,$_POST['search_input'])!==false) {
						$message_display .= <<<MESSAGE_DISPLAY
							  <li class="messages red" onmouseover="" onmouseout="" onclick="">
							  <h2>$title</h2>
							  <i>
MESSAGE_DISPLAY;
						if ($sto == $myuser) {
							$message_display .= <<<MESSAGE_DISPLAY
							<span style="color:red">private message from $user</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##ALLFRIENDS##") {
							$message_display .= <<<MESSAGE_DISPLAY
							<span style="color:blue">public for all my friends by $user</span>
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
							<span style="color:gray">my message for $sto</span>
MESSAGE_DISPLAY;
						}
						// background-color: red
						$message_display .= <<<MESSAGE_DISPLAY
							  </i><p><div style="">$bodytext</div></p>
							  </li>
MESSAGE_DISPLAY;
					} 
				}
				$id++;
			}
		}
	  }
	}  
      $message_display .= <<<MESSAGE_DISPLAY
	</ul>	
MESSAGE_DISPLAY;

    } else {
      $message_display = <<<MESSAGE_DISPLAY

    <h2> This Page Is Under Construction </h2>
    <p>
      No entries have been made on this page. 
      Please check back soon, or click the
      link below to add an entry!
    </p>

MESSAGE_DISPLAY;
    }
  echo($message_display);
}

/* @info  get message by crea */
public function get_message($id) {
	$this->switch_data_table();
	
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			// bodytext
			$bodytext = $a['bodytext'];
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
		
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
			// all users ? is my friend?, or is login as admin ? or is my message ?
			if ( ($id==$crea) && (($sto == "##ALLUSERS##") || ($this->ismyfriend($user)==1)  || ($this->isadmin($myuser)==1) || ($myuser==$user)) ) {
				if ($this->preview_type==1) {
					$avat = $this->getavatar($user);
					$entry_display = <<<MESSAGE_FORM
						<br>
						<div class="tweet"> 
						<img class="avatar" src="/{$this->upload_dir}/{$user}/{$avat}" alt="twitter"> 
						<img class="bubble" src="themes/images/interface/speech_bubble.png" alt="bubble">
						<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
						<span>Link to Message by <a href="#">{$user}</a> at {$datum}</span>
						</div>
						</div>
						<br>
MESSAGE_FORM;
				} else {
					$entry_display = <<<MESSAGE_FORM
						<br>
						<div class="page_of clearfix">
						<p><b>Link to Message</b></p>
						<p>$title</p>
						<p>$bodytext</p>
						</div>
						<br>
MESSAGE_FORM;
				}
			}
		}
	}
	return $entry_display;
}

/* @info  get message by crea */
public function get_message_clean($id) {
	$this->switch_data_table();
	
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	$r = mysql_query($q);
	
	if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			// bodytext
			$bodytext = $a['bodytext'];
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);
			
			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);
			// all users ? is my friend?, or is login as admin ? or is my message ?
			if ( ($id==$crea) && (($sto == "##ALLUSERS##") || ($this->ismyfriend($user)==1)  || ($this->isadmin($myuser)==1) || ($myuser==$user)) ) {
				if ($this->preview_type==1) {
					$avat = $this->getavatar($user);
					$entry_display = <<<MESSAGE_FORM
						{$bodytext}*
						
MESSAGE_FORM;
				} else {
					$entry_display = <<<MESSAGE_FORM
						{$bodytext}
MESSAGE_FORM;
				}
			}
		}
	}
	return $entry_display;
}

//		  <input type="text" class="bginput" style="font-size: 11px" name="search_input" maxlength="150" size="10"/> 
//		  <input type="submit" name="search_but" value="Search">
// style="border: 0; background: transparent;"  <--- super funckia zobrazi len text a nie cele tlacitko
public function display_header() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	$message_display = <<<MESSAGE_DISPLAY
		<div class="messagepanel">
		<table border="0" width="100%">
		<tr>
		<td align=left>
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return check_searchform()">
MESSAGE_DISPLAY;
		$message_display .= $this->fill_view_option(0);
		//// <a href="index.php?previewtype=classic"> Normal</a> |  <a href="index.php?previewtype=forum"> Forum</a> |  <a href="index.php?previewtype=list"> List</a> | <a href="index.php?plugin=audioplayer"> Your Playlist</a>
		$message_display .= <<<MESSAGE_DISPLAY
		<a href="index.php?previewtype=forum"> Preview the Messages</a> | <a href="index.php?plugin=audioplayer"> Your Playlist</a>
		</form>
		</td>
		<td align=right>
		<form method="post" action="" NAME="formular"> 
		<input type="text" style="width: 200px;" name="search_input" maxlength="150"/> 
		<input style="width: 80px;" type="submit" name="search_but" value="Search" tabindex="104" title="Search in Synapse.." accesskey="n" />
MESSAGE_DISPLAY;
	if ($this->isvisible($myuser)==0) {
		$message_display .= <<<MESSAGE_DISPLAY
			<input style="width: 120px;" type="submit" name="task" value="Find Friends">
MESSAGE_DISPLAY;
	}
	$message_display .= <<<MESSAGE_DISPLAY
		</form>
		</td>
		</tr>
		</table> 
		</div>
MESSAGE_DISPLAY;
	
	$clearinf  = <<<MESSAGE_DISPLAY
MESSAGE_DISPLAY;
//	if ($this->preview_header==2) 
/*
$clearinf .= <<<MESSAGE_DISPLAY
	<div id="search">
	<form id="searchform" method="post" action="index.php">
		<input type="hidden" name="search_usr" value="##ANY##">
		<input type="text" value="" name="search_input" id="s" size="20" placeholder="Search name or tag" required>
		<button type="submit" name="search_but" value="YES">Search</button>
	</form>
	<div class="textwidget">
  </div>
MESSAGE_DISPLAY;
*/
	$clearinf  .= <<<MESSAGE_DISPLAY
		<center>
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return check_searchform()">
MESSAGE_DISPLAY;
	$clearinf .= $this->fill_view_option(0);
	$clearinf .= <<<MESSAGE_DISPLAY
		</form>
		</center>
MESSAGE_DISPLAY;
	
	if ($this->preview_header==1) return $message_display; else if ($this->preview_header==2) return $clearinf; else return "";
}

public function display_userswitcher() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	$message_display = <<<MESSAGE_DISPLAY
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return check_searchform()">
MESSAGE_DISPLAY;
		$message_display .= $this->fill_view_option(0);
		$message_display .= <<<MESSAGE_DISPLAY
		</form>
MESSAGE_DISPLAY;

	return $message_display;
}


public function display_findfriends_btn() {
$message_display = <<<MESSAGE_DISPLAY
	<form method="post" action="" NAME="formular"> 
		<input type="text" style="width: 99%;" name="search_input" maxlength="150"/> 
		<input style="width: 80px;" type="submit" name="search_but" value="Search" tabindex="104" title="Search in Synapse.." accesskey="n" />
MESSAGE_DISPLAY;
	if ($this->isvisible($myuser)==0) {
		$message_display .= <<<MESSAGE_DISPLAY
			<input style="width: 120px;" type="submit" name="task" value="Find Friends">
MESSAGE_DISPLAY;
	}
	$message_display .= <<<MESSAGE_DISPLAY
		</form>
MESSAGE_DISPLAY;

	return $message_display;
}

public function display_plugins_menu($friend) {
	$message_display = <<<MESSAGE_DISPLAY
<style type="text/css">
div.expand span.collapsible { display : none; }
div.expand:hover span.collapsible { display : inline; }
</style>
		<br><b>
		<div class='expand'>
		<a href="#" style="font-family: 'ubuntu'; color: gray;">Available Plugins of $friend: </a>
		<span class="collapsible">
MESSAGE_DISPLAY;
		$mdn="{$this->synapse_path}plugins/";
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
							$plug = $mdn."/".$dirArray[$index]."/stage_run.php";
							if (file_exists($plug)) $message_display .= "<a style=\"font-family: 'ubuntu'; color: gray;\" href=\"index.php?plugin={$dirArray[$index]}&user=$friend\"> $dirArray[$index]</a> ";
				}
			}
		}
	$message_display .= <<<MESSAGE_DISPLAY
		</span>
		</div>
		</b>
MESSAGE_DISPLAY;
	echo($message_display);
}

/* @info  display messages from friend */
public function display_friend_messages($friend)
{
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	$this->unpack_files($friend);

	$this->display_notifications();
	
	$_SESSION['infotext'] = "Friend Messages";

	if ($this->themecity==1) {
		$this->switch_buffer_table();	
		$q = mysql_query("SELECT Work FROM buffer WHERE UsernameOne='##CHANGEWALLPAPER##' AND UsernameTwo='$friend'");	
		$a = mysql_fetch_assoc($q);
		$workinf = $a['Work'];
		//echo($workinf);
		if ($workinf) {
				$_SESSION['bodycss']=$friend."/".$workinf;
				//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
		}
	}

	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";


	// display followers
	// $message_display .= "<p><div style=\"float: left;\"><b>Followers of <a href=\"blog.php?user={$friend}\">{$friend}</a> : {$this->display_followers($friend)}</b></div>";
	$message_display .= "<div style=\"float: left; color: gray; width: 400px;\">{$this->getinform($friend)}<br /></div>";
	// link to public profile
	$message_display .= "<div style=\"float: right;\"><b>Link to <a href=\"blog.php?user={$friend}\">{$friend} public profile</a></b></div></p><br><br/>";
	
	
	$this->switch_data_table();
	
    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {

		//$this->preview_type=1;

		if ($this->preview_type==99) {
						$message_display .= <<<MESSAGE_DISPLAY
							<ul class="messages">
MESSAGE_DISPLAY;
						$numbers=$this->lines;
		} else
		if ($this->preview_type==0) {
			$message_display .= "<ul class=\"messages\">";
			$numbers=$this->lines;
		} else if ($this->preview_type==1) {
			$numbers=$this->lines;
		} else if ($this->preview_type==2) {
			$numbers=$this->lines;
		} else if ($this->preview_type==3) {
			$numbers=$this->lines;
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.commentlist li {
    padding: 0px;
        padding-top: 0px;
        padding-right-value: 0px;
        padding-bottom: 0px;
        padding-left-value: 0px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
}
.commentlist {
    list-style: none outside none;
        list-style-type: none;
        list-style-image: none;
        list-style-position: outside;
}
.commentlist li > div {
    border: 1px solid rgb(221, 221, 221);
        border-top-width: 1px;
        border-right-width-value: 1px;
        border-right-width-ltr-source: physical;
        border-right-width-rtl-source: physical;
        border-bottom-width: 1px;
        border-left-width-value: 1px;
        border-left-width-ltr-source: physical;
        border-left-width-rtl-source: physical;
        border-top-style: solid;
        border-right-style-value: solid;
        border-right-style-ltr-source: physical;
        border-right-style-rtl-source: physical;
        border-bottom-style: solid;
        border-left-style-value: solid;
        border-left-style-ltr-source: physical;
        border-left-style-rtl-source: physical;
        border-top-color: rgb(221, 221, 221);
        border-right-color-value: rgb(221, 221, 221);
        border-right-color-ltr-source: physical;
        border-right-color-rtl-source: physical;
        border-bottom-color: rgb(221, 221, 221);
        border-left-color-value: rgb(221, 221, 221);
        border-left-color-ltr-source: physical;
        border-left-color-rtl-source: physical;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image-source: none;
        border-image-slice: 100% 100% 100% 100%;
        border-image-width: 1 1 1 1;
        border-image-outset: 0 0 0 0;
        border-image-repeat: stretch stretch;
    background: none repeat scroll 0% 0% rgb(252, 252, 252);
        background-color: rgb(252, 252, 252);
        background-image: none;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: 0% 0%;
        background-clip: border-box;
        background-origin: padding-box;
        background-size: auto auto;
    padding: 20px 20px 3px;
        padding-top: 20px;
        padding-right-value: 20px;
        padding-bottom: 3px;
        padding-left-value: 20px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
    position: relative;
    margin-bottom: 20px;
    margin-left: 85px;
        margin-left-value: 85px;
        margin-left-ltr-source: physical;
        margin-left-rtl-source: physical;
    border-radius: 5px 5px 5px 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
}
.commentlist .avatar {
    position: absolute;
    top: 3px;
    left: -80px;
    border-radius: 50% 50% 50% 50%;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    box-shadow: 0px 0px 0px 3px rgb(204, 204, 204);
}
.comment-reply-link {
    position: absolute;
    top: 60px;
    left: -80px;
    font-size: 13px;
    width: 50px;
    text-align: center;
    color: rgb(204, 204, 204);
}
.comment-author {
    font-weight: bold;
    font-size: 16px;
}
.comment-date-link {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 11px;
    line-height: 13px;
    text-align: right;
}
.comment-text {
}
</style>
<ol class="commentlist">
MESSAGE_DISPLAY;
		} else {
			$message_display .= "<!-- css3 accordion --><div class=\"accordion-container\"><!--accordion--><ul><li class=\"block_header\">Selected $friend Messages</li>";
			$numbers=$this->lines_vert;
		}
		//$id=1;
		$ig=1;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext'];
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 	
			
			// preview for all userd
			$vypa=$_SESSION['pageid']*$numbers; 
			$vypb=$vypa-$numbers;
			
			// spravicky od fiend, ak su urcene pre vsetkych alebo pre mna
			if ( ($user==$friend) &&  (($sto==$myuser) || ($sto == "##ALLFRIENDS##") || ($sto == "##ALLUSERS##")) ) {
					if (($ig>$vypb)&&($ig<$vypa)) {
						$avat = $this->getimgavatar($user);
						$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
						$result = $this->nicetime($date); // 2 days ago 
						
				
						
						if ($this->karma_health($crea)==1) {
								$heart = <<<MESSAGE_DISPLAY
									<img class="bubble" src="{$this->synapse_dir}themes/images/interface/star.gif" alt="karma_heart" title="{$this->karma_health_likes($crea)} likes">
MESSAGE_DISPLAY;
						} else $heart = "";

						// begin of Karma Code Widget
						$this->switch_karma_table();
						$km = mysql_query("SELECT yesno FROM karma WHERE id='$crea' AND username='$myuser'");	
						$row = mysql_fetch_assoc($km);
						$akyesno = $row["yesno"];
						
						if ($akyesno) {
							if (strpos($akyesno,"Yes")!==false) {
								$karma = <<<MESSAGE_DISPLAY
									<img src="{$this->synapse_dir}themes/images/interface/plus.gif"> $heart
MESSAGE_DISPLAY;
							} else {
								$karma = <<<MESSAGE_DISPLAY
									<img src="{$this->synapse_dir}themes/images/interface/minus.gif"> $heart

MESSAGE_DISPLAY;
							}
						} else {
							$karma = <<<MESSAGE_DISPLAY
									<form NAME="formular" action="index.php" method="post" onsubmit="">
											<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="Yes">
												<img src="{$this->synapse_dir}themes/images/interface/vote_up.png" alt="submit" />
											</button> Yes 
											
											<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="No">
												<img src="{$this->synapse_dir}themes/images/interface/vote_down.png" alt="submit" />
											</button> No 
											
											<input type="hidden" name="karma_user" value="{$myuser}">
											<input type="hidden" name="karma_title" value="{$title}">
											<input type="hidden" name="karma_index" value="{$crea}">
											<input type="hidden" name="karma_bodytext" value="{$bodytext}">
									</form>
MESSAGE_DISPLAY;
						}
				
				
				
					if ($user != $myuser) $sharebtn = "<input type=\"submit\" name=\"karma_yesno\" value=\"Share\">";
				
					// Display Bodytext and reply messages
						$replies = $this->howmany_reply_messages($crea);
						$under_title = <<<MESSAGE_DISPLAY
								Posted by {$user} with {$replies} replies</i></p>							
MESSAGE_DISPLAY;

					// if reply messages fill array and put to screen
						$reply_func = $this->display_reply_messages_inside($crea);
						
						$reply_butfunc = $this->display_reply_button($crea);
						
						if ($this->preview_type==99) {
							$message_display .= <<<ADMIN_FORM
								<li class="messages">
								<h2>$title</h2>
								<p>
								<table border="0" width="100%">
								<tr>
								<td align=left>
									<span class="label label-warning pull-right"><i><font size=1>{$title} <br />{$under_title}<br /></font></font></i></span>
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
							<p><div id="alt">{$bodytext} {$reply_func}</div></p>
							<p>	
								<table class="comment-buttons" border="0" width="100%">
								<tr>
								<td align=left>
								<form style="display: inline-block;" NAME="formular" action="index.php" method="post" onsubmit="">
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_bodytext" value="{$bodytext}">
								{$sharebtn}
								<input type="submit" id="bbookmark"  name="insertfavourite" value="Bookmark It">
								<!--<input type="submit" id="breply"  name="karma_yesno" value="Reply">!-->
								{$reply_butfunc}
								</form>
								</td>
								<td align=right>
									{$karma}
								</td>
								</tr>
								</table>
								
							</p>
							</li>	
ADMIN_FORM;
						} else
						if ($this->preview_type==0) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<h2>$title</h2>
								<i>
								<span style="color:black">Posted by $user, $result</span>
								</i>
								<p><div id="alt">$bodytext</div></p>
								</li>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==1) {
							$message_display .= <<<MESSAGE_DISPLAY
								<div class="tweet"> 
								<img class="avatar" src="$avat" alt="twitter"> 
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Posted by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
								</div>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==3) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}" onclick="return addComment.moveForm(&quot;comment-1781&quot;, &quot;1781&quot;, &quot;respond&quot;, &quot;232&quot;)">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
										{$result}
									</a>
								</span>				

								<div class="comment-text">
									<p>{$bodytext}</p>
									
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="submit" name="karma_yesno" value="Reply">
								<input type="submit" name="karma_yesno" value="Share">
								</td>
								</tr>
								</table>
								</form>
				
								</div>

								</div>
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="block" id="block_{$ig}"><a class="header" href="#block_{$ig}">$title</a><div class="arrow"></div>
								<div> 
									<table border="0" width="100%">
									<tr>
									<td>
									<p>
									<img src="$avat"  width=48px; height=48px; style="margin-top:0px;border:0;" alt="avatar" /> <br>
									</p>
									</td>
									<td>
									<p><span style="color:black">Written by {$user}, {$datum}</span></p>
									<p>$bodytext</p>
									</td>
									</tr>
									</table>
									
								</div>
								</li>
MESSAGE_DISPLAY;
						}
					}
				$ig++;
			}
		}
		if ($this->preview_type!=1) {
			$message_display .= "</ul>";
			if ($this->preview_type!=0) $message_display .= "</div>";
		}
	}
	echo($message_display);
	
	echo("<div style=\"padding-left: 10px;padding-right: 15px;\">");
	// display friends of your friends, who you dont have in contacts
	if ($this->isvisible($myuser)==0) $this->display_friend_friends_notifications($friend); else $this->display_followers_notifications($friend);
	// preview pictures of your friends
	$this->list_image_files ($this->upload_dir . $friend . "/");
	// display plugins of friend 
	//$this->display_plugins_menu($friend);
	// display formular
	echo($this->display_messages_form($ig, $numbers, $friend));
	
	echo("</div>");
	
	
}

public function isfavourite($crea) {
	$this->switch_favourites_table();
	
	$fq = "SELECT * FROM favourites ORDER BY created DESC LIMIT 2048";
	$fr = mysql_query($fq);
	
	$test=0;
	if ( $fr !== false && mysql_num_rows($fr) > 0 ) {
		while ( $fa = mysql_fetch_assoc($fr) ) {
			//$ftitle = stripslashes($fa['title']);
			//$fsendto = stripslashes($fa['title']);
			//$fuser = stripslashes($fa['user']);
			$fid = stripslashes($fa['id']);
		
			if ($crea==$fid) return 1; 
		}
		
	    return 0;
	}
	return 0;
}

public function ismyfavourite($crea) {
	$this->switch_favourites_table();
	
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	$fq = "SELECT * FROM favourites ORDER BY created DESC LIMIT 2048";
	$fr = mysql_query($fq);
	
	$test=0;
	if ( $fr !== false && mysql_num_rows($fr) > 0 ) {
		while ( $fa = mysql_fetch_assoc($fr) ) {
			//$ftitle = stripslashes($fa['title']);
			//$fsendto = stripslashes($fa['sendto']);
			$fuser = stripslashes($fa['user']);
			$fid = stripslashes($fa['id']);
		
			// if ID == CREA and IF Message is bookmarked by me,then i see it
			if ($crea==$fid) if ($fuser==$myuser) return 1; 
		}
	}
	return 0;
}

/* @info  display messages from friend */
public function display_bookmarks_messages() {
	if ($_SESSION['loginuser']) {
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	//$this->display_notifications();

	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";

	//$message_display .= "<p style=\"float: right;\"><b>Link to <a href=\"blog.php?user={$friend}\">{$friend} public profile</a></b></p>";

	$_SESSION['infotext'] = "Bookmarks";

	//////////////

	$this->switch_data_table();
	
    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {

		//$this->preview_type=1;

		if ($this->preview_type==0) {
			$message_display .= "<ul class=\"messages\">";
			$numbers=$this->lines;
		} else if ($this->preview_type==1) {
			$numbers=$this->lines;
		} else if ($this->preview_type==2) {
			$numbers=$this->lines;
		} else if ($this->preview_type==3) {
			$numbers=$this->lines;
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.commentlist li {
    padding: 0px;
        padding-top: 0px;
        padding-right-value: 0px;
        padding-bottom: 0px;
        padding-left-value: 0px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
}
.commentlist {
    list-style: none outside none;
        list-style-type: none;
        list-style-image: none;
        list-style-position: outside;
}
.commentlist li > div {
    border: 1px solid rgb(221, 221, 221);
        border-top-width: 1px;
        border-right-width-value: 1px;
        border-right-width-ltr-source: physical;
        border-right-width-rtl-source: physical;
        border-bottom-width: 1px;
        border-left-width-value: 1px;
        border-left-width-ltr-source: physical;
        border-left-width-rtl-source: physical;
        border-top-style: solid;
        border-right-style-value: solid;
        border-right-style-ltr-source: physical;
        border-right-style-rtl-source: physical;
        border-bottom-style: solid;
        border-left-style-value: solid;
        border-left-style-ltr-source: physical;
        border-left-style-rtl-source: physical;
        border-top-color: rgb(221, 221, 221);
        border-right-color-value: rgb(221, 221, 221);
        border-right-color-ltr-source: physical;
        border-right-color-rtl-source: physical;
        border-bottom-color: rgb(221, 221, 221);
        border-left-color-value: rgb(221, 221, 221);
        border-left-color-ltr-source: physical;
        border-left-color-rtl-source: physical;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image-source: none;
        border-image-slice: 100% 100% 100% 100%;
        border-image-width: 1 1 1 1;
        border-image-outset: 0 0 0 0;
        border-image-repeat: stretch stretch;
    background: none repeat scroll 0% 0% rgb(252, 252, 252);
        background-color: rgb(252, 252, 252);
        background-image: none;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: 0% 0%;
        background-clip: border-box;
        background-origin: padding-box;
        background-size: auto auto;
    padding: 20px 20px 3px;
        padding-top: 20px;
        padding-right-value: 20px;
        padding-bottom: 3px;
        padding-left-value: 20px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
    position: relative;
    margin-bottom: 20px;
    margin-left: 85px;
        margin-left-value: 85px;
        margin-left-ltr-source: physical;
        margin-left-rtl-source: physical;
    border-radius: 5px 5px 5px 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
}
.commentlist .avatar {
    position: absolute;
    top: 3px;
    left: -80px;
    border-radius: 50% 50% 50% 50%;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    box-shadow: 0px 0px 0px 3px rgb(204, 204, 204);
}
.comment-reply-link {
    position: absolute;
    top: 60px;
    left: -80px;
    font-size: 13px;
    width: 50px;
    text-align: center;
    color: rgb(204, 204, 204);
}
.comment-author {
    font-weight: bold;
    font-size: 16px;
}
.comment-date-link {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 11px;
    line-height: 13px;
    text-align: right;
}
.comment-text {
}
</style>
<ol class="commentlist">
MESSAGE_DISPLAY;
		} else {
			$message_display .= "<!-- css3 accordion --><div class=\"accordion-container\"><!--accordion--><ul><li class=\"block_header\">Selected $friend Messages</li>";
			$numbers=$this->lines_vert;
		}
		//$id=1;
		$ig=1;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext'];
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 	
			
			// preview for all userd
			$vypa=$_SESSION['pageid']*$numbers; 
			$vypb=$vypa-$numbers;
			
			// spravicky od fiend, ak su urcene pre vsetkych alebo pre mna
			//if  ($user==$myuser) {
			if ( $this->ismyfavourite($crea)==1 ) {
					if (($ig>$vypb)&&($ig<$vypa)) {
						$avat = $this->getimgavatar($user);
						$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
						$result = $this->nicetime($date); // 2 days ago 
						if ($this->preview_type==0) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<h2>$title</h2>
								<i>
								<span style="color:black">Posted by {$user}, $result</span>
								</i>
								<p><div id="alt">$bodytext</div></p>
								</li>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==1) {
							$message_display .= <<<MESSAGE_DISPLAY
								<div class="tweet"> 
								<img class="avatar" src="$avat" alt="twitter"> 
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Posted by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
								</div>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==3) {
							
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}" onclick="return addComment.moveForm(&quot;comment-1781&quot;, &quot;1781&quot;, &quot;respond&quot;, &quot;232&quot;)">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
										{$result}
									</a>
								</span>				

								<div class="comment-text">
									<p>{$bodytext}</p>
									
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="submit" name="karma_yesno" value="Delete from Bookmarks">
								<input type="submit" name="karma_yesno" value="Reply">
								</td>
								</tr>
								</table>
								</form>
				
								</div>

								</div>
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="block" id="block_{$ig}"><a class="header" href="#block_{$ig}">$title</a><div class="arrow"></div>
								<div> 
									<table border="0" width="100%">
									<tr>
									<td>
									<p>
									<img src="$avat"  width=48px; height=48px; style="margin-top:0px;border:0;" alt="avatar" /> <br>
									</p>
									</td>
									<td>
									<p><span style="color:black">Written by {$user}, {$datum}</span></p>
									<p>$bodytext</p>
									</td>
									</tr>
									</table>
									
								</div>
								</li>
MESSAGE_DISPLAY;
						}
					}
				$ig++;
			}
		}
		if ($this->preview_type!=1) {
			$message_display .= "</ul>";
			if ($this->preview_type!=0) $message_display .= "</div>";
		}
	}

	echo($message_display);
	// display friends of your friends, who you dont have in contacts
	//if ($this->isvisible($myuser)==0) $this->display_friend_friends_notifications($friend); else $this->display_followers_notifications($friend);
	// preview pictures of your friends
	//$this->list_image_files ($this->upload_dir . $friend . "/");
	// display plugins of friend 
	//$this->display_plugins_menu($friend);
	// display formular
	echo($this->display_pager($ig, $numbers));
	} else echo("<div id=logo> </div>
		<div id=prihlasenie> 
		Access denied!
		</div>");
}

/* @info  display messages from friend */
public function display_favourites_messages() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	//$this->display_notifications();
	
	$_SESSION['infotext'] = "Favourite Messages";

	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";

	//$message_display .= "<p style=\"float: right;\"><b>Link to <a href=\"blog.php?user={$friend}\">{$friend} public profile</a></b></p>";

	//////////////

	$this->switch_data_table();
	
    $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {

		//$this->preview_type=1;

		if ($this->preview_type==0) {
			$message_display .= "<ul class=\"messages\">";
			$numbers=$this->lines;
		} else if ($this->preview_type==1) {
			$numbers=$this->lines;
		} else if ($this->preview_type==2) {
			$numbers=$this->lines;
		} else if ($this->preview_type==3) {
			$numbers=$this->lines;
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.commentlist li {
    padding: 0px;
        padding-top: 0px;
        padding-right-value: 0px;
        padding-bottom: 0px;
        padding-left-value: 0px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
}
.commentlist {
    list-style: none outside none;
        list-style-type: none;
        list-style-image: none;
        list-style-position: outside;
}
.commentlist li > div {
    border: 1px solid rgb(221, 221, 221);
        border-top-width: 1px;
        border-right-width-value: 1px;
        border-right-width-ltr-source: physical;
        border-right-width-rtl-source: physical;
        border-bottom-width: 1px;
        border-left-width-value: 1px;
        border-left-width-ltr-source: physical;
        border-left-width-rtl-source: physical;
        border-top-style: solid;
        border-right-style-value: solid;
        border-right-style-ltr-source: physical;
        border-right-style-rtl-source: physical;
        border-bottom-style: solid;
        border-left-style-value: solid;
        border-left-style-ltr-source: physical;
        border-left-style-rtl-source: physical;
        border-top-color: rgb(221, 221, 221);
        border-right-color-value: rgb(221, 221, 221);
        border-right-color-ltr-source: physical;
        border-right-color-rtl-source: physical;
        border-bottom-color: rgb(221, 221, 221);
        border-left-color-value: rgb(221, 221, 221);
        border-left-color-ltr-source: physical;
        border-left-color-rtl-source: physical;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image-source: none;
        border-image-slice: 100% 100% 100% 100%;
        border-image-width: 1 1 1 1;
        border-image-outset: 0 0 0 0;
        border-image-repeat: stretch stretch;
    background: none repeat scroll 0% 0% rgb(252, 252, 252);
        background-color: rgb(252, 252, 252);
        background-image: none;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: 0% 0%;
        background-clip: border-box;
        background-origin: padding-box;
        background-size: auto auto;
    padding: 20px 20px 3px;
        padding-top: 20px;
        padding-right-value: 20px;
        padding-bottom: 3px;
        padding-left-value: 20px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
    position: relative;
    margin-bottom: 20px;
    margin-left: 85px;
        margin-left-value: 85px;
        margin-left-ltr-source: physical;
        margin-left-rtl-source: physical;
    border-radius: 5px 5px 5px 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
}
.commentlist .avatar {
    position: absolute;
    top: 3px;
    left: -80px;
    border-radius: 50% 50% 50% 50%;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    box-shadow: 0px 0px 0px 3px rgb(204, 204, 204);
}
.comment-reply-link {
    position: absolute;
    top: 60px;
    left: -80px;
    font-size: 13px;
    width: 50px;
    text-align: center;
    color: rgb(204, 204, 204);
}
.comment-author {
    font-weight: bold;
    font-size: 16px;
}
.comment-date-link {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 11px;
    line-height: 13px;
    text-align: right;
}
.comment-text {
}
</style>
<ol class="commentlist">
MESSAGE_DISPLAY;
		} else {
			$message_display .= "<!-- css3 accordion --><div class=\"accordion-container\"><!--accordion--><ul><li class=\"block_header\">Selected $friend Messages</li>";
			$numbers=$this->lines_vert;
		}
		//$id=1;
		$ig=1;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext'];
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 	
			
			// preview for all userd
			$vypa=$_SESSION['pageid']*$numbers; 
			$vypb=$vypa-$numbers;
			
			// spravicky od fiend, ak su urcene pre vsetkych alebo pre mna
			if ( $this->isfavourite($crea)==1 ) {
					if (($ig>$vypb)&&($ig<$vypa)) {
						$avat = $this->getimgavatar($user);
						$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
						$result = $this->nicetime($date); // 2 days ago 
						if ($this->preview_type==0) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<h2>$title</h2>
								<i>
								<span style="color:black">Posted by $user, $result</span>
								</i>
								<p><div id="alt">$bodytext</div></p>
								</li>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==1) {
							$message_display .= <<<MESSAGE_DISPLAY
								<div class="tweet"> 
								<img class="avatar" src="$avat" alt="twitter"> 
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Posted by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
								</div>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==3) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}" onclick="return addComment.moveForm(&quot;comment-1781&quot;, &quot;1781&quot;, &quot;respond&quot;, &quot;232&quot;)">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
										{$result}
									</a>
								</span>				

								<div class="comment-text">
									<p>{$bodytext}</p>
									
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="submit" name="karma_yesno" value="Reply">
								<input type="submit" name="karma_yesno" value="Share">
								</td>
								</tr>
								</table>
								</form>
				
								</div>

								</div>
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="block" id="block_{$ig}"><a class="header" href="#block_{$ig}">$title</a><div class="arrow"></div>
								<div> 
									<table border="0" width="100%">
									<tr>
									<td>
									<p>
									<img src="$avat"  width=48px; height=48px; style="margin-top:0px;border:0;" alt="avatar" /> <br>
									</p>
									</td>
									<td>
									<p><span style="color:black">Written by {$user}, {$datum}</span></p>
									<p>$bodytext</p>
									</td>
									</tr>
									</table>
									
								</div>
								</li>
MESSAGE_DISPLAY;
						}
					}
				$ig++;
			}
		}
		if ($this->preview_type!=1) {
			$message_display .= "</ul>";
			if ($this->preview_type!=0) $message_display .= "</div>";
		}
	}

	echo($message_display);
	// display friends of your friends, who you dont have in contacts
	//if ($this->isvisible($myuser)==0) $this->display_friend_friends_notifications($friend); else $this->display_followers_notifications($friend);
	// preview pictures of your friends
	//$this->list_image_files ($this->upload_dir . $friend . "/");
	// display plugins of friend 
	//$this->display_plugins_menu($friend);
	// display formular
	echo($this->display_pager($ig, $numbers));
}

/* @info  display messages from friend */
public function display_recyclebin_messages() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);

	$_SESSION['infotext'] = "Recycle Bin";

	//$this->display_notifications();

	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";

	//$message_display .= "<p style=\"float: right;\"><b>Link to <a href=\"blog.php?user={$friend}\">{$friend} public profile</a></b></p>";

	//////////////

	$this->switch_recyclebin_table();
	
    $q = "SELECT * FROM recyclebin ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
	 if ( $r !== false && mysql_num_rows($r) > 0 ) {

		//$this->preview_type=1;

		if ($this->preview_type==0) {
			$message_display .= "<ul class=\"messages\">";
			$numbers=$this->lines;
		} else if ($this->preview_type==1) {
			$numbers=$this->lines;
		} else if ($this->preview_type==2) {
			$numbers=$this->lines;
		} else if ($this->preview_type==3) {
			$numbers=$this->lines;
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.commentlist li {
    padding: 0px;
        padding-top: 0px;
        padding-right-value: 0px;
        padding-bottom: 0px;
        padding-left-value: 0px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
}
.commentlist {
    list-style: none outside none;
        list-style-type: none;
        list-style-image: none;
        list-style-position: outside;
}
.commentlist li > div {
    border: 1px solid rgb(221, 221, 221);
        border-top-width: 1px;
        border-right-width-value: 1px;
        border-right-width-ltr-source: physical;
        border-right-width-rtl-source: physical;
        border-bottom-width: 1px;
        border-left-width-value: 1px;
        border-left-width-ltr-source: physical;
        border-left-width-rtl-source: physical;
        border-top-style: solid;
        border-right-style-value: solid;
        border-right-style-ltr-source: physical;
        border-right-style-rtl-source: physical;
        border-bottom-style: solid;
        border-left-style-value: solid;
        border-left-style-ltr-source: physical;
        border-left-style-rtl-source: physical;
        border-top-color: rgb(221, 221, 221);
        border-right-color-value: rgb(221, 221, 221);
        border-right-color-ltr-source: physical;
        border-right-color-rtl-source: physical;
        border-bottom-color: rgb(221, 221, 221);
        border-left-color-value: rgb(221, 221, 221);
        border-left-color-ltr-source: physical;
        border-left-color-rtl-source: physical;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image-source: none;
        border-image-slice: 100% 100% 100% 100%;
        border-image-width: 1 1 1 1;
        border-image-outset: 0 0 0 0;
        border-image-repeat: stretch stretch;
    background: none repeat scroll 0% 0% rgb(252, 252, 252);
        background-color: rgb(252, 252, 252);
        background-image: none;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: 0% 0%;
        background-clip: border-box;
        background-origin: padding-box;
        background-size: auto auto;
    padding: 20px 20px 3px;
        padding-top: 20px;
        padding-right-value: 20px;
        padding-bottom: 3px;
        padding-left-value: 20px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
    position: relative;
    margin-bottom: 20px;
    margin-left: 85px;
        margin-left-value: 85px;
        margin-left-ltr-source: physical;
        margin-left-rtl-source: physical;
    border-radius: 5px 5px 5px 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
}
.commentlist .avatar {
    position: absolute;
    top: 3px;
    left: -80px;
    border-radius: 50% 50% 50% 50%;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    box-shadow: 0px 0px 0px 3px rgb(204, 204, 204);
}
.comment-reply-link {
    position: absolute;
    top: 60px;
    left: -80px;
    font-size: 13px;
    width: 50px;
    text-align: center;
    color: rgb(204, 204, 204);
}
.comment-author {
    font-weight: bold;
    font-size: 16px;
}
.comment-date-link {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 11px;
    line-height: 13px;
    text-align: right;
}
.comment-text {
}
</style>
<ol class="commentlist">
MESSAGE_DISPLAY;
		} else {
			$message_display .= "<!-- css3 accordion --><div class=\"accordion-container\"><!--accordion--><ul><li class=\"block_header\">Selected $friend Messages</li>";
			$numbers=$this->lines_vert;
		}
		//$id=1;
		$ig=1;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext'];
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 	
			
			// preview for all userd
			$vypa=$_SESSION['pageid']*$numbers; 
			$vypb=$vypa-$numbers;
			
					if (($ig>$vypb)&&($ig<$vypa)) {
						$avat = $this->getimgavatar($user);
						$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
						$result = $this->nicetime($date); // 2 days ago 
						if ($this->preview_type==0) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<h2>$title</h2>
								<i>
								<span style="color:black">Posted by $user, $result</span>
								</i>
								<p><div id="alt">$bodytext</div></p>
								</li>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==1) {
							$message_display .= <<<MESSAGE_DISPLAY
								<div class="tweet"> 
								<img class="avatar" src="$avat" alt="twitter"> 
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Posted by <a href="#">{$user}</a> at ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
								</div>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==3) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}" onclick="return addComment.moveForm(&quot;comment-1781&quot;, &quot;1781&quot;, &quot;respond&quot;, &quot;232&quot;)">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
										{$result}
									</a>
								</span>				

								<div class="comment-text">
									<p>{$bodytext}</p>
									
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_index" value="{$crea}">
								<!--
								<input type="submit" name="karma_yesno" value="Reply">
								<input type="submit" name="karma_yesno" value="Share">
								-->
								</td>
								</tr>
								</table>
								</form>
				
								</div>

								</div>
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="block" id="block_{$ig}"><a class="header" href="#block_{$ig}">$title</a><div class="arrow"></div>
								<div> 
									<table border="0" width="100%">
									<tr>
									<td>
									<p>
									<img src="$avat"  width=48px; height=48px; style="margin-top:0px;border:0;" alt="avatar" /> <br>
									</p>
									</td>
									<td>
									<p><span style="color:black">Written by {$user}, {$datum}</span></p>
									<p>$bodytext</p>
									</td>
									</tr>
									</table>
									
								</div>
								</li>
MESSAGE_DISPLAY;
						}
					}
				$ig++;
		}
		if ($this->preview_type!=1) {
			$message_display .= "</ul>";
			if ($this->preview_type!=0) $message_display .= "</div>";
		}
	}

	echo($message_display);
	// display friends of your friends, who you dont have in contacts
	//if ($this->isvisible($myuser)==0) $this->display_friend_friends_notifications($friend); else $this->display_followers_notifications($friend);
	// preview pictures of your friends
	//$this->list_image_files ($this->upload_dir . $friend . "/");
	// display plugins of friend 
	//$this->display_plugins_menu($friend);
	// display formular
	echo($this->display_pager($ig, $numbers));
}

// health of Karma
// 0 - nothing
// 1 - Good
// 2 - Bad
function karma_health($kea) {
	$this->switch_karma_table();
	
	$q = "SELECT * FROM karma ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
	$good=0;
	$bad=0;
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			//$user = stripslashes($a['Username']);
			$kyesno = stripslashes($a['yesno']);
			$id = stripslashes($a['id']);
			
			if ($id==$kea) {
				if (strpos($kyesno,"Yes")!==false) $good++;
					else if (strpos($kyesno,"No")!==false) $bad++;
			}
		}
	}
	if ($good>$bad) return 1; else
		if ($good<$bad) return 2; else
	return 0;
}

function karma_health_likes($kea) {
	$this->switch_karma_table();
	
	$q = "SELECT * FROM karma ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	
	$good=0;
	$bad=0;
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			//$user = stripslashes($a['Username']);
			$kyesno = stripslashes($a['yesno']);
			$id = stripslashes($a['id']);
			
			if ($id==$kea) {
				if (strpos($kyesno,"Yes")!==false) $good++;
					//else if (strpos($kyesno,"No")!==false) $bad++;
			}
		}
	}
	//if ($good>$bad) return 1; else
		//if ($good<$bad) return 2; else
	return $good;
}


/* @info  global function for display messages, core of synapse-cms */
public function display_timeline() {

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	//$this->display_notifications();
	
	$_SESSION['infotext'] = "Your Messages";
	
	if ($this->themecity==1) {
		$this->switch_buffer_table();	
		$q = mysql_query("SELECT Work FROM buffer WHERE UsernameOne='##CHANGEWALLPAPER##' AND UsernameTwo='$myuser'");	
		$a = mysql_fetch_assoc($q);
		$workinf = $a['Work'];
		if ($workinf) {
				$_SESSION['bodycss']=$myuser."/".$workinf;
				//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
		}
	}
	
	$newmessages=0;
	
	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";
	
	//$message_display .= "<p style=\"float: right;\"><b>Messages from All Friends</b></p>";
	
	$this->switch_data_table();
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {		
		$tm1=mysql_real_escape_string($_GET['timeline1']);	// 1-11-2012
		$tm2=mysql_real_escape_string($_GET['timeline2']);	// 30-11-2012
		
		
		$ts1 = strtotime($tm1);
		$ts2 = strtotime($tm2);
		
		//var_dump($tm1);
		//var_dump($tm2);
		
		//$format="%d/%m/%Y %H:%M:%S";
		//$strf=strftime($format);
		//echo("$strf");
		//$ts = strptime($tm1, $format);
		//$ts1 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts1);
		//$ts = strptime($tm2, $format);
		//$ts2 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts2);
		
		$q = "SELECT * FROM data WHERE created<$ts2 ORDER BY created DESC LIMIT 2048";
	} else $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		
		//
		// Display type of Preview
		//
		$message_display .= <<<MESSAGE_DISPLAY
			<br />
			<br />
MESSAGE_DISPLAY;
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.message-frame {
width: 98%;
border: 2px solid #CCCCCC;
text-decoration: none;
background: #FFFFFF;
font-weight: normal;
color: #53524E; 
padding-left:2px;
}
</style>
MESSAGE_DISPLAY;
		
		$ig=1;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext']; 
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 			
		
			// preview for all userd
			if ($sto == "##SYSMESSAGE##") {
			} else 
			if ( ($sto == "##ALLUSERS##")||($sto == "##SHOP##") ) {
				if ( ($this->ismyfriend($user)==1)  || ($this->isadmin($user)==1)|| ($myuser==$user) ) { 
					
				}
			} else if ($this->isvisible($myuser)==0) {  
				// {SK} Informacny vidi len svoje spravicky, ostatne nie
				// preview messagef for : All Friends, Post Private, Get Private  
				// jedna sa o moju spravicku, alebo jedna sa  o mojho priatelove spravicky, 
				if (!is_numeric ( $sto ))
				if  ( ( $myuser == $user ) ||  ( ($this->ismyfriend($user)==1) && ($sto == "##ALLFRIENDS##") ) 
										   ||  ( ($this->ismyfriend($user)==1) && ($sto == "##SHARED##") ) 
										   ||  ( ($this->ismyfriend($user)==1) && ($sto == "##SECURE##") )  
										   || ( ($this->ismyfriend($user)==1) && ($sto == $myuser) ) ) {
					// lasttime notification test
					if ( ($this->lasttime_test($crea)==1) && ( $myuser != $user ) ) $newmessages++;
					// display messages with page coun
						
						// get avatar name
						/// $avat = $this->getimgavatar($user); 
						if ($sto == $myuser) { $avat = $this->getimgavatar($user); } else if ( ($sto == "##ALLFRIENDS##")||($sto == "##SHARED##")||($sto == "##SECURE##") ) { $avat = $this->getimgavatar($user); } else { $avat = $this->getimgavatar($user); }
						
						$message_display .= <<<MESSAGE_DISPLAY
								<li class="message-frame">
								<p><h2>$title</h2></p>
								</li><br>
MESSAGE_DISPLAY;
				
				}
			}
		$this->switch_data_table();
		}
	} else {
		$message_display = <<<MESSAGE_DISPLAY
			<h2> This Page Is Under Construction </h2>
			<p>	
			No entries have been made on this page. 
			Please check back soon, or click the
			link below to add an entry!
			</p>
MESSAGE_DISPLAY;
    }

  echo($message_display);
  
  // new information about new messages
  if ($newmessages>0) {
	$this->switch_buffer_table();
	$created = time();
	$askmsg="You have " . $newmessages . " not readed new messages..";
	$sql = "INSERT INTO buffer VALUES('##SYSMESSAGE##','$myuser','$askmsg','#','#','$created')";
	$r = mysql_query($sql);
  }
  
  // update lasttime
  $this->switch_users_table();
  $curtime = time();
  $q = "UPDATE users SET Lasttime='$curtime' WHERE Username = '$myuser'";
  $r = mysql_query($q);
}

/* @info  global function for display messages, core of synapse-cms */
public function display_messages() {

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	$this->display_notifications();
	
	$_SESSION['infotext'] = "Your Messages";
	
	if ($this->themecity==1) {
		$this->switch_buffer_table();	
		$q = mysql_query("SELECT Work FROM buffer WHERE UsernameOne='##CHANGEWALLPAPER##' AND UsernameTwo='$myuser'");	
		$a = mysql_fetch_assoc($q);
		$workinf = $a['Work'];
		if ($workinf) {
				$_SESSION['bodycss']=$myuser."/".$workinf;
				//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
		}
	}
	
	$newmessages=0;
	
	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";
	
	//$message_display .= "<p style=\"float: right;\"><b>Messages from All Friends</b></p>";
	
	$this->switch_data_table();
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {		
		$tm1=mysql_real_escape_string($_GET['timeline1']);	// 1-11-2012
		$tm2=mysql_real_escape_string($_GET['timeline2']);	// 30-11-2012
		
		
		$ts1 = strtotime($tm1);
		$ts2 = strtotime($tm2);
		
		//var_dump($tm1);
		//var_dump($tm2);
		
		//$format="%d/%m/%Y %H:%M:%S";
		//$strf=strftime($format);
		//echo("$strf");
		//$ts = strptime($tm1, $format);
		//$ts1 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts1);
		//$ts = strptime($tm2, $format);
		//$ts2 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts2);
		
		$q = "SELECT * FROM data WHERE created<$ts2 ORDER BY created DESC LIMIT 2048";
	} else $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	
   $r = mysql_query($q);
   
   
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
			$numbers=$this->lines;
			//$numbers=$this->lines_vert;
		if ($this->preview_type==99) {
						$message_display .= <<<MESSAGE_DISPLAY
							<ul class="messages">
MESSAGE_DISPLAY;
		} else
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.commentlist li {
    padding: 0px;
        padding-top: 0px;
        padding-right-value: 0px;
        padding-bottom: 0px;
        padding-left-value: 0px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
}
.commentlist {
    list-style: none outside none;
        list-style-type: none;
        list-style-image: none;
        list-style-position: outside;
}
.commentlist li > div {
    border: 1px solid rgb(221, 221, 221);
        border-top-width: 1px;
        border-right-width-value: 1px;
        border-right-width-ltr-source: physical;
        border-right-width-rtl-source: physical;
        border-bottom-width: 1px;
        border-left-width-value: 1px;
        border-left-width-ltr-source: physical;
        border-left-width-rtl-source: physical;
        border-top-style: solid;
        border-right-style-value: solid;
        border-right-style-ltr-source: physical;
        border-right-style-rtl-source: physical;
        border-bottom-style: solid;
        border-left-style-value: solid;
        border-left-style-ltr-source: physical;
        border-left-style-rtl-source: physical;
        border-top-color: rgb(221, 221, 221);
        border-right-color-value: rgb(221, 221, 221);
        border-right-color-ltr-source: physical;
        border-right-color-rtl-source: physical;
        border-bottom-color: rgb(221, 221, 221);
        border-left-color-value: rgb(221, 221, 221);
        border-left-color-ltr-source: physical;
        border-left-color-rtl-source: physical;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image-source: none;
        border-image-slice: 100% 100% 100% 100%;
        border-image-width: 1 1 1 1;
        border-image-outset: 0 0 0 0;
        border-image-repeat: stretch stretch;
    background: none repeat scroll 0% 0% rgb(252, 252, 252);
        background-color: rgb(252, 252, 252);
        background-image: none;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: 0% 0%;
        background-clip: border-box;
        background-origin: padding-box;
        background-size: auto auto;
    padding: 20px 20px 3px;
        padding-top: 20px;
        padding-right-value: 20px;
        padding-bottom: 3px;
        padding-left-value: 20px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
    position: relative;
    margin-bottom: 20px;
    margin-left: 85px;
        margin-left-value: 85px;
        margin-left-ltr-source: physical;
        margin-left-rtl-source: physical;
    border-radius: 5px 5px 5px 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
}
.commentlist .avatar {
    position: absolute;
    top: 3px;
    left: -80px;
    border-radius: 50% 50% 50% 50%;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    box-shadow: 0px 0px 0px 3px rgb(204, 204, 204);
}
.comment-reply-link {
    position: absolute;
    top: 60px;
    left: -80px;
    font-size: 13px;
    width: 50px;
    text-align: center;
    color: rgb(204, 204, 204);
}
.comment-author {
    font-weight: bold;
    font-size: 16px;
}
.comment-date-link {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 11px;
    line-height: 13px;
    text-align: right;
}
.comment-text {
}
</style>
<ol class="commentlist">
MESSAGE_DISPLAY;

		$ig=0;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext']; 
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 			
			
			// secure message ?
			$test=0;
			if (!empty($_POST['insertcode'])) if ($_POST['insertcode']=="Insert Code") if ($crea==$_POST['insertcode_index']) if ($this->issecure($_POST['insertcode_user'], $_POST['insertcode_search'])==1) $test=1;
					
			// preview for all userd
			
			$numbers=10;
			$vypa=$_SESSION['pageid']*$numbers-$numbers; 
			$vypb=$vypa+$numbers;
			
			// ** SWITCH
			switch ($sto) {
				
				// ** System Messages and Notifications
				case '##SYSMESSAGE##':
					// ** empty **
				break;
				
				// All Users and Shop
				case '##ALLUSERS##':
				case '##SHOP##':
					$this->unpack_files($user);
				
				
					// ** Tools **
					if ($this->isadmin($myuser)==1) {
					$deletebtn = <<<MESS_DISPLAY
										<input type="submit" id="bdelete" name="karma_yesno" value="Delete Message">
MESS_DISPLAY;
					} else $deletebtn = "";
				
					if ( ($this->isadmin($myuser)==1) && ($this->recyclecity==1) ) {
					$recyclebtn = <<<MESS_DISPLAY
						<input type="submit" id="brecycle" name="recyclebin" value="Recycle Bin">
MESS_DISPLAY;
					} else $recyclebtn = "";
				
					if ($user != $myuser) $sharebtn = "<input type=\"submit\" name=\"karma_yesno\" value=\"Share\">";
				
					// Display Bodytext and reply messages
						$replies = $this->howmany_reply_messages($crea);
						$under_title = <<<MESSAGE_DISPLAY
								Posted by {$user} with {$replies} replies</i></p>							
MESSAGE_DISPLAY;

					// if reply messages fill array and put to screen
						$reply_func = $this->display_reply_messages_inside($crea);
					
					// ** Start BODY **
					if ( ($this->ismyfriend($user)==1)  || ($this->isadmin($user)==1)|| ($myuser==$user) ) { 
						// new messages?
						if ( ($this->lasttime_test($crea)==1) && ( $myuser != $user ) ) $newmessages++;
						// display messages
						if (($ig>=$vypa)&&($ig<=$vypb)) {
							// getavatar
							$this->unpack_files($user);
							
							$avat = $this->getimgavatar($user); 
							
						if ($this->karma_health($crea)==1) {
								$heart = <<<MESSAGE_DISPLAY
									<img class="bubble" src="{$this->synapse_dir}themes/images/interface/star.gif" alt="karma_heart" title="{$this->karma_health_likes($crea)} likes">
MESSAGE_DISPLAY;
						} else $heart = "";

						// begin of Karma Code Widget
						$this->switch_karma_table();
						$km = mysql_query("SELECT yesno FROM karma WHERE id='$crea' AND username='$myuser'");	
						$row = mysql_fetch_assoc($km);
						$akyesno = $row["yesno"];
						
						if ($akyesno) {
							if (strpos($akyesno,"Yes")!==false) {
								$karma = <<<MESSAGE_DISPLAY
									<img src="{$this->synapse_dir}themes/images/interface/plus.gif"> $heart
MESSAGE_DISPLAY;
							} else {
								$karma = <<<MESSAGE_DISPLAY
									<img src="{$this->synapse_dir}themes/images/interface/minus.gif"> $heart

MESSAGE_DISPLAY;
							}
						} else {
							$karma = <<<MESSAGE_DISPLAY
									<form NAME="formular" action="index.php" method="post" onsubmit="">
											<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="Yes">
												<img src="{$this->synapse_dir}themes/images/interface/vote_up.png" alt="submit" />
											</button> Yes 
											
											<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="No">
												<img src="{$this->synapse_dir}themes/images/interface/vote_down.png" alt="submit" />
											</button> No 
											
											<input type="hidden" name="karma_user" value="{$user}">
											<input type="hidden" name="karma_title" value="{$title}">
											<input type="hidden" name="karma_index" value="{$crea}">
											<input type="hidden" name="karma_bodytext" value="{$bodytext}">
									</form>
MESSAGE_DISPLAY;
						}
							
							
							if ($this->preview_type==99) {
							$message_display .= <<<ADMIN_FORM
								<li class="messages">
								<h2>$title</h2>
								<p>
								<table border="0" width="100%">
								<tr>
								<td align=left>
									<span class="label label-warning pull-right"><i><font size=1>{$under_title}</font></i></span>
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
							<p><div id="alt">{$bodytext} {$reply_func}</div></p>
							<p>	
								<table class="comment-buttons" border="0" width="100%">
								<tr>
								<td align=left>
								<form style="display: inline-block;" NAME="formular" action="index.php" method="post" onsubmit="">
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_bodytext" value="{$bodytext}">
								{$deletebtn}
								{$sharebtn}
								<input type="submit" id="bbookmark"  name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								<!--<input type="submit" id="breply"  name="karma_yesno" value="Reply">!-->
								{$reply_butfunc}
								</form>
								</td>
								<td align=right>
									{$karma}
								</td>
								</tr>
								</table>
								
							</p>
							</li>	
ADMIN_FORM;
						} else
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
									</a>
										{$result}
										<form  NAME="formular" action="{$this->synapse_dir}message.php?created=$crea" method="post">
											<button type="submit" style="border: 0; background: transparent">
												<img src="{$this->synapse_dir}themes/images/interface/sharebut.png" width="24" height="24" alt="submit" />
											</button>
										</form>
								</span>				

								<div class="comment-text">
									<p>{$under_title}</p>
									<p>{$bodytext}</p>
									<p>{$reply_func}</p>
								
								
								<table class="comment-buttons" border="0" width="100%">
								<tr>
								<td align=left>
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_bodytext" value="{$bodytext}">
								{$deletebtn}
								{$sharebtn}
								<input type="submit" id="bbookmark"  name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								{$reply_butfunc}
								<!--<input type="submit" id="breply"  name="karma_yesno" value="Reply">!-->
								</form>
								</td>
								<td align=right>
									{$karma}
								</td>
								</tr>
								</table>
								
											
								</div>

								</div>
								</li>
MESSAGE_DISPLAY;
						}
						$ig++;
						//if ($this->howmany_reply_messages($crea)!=0) $ig=$ig-$this->howmany_reply_messages($crea);
					}
					// ** End BODY **
				break;
				
				// ** All Friends and others in $sto
			    default:
						if ($this->isvisible($myuser)==0) {  
						// {SK} Informacny vidi len svoje spravicky, ostatne nie
						// preview messagef for : All Friends, Post Private, Get Private  
						// jedna sa o moju spravicku, alebo jedna sa  o mojho priatelove spravicky, 
						if (!is_numeric ( $sto ))
						if  ( ( $myuser == $user ) ||  ( ($this->ismyfriend($user)==1) && ($sto == "##ALLFRIENDS##") ) 
										   ||  ( ($this->ismyfriend($user)==1) && ($sto == "##SHARED##") ) 
										   ||  ( ($this->ismyfriend($user)==1) && ($sto == "##SECURE##") )  
										   || ( ($this->ismyfriend($user)==1) && ($sto == $myuser) ) ) {
						// lasttime notification test
						if ( ($this->lasttime_test($crea)==1) && ( $myuser != $user ) ) $newmessages++;
						// display messages with page count
						if (($ig>=$vypa)&&($ig<=$vypb)) {
						
						// get avatar name
						/// $avat = $this->getimgavatar($user); 
						if ($sto == $myuser) { $avat = $this->getimgavatar($user); } else if ( ($sto == "##ALLFRIENDS##")||($sto == "##SHARED##")||($sto == "##SECURE##") ) { $avat = $this->getimgavatar($user); } else { $avat = $this->getimgavatar($user); }
						
						// delete button is enabled? when Replies=0
						if ( ($this->delecity==1)&&($this->howmany_reply_messages($crea)==0) && ($myuser==$user) ) {
							$deletebtn = <<<MESS_DISPLAY
										<input type="submit" id="bdelete"  name="karma_yesno" value="Delete Message">
MESS_DISPLAY;
							} else $deletebtn = "";
						
						// delete button is enabled? when Replies=0					
						if ( ($this->recyclecity==1) && ($myuser==$user) ) {
							$recyclebtn = <<<MESS_DISPLAY
												<input type="submit" id="brecycle"  name="recyclebin" value="Recycle Bin">
MESS_DISPLAY;
							} else $recyclebtn = "";
						
						// fill SELECT with user friends, who are not my friend (i do not have it in my contact list)
						if ($myuser != $user) $friends=$this->display_friend_friends_option($user); else $friends=$result; 

						// if reply messages fill array and put to screen
						$reply_func = $this->display_reply_messages_inside($crea);
						$reply_butfunc = $this->display_reply_button($crea);
						
						$prevbl="blog.php?user={$user}";
						//$prevbl="index.php?preview={$user}";
						
						// again test for myuser?
						if ($sto == $myuser) {
							$under_title = <<<MESSAGE_DISPLAY
								<span style="color:red">Posted by <a href="{$prevbl}">$user</a> as Private at {$result}</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##ALLFRIENDS##") {
							$under_title = <<<MESSAGE_DISPLAY
								<span style="color:black">Posted by <a href="{$prevbl}">$user</a> for all friends at {$result}</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##SHARED##") {
							$under_title = <<<MESSAGE_DISPLAY
								<span style="color:blue">Shared by <a href="{$prevbl}">$user</a> for all friends by ---- at {$result}</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##SECURE##") {
							$under_title = <<<MESSAGE_DISPLAY
								<span style="color:red">Secure with required password by <a href="{$prevbl}">$user</a> for all friends at {$result}</span>
MESSAGE_DISPLAY;
						} else {
							$under_title = <<<MESSAGE_DISPLAY
								<span style="color:red">I post to {$sto} at {$result}</span>
MESSAGE_DISPLAY;
						}
						
						// Display Bodytext and reply messages
						$replies = $this->howmany_reply_messages($crea);
						$under_title .= <<<MESSAGE_DISPLAY
								with {$replies} replies</i></p>							
MESSAGE_DISPLAY;

						if ($this->karma_health($crea)==1) {
								$heart = <<<MESSAGE_DISPLAY
									<img class="bubble" src="{$this->synapse_dir}themes/images/interface/star.gif" alt="karma_heart" title="{$this->karma_health_likes($crea)} likes">
MESSAGE_DISPLAY;
						} else $heart = "";

						// begin of Karma Code Widget
						$this->switch_karma_table();
						$km = mysql_query("SELECT yesno FROM karma WHERE id='$crea' AND username='$myuser'");	
						$row = mysql_fetch_assoc($km);
						$akyesno = $row["yesno"];
						
						if ($akyesno) {
							if (strpos($akyesno,"Yes")!==false) {
								$karma = <<<MESSAGE_DISPLAY
									<img src="{$this->synapse_dir}themes/images/interface/plus.gif"> $heart
MESSAGE_DISPLAY;
							} else {
								$karma = <<<MESSAGE_DISPLAY
									<img src="{$this->synapse_dir}themes/images/interface/minus.gif"> $heart

MESSAGE_DISPLAY;
							}
						} else {
							$karma = <<<MESSAGE_DISPLAY
									<form NAME="formular" action="index.php" method="post" onsubmit="">
											<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="Yes">
												<img src="{$this->synapse_dir}themes/images/interface/vote_up.png" alt="submit" />
											</button> Yes 
											
											<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="No">
												<img src="{$this->synapse_dir}themes/images/interface/vote_down.png" alt="submit" />
											</button> No 
											
											<input type="hidden" name="karma_user" value="{$user}">
											<input type="hidden" name="karma_title" value="{$title}">
											<input type="hidden" name="karma_index" value="{$crea}">
											<input type="hidden" name="karma_bodytext" value="{$bodytext}">
									</form>
MESSAGE_DISPLAY;
						}
						
						// only visible buttons for administrators
						if ($this->isadmin($myuser)==1) {
								$buttons = <<<MESSAGE_DISPLAY
										<input type="submit"  id="bdelete" name="karma_yesno" value="Delete Message">
										<input type="submit"  id="bpin" name="karma_yesno" value="Pin to Homepage">
MESSAGE_DISPLAY;
						} else if ( $myuser == $user ) {
								// for login user messages and not admin
								
								// ak je nastaveny portal v rezime rozsirenej publicity, ze aj obycajny uzivatel - nie admin, nie kanal 
								// moze posielat spravicky na volnu nastenku
								if ($this->publicity==1) {
									$buttons = <<<MESSAGE_DISPLAY
										{$deletebtn}
										<input type="submit"  id="bpin" name="karma_yesno" value="Pin to Homepage">
MESSAGE_DISPLAY;
								} else
									$buttons = <<<MESSAGE_DISPLAY
										{$deletebtn}
										<input type="submit"  id="bask" name="karma_yesno" value="Public Ask">
MESSAGE_DISPLAY;
						}
						
						if ($user != $myuser) $buttons .= "<input type=\"submit\"  id=\"bshare\" name=\"karma_yesno\" value=\"Share\">";
						
						// ** Start BODY
						if ($this->preview_type==99) {
							$message_display .= <<<ADMIN_FORM
								<li class="messages">
								<h2>$title</h2>
								<p>
								<table border="0" width="100%">
								<tr>
								<td align=left>
									<span class="label label-warning pull-right"><i><font size=1>{$under_title}</font></i></span>
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
							<p><div id="alt">{$bodytext} {$reply_func}</div></p>
							<p>
								
								<table class="comment-buttons" border="0" width="100%">
								<tr>
								<td align=left>
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_bodytext" value="{$bodytext}">
								{$buttons}
								<input type="submit" id="bbookmark"  name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								{$reply_butfunc}
								<!--<input type="submit" id="breply"  name="karma_yesno" value="Reply">!-->
								</form>
								</td>
								<td align=right>
									{$karma}
								</td>
								</tr>
								</table>
								
							</p>
							</li>	
ADMIN_FORM;
						} else
						$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
									</a>
									{$result}
										<form  NAME="formular" action="{$this->synapse_dir}message.php?created=$crea" method="post">
											<button type="submit" style="border: 0; background: transparent">
												<img src="{$this->synapse_dir}themes/images/interface/sharebut.png" width="24" height="24" alt="submit" />
											</button>
										</form>
								</span>				

								<div class="comment-text">
									<p>{$under_title}</p>
									<p>{$bodytext}</p>
									<p>{$reply_func}</p>
									
								
								<table class="comment-buttons" border="0" width="100%">
								<tr>
								<td align=left>
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_bodytext" value="{$bodytext}">
								{$buttons}
								<input type="submit" id="bbookmark"  name="insertfavourite" value="Bookmark It">
								<input type="submit" id="brecycle" name="recyclebin" value="Recycle Bin">
								{$reply_butfunc}
								<!-- <input type="submit" id="breply"  name="karma_yesno" value="Reply"> !-->
								</form>
								</td>
								<td align=right>
									{$karma}
								</td>
								</tr>
								</table>
								
				
								</div>

								</div>
								</li>
MESSAGE_DISPLAY;
						// ** End BODY
					}
						$ig++;
						//if ($this->howmany_reply_messages($crea)!=0) $ig=$ig-$this->howmany_reply_messages($crea);
					}
					}
				break;
			}
			// ** End of SWITCH	
			
			// $ig++;
			
			$this->switch_data_table();
		}
		
		if ($this->preview_type==99) {
			$message_display .= <<<MESSAGE_DISPLAY
			</ul>
MESSAGE_DISPLAY;
		} else
		$message_display .= <<<MESSAGE_DISPLAY
			</ol>
MESSAGE_DISPLAY;
	} else {
		$message_display = <<<MESSAGE_DISPLAY
			<h2> This Page Is Under Construction </h2>
			<p>	
			No entries have been made on this page. 
			Please check back soon, or click the
			link below to add an entry!
			</p>
MESSAGE_DISPLAY;
			$title = "Welcome to {$this->synapse_title}!";
			$sendto = "##ALLUSERS##";
			$bodytext = "Welcome. {$this->synapse_title} is little social network with bloging support, where you can add your comments, or you can Find Your Friends and after share a messages all on one board. All you have to do is fill in the Registration Formular, and Login. Synapse, is free product with optional commercial support, and it is created for one site license. Please, dont post spams, or agresive words.";
			if ($this->synapse_crypt==1) {
				//inicializácia vnorenej-triedy
				//$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				//if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($myuser); //kľúč
				//$ktitle = $this->encrypt($title); // zasifruje lubovolny retazec
				//$kbody = $this->encrypt($bodytext); // zasifruje lubovolny retazec
				
				$kluc = "";
				if ( ( $this->getcreated($myuser) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					//inicializácia vnorenej-triedy
					//$crypt = new Crypt();
					$this->Mode = Crypt::MODE_HEX; // druh šifrovania
					$this->Key  = $this->synapse_password; //kľúč
					$kluc = $this->decrypt($this->getpassword($myuser)); // desifruje lubovolny zasifrovany retazec
				}
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if ( ( $this->getcreated($myuser) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					$this->Key  = $kluc; //kľúč
				} else {
					if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($myuser); //kľúč
				}
	
				$ktitle = $this->encrypt($title); // zasifruje lubovolny retazec
				$kbody = $this->encrypt($bodytext); // zasifruje lubovolny retazec
			}
			$created = time();
			$this->switch_data_table();
			$sql = "INSERT INTO data VALUES('$ktitle','$kbody','$myuser','$sendto','$created')";
			mysql_query($sql);
    }

  echo($message_display);
  echo($this->display_messages_form($ig, $numbers, ""));
  
  // new information about new messages
  if ($newmessages>0) {
	$this->switch_buffer_table();
	$created = time();
	$askmsg="You have " . $newmessages . " not readed new messages..";
	$sql = "INSERT INTO buffer VALUES('##SYSMESSAGE##','$myuser','$askmsg','#','#','$created')";
	$r = mysql_query($sql);
  }
  // update lasttime
  $this->switch_users_table();
  $curtime = time();
  $q = "UPDATE users SET Lasttime='$curtime' WHERE Username = '$myuser'";
  $r = mysql_query($q);
}

/* @info  global function for display messages, core of synapse-cms */
// Recycle Bin = brecycle = Red
// Bookmark It = bbookmark = Blue
// Delete = bdelete = Green
// Share = bshare = Black
// Pin = bpin = Yellow
// Reply = breply = 
public function display_messages_orig() {

	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
	$this->display_notifications();
	
	$_SESSION['infotext'] = "Your Messages";
	
	if ($this->themecity==1) {
		$this->switch_buffer_table();	
		$q = mysql_query("SELECT Work FROM buffer WHERE UsernameOne='##CHANGEWALLPAPER##' AND UsernameTwo='$myuser'");	
		$a = mysql_fetch_assoc($q);
		$workinf = $a['Work'];
		if ($workinf) {
				$_SESSION['bodycss']=$myuser."/".$workinf;
				//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
		}
	}
	
	$newmessages=0;
	
	if ($this->isvisible($myuser)==0) $message_display = $this->display_header(); else $message_display = "";
	
	//$message_display .= "<p style=\"float: right;\"><b>Messages from All Friends</b></p>";
	
	$this->switch_data_table();
	
	if ( (isset($_GET['timeline1']))&&(isset($_GET['timeline2'])) ) {		
		$tm1=mysql_real_escape_string($_GET['timeline1']);	// 1-11-2012
		$tm2=mysql_real_escape_string($_GET['timeline2']);	// 30-11-2012
		
		
		$ts1 = strtotime($tm1);
		$ts2 = strtotime($tm2);
		
		//var_dump($tm1);
		//var_dump($tm2);
		
		//$format="%d/%m/%Y %H:%M:%S";
		//$strf=strftime($format);
		//echo("$strf");
		//$ts = strptime($tm1, $format);
		//$ts1 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts1);
		//$ts = strptime($tm2, $format);
		//$ts2 = mktime($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
		//var_dump($ts2);
		
		$q = "SELECT * FROM data WHERE created<$ts2 ORDER BY created DESC LIMIT 2048";
	} else $q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
	
    $r = mysql_query($q);
	
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		
		//
		// Display type of Preview
		//
		$message_display .= <<<MESSAGE_DISPLAY
		    <br /><br />
MESSAGE_DISPLAY;

		if ($this->preview_type==0) {
			$message_display .= "<ul class=\"messages\">";
			$numbers=$this->lines;
		} else if ($this->preview_type==1) {
			$numbers=$this->lines;
		} else if ($this->preview_type==2) {
			$numbers=$this->lines;
		} else if ($this->preview_type==3) {
			$numbers=$this->lines;
			$message_display .= <<<MESSAGE_DISPLAY
<style>
.commentlist li {
    padding: 0px;
        padding-top: 0px;
        padding-right-value: 0px;
        padding-bottom: 0px;
        padding-left-value: 0px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
}
.commentlist {
    list-style: none outside none;
        list-style-type: none;
        list-style-image: none;
        list-style-position: outside;
}
.commentlist li > div {
    border: 1px solid rgb(221, 221, 221);
        border-top-width: 1px;
        border-right-width-value: 1px;
        border-right-width-ltr-source: physical;
        border-right-width-rtl-source: physical;
        border-bottom-width: 1px;
        border-left-width-value: 1px;
        border-left-width-ltr-source: physical;
        border-left-width-rtl-source: physical;
        border-top-style: solid;
        border-right-style-value: solid;
        border-right-style-ltr-source: physical;
        border-right-style-rtl-source: physical;
        border-bottom-style: solid;
        border-left-style-value: solid;
        border-left-style-ltr-source: physical;
        border-left-style-rtl-source: physical;
        border-top-color: rgb(221, 221, 221);
        border-right-color-value: rgb(221, 221, 221);
        border-right-color-ltr-source: physical;
        border-right-color-rtl-source: physical;
        border-bottom-color: rgb(221, 221, 221);
        border-left-color-value: rgb(221, 221, 221);
        border-left-color-ltr-source: physical;
        border-left-color-rtl-source: physical;
        -moz-border-top-colors: none;
        -moz-border-right-colors: none;
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        border-image-source: none;
        border-image-slice: 100% 100% 100% 100%;
        border-image-width: 1 1 1 1;
        border-image-outset: 0 0 0 0;
        border-image-repeat: stretch stretch;
    background: none repeat scroll 0% 0% rgb(252, 252, 252);
        background-color: rgb(252, 252, 252);
        background-image: none;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: 0% 0%;
        background-clip: border-box;
        background-origin: padding-box;
        background-size: auto auto;
    padding: 20px 20px 3px;
        padding-top: 20px;
        padding-right-value: 20px;
        padding-bottom: 3px;
        padding-left-value: 20px;
        padding-left-ltr-source: physical;
        padding-left-rtl-source: physical;
        padding-right-ltr-source: physical;
        padding-right-rtl-source: physical;
    position: relative;
    margin-bottom: 20px;
    margin-left: 85px;
        margin-left-value: 85px;
        margin-left-ltr-source: physical;
        margin-left-rtl-source: physical;
    border-radius: 5px 5px 5px 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
}
.commentlist .avatar {
    position: absolute;
    top: 3px;
    left: -80px;
    border-radius: 50% 50% 50% 50%;
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    box-shadow: 0px 0px 0px 3px rgb(204, 204, 204);
}
.comment-reply-link {
    position: absolute;
    top: 60px;
    left: -80px;
    font-size: 13px;
    width: 50px;
    text-align: center;
    color: rgb(204, 204, 204);
}
.comment-author {
    font-weight: bold;
    font-size: 16px;
}
.comment-date-link {
    position: absolute;
    top: 5px;
    right: 10px;
    font-size: 11px;
    line-height: 13px;
    text-align: right;
}
.comment-text {
}
</style>
<ol class="commentlist">
MESSAGE_DISPLAY;
		} else {
			if ($this->isvisible($myuser)==0) $message_display .= "<!-- css3 accordion --><div class=\"accordion-container\"><div class=\"results\"><div>Order by  <a href=\"#\"> relevance </a> |  <a href=\"#\"> date </a> |  <a href=\"#\"> replies </a> |  <b> users </b></div></div><!--accordion--><ul><li class=\"block_header\">Messages by You and Your Friends</li>";
				else $message_display .= "<!-- css3 accordion --><div class=\"accordion-container\"><!--accordion--><ul><li class=\"block_header\">Public Messages. My Information Channel.</li>";
			$numbers=$this->lines_vert;
		}
		
		$ig=1;
	
		while ( $a = mysql_fetch_assoc($r) ) {
			$title = stripslashes($a['title']);
			
			// bodytext
			$bodytext = $a['bodytext']; 
			
			// others
			$user = stripslashes($a['username']);
			$sto = stripslashes($a['sendto']);
			$crea = stripslashes($a['created']);

			// more then X (433) chars?
			$bodytext = $this->get_bodytext($bodytext, $crea, $user);
			$title = $this->get_titletext($title, $crea, $user);
			
			if ($this->striptags==1) $bodytext = strip_tags($bodytext); 
			$bodytext = $this->spracuj_form($bodytext);
			
			$datum = StrFTime("%d/%m/%Y %H:%M:%S", $crea);

			$date = StrFTime("%Y-%m-%d %H:%M", $crea);   // "2009-03-04 17:45";
			$result = $this->nicetime($date); // 2 days ago 			
			
			// secure message ?
			$test=0;
			if (!empty($_POST['insertcode'])) if ($_POST['insertcode']=="Insert Code") if ($crea==$_POST['insertcode_index']) if ($this->issecure($_POST['insertcode_user'], $_POST['insertcode_search'])==1) $test=1;
						
			if ( ($sto=="##SECURE##")&&($test==0) ) {
							$bodytext = <<<ADMIN_FORM
								<big><b>This is Private Channel and for view content of this message you must enter a private code:</b></big>
								<form method="post" action="" >
								<input type="hidden" name="insertcode_user" value="{$user}">
								<input type="hidden" name="insertcode_index" value="{$crea}">
								<table>
								<tr><td><label for="meno"></label></td><td>&nbsp;<input type="text" style="width: 128px;" name="insertcode_search"></td><td><input type="submit" style="background: #F9F9F9;" name="insertcode" value="Insert Code"></td></tr>
								</table>
								</form>	
ADMIN_FORM;
			}
		
			// preview for all userd
			$vypa=$_SESSION['pageid']*$numbers; 
			$vypb=$vypa-$numbers;
			//echo ("$vypocet . ");
			//if ( ($id > $vypb) && ($id <= $vypa ) ) {
			if ($sto == "##SYSMESSAGE##") {
			} else 
			if ( ($sto == "##ALLUSERS##")||($sto == "##SHOP##") ) {
				if ($this->isadmin($myuser)==1) {
					$deletebtn = <<<MESS_DISPLAY
										<input type="submit" id="bdelete" name="karma_yesno" value="Delete Message">
MESS_DISPLAY;
				} else $deletebtn = "";
				
				if ( ($this->isadmin($myuser)==1) && ($this->recyclecity==1) ) {
					$recyclebtn = <<<MESS_DISPLAY
						<input type="submit" id="brecycle" name="recyclebin" value="Recycle Bin">
MESS_DISPLAY;
				} else $recyclebtn = "";
				
				if ($user != $myuser) $sharebtn = "<input type=\"submit\" name=\"karma_yesno\" value=\"Share\">";
				// ak je uzivatel admin alebo ak je informacny kanal tak zobraz od neho ALLUSERS spravicky, 
				// ak nesplnuje tuto podmienku tak sa spravicky s priznakom ALLUSERS nezobrazia, aj ked sa jedna o topovanu spravicku na hlavnu stranku
				/*if ( ($this->isadmin($user)==2)&&($myuser!=$user) ) {
					$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<h2>$title</h2>
								<i>
								<span style="color:gray">Posted by <a href="index.php?preview={$user}">{$user}</a> as Public at ${result} with <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a></span>
								<hr>
								</i>
								<p><div id="alt">
								<br>
								<big><b>Message with hidden body:</b></big>
								<form method="post" action="index.php?user={$user}" >
								<table>
								<tr><td><label for="meno"></label></td><td>&nbsp;<input type="text" style="width: 240px;" id="search" name="search"></td><td><input type="submit" style="background: #F9F9F9;" name="insertcodeBtn" value="Insert Code"></td></tr>
								</table>	
								</form>
								</div></p>
MESSAGE_DISPLAY;
				} else
				*/
				if ( ($this->ismyfriend($user)==1)  || ($this->isadmin($user)==1)|| ($myuser==$user) ) { 
					// new messages?
					if ( ($this->lasttime_test($crea)==1) && ( $myuser != $user ) ) $newmessages++;
					// display messages
					if (($ig>$vypb)&&($ig<$vypa)) {
						
						// getavatar
						$avat = $this->getimgavatar($user); 
						
						if ($this->preview_type==0) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<h2>$title</h2>
								<i>
								<span style="color:gray">Posted by <a href="index.php?preview={$user}">{$user}</a> as Public at ${result} with <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a></span>
								<hr>
								</i>
								<p><div id="alt">$bodytext</div></p>
								
								<form NAME="formular" action="index.php" method="post" onsubmit="">
									<input type="hidden" name="karma_index" value="{$crea}">
									<input type="hidden" name="karma_title" value="{$title}">
									<input type="hidden" name="karma_bodytext" value="{$bodytext}">
MESSAGE_DISPLAY;
							/***
							$mdn= $this->synapse_path."plugins/";
							$message_display .= $mdn;
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
										$plug = $mdn."/".$dirArray[$index]."/stage_message.txt";
										if (file_exists($plug)) {
											$fl = fopen($plug,"r");
											while (!feof($fl)) {
												fgets($fl, $text);
												$message_display .= $text;
											}
											fclose($fl);
										}							
									}
								}
							}
							***/
							if ($this->isvisible($myuser)==0) {
	    							
								if ($sto == "##SHOP##") $message_display .= "<div style=\"float: right;\"><input type=\"submit\" name=\"karma_yesno\" value=\"Buy It\"></div>";
							}
							$message_display .= "<div style=\"float: right;\">{$deletebtn}{$sharebtn}</div></form></li>";

						} else if ($this->preview_type==1) {
							$message_display .= <<<MESSAGE_DISPLAY
								<div class="tweet"> 
								<img class="avatar" src="{$avat}" alt="twitter"> 
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
								<span>Public written by <a href="index.php?preview={$user}">{$user}</a>, ${datum} | <a href="{$this->synapse_dir}message.php?created=$crea">Link to Message</a> </span> 
								</div>
								</div>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==2) {
							$message_display .= <<<MESSAGE_DISPLAY
								<pre class="msg-users">
									<h2>$title</h2>
									<p><i>Public written by $user</i></p>
									<p>$bodytext</p>
								<p>	
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="submit" id="bbookmark" name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								<input type="submit" id="breply"  name="karma_yesno" value="Reply">
								{$deletebtn}
								{$sharebtn}
								</td>
								</tr>
								</table>
								</form>
								</p>
								</pre>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==3) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link">
									<a href="">
									</a>
										{$result}
										<form  NAME="formular" action="{$this->synapse_dir}message.php?created=$crea" method="post">
											<button type="submit" style="border: 0; background: transparent">
												<img src="{$this->synapse_dir}themes/images/interface/sharebut.png" width="24" height="24" alt="submit" />
											</button>
										</form>
								</span>				

								<div class="comment-text">
									<p><br></p>
									<p>{$bodytext}</p>
									
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="submit" id="bbookmark"  name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								<input type="submit" id="breply"  name="karma_yesno" value="Reply">
								{$deletebtn}
								{$sharebtn}
								</td>
								</tr>
								</table>
								</form>
				
								</div>

								</div>
								</li>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==4) {
							$message_display .= <<<MESSAGE_DISPLAY
								<article id="post-{$ig}" class="post-{$ig} post type-post status-publish format-standard hentry">
									<header class="entry-header">
										<h1 class="entry-title">
											<a href="" title="{$title}" rel="bookmark">{$title}</a>
										</h1>
									</header> 
									<div class="entry-content">
										<span class="Apple-style-span" style="border-collapse: separate;border-spacing: 0px;font-family: Helvetica">{$bodytext}</span> 
									</div> 
									<footer class="entry-meta">
										This entry was posted in Uncategorized on <a href="{$this->synapse_dir}message.php?created=$crea" title="{$datum}" rel="bookmark"><time class="entry-date" datetime="{$datum}">{$datum}</time></a><span class="by-author"> by <span class="author vcard"><a class="url fn n" href="" title="View all posts by ${user}" rel="author">{$user}</a></span></span>. 
									</footer> 
								</article> 
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="block" id="block_{$ig}"><a class="header" href="#block_{$ig}">$title</a><div class="arrow"></div>
								<div>
								<table border="0" width="100%">
								<tr>4
								<td>
								<p><img src="$avat"  width=48px; height=48px; style="margin-top:0px;border:0;" alt="avatar" /> <br></p>
								</td>
								<td>
								<p><span style="color:black">Public written by <a href="blog.php?user={$user}">$user</a>, {$datum}</span>
MESSAGE_DISPLAY;
							$replies = $this->howmany_reply_messages($crea);
							$message_display .= <<<MESSAGE_DISPLAY
								<a href="{$this->synapse_dir}message.php?created=$crea" style="margin-left: 11px;">Link to Message</a> , {$replies} Replies</p>
								<p>{$bodytext}</p>
								</td>
								</tr>
								</table>
								
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<table border="0" width="100%">
								<tr>
								<td align=left>
								</td>
								<td align=right>
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="submit"  id="bbookmark" name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								<input type="submit"  id="breply"  name="karma_yesno" value="Reply">
								{$deletebtn}
								{$sharebtn}
								</td>
								</tr>
								</table>
								</form>
								</div>
								</li>
MESSAGE_DISPLAY;
						}
					}
					$ig++;
				}
			} else if ($this->isvisible($myuser)==0) {  
				// {SK} Informacny vidi len svoje spravicky, ostatne nie
				// preview messagef for : All Friends, Post Private, Get Private  
				// jedna sa o moju spravicku, alebo jedna sa  o mojho priatelove spravicky, 
				if (!is_numeric ( $sto ))
				if  ( ( $myuser == $user ) ||  ( ($this->ismyfriend($user)==1) && ($sto == "##ALLFRIENDS##") ) 
										   ||  ( ($this->ismyfriend($user)==1) && ($sto == "##SHARED##") ) 
										   ||  ( ($this->ismyfriend($user)==1) && ($sto == "##SECURE##") )  
										   || ( ($this->ismyfriend($user)==1) && ($sto == $myuser) ) ) {
					// lasttime notification test
					if ( ($this->lasttime_test($crea)==1) && ( $myuser != $user ) ) $newmessages++;
					// display messages with page count
					if (($ig>$vypb)&&($ig<$vypa)) {
						
						// get avatar name
						/// $avat = $this->getimgavatar($user); 
						if ($sto == $myuser) { $avat = $this->getimgavatar($user); } else if ( ($sto == "##ALLFRIENDS##")||($sto == "##SHARED##")||($sto == "##SECURE##") ) { $avat = $this->getimgavatar($user); } else { $avat = $this->getimgavatar($user); }
						
						// delete button is enabled? when Replies=0					
						if ( ($this->delecity==1)&&($this->howmany_reply_messages($crea)==0) && ($myuser==$user) ) {
							$deletebtn = <<<MESS_DISPLAY
										<input type="submit" id="bdelete"  name="karma_yesno" value="Delete Message">
MESS_DISPLAY;
							} else $deletebtn = "";
						
						// delete button is enabled? when Replies=0					
						if ( ($this->recyclecity==1) && ($myuser==$user) ) {
							$recyclebtn = <<<MESS_DISPLAY
												<input type="submit" id="brecycle"  name="recyclebin" value="Recycle Bin">
MESS_DISPLAY;
							} else $recyclebtn = "";
						
						// fill SELECT with user friends, who are not my friend (i do not have it in my contact list)
						if ($myuser != $user) $friends=$this->display_friend_friends_option($user); else $friends=$result; 

						// if reply messages fill array and put to screen
						$reply_func = $this->display_reply_messages_inside($crea);
						
						if ($this->preview_type==0) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="messages">
								<table border="0" width="100%">
								<tr>
								<td align=left><h2>$title</h2></td>
								<td align=right>$friends</td>
								</tr>
								<table border="0" width="100%">
								<tr>
								<td align=left>
								<p>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==1) { 
							$message_display .= <<<MESSAGE_DISPLAY
								<div class="tweet"> 
								<img class="avatar" src="$avat" alt="twitter"> 
								<img class="bubble" src="{$this->synapse_dir}themes/images/interface/speech_bubble.png" alt="bubble">
								<div class="text" style="width: 85%;"> {$title} <br><div style="font-weight: normal">{$bodytext}</div><br>
MESSAGE_DISPLAY;
						} else if ($this->preview_type==2) {
						} else if ($this->preview_type==3) {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="comment even thread-even depth-1" id="comment-{$ig}">
								<div>
								<img alt="" src="{$avat}" class="avatar avatar-50 photo" height="50" width="50">
								<a class="comment-reply-link" href="index.php?preview={$user}">{$user}</a>
								
								<span class="comment-author">
									{$title}
								</span>
		
								<span class="comment-date-link"
										{$result}
										<form  NAME="formular" action="{$this->synapse_dir}message.php?created=$crea" method="post">
											<button type="submit" style="border: 0; background: transparent">
												<img src="{$this->synapse_dir}themes/images/interface/sharebut.png" width="24" height="24" alt="submit" />
											</button>
										</form>
								</span>				

								<div class="comment-text">
								<table><tr><td>
									
MESSAGE_DISPLAY;
							/*
							 * <p>{$bodytext}</p>	{$result}		
							 * </div>
							 */
						} else if ($this->preview_type==4) {
							$message_display .= <<<MESSAGE_DISPLAY
								<article id="post-{$ig}" class="post-{$ig} post type-post status-publish format-standard hentry">
									<header class="entry-header">
										<h1 class="entry-title">
											<a href="" title="{$title}" rel="bookmark">{$title}</a>
										</h1>
									</header> 
									<div class="entry-content">
										<span class="Apple-style-span" style="border-collapse: separate;border-spacing: 0px;font-family: Helvetica">
MESSAGE_DISPLAY;
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<li class="block" id="block_{$ig}"><a class="header" href="#block_{$ig}">$title</a><div class="arrow"></div>
								<div>
								<p>
								<table border="0" width="100%">
								<tr>
								<td align=left>
								<p><img src="$avat"  width=48px; height=48px; style="margin-top:0px;border:0;" alt="avatar" /></p>
								</td>
								<td>
								<p>
MESSAGE_DISPLAY;
						}
	
						
						$prevbl="blog.php?user={$user}";
						//$prevbl="index.php?preview={$user}";
						
						// again test for myuser?
						if ($sto == $myuser) {
							if ($this->preview_type==2) $message_display .="<pre class=\"msg-private\">".$title."<br>";
							$message_display .= <<<MESSAGE_DISPLAY
								<span style="color:red">Posted by <a href="{$prevbl}">$user</a> as Private at {$result}</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##ALLFRIENDS##") {
							if ($this->preview_type==2) $message_display .="<pre class=\"msg-friends\">".$title."<br>";
							$message_display .= <<<MESSAGE_DISPLAY
								<span style="color:black">Posted by <a href="{$prevbl}">$user</a> for all friends at {$result}</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##SHARED##") {
							if ($this->preview_type==2) $message_display .="<pre class=\"msg-friends\">".$title."<br>";
							$message_display .= <<<MESSAGE_DISPLAY
								<span style="color:blue">Shared by <a href="{$prevbl}">$user</a> for all friends by ---- at {$result}</span>
MESSAGE_DISPLAY;
						} else if ($sto == "##SECURE##") {
							if ($this->preview_type==2) $message_display .="<pre class=\"msg-friends\">".$title."<br>";
							$message_display .= <<<MESSAGE_DISPLAY
								<span style="color:red">Secure with required password by <a href="{$prevbl}">$user</a> for all friends at {$result}</span>
MESSAGE_DISPLAY;
						} else {
							if ($this->preview_type==2) $message_display .="<pre class=\"msg-private\">".$title."<br>";
							$message_display .= <<<MESSAGE_DISPLAY
								<span style="color:red">I post to {$sto} at {$result}</span>
MESSAGE_DISPLAY;
						}
									
						// Display Bodytext and reply messages
						$replies = $this->howmany_reply_messages($crea);
						if ($this->preview_type!=1) {
							$message_display .= <<<MESSAGE_DISPLAY
								with {$replies} Replies</i></p>							
MESSAGE_DISPLAY;

							//if ($this->preview_type==0) $message_display .= "<p><div id=\"alt\">{$bodytext}</div></p><p>{$reply_func}</p></td></tr></table>"; else
								 $message_display .= "<p><br></p> <p><div id=\"alt\">{$bodytext}</div></p><p>{$reply_func}</p></td></tr></table>";
						}

						if ($this->karma_health($crea)==1) {
								$heart = <<<MESSAGE_DISPLAY
									<img class="bubble" src="{$this->synapse_dir}themes/images/interface/star.gif" alt="karma_heart" title="{$this->karma_health_likes($crea)} likes">
MESSAGE_DISPLAY;
						} else $heart = "";

						// begin of Karma Code Widget
						$this->switch_karma_table();
						$km = mysql_query("SELECT yesno FROM karma WHERE id='$crea' AND username='$myuser'");	
						$row = mysql_fetch_assoc($km);
						$akyesno = $row["yesno"];
							
						if ($akyesno) {
							if (strpos($akyesno,"Yes")!==false) {
								$message_display .= <<<MESSAGE_DISPLAY
									<table border="0" width="100%">
									<tr>
									<td align=left>
									<img src="{$this->synapse_dir}themes/images/interface/plus.gif"> $heart
									</td>
									<td align=right>
									<form NAME="formular" action="index.php" method="post" onsubmit="">
MESSAGE_DISPLAY;
								// only visible buttons for administrators
								if ($this->isadmin($myuser)==1) {
									$message_display .= <<<MESSAGE_DISPLAY
										<input type="submit"  id="bdelete" name="karma_yesno" value="Delete Message">
										<input type="submit"  id="bpin" name="karma_yesno" value="Pin to Homepage">
MESSAGE_DISPLAY;
								} else if ( $myuser == $user ) {
									// for login user messages and not admin
									$message_display .= <<<MESSAGE_DISPLAY
										{$deletebtn}
										<input type="submit"  id="bask" name="karma_yesno" value="Public Ask">
MESSAGE_DISPLAY;
								}
										
								if ($user != $myuser) $message_display .= "<input type=\"submit\"  id=\"bshare\" name=\"karma_yesno\" value=\"Share\">";
							
								$message_display .= <<<MESSAGE_DISPLAY
									<input type="hidden" name="karma_index" value="{$crea}">
									<input type="hidden" name="karma_user" value="{$user}">
									<input type="hidden" name="karma_title" value="{$title}">
									<input type="hidden" name="karma_bodytext" value="{$bodytext}">
									<input type="submit"  id="bbookmark" name="insertfavourite" value="Bookmark It">
									{$recyclebtn}
									<input type="submit"  id="breply" name="karma_yesno" value="Reply">
									</td>
									</tr>
									</table>
									</form>
MESSAGE_DISPLAY;
							} else if (strpos($akyesno,"No")!==false) {
								$message_display .= <<<MESSAGE_DISPLAY
									<table border="0" width="100%">
									<tr>
									<td align=left>
									<img src="{$this->synapse_dir}themes/images/interface/minus.gif"> $heart
									</td>
									<td align=right>
									{$friends}
									<form NAME="formular" action="index.php" method="post" onsubmit="">
MESSAGE_DISPLAY;

								// only visible buttons for administrators
								if ($this->isadmin($myuser)==1) {
									$message_display .= <<<MESSAGE_DISPLAY
										<input type="submit"  id="bdelete" name="karma_yesno" value="Delete Message">
										<input type="submit"  id="bpin" name="karma_yesno" value="Pin to Homepage">
MESSAGE_DISPLAY;
								} else if ( $myuser == $user ) {
									// for login user messages and not admin
									$message_display .= <<<MESSAGE_DISPLAY
										{$deletebtn}
										<input type="submit"  id="bask" name="karma_yesno" value="Public Ask">
MESSAGE_DISPLAY;
								}
										
								if ($user != $myuser) $message_display .= "<input type=\"submit\"  id=\"bshare\" name=\"karma_yesno\" value=\"Share\">";
										
								$message_display .= <<<MESSAGE_DISPLAY
									<input type="hidden" name="karma_index" value="{$crea}">
									<input type="hidden" name="karma_title" value="{$title}">
									<input type="hidden" name="karma_user" value="{$user}">
									<input type="hidden" name="karma_bodytext" value="{$bodytext}">
									<input type="submit"  id="bbookmark" name="insertfavourite" value="Bookmark It">
									{$recyclebtn}
									<input type="submit"  id="breply" name="karma_yesno" value="Reply">
									</td>
									</tr>
									</table>
									</form>
MESSAGE_DISPLAY;
							}			
						} else {
							$message_display .= <<<MESSAGE_DISPLAY
								<table border="0" width="100%">
								<tr>
								<td align=left>
								<form NAME="formular" action="index.php" method="post" onsubmit="">
								<input type="hidden" name="karma_index" value="{$crea}">
								<input type="hidden" name="karma_title" value="{$title}">
								<input type="hidden" name="karma_bodytext" value="{$bodytext}">
MESSAGE_DISPLAY;
							//// <input type="submit" class="buttonyes" name="karma_yesno" value="Yes" tabindex="104" title="Yes, I Like It" accesskey="y" />
							//// <input type="submit" class="buttonno" name="karma_yesno" value="No" tabindex="104" title="No, I Dont Like It" accesskey="n" />
								
							$message_display .= <<<MESSAGE_DISPLAY
								<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="Yes">
									<img src="{$this->synapse_dir}themes/images/interface/vote_up.png" alt="submit" />
								</button> Yes 
								<button type="submit" style="border: 0; background: transparent" name="karma_yesno" value="No">
									<img src="{$this->synapse_dir}themes/images/interface/vote_down.png" alt="submit" />
								</button> No 
								</form>
								</td>
								<td align=right>
								{$friends}
								<form NAME="formular" action="index.php" method="post" onsubmit="">
MESSAGE_DISPLAY;

							if ($this->isadmin($myuser)==1) {
								$message_display .= <<<MESSAGE_DISPLAY
									<input type="submit"  id="bdelete" name="karma_yesno" value="Delete Message">
									<input type="submit"  id="bpin" name="karma_yesno" value="Pin to Homepage">
MESSAGE_DISPLAY;
							} else if ( $myuser == $user ) {
									// for login user messages and not admin
									$message_display .= <<<MESSAGE_DISPLAY
										{$deletebtn}
										<input type="hidden" name="asked_work" value="##PUBLICMESSAGE##">
										<input type="hidden" name="asked_message" value="$crea">
										<input type="submit"  id="bask" name="karma_yesno" value="Public Ask">
MESSAGE_DISPLAY;
							}
							
							if ($user != $myuser) $message_display .= "<input type=\"submit\" name=\"karma_yesno\" value=\"Share\">";
			
							$message_display .= <<<MESSAGE_DISPLAY
								<input type="hidden" name="karma_user" value="{$user}">
								<input type="submit"  id="bbookmark" name="insertfavourite" value="Bookmark It">
								{$recyclebtn}
								<input type="submit"  id="breply" name="karma_yesno" value="Reply">
								</form>
								</td>
								</tr>
								</table>
MESSAGE_DISPLAY;
						}

						if ($this->preview_type==0) {
							$message_display .= "</li>"; //</a>
						} else 
						if ($this->preview_type==1) {
							$message_display .= "</div></div>";
						} else
						if ($this->preview_type==2) {
							$message_display .="</pre><br>";
						} else 
						if ($this->preview_type==3) {
							//$reply_func = $this->display_reply_messages_inside($crea);
							$message_display .= <<<MESSAGE_DISPLAY
								</div>
								</div>
								</li>
MESSAGE_DISPLAY;
						} else 
						if ($this->preview_type==4) {
								$message_display .= <<<DISPLAY_MESSAGE
									</span> 
									</div> 
									<footer class="entry-meta">
										This entry was posted in Uncategorized on <a href="{$this->synapse_dir}message.php?created=$crea" title="{$datum}" rel="bookmark"><time class="entry-date" datetime="{$datum}">{$datum}</time></a><span class="by-author"> by <span class="author vcard"><a class="url fn n" href="" title="View all posts by ${user}" rel="author">{$user}</a></span></span>. 
									</footer> 
								</article> 
DISPLAY_MESSAGE;
						} else $message_display .= "</div></li>";
					}
					$ig++;
				}
			}
		$this->switch_data_table();
		}
		    if ($this->preview_type==2) $message_display .=""; else
			if ($this->preview_type==3) $message_display .="</ol>"; else
			if ($this->preview_type==4) $message_display .= ""; else
		    if ($this->preview_type!=1) {
			$message_display .= "</ul>";
			if ($this->preview_type!=0) $message_display .= "</div>";
		    }
	} else {
		$message_display = <<<MESSAGE_DISPLAY
			<h2> This Page Is Under Construction </h2>
			<p>	
			No entries have been made on this page. 
			Please check back soon, or click the
			link below to add an entry!
			</p>
MESSAGE_DISPLAY;
			$title = "Welcome to {$this->synapse_title}!";
			$sendto = "##ALLUSERS##";
			$bodytext = "Welcome. {$this->synapse_title} is little social network with bloging support, where you can add your comments, or you can Find Your Friends and after share a messages all on one board. All you have to do is fill in the Registration Formular, and Login. Synapse, is free product with optional commercial support, and it is created for one site license. Please, dont post spams, or agresive words.";
			$created = time();
			$this->switch_data_table();
			$sql = "INSERT INTO data VALUES('$title','$bodytext','$myuser','$sendto','$created')";
			mysql_query($sql);
    }

  echo($message_display);
  echo($this->display_messages_form($ig, $numbers, ""));
  
  // new information about new messages
  if ($newmessages>0) {
	$this->switch_buffer_table();
	$created = time();
	$askmsg="You have " . $newmessages . " not readed new messages..";
	$sql = "INSERT INTO buffer VALUES('##SYSMESSAGE##','$myuser','$askmsg','#','#','$created')";
	$r = mysql_query($sql);
  }
  // update lasttime
  $this->switch_users_table();
  $curtime = time();
  $q = "UPDATE users SET Lasttime='$curtime' WHERE Username = '$myuser'";
  $r = mysql_query($q);
}

public function userlasttime() {
	$this->switch_users_table();

	$lastinf = "";

	if ($_SESSION['loginuser']) {
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
		$q = mysql_query("SELECT Lasttime FROM users WHERE Username='$myuser'");	
		$a = mysql_fetch_assoc($q);
		$lastinf = $a['Lasttime'];
	}
	
	return $lastinf;
}

public function recent_comments($last) {
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);

$rets = <<< DISPLAY_MESSAGE
DISPLAY_MESSAGE;
	
	$this->switch_data_table();

	$q = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $r = mysql_query($q);
	$id=0;
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
		while ( $a = mysql_fetch_assoc($r) ) {
			$user = stripslashes($a['Username']);
			$title = stripslashes($a['Title']);
			$crea = stripslashes($a['Created']);
			
			if ($crea>=$last) {
			$rets .= <<< DISPLAY_MESSAGE
					{$title}<br>
DISPLAY_MESSAGE;
			}

		}
	}
	return $rets;
}

/* @info share message */
public function share_data($p) {
	$this->switch_data_table();
	
	//var_dump($_POST);
	
    if ( $_POST['karma_title'] )
      $ktitle = mysql_real_escape_string($_POST['karma_title']);
    if ( $_POST['karma_bodytext'])
      $kbody = mysql_real_escape_string($_POST['karma_bodytext']);
	if ( $_POST['karma_index'])
      $kindex = mysql_real_escape_string($_POST['karma_index']);
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	//echo ("{$title} : {$bodytext} : {$user}<br>");
	 
	// $sendto="##ALLFRIENDS##";
	$sendto="##SHARED##";
	 
	if ( $ktitle && $kbody && $myuser && $kindex) {
			// crypt or decrypt
			if ($this->synapse_crypt==1) {
				$kluc = "";
				if ( ( $this->getcreated($myuser) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					//inicializácia vnorenej-triedy
					//$crypt = new Crypt();
					$this->Mode = Crypt::MODE_HEX; // druh šifrovania
					$this->Key  = $this->synapse_password; //kľúč
					$kluc = $this->decrypt($this->getpassword($myuser)); // desifruje lubovolny zasifrovany retazec
				}
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if ( ( $this->getcreated($myuser) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					$this->Key  = $kluc; //kľúč
				} else {
					if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($myuser); //kľúč
				}
	
				$ktitle = $this->encrypt($ktitle); // zasifruje lubovolny retazec
				$kbody = $this->encrypt($kbody); // zasifruje lubovolny retazec
				
				//inicializácia vnorenej-triedy
				//$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				//if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($myuser); //kľúč
				//$ktitle = $this->encrypt($ktitle); // zasifruje lubovolny retazec
				//$kbody = $this->encrypt($kbody); // zasifruje lubovolny retazec
			}
			$created = time();
			$sql = "INSERT INTO data VALUES('$ktitle','$kbody','$myuser','$sendto','$created')";
			mysql_query($sql);
			echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message Shared !!! Refresh Page</a></b></center></div></div>");
			return true;
	} else return false;
}
  
public function display_searchfriends() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
    $message_display = <<<MESSAGE_DISPLAY
		<br><br><br><br>
		<div class="messagepanel">
		<img src="themes/images/share-enjoy.png"><br><br>
		Here you can add registered users at Synapse to your Contact list. From all users, in your contact list you can see messages, but
		you can send private message for each user, or send to "All Friends". This option is set as default.<br><br>You can break friendship with your friend, only click to user in "Users in Your Contacts".<br><br>
		</div>
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">
		<table border="1" width="100%">


		<tr>
		<td align=left><div class="smallfont">Available Users (users not in your contact list)</div><br>
		<style tyle=text/css>
		input.red {background-color: #cc0000; font-weight: bold; font-size: 12px; color: white;}
		input.pink {background-color: #ffcccc;}
		textarea.violet {background-color: #ccccff; font-size: 10px;}
		option.red {background-color: #cc0000; font-weight: bold; font-size: 12px; color: white;}
		option.pink {background-color: #ffcccc;}
		</style>
		<SELECT NAME="searchtype">
		<option class="red" value= "##USERNAME##">Search by Username </option>
		<option class="pink" value= "##USERNAME-MANS##">- search in Mans</option>
		<option class="pink" value= "##USERNAME-WOMANS##">- search in Womans</option>
		<option class="red" value= "##EMAIL##">Search by Email</option> 
		<option class="pink" value= "##EMAIL-GMAIL##">- search in Gmail users</option>
		<option class="pink" value= "##EMAIL-HOTMAIL##">- search in Hotmail users</option>
		</SELECT>
		<input type="submit" name="searchfriends_but" value="Search">
		</td>
		</tr>
		<tr>
		<td><div class="smallfont">Users in Your Contacts. (from here you can break a friendship with your ex-friend)</div><br>
MESSAGE_DISPLAY;
	$this->switch_friends_table();
	$usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
			$message_display .= <<<MESSAGE_DISPLAY
			  <input type="submit" name="del_friend" value="$usry">
MESSAGE_DISPLAY;
			}
			if ($myuser==$usry) {
			$message_display .= <<<MESSAGE_DISPLAY
			  <input type="submit" name="del_friend" value="$usrx">
MESSAGE_DISPLAY;
			}
		}
	}
	$message_display .= <<<MESSAGE_DISPLAY
		</td>
		</tr>
		</table>
		</form>
		<br><br><br>
		<br><br>
MESSAGE_DISPLAY;

	return ($message_display);
}

/* @info  Find Friends function */
public function display_findfriends() {
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
    $message_display = <<<MESSAGE_DISPLAY
		<br><br><br><br>
		<div class="messagepanel">
		<img src="themes/images/share-enjoy.png"><br><br>
		Here you can add registered users at Synapse to your Contact list. From all users, in your contact list you can see messages, but
		you can send private message for each user, or send to "All Friends". This option is set as default.<br><br>You can break friendship with your friend, only click to user in "Users in Your Contacts".<br><br>
		</div>
		
		<br>
		<form name="searchForm" action="" method="get">
		<b>Search for someone by name: </b>
              <label for="first">First Name</label>
              <input type="text" style="width: 130px;" name="first" id="first" />
			  <label for="last">Last Name</label>
              <input type="text" style="width: 170px;" name="last" id="last" />
			  <input type="submit" name="search" value="Go"/>
		</form>
		<br>
		
		<table border="1" width="100%">
		<form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">
MESSAGE_DISPLAY;

	$usrfronta[1]="";
	
    // fill array with users in contact list
    $this->switch_friends_table();
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	$id=1;
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
				$usrfronta[$id]=$usry;
				$id++;
			}
			if ($myuser==$usry) {
				$usrfronta[$id]=$usrx;
				$id++;
			}
		}
	}
	

    // fill array with people who are not in database
    $this->switch_users_table();
    $notq = "SELECT * FROM users ORDER BY created DESC LIMIT 2048";
    $notr = mysql_query($notq);
	$id=1; $notfronta[1]="";
	if ( $notr !== false && mysql_num_rows($notr) > 0 ) {
		while ( $nota = mysql_fetch_assoc($notr) ) {
			$notx = stripslashes($nota['Username']);
			//$noty = stripslashes($nota['UsernameTwo']);
			if ($notx!=$myuser) {
				$test1=false;
				foreach ($usrfronta as $usr) {
					if ($notx==$usr) $test1=true;
				}
				if ($test1!=true) {
					$k=false;
					foreach ($notfronta as $prem) {
						if ($prem==$notx) $k=true;
					}
					if ($k==false) {
						$notfronta[$id]=$notx;
						$id++;
					}
				}
			}
		}
	}
	
		$message_display .= <<<MESSAGE_DISPLAY
				<tr>
				<td align=left><div class="smallfont">Information Channels (channels not in your contact list) - Direct Add</div><br>
MESSAGE_DISPLAY;
	
	
	foreach ($notfronta as $usr) {
		if ( (strlen($usr)>0) && ($this->isvisible($usr)==1) ) {
			$usrtit=$this->getinform($usr);
			$message_display .= <<<MESSAGE_DISPLAY
				<input type="submit" name="find_friend" value="$usr" title="$usrtit">
MESSAGE_DISPLAY;
		}
	}
	
	$message_display .= <<<MESSAGE_DISPLAY
				<br><br>
				</td>
				</tr>
				<tr>
				<td align=left><div class="smallfont">Available Users (users not in your contact list) - Ask for Friendship</div><br>
MESSAGE_DISPLAY;
	
	foreach ($notfronta as $usr) {
		if ( (strlen($usr)>0) && ($this->isvisible($usr)==0) ) {
			$usrtit=$this->getinform($usr);
			$message_display .= <<<MESSAGE_DISPLAY
				<input type="submit" name="asked_friend" value="$usr" title="$usrtit">
MESSAGE_DISPLAY;
		}
	}
	
	$message_display .= <<<MESSAGE_DISPLAY
		<input type="hidden" name="asked_work" value="##FRIENDSHIP##">
		</td>
		</tr>
		<tr>
		<td><div class="smallfont">Users in Your Contacts. (from here you can break a friendship with your ex-friend) - Remove User</div><br>
MESSAGE_DISPLAY;
	$this->switch_friends_table();
	$usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($myuser==$usrx) {
			$usrtit=$this->getinform($usry);
			$message_display .= <<<MESSAGE_DISPLAY
			  <input type="submit" name="del_friend" value="$usry" title="$usrtit">
MESSAGE_DISPLAY;
			}
			if ($myuser==$usry) {
			$usrtit=$this->getinform($usrx);
			$message_display .= <<<MESSAGE_DISPLAY
			  <input type="submit" name="del_friend" value="$usrx" title="$usrtit">
MESSAGE_DISPLAY;
			}
		}
	}
	$message_display .= <<<MESSAGE_DISPLAY
		</td>
		</tr>
		</form>
		</table>
		<br>
		<br>
		<br>
		<br>
MESSAGE_DISPLAY;

	return ($message_display);
}


function display_followers($name) {
	$this->switch_friends_table();
			
	if ($_SESSION['loginuser'])
		$myuser = mysql_real_escape_string($_SESSION['loginuser']);
		
	$entry_display = <<<MESSAGE_DISPLAY
					<!-- <form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post"> !-->
					<i><b>
MESSAGE_DISPLAY;
		
	/// FILL STRUCT WITH MY FRIENDS
	//BEGIN prejdi celu databazu FRIENDS po riadkoch a napln datamy objekt		
    $usrq = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
    $usrr = mysql_query($usrq);
	
	$id=1; $usrfronta[1]="";
    if ( $usrr !== false && mysql_num_rows($usrr) > 0 ) {
		while ( $usra = mysql_fetch_assoc($usrr) ) {
			$usrx = stripslashes($usra['UsernameOne']);
			$usry = stripslashes($usra['UsernameTwo']);
			if ($name==$usrx) {
							$usrinf=$this->getinform($usry);
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" style="border: 0; background: transparent;" name="asked_friend" value="$usry" title="{$usrinf}" tabindex="202"> |
MESSAGE_DISPLAY;

			} else
			if ($name==$usry) {
							$usrinf=$this->getinform($usrx);
							$entry_display .= <<<MESSAGE_DISPLAY
								<input type="submit" style="border: 0; background: transparent;" name="asked_friend" value="$usrx" title="{$usrinf}" tabindex="202"> |
MESSAGE_DISPLAY;
			}
		}
	}			
				$entry_display .= <<<MESSAGE_DISPLAY
					<!-- </form> !-->
					</i></b>
MESSAGE_DISPLAY;
			return ( $entry_display );
}

// Display all users with their short informations
// about avatar, info
public function users_management() {
	$this->switch_users_table();
	
	if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	
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
			
					if ($_SESSION['loginuser']) {
						if ($user==$myuser) {
							$friendsopt =  "";
						} else
						if ($this->ismyfriend($user)==1) { 
									$usrtit=$this->getinform($user);
									$friendsopt = <<<MESSAGE_DISPLAY
										<button type="submit" name="del_friend" value="$user" title="$usrtit">Break Friendship</button>
MESSAGE_DISPLAY;
						} else {
									$usrtit=$this->getinform($user);
									if ($this->isvisible($user)==0) {
										$friendsopt = <<<MESSAGE_DISPLAY
											<button type="submit" name="asked_friend" value="$user" title="$usrtit">Ask for Friendship</button>
MESSAGE_DISPLAY;
									} else {
										$friendsopt = <<<MESSAGE_DISPLAY
											<button type="submit" name="find_friend" value="$user" title="$usrtit">Add Channel</button>
MESSAGE_DISPLAY;
									}
						}
					} else $friendsopt =  "";
			
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
						<div style="float: left;"><span>Link to {$hyper} pressentation page.</span></div>
						<div style="float: right;"><form  NAME="formular" action="{$_SERVER['PHP_SELF']}" method="post">{$friendsopt}<input type="hidden" name="asked_work" value="##FRIENDSHIP##"></form></div> 
						<br>
						</div>
					
						</div>
						<br>
MESSAGE_FORM;
			
		}
	}
	return $entry_display;
}

public function delete_friend($p) {
		$this->switch_friends_table();
	
		if ( $_POST['del_friend'] )
			$myfriend = $_POST['del_friend']; 	
			
		if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
		if (( $myuser ) && ($myfriend)) {
				$q = "DELETE FROM friends WHERE UsernameOne = '$myuser' AND UsernameTwo = '$myfriend'";
				$r = mysql_query($q);
				$q = "DELETE FROM friends WHERE UsernameOne = '$myfriend' AND UsernameTwo = '$myuser'";
				$r = mysql_query($q);
				$message_display = <<<MESSAGE_DISPLAY
					<div class="hehe"><div class="smallfont"><center><b><a href="index.php">Break friendship with $myfriend !</a></b><br><br></center></div></div>
MESSAGE_DISPLAY;
				echo($message_display);
				// send message about break friendship
				$this->switch_data_table();
				$created = time();
				$title = "Broken friendship..";
				$bodytext = "Users <b>$myuser</b> and <b>$myfriend</b> are not friends..";
				$sendto = "##SYSMESSAGE##";
				$sql = "INSERT INTO data VALUES('$title','$bodytext','$myuser','$sendto','$created')";
				mysql_query($sql);
		}
}

public function write_friend($p) {
		$this->switch_friends_table();
	
		if ( $_POST['find_friend'] )
			$myfriend = $_POST['find_friend']; 
		else 
		if ( $_POST['insert_friend'] )
			$myfriend = $_POST['insert_friend']; 	
			
		if ($_SESSION['loginuser'])
			$myuser = mysql_real_escape_string($_SESSION['loginuser']);
			
		if (( $myuser ) && ($myfriend)) {
				$q = "SELECT * FROM friends ORDER BY created DESC LIMIT 2048";
				$r = mysql_query($q);
				//$id=1;
				if ( $r !== false && mysql_num_rows($r) > 0 ) {
					while ( $a = mysql_fetch_assoc($r) ) {
						$one = stripslashes($a['UsernameOne']);
						$two = stripslashes($a['UsernameTwo']);
						if ( (($one==$myuser)&&($two==$myfriend)) || (($two==$myuser)&&($one==$myfriend)) ) return null;
					}
					$message_display = <<<MESSAGE_DISPLAY
					<div class="hehe"><div class="smallfont"><center><b><a href="index.php"><br>Your New Friend is $myfriend !</a></b><br><br></center></div></div>
MESSAGE_DISPLAY;
				} else {
$message_display = <<<MESSAGE_DISPLAY
					<div class="hehe"><div class="smallfont"><center><b><a href="index.php"><br>Refresh Page</a></b><br><br></center></div></div>
MESSAGE_DISPLAY;
				}
				echo($message_display);
				// send message about new friendship
				$this->switch_data_table();
				$created = time();
				$title = "New friends..";
				$bodytext = "New friendship between <b>$myuser</b> and <b>$myfriend</b> created..";
				$sendto = "##SYSMESSAGE##";
				$sql = "INSERT INTO data VALUES('$title','$bodytext','$myuser','$sendto','$created')";
				mysql_query($sql);
				// register user to contact list
				$this->switch_friends_table();
				$created = time();
				$sql = "INSERT INTO friends VALUES('$myuser','$myfriend','$created')";
				return mysql_query($sql);
		} else return null;
} 	
 
 public function switch_friends_table() {
	mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

    return $this->build_friends_db();
  }
  
  private function build_friends_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS friends (
UsernameOne	VARCHAR(150),
UsernameTwo	VARCHAR(150),
Created		VARCHAR(100)
)
MySQL_QUERY;

    return mysql_query($sql);
  }
  
  
 public function switch_data_table() {
    mysql_select_db($this->table) or die("Could not select database. " . mysql_error());
	
    return $this->build_data_db();
  }
  
 private function build_data_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS data (
title	    VARCHAR(150),
bodytext	    	TEXT,
username    VARCHAR(150),
sendto      VARCHAR(150),
created		INT(24)
)
MySQL_QUERY;
    return mysql_query($sql);
  }

  
  public function switch_karma_table() {
	mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

    return $this->build_karma_db();
  }

 private function build_karma_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS karma (
username    VARCHAR(150),
yesno       VARCHAR(150),
id			VARCHAR(100),
created		VARCHAR(100)
)
MySQL_QUERY;
    return mysql_query($sql);
  }
  
   public function switch_buffer_table() {
    mysql_select_db($this->table) or die("Could not select database. " . mysql_error());
	
    return $this->build_buffer_db();
  }
  
 private function build_buffer_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS buffer (
UsernameOne	VARCHAR(150),
UsernameTwo	VARCHAR(150),
Work		VARCHAR(150),
Password	VARCHAR(150),
Email		VARCHAR(150),
Created		VARCHAR(100)
)
MySQL_QUERY;
    return mysql_query($sql);
  }

/* @info  write favourites..message info.. */
public function write_favourites($p) {
	$this->switch_favourites_table();
	
	//var_dump($_POST);
	
	if ( $_POST['karma_user'] )
      $user = mysql_real_escape_string($_POST['karma_user']);
    if ( $_POST['karma_title'] )
      $title = mysql_real_escape_string($_POST['karma_title']);
    if ( $_POST['karma_index'])
      $crea = mysql_real_escape_string($_POST['karma_index']);
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	//echo ("{$title} : {$bodytext} : {$user}<br>");
	 
	if ( $title && $crea && $user) {
		$t1 = "<?";
		$t2 = "<script";
		//// test for BAD words
		if (strpos($bodytext,$t1)!==false) {
			return false;
		} else if (strpos($bodytext,$t2)!==false) {
			return false;
		} else {
			// crypt or decrypt
			if ($this->synapse_crypt==1) {
				$kluc = "";
				if ( ( $this->getcreated($user) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					//inicializácia vnorenej-triedy
					//$crypt = new Crypt();
					$this->Mode = Crypt::MODE_HEX; // druh šifrovania
					$this->Key  = $this->synapse_password; //kľúč
					$kluc = $this->decrypt($this->getpassword($user)); // desifruje lubovolny zasifrovany retazec
				}
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if ( ( $this->getcreated($user) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					$this->Key  = $kluc; //kľúč
				} else {
					if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($user); //kľúč
				}
	
				$title = $this->encrypt($title); // zasifruje lubovolny retazec
				//$bodytext = $this->encrypt($bodytext); // zasifruje lubovolny retazec
				
				//inicializácia vnorenej-triedy
				//$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				//if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($user); //kľúč
				//$title = $this->encrypt($title); // zasifruje lubovolny retazec
				//$kbody = $this->encrypt($kbody); // zasifruje lubovolny retazec
			}
			$created = time();
			$sql = "INSERT INTO favourites VALUES('$title','$crea','$myuser','$crea','$user','$created')";
			mysql_query($sql);
			return true;
		}
    } else {
      return false;
    }
  }

   public function switch_favourites_table() {
    mysql_select_db($this->table) or die("Could not select database. " . mysql_error());
	
    return $this->build_favourites_db();
  }
  
 private function build_favourites_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS favourites (
title	VARCHAR(150),
id		VARCHAR(150),
user		VARCHAR(150),
link		VARCHAR(150),
sendto		VARCHAR(150),
created		VARCHAR(100)
)
MySQL_QUERY;
    return mysql_query($sql);
  }
  
 /* @info share message */
public function write_recyclebin($p) {
	if ( $_POST['karma_user'] )
      $user = mysql_real_escape_string($_POST['karma_user']);
    if ( $_POST['karma_title'] )
      $ktitle = mysql_real_escape_string($_POST['karma_title']);
    if ( $_POST['karma_index'])
      $kindex = mysql_real_escape_string($_POST['karma_index']);
    if ( $_POST['karma_bodytext'])
      $kbody = mysql_real_escape_string($_POST['karma_bodytext']);
	if ($_SESSION['loginuser'])
      $myuser = mysql_real_escape_string($_SESSION['loginuser']);
	
	//echo ("{$title} : {$bodytext} : {$user}<br>");
	 
	// $sendto="##ALLFRIENDS##";
	$sendto="$myuser";
	 
	if ( $ktitle && $kbody && $myuser && $kindex && $user) {
			// crypt or decrypt
			if ($this->synapse_crypt==1) {
				$kluc = "";
				if ( ( $this->getcreated($myuser) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					//inicializácia vnorenej-triedy
					//$crypt = new Crypt();
					$this->Mode = Crypt::MODE_HEX; // druh šifrovania
					$this->Key  = $this->synapse_password; //kľúč
					$kluc = $this->decrypt($this->getpassword($myuser)); // desifruje lubovolny zasifrovany retazec
				}
				//inicializácia vnorenej-triedy
				//$crypt = new Crypt();
				$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				if ( ( $this->getcreated($myuser) >= $this->synapse_password_after ) && (isset($this->synapse_password_after)) )   {
					$this->Key  = $kluc; //kľúč
				} else {
					if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($myuser); //kľúč
				}
	
				$ktitle = $this->encrypt($ktitle); // zasifruje lubovolny retazec
				$kbody = $this->encrypt($kbody); // zasifruje lubovolny retazec
				
				//inicializácia vnorenej-triedy
				//$this->Mode = Crypt::MODE_HEX; // druh šifrovania
				//if (isset($this->synapse_crypt_pwd)) $this->Key  = $this->synapse_crypt_pwd; else $this->Key  = $this->getpassword($myuser); //kľúč
				//$ktitle = $this->encrypt($ktitle); // zasifruje lubovolny retazec
				//$kbody = $this->encrypt($kbody); // zasifruje lubovolny retazec
			}
			$this->switch_recyclebin_table();
			$created = time();
			$sql = "INSERT INTO recyclebin VALUES('$ktitle','$kbody','$user','$sendto','$kindex','$created')";
			mysql_query($sql);
			// delete message
			$this->switch_data_table();
			$q = "DELETE FROM data WHERE created = '$kindex'";
			$r = mysql_query($q);
		    echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message in Recyclebin !!! Refresh Page</a></b></center></div></div>");
			return true;
	} else return false;
}
  
 public function switch_recyclebin_table() {
    mysql_select_db($this->table) or die("Could not select database. " . mysql_error());
	
    return $this->build_recyclebin_db();
  }
  
 private function build_recyclebin_db() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS recyclebin (
title	    VARCHAR(150),
bodytext	    	TEXT,
username    VARCHAR(150),
sendto      VARCHAR(150),
lasttime    VARCHAR(150),
created		INT(24)
)
MySQL_QUERY;
    return mysql_query($sql);
  }
  
public function connect_db() {
    if ($this->error_output==0) { mysql_connect($this->host,$this->username,$this->password) or die( "Could not connect. " . mysql_error() ); } else
		{ mysql_connect($this->host,$this->username,$this->password) 
			or include("./synapse-cms/setup-config.php");
		    }
}
  
// END OF
  
}

?>
