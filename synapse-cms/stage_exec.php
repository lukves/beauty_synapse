<?php
	// set custom wallpaper
	if (isset($_SESSION['bodycss'])) {
		echo $display = <<<DISPLAY
			<style>
				body {background: transparent url(./bindata/files/{$_SESSION['loginuser']}/{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
			</style>
DISPLAY;
	}
	
	if (isset($_SESSION['viewpage'])) { } else $_SESSION['viewpage']=="##ALLFRIENDS##";
?>
<script>
//function reloadPage()
  //{
  //location.reload(false)
  //history.go(1);
  //location.reload(true);
  //}
  
  function reloadPage(){document.location = document.location}
</script>
<?php

/**
 * Synapse-CMS stage_run
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
 
 // $mdn= $obj->synapse_path."plugins/";
 
	// _POST
	if (!empty($_POST['usersettings_opt'])) { 
				$obj->update_usersettings($_POST);
	} else
	if (!empty($_POST['usersettingsbg_opt'])) { 
				$obj->update_usersettings($_POST);
	} else
	if (!empty($_POST['usersettings_info'])) { 
				$obj->update_usersettings($_POST);
	} else 
	if (!empty($_POST['preview'])) { 
				$_SESSION['pageid']=1;
				$_SESSION['viewpage']=$_POST['preview'];
				//$obj->display_friend_messages($_POST['preview']);
				$previewtest=1;
	} else
	if ($_POST['karma_yesno']=="Delete Message") { $test = $obj->delete_message($_POST); echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message Deleted!!! Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
	if ($_POST['karma_yesno']=="Pin to Homepage") { $test = $obj->pin_message($_POST); echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Pin Message to Homepage!!! Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
	if ($_POST['karma_yesno']=="Yes") { $test = $obj->write_karma($_POST); echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Thanks for -Yes- Vote. Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
	if ($_POST['karma_yesno']=="No") { $test = $obj->write_karma($_POST);  echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Thanks for -No- Vote. Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
	if ($_POST['karma_yesno']=="Reply") { echo($obj->display_reply_messages($_POST)); } else 
	if ($_POST['karma_yesno']=="Share") { $test = $obj->share_data($_POST); } else
	if ($_POST['karma_yesno']=="Public Ask") {  $obj->accept_question($_POST); } else
	if ($_POST['task']=="Register") { echo($obj->display_register()); } else
	if ($_POST['task']=="Login") { echo($obj->display_login()); } else
	if ($_POST['task']=="Logout") {
						$_SESSION['loginuser'] = null; 
						echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); 
						//echo($obj->display_zero()); 
	} else 
	if ($_POST['task']=="$") { 
					$_SESSION['viewpage']="##ALLFRIENDS##";
					//$obj->display_messages();
					$previewtest=1;
	} else 
	if ($_POST['task']=="Find Friends") {
					if ($obj->isvisible($_SESSION['loginuser'])==0) echo($obj->display_findfriends()); // else // findfriends | searchfriends
						//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Not for Presentation Account. Refresh Page</a></b></center></div></div>");
	} else 
	if ($_POST['task']=="Upload") {
					if ($_SESSION['loginuser']!=null) { $af=1; $obj->upload_myfile($af); }
	} else 
	if ($_POST['task']=="Settings") {
					//$obj->settings_interface();
					//$obj->admin_interface();
	} else
	if ($_POST['task']=="Create Database Dump") { 
					// create backup of table with new user
					$obj->backup_tables($obj->host,$obj->username,$obj->password,'users');
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Dump Created. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
	} else
	if (!empty($_POST['login_username'])) {
						$_SESSION['viewpage']="";
						$_SESSION['loginuser']= $obj->write_login($_POST); 
	} else
	if (!empty($_POST['reg_username'])) { 
						if (!empty($_REQUEST['captcha'])) {
							if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
								$captcha_message = "Invalid captcha";
								$style = "background-color: #FF606C";
							} else {
								$captcha_message = "Valid captcha";
								$style = "background-color: #CCFF99";
								// REGISTER NEW USER
								//Ask for Register Channel, or classic registration?
								if ($_POST['register_button']=="Ask for Register Channel") $obj->accept_question($_POST); else $obj->write_registration($_POST);
							}
							$request_captcha = htmlspecialchars($_REQUEST['captcha']);
								echo <<<HTML
								        <div id="result" style="$style">
											<h2>$captcha_message</h2>
										</div>
HTML;
							unset($_SESSION['captcha']);
						}
	} else 
	if (!empty($_POST['msg_title'])) {
				$test = $obj->write_data($_POST); 
				if ($_POST['reply_btn']=="Create Reply Message") { echo($obj->display_reply_messages($_POST)); } else
				if ($_POST['reply_btn']=="Reply Message") { 
						// do nothing only reload page
						if ($test==true) echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
						else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message Error.. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
			    } else {
					if ($test==true) echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
						else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message Error.. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
				}
	} else
    if (isset($_GET['plugin'])) {
			$plugin = htmlspecialchars($_GET['plugin']); 
			
			if (is_dir($mdn."/".$plugin)) {
					$plug = $mdn."/".$plugin."/stage_run.php";
					if (file_exists($plug)) include_once($plug);
			}
	} else 
	// _GET
	if (isset($_GET['page'])) {
			$page = htmlspecialchars($_GET['page']);
			switch ($page) { 
				//case 'shop':
					//$_SESSION['viewpage']=$_POST['preview'];
					//include_once("plugins/shop/stage_run.php");
				//break;
				
				case 'messages':
					$_SESSION['viewpage']="##ALLFRIENDS##";
					$previewtest=1;
				break;
				
				case 'findfriends':
					if ($obj->isvisible($_SESSION['loginuser'])==0) echo($obj->display_findfriends()); 
				break;
				
				case 'login':
					echo($obj->display_login());
				break;
				
				case 'calendar':
					echo("<p><center><b><h4>Timeline</h4></b>");
					echo($obj->fill_calendar(0,0,0));
					echo("</center></p>");
				break;
				
				case 'usertable':
					echo($obj->display_users());
				break;
				
				case 'blogs':
					echo("<b><center>Public Channels</center></b><br />");
					echo($obj->display_blogchannels());
					echo("<br><b><center>Users blogs</center></b><br />");
					echo("<br />");
					echo($obj->display_blogusers());
					echo("<br /><br />");
				break;
		
				/*
				case 'blog':
					if (isset($_GET['user'])) {
						echo($obj->display_zero($_GET['user']));
					}
				break;
				*/
		
				case 'register':
					echo($obj->display_register());
				break;

				case 'logout':
					$_SESSION['loginuser'] = null; 
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
				break;
				
				case 'contacts':
					echo($obj->display_contacts());
					//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Main Developer:<br>Lukas Vesel..<br>mail: lukves@gmail.com</a></b></center></div></div>");
				break;

				case 'adminsettings':
				//	$obj->settings_interface();
				break;
				
				case 'settings':
				//	$obj->settings_interface();
				break;
				
				case 'upload':
					if ($_SESSION['loginuser']!=null) { $af=1; $obj->upload_myfile($af); }
				break;
				
				default:
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); // <script>reloadPage();</script>
				break;
			}
	} else 
	if (isset($_GET['blog'])) {
			if (isset($_GET['blog'])) {
				echo($obj->display_zero($_GET['blog']));
			}
	} else if (isset($_GET['message'])) {
			$msg = htmlspecialchars($_GET['message']);
			echo($obj->display_fullmessage($msg));
	} else if (isset($_GET['comments'])) {
			$msg = htmlspecialchars($_GET['comments']);
			echo($obj->display_reply_zero($msg));
	} else if (isset($_GET['channel'])) {
			$chusr = htmlspecialchars($_GET['channel']);
			//echo($obj->display_channel_messages($chusr));
			$_SESSION['pageid']=1; 
			if ($_SESSION['zeroview']==0) echo($obj->display_zero($chusr)); else echo($obj->display_zero_list($chusr, $_SESSION['zeroview'])); 
	} else if (isset($_GET['displayzeropage'])) { // display special request for login user for preview only public messages like non loged
			$chusr = htmlspecialchars($_GET['displayzeropage']);
			$_SESSION['pageid']=1; 
			if ($_SESSION['zeroview']==0) echo($obj->display_zero("##ZEROPAGE##")); else echo($obj->display_zero_list("##ZEROPAGE##", $_SESSION['zeroview']));
	} else if (isset($_GET['plugin'])) {
			$plugin = htmlspecialchars($_GET['plugin']); 
			
			if (is_dir($mdn."/".$plugin)) {
					$plug = $mdn."/".$plugin."/stage_run.php";
					if (file_exists($plug)) include_once($plug);
			}
	} 
	if (!empty($_POST['zeropage'])) {
					$_SESSION['pageid']=$_POST['zeropage'];
					if ($_SESSION['zeroview']==0) echo($obj->display_zero("##ZEROPAGE##")); else echo($obj->display_zero_list("##ZEROPAGE##", $_SESSION['zeroview'])); 
	} else
	if (!empty($_POST['search_but'])) {
				//var_dump($_POST);
				//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Nothing to Search. Refresh Page</a></b></center></div></div>");
				if ($_SESSION['loginuser']!=null) {
						if (!empty($_POST['search_input'])) { 
							$obj->display_search_items($_POST);
						} else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Nothing to Search. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
				} else if (!empty($_POST['search_input'])) { 
							$obj->display_search_zero($_POST['search_usr']);
						} else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Nothing to Search. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
	} else 
	if (!empty($_POST['asked_friend'])) $obj->accept_question($_POST); else 
	if (!empty($_POST['del_friend'])) $obj->delete_friend($_POST); else 
	if (!empty($_POST['notaccept'])) { 
					$obj->delete_question($_POST);
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Canceled. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
	} else 
	if (!empty($_POST['accept'])) { 
					// potvrdenie accept priatelstva akymkolvek uzivatelom
					$obj->write_friend($_POST);
					$obj->delete_question($_POST);
	} else 
	if (!empty($_POST['msgaccept'])) { 
					$test = $obj->public_message($_POST);
					$obj->delete_question($_POST);
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message is Public. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
	} else 
	if (!empty($_POST['chaccept'])) { 
					// potvrdenie chaccept adminom pre zaregistrovanie kanalu
					$obj->write_channel_registration($_POST);
					$obj->delete_question($_POST);
	} else 
	if (!empty($_POST['find_friend'])) { 
					// tlacitko find friends
					$obj->write_friend($_POST);
	}
	else   
		// the core
		if ($_SESSION['loginuser']!=null) {
			if (isset($_GET['previewtype'])) {
				$previewtype = htmlspecialchars($_GET['previewtype']);
				switch ($previewtype) { 
				
					case 'classic':
						$obj->preview_type=0;//$_SESSION['viewpage']="##ALLFRIENDS##";
					break;

					case 'forum':
						$obj->preview_type=3;//$_SESSION['viewpage']="##ALLFRIENDS##";
					break;
				
					case 'list':
						$obj->preview_type=99;//$_SESSION['viewpage']="##ALLFRIENDS##";
					break;

					default:
						//$obj->preview_type=0;//$_SESSION['viewpage']="##ALLFRIENDS##";
					break;
				}
			
				$_SESSION['pwtp']=$obj->preview_type;
			}
			 
			if (!empty($_POST['page'])) {
					$_SESSION['pageid']=$_POST['page'];
			} 
			
			if (isset($_SESSION['viewpage'])) {
				if ($_SESSION['viewpage']=="##ALLFRIENDS##") {
					$obj->display_messages();
				} else {
					$obj->display_friend_messages($_SESSION['viewpage']);
				}
			} else $obj->display_messages();
	} else if ($_SESSION['loginuser']==null) { 
			if ($_SESSION['zeroview']==0) echo($obj->display_zero("##ZEROPAGE##")); else echo($obj->display_zero_list("##ZEROPAGE##", $_SESSION['zeroview']));
	} 


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
				$plug = $mdn."/".$dirArray[$index]."/stage_run-bottom.php";
				if (file_exists($plug)) include_once($plug);
			}
			// run EXEC
			if (is_dir($mdn."/".$dirArray[$index])) {
				$plug = $mdn."/".$dirArray[$index]."/stage_run-exec.php";
				if (file_exists($plug)) include_once($plug);
			}
		}
  }



?>
