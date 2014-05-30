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

    // set custom wallpaper
	if (isset($_SESSION['bodycss'])) {
		//echo($_SESSION['bodycss']);
		if (file_exists("./bindata/files/{$_SESSION['bodycss']}")) {
		echo $display = <<<DISPLAY
			<style type="text/css">
				body {background: transparent url(./bindata/files/{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
				#sitebody {background: transparent url(./bindata/files/{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
			</style>
DISPLAY;
		} else
		if (file_exists("./bindata/files/{$_SESSION['loginuser']}/{$_SESSION['bodycss']}")) {
		echo $display = <<<DISPLAY
			<style type="text/css">
				body {background: transparent url(./bindata/files/{$_SESSION['loginuser']}/{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
				#sitebody {background: transparent url(./bindata/files/{$_SESSION['loginuser']}/{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
			</style>
DISPLAY;
		} else
		if (file_exists("./".$_SESSION['bodycss'])) {
		echo $display = <<<DISPLAY
			<style type="text/css">
				body {background: transparent url(./{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
				#sitebody {background: transparent url(./{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
			</style>
DISPLAY;
		}
	} 
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
		$obj->switch_users_table();
		
		$mdn= $obj->synapse_path."plugins/";
		
		$previewtest=0;
		
		if ($_POST) {
			if (!empty($_POST['insertcode'])) {
				//$_SESSION['pageid']=1;
				//$_SESSION['viewpage']=$_POST['preview'];
				//$obj->display_friend_messages($_POST['preview']);
				$_SESSION['viewpage']="##ALLFRIENDS##";
				$previewtest=1;
				//$obj->display_messages();
			} else
			if (!empty($_POST['insertfavourite'])) {
				$test = $obj->write_favourites($_POST); 
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
				//$_SESSION['pageid']=1;
				//$_SESSION['viewpage']=$_POST['preview'];
				//$obj->display_friend_messages($_POST['preview']);
				//$_SESSION['viewpage']="##ALLFRIENDS##";
				//$previewtest=1;
				//$obj->display_messages();
			} else
			if (isset($_POST['recyclebin'])) {
				$test = $obj->write_recyclebin($_POST); 
				//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Recycle Bin. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
				//$_SESSION['pageid']=1;
				//$_SESSION['viewpage']=$_POST['preview'];
				//$obj->display_friend_messages($_POST['preview']);
				//$_SESSION['viewpage']="##ALLFRIENDS##";
				//$previewtest=1;
				//$obj->display_messages();
			} else
			if (!empty($_POST['usersettingsbg_opt'])) { 
				$usrbgopt = $_POST['usersettingsbg_opt'];
		
				$_SESSION['bodycss']=$usrbgopt;
		
				$obj->switch_buffer_table();
				$created = time();
				$askmsg=$usrbgopt;
				$myuser = $_SESSION['loginuser'];
				$sql = "INSERT INTO buffer VALUES('##CHANGEWALLPAPER##','$myuser','$askmsg','#','#','$created')";
				$r = mysql_query($sql);
				
				echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
		//$this->switch_users_table();
		//$q = "UPDATE users SET Avatar='$usropt' WHERE Username = '$myuser'";
		//$r = mysql_query($q);
			} else
			if (!empty($_POST['passwordsettings_btn'])) { 
				$obj->update_passwordsettings($_POST);
			} else
			if (!empty($_POST['usersettings_opt'])) { 
				$obj->update_usersettings($_POST);
			} else
			if (!empty($_POST['usersettingsbg_opt'])) { 
				$obj->update_usersettings($_POST);
			} else
			if (!empty($_POST['usersettings_info'])) { 
				$obj->update_usersettings($_POST);
			} else
			if (!empty($_POST['deleteaccount_btn'])) { 
				$obj->update_deleteaccount($_POST);
			} else
			if (!empty($_POST['preview'])) { 
				$_SESSION['pageid']=1;
				$_SESSION['viewpage']=$_POST['preview'];
				//$obj->display_friend_messages($_POST['preview']);
				$previewtest=1;
			} else
			if (!empty($_POST['karma_yesno'])) {
				if ($_POST['karma_yesno']=="Recycle Bin") { $test = $obj->write_recyclebin($_POST);    } else
				if ($_POST['karma_yesno']=="Delete from Bookmarks") { $test = $obj->delete_bookmark($_POST);  } else
				if ($_POST['karma_yesno']=="Delete Message") { $test = $obj->delete_message($_POST); echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message Deleted!!! Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
				if ($_POST['karma_yesno']=="Pin to Homepage") { $test = $obj->pin_message($_POST); echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Pin Message to Homepage!!! Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
				if ($_POST['karma_yesno']=="Yes") { $test = $obj->write_karma($_POST); echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Thanks for -Yes- Vote. Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
				if ($_POST['karma_yesno']=="No") { $test = $obj->write_karma($_POST);  echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Thanks for -No- Vote. Refresh Page</a></b></center></div></div><script>reloadPage();</script>"); } else
				if ($_POST['karma_yesno']=="Reply") { echo($obj->display_reply_messages($_POST)); } else 
				if ($_POST['karma_yesno']=="Share") { $test = $obj->share_data($_POST); } else
				if ($_POST['karma_yesno']=="Public Ask") {  $obj->accept_question($_POST); } 
			} else
	        if (!empty($_POST['task'])) {
			    if ($_POST['task']=="Register") { echo($obj->display_register()); } else
				if ($_POST['task']=="Login") { echo($obj->display_login()); } else
				if ($_POST['task']=="Logout") {
						$obj->unlink_files($_SESSION['loginuser']);
					
						$_SESSION['loginuser'] = null;
						unset($_SESSION['loadpage']); 
						echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script></script>"); 
						//echo($obj->display_zero()); 
				} else if ($_POST['task']=="$") { 
					$_SESSION['viewpage']="##ALLFRIENDS##";
					//$obj->display_messages();
					$previewtest=1;
				} else if ($_POST['task']=="Find Friends") {
					if ($obj->isvisible($_SESSION['loginuser'])==0) echo($obj->display_findfriends()); // else // findfriends | searchfriends
						//echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Not for Presentation Account. Refresh Page</a></b></center></div></div>");
				} else if ($_POST['task']=="Upload") {
					if ($_SESSION['loginuser']!=null) { $af=1; $obj->upload_myfile($af); }
				} 
				else if ($_POST['task']=="Settings") {
					//$obj->settings_interface();
					//$obj->admin_interface();
				}
				else
				if ($_POST['task']=="Create Database Dump") { 
					// create backup of table with new user
					$obj->backup_tables($obj->host,$obj->username,$obj->password,'users');
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Dump Created. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
				}
	        } else 
			if (!empty($_POST['login_username'])) {
						//$_SESSION['viewpage']="";
						$_SESSION['loginuser'] = $obj->write_login($_POST); 
						
						
						if ($_SESSION['loginuser']) $obj->unpack_files($_SESSION['loginuser']);
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
								if ($_POST['register_button']=="Register")
										$obj->write_registration($_POST);
								else if ($_POST['register_button']=="Ask for Register Channel") $obj->accept_question($_POST);
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
			if (!empty($_POST['page'])) {
					$_SESSION['pageid']=$_POST['page'];
					//$obj->display_messages();
					$previewtest=1;
			} else 
			if (!empty($_POST['zeropage'])) {
					$_SESSION['pageid']=$_POST['zeropage'];
					if ($_SESSION['zeroview']==0) echo($obj->display_zero("##ZEROPAGE##")); else echo($obj->display_zero_list("##ZEROPAGE##", $_SESSION['zeroview'])); 
			} else 
				// search in messages when is loged user, or in zero search
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
			} else if (!empty($_POST['accept'])) { 
					// potvrdenie accept priatelstva akymkolvek uzivatelom
					$obj->write_friend($_POST);
					$obj->delete_question($_POST);
			} else if (!empty($_POST['msgaccept'])) { 
					$test = $obj->public_message($_POST);
					$obj->delete_question($_POST);
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Message is Public. Refresh Page</a></b></center></div></div><script>reloadPage();</script>");
			} else if (!empty($_POST['chaccept'])) { 
					// potvrdenie chaccept adminom pre zaregistrovanie kanalu
					$obj->write_channel_registration($_POST);
					$obj->delete_question($_POST);
			} else if (!empty($_POST['find_friend'])) { 
					// tlacitko find friends
					$obj->write_friend($_POST);
			} /// if is POST but nothing then display ZERO page
				else if ($_SESSION['loginuser']==null) { 
				if ($_SESSION['zeroview']==0) echo($obj->display_zero("##ZEROPAGE##")); else echo($obj->display_zero_list("##ZEROPAGE##", $_SESSION['zeroview']));
			}	 
		} else if (isset($_GET['plugin'])) {
			$plugin = htmlspecialchars($_GET['plugin']); 
			
			if (is_dir($mdn."/".$plugin)) {
					$plug = $mdn."/".$plugin."/stage_run.php";
					if (file_exists($plug)) include($plug);
			}
		} else if (isset($_GET['previewtype'])) {
			$previewtype = htmlspecialchars($_GET['previewtype']);
			switch ($previewtype) { 
				
				case 'classic':
					$obj->preview_type=0;//$_SESSION['viewpage']="##ALLFRIENDS##";
				break;

				case 'forum':
					$obj->preview_type=3;//$_SESSION['viewpage']="##ALLFRIENDS##";
				break;
				
				case 'blog':
					$obj->preview_type=4;//$_SESSION['viewpage']="##ALLFRIENDS##";
				break;
				
				case 'list':
					$obj->preview_type=99;//$_SESSION['viewpage']="##ALLFRIENDS##";
				break;

				default:
					//$obj->preview_type=0;//$_SESSION['viewpage']="##ALLFRIENDS##";
				break;
			}
			
			$_SESSION['pwtp']=$obj->preview_type;
			
			if ($_SESSION['loginuser']!=null) {
				if($_SESSION['viewpage']=="##ALLFRIENDS##") {
					$obj->display_messages();
				} else {
					$obj->display_friend_messages($_SESSION['viewpage']);
				}
			}
		} else if (isset($_GET['decryptfile'])) {
			$rul = $obj->upload_dir . $_SESSION['loginuser'] . "/" . $_GET['decryptfile'];
			$ruldest = preg_replace('/\.sif$/','',$rul);
			$obj->decrypt_file($rul , $_SESSION['loginuser'] );
			if ( (strpos($ruldest, ".wma")!==false)  
						 || (strpos($ruldest, ".WMA")!==false)  
						 || (strpos($ruldest, ".mp3")!==false) 
						 || (strpos($ruldest, ".MP3")!==false) 
						 || (strpos($ruldest, ".flac")!==false) 
						 || (strpos($ruldest, ".FLAC")!==false) ) { 
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"/index.php?mediafile={$ruldest}\">Refresh Page</a></b></center></div></div>");
			} else echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"/index.php?plugin=audioplayer\">Refresh Page</a></b></center></div></div>");
		} else if (isset($_GET['background'])) {
					$_SESSION['bodycss']=$_GET['background'];
					/*
					if (isset($_SESSION['bodycss'])) {
						echo $display = <<<DISPLAY
							<style>
								body {background: transparent url(./bindata/files/{$_SESSION['loginuser']}/{$_SESSION['bodycss']}) 0 0 repeat;color: #1c3966;}
							</style>
DISPLAY;
					}
					*/
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div>");
		}
		else if (isset($_GET['page'])) {
			$page = htmlspecialchars($_GET['page']);
			switch ($page) { 
				//case 'shop':
					//$_SESSION['viewpage']=$_POST['preview'];
					//include_once("plugins/shop/stage_run.php");
				//break;
				
				case 'listimages':
					if (isset($_GET['user'])) {
						$usr = htmlspecialchars($_GET['user']);
						if ($obj->listimages!=0) {
												echo("<center><h1><big>Pictures of {$usr}</big></h1></center><br /><br />");
												//echo($obj->list_files_ex("./bindata/files/".$usr."/", $usr, 0, 0, 0, 1 ));
												echo($obj->list_image_files_box("./bindata/files/".$usr."/"));
								}
					}
				break;
				
				case 'deleteaccount':
					echo($obj->display_delete_account());
				break;
				
				case 'usersmanagement':
					echo($obj->users_management());
				break;
				
				case 'followers':
					$user = htmlspecialchars($_GET['user']);
					echo($obj->display_followers($user));
				break;
				
				case 'timeline':
					$obj->display_timeline();
				break;
				
				case '$':
					$_SESSION['viewpage']="##ALLFRIENDS##";
					//$obj->display_messages();
					$previewtest=1;
				break;
				
				case 'recyclebin':
					//$_SESSION['viewpage']="##ALLFRIENDS##";
					//$previewtest=1;
					echo($obj->display_recyclebin_messages());
				break;
				
				case 'favourites':
					//$_SESSION['viewpage']="##ALLFRIENDS##";
					//$previewtest=1;
					echo($obj->display_favourites_messages());
				break;
				
				case 'bookmarks':
					//$_SESSION['viewpage']="##ALLFRIENDS##";
					//$previewtest=1;
					echo($obj->display_bookmarks_messages());
				break;
				
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
				
				case 'channels':
					echo($obj->display_blogchannels());
				break;
				
				case 'users':
					echo($obj->display_blogusers());
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
					$obj->unlink_files($_SESSION['loginuser']);
				
					$_SESSION['loginuser'] = null; 
					unset($_SESSION['loadpage']);
				
					echo("<div class=\"hehe\"><div class=\"smallfont\"><center><b><a href=\"index.php\">Refresh Page</a></b></center></div></div><script></script>");
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
		} else if (isset($_GET['blog'])) {
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
		} else if ($_SESSION['loginuser']!=null) {
			if (!empty($_GET['preview'])) {
				$viewfr = htmlspecialchars($_GET['preview']);
				if(isset($viewfr)) {
					$_SESSION['pageid']=1;
					$_SESSION['viewpage']=$viewfr;
					$previewtest=1;
				}
			}
			/*
			if ( ($_SESSION['viewpage']=="##ALLFRIENDS##") || (empty($_SESSION['viewpage'])) ) {
				$obj->display_messages();
			} else {
				$obj->display_friend_messages($_SESSION['viewpage']);
			}
			*/
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
		
		if ($_SESSION['loginuser']!=null) {
			if ($previewtest==1) {
				if($_SESSION['viewpage']=="##ALLFRIENDS##") {
					$obj->display_messages();
				} else if (empty($_SESSION['viewpage'])) {
					$obj->display_messages();
				} else {
					$obj->display_friend_messages($_SESSION['viewpage']);
				}
			}
		}
		//$viewfr = htmlspecialchars($_GET['preview']);
		//if(isset($viewfr)) {
	
		//if ($obj->admin==5) $obj->switch_data_table(); else
		   //$obj->switch_users_table();
	  
	  //if (Is) if ( $_POST ) $obj->write_registration($_POST);
	  //if ( $_POST ) $obj->write_login($_POST);
	  //if ( $_POST ) $obj->write_data($_POST);
	
	  
	  //$obj->display_world();
	
  
  $myDirectory = opendir($mdn.".");
  // get each entry
  while($entryName = readdir($myDirectory)) {
	$dirArraye[] = $entryName;
  }
  closedir($myDirectory);
  // count elements in array
  $indexCount	= count($dirArraye);
  //echo ("$indexCount files<br>\n");
  sort($dirArraye);
  // loop through the array of files and print them all
  for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArraye[$index]", 0, 1) != ".") { // don't list hidden files
			if (is_dir($mdn."/".$dirArraye[$index])) {
				$plug = $mdn.$dirArraye[$index]."/stage_run-bottom.php";
				// $mdn."/".$dirArraye[$index]."/stage_run-bottom.php";
				if (file_exists($plug)) include_once ($plug);
				//Print $plug;
			}
			// run EXEC
			if (is_dir($mdn."/".$dirArraye[$index])) {
				$plug = $mdn.$dirArraye[$index]."/stage_run-exec.php";
				if (file_exists($plug)) include_once ($plug);
			}
		}
  }



?>
