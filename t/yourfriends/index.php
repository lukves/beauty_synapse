<?php 

/**
 * Synapse-CMS  template haiku - fork of try template
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
 
 
	$Web = $_SERVER['SERVER_NAME']; 
	
	$testpag = "./t//".$obj->template."/";

?>

<? 
   // load guestbook
   // include_once("./synapse-cms/synapsecms-guestbook.php");
   // load synapsecms-menu.php
   // include_once("./synapse-cms/synapsecms-menu.php");
   $data=json_encode(array(
	'key'=>utf8_encode($key),
	'iv'=>utf8_encode($iv),
	'c'=>utf8_encode($c),
	'm'=>utf8_encode($m),
	'crypted'=>utf8_encode($crypted),
	'plain'=>utf8_encode($plain)));
?>

	
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="me-sketch.png">
	<meta name="language" content="en-US">
	<meta name="Author" lang="en-US" content="Lukas Veselovsky">
	<meta name="copyright" content="">
	<meta name="description" content="<?php echo $obj->title; ?> -  <?php echo $obj->slogan; ?>">

	<link rel="shortcut icon" href="me-sketch.png">

	<!-- CSS reset: http://meyerweb.com/eric/thoughts/2007/05/01/reset-reloaded/ -->
	<link rel="stylesheet" href="<?php echo($testpag); ?>/reset.css" media="all">
	<link rel="stylesheet" type="text/css" href="./synapse-cms/css/addons.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./synapse-cms/plugins/virtualfriend/clippy.css" media="all">
	<link rel="stylesheet" type="text/css" href="./synapse-cms/css/defaults.css">
	<link rel="stylesheet" href="<?php echo($testpag); ?>/style.css" media="all">

	<!-- Ubuntu webfont -->
	<link rel="alternate" type="application/rss+xml" title="<?php echo $obj->title; ?> // Articles feed" href="feed/">

	
<link rel="stylesheet" type="text/css" href="./t/yourfriends/global.css"><link rel="stylesheet" type="text/css" href="./t/yourfriends/special.css"><link rel="stylesheet" type="text/css" href="./t/yourfriends/auth.css">
	
	
<script type="text/javascript">
	var cookie = readCookie("style");
	var title = cookie ? cookie : getPreferredStyleSheet();
	setActiveStyleSheet(title);

	var language = readCookie("language");
	if (language==null) createCookie('language',"en", 1);
	//setActiveLanguage(language);
</script>


<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">

<style type="text/css">

#element {
	padding-left: 15px;
	padding-right: 15px;
}

/* Index Menu */

#index-menu {
	width: 100%;
	height: 36px;				/*height of bar */
	margin: 0 auto;
	padding: 0;					/*padding down */
	
	/*
	border-top: 1px dotted black;
	border-bottom: 1px dotted black;
	*/
	
	/* background: rgb(51, 51, 51); */
	/*
	background-image: url("<?php echo($testpag);?>/images/bg/blue-selection.png");
	background-repeat:repeat-x;
	*/
}

#index-menu ul {
	margin: 0px 0px 0px 10px;
	padding: 0;
	list-style: none;
	line-height: normal;
}

#index-menu li {
	float: left;
}

#index-menu a {
	display: inline-block;
	height: 12px;									/* highlight height */
	padding: 12px 18px 12px 18px;					/* top, right, bottom, left*/
	text-decoration: none;
	text-align: justify;
	text-transform: uppercase;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #00ff00;
	border: none;
	border-top:1px solid #fff; border-bottom:1px solid #dbdbdb; border-right:none;
}

#index-menu a:hover, #index-menu .current_page_item a {
	background: rgba(0,150,64,.1); /* #006600; */
	text-decoration: none;
}

#index-menu .current_page_item a {
	background: #009900;
	color: #ffffff;
}

#index-menu li ul{ background:#fff; position:absolute; left:-999em; width:182px; margin:0px 0px 0px -2px; border:1px solid #dbdbdb; border-width:1px 1px 0px; z-index:999; }
#index-menu li ul li{ border-top:1px solid #fff; border-bottom:1px solid #dbdbdb; border-right:none; }

#index-menu li ul li a{ background: #f5f5f5; width:147px; padding:7px 17px; color:#333; font-size:12px; font-weight:normal; }

#index-menu li ul li a.sf-with-ul{ padding:7px 17px; }
#index-menu li ul li a:hover{ background:#ebebeb; text-decoration:underline; }
#index-menu li ul ul{ margin:-31px 0px 0px 181px; }
#index-menu li ul ul li a{  }
#index-menu li ul li ul li a{  }
#index-menu li:hover,.nav li.hover{ position:static; }
#index-menu li:hover ul ul, .nav li.sfhover ul ul,
#index-menu li:hover ul ul ul, .nav li.sfhover ul ul ul,
#index-menu li:hover ul ul ul ul, .nav li.sfhover ul ul ul ul{ left:-999em; }
#index-menu li:hover ul, .nav li.sfhover ul,
#index-menu li li:hover ul, .nav li li.sfhover ul,
#index-menu li li li:hover ul, .nav li li li.sfhover ul,
#index-menu li li li li:hover ul, .nav li li li li.sfhover ul{ left:auto; }


/* others */

#page_of strong{
  display: inline;
  font-weight: normal;
}

.messages LI {
	TEXT-ALIGN: left; TEXT-DECORATION: none;
	
	/* WIDTH: 99; */
	width: 100%;
	
	DISPLAY: inline-block; 
	
	opacity:0.7;
	filter:alpha(opacity=70); /* For IE8 and earlier */
	
	color: black;
	/* background-color: #525352;*/
	
	background: rgba(150,150,150,.1);
	
	border: 2px solid transparent;
	color: black;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.messages LI:hover {
	TEXT-ALIGN: left; TEXT-DECORATION: none;
	
	cursor: url('Link.cur'), pointer;
	
	/* WIDTH: 99; */
	width: 100%;
	
	DISPLAY: inline-block;
	
	opacity:1.0;
	filter:alpha(opacity=100); /* For IE8 and earlier */
	
	color: black;
	/* background-color: #525352;*/
	
	background: rgba(160,160,160,.1);
	
	border: 2px solid #000;
	color: black;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.red {
	background: transparent url('./synapse-cms/themes/images/comment_bg-select.jpg') repeat;
	background-size: 100% 100%;
}

DIV#slideload {
	background-image: url("/synapse-cms/themes/images/slideloading.gif");
	background-repeat: no-repeat;
	background-color: #transparent; background-position:top;
}

#send-to-top {
    position: fixed;
    bottom: 0;
    left: 50%;
    margin-left: -30%;
    width: 60%;
    background-color: rgba(0,0,0,.45);
    text-align: center;
    z-index: 9999;
    border: 1px solid #816e6e;
    border-bottom: none;
    -webkit-border-top-left-radius: 2px;
    -moz-border-top-left-radius: 2px;
    border-top-left-radius: 2px;
    -webkit-border-top-right-radius: 2px;
    -moz-border-top-right-radius: 2px;
    border-top-right-radius: 2px;
}

#send-to-top a {
    padding: 10px 0px;
    font-size: 16px;
    color: white;
    font-weight: bold;
    display: block;
}

@media screen and (min-height: 600px) {
#to-top {
    position: fixed;
    bottom: 0;
    /* 
    left: 50%;
    margin-left: -30%;
    */
    width: 100%;
    /* background-color: rgba(0,0,0,.45);*/
    text-align: center;
    z-index: 9999;
    /*
    border: 1px solid #816e6e;*/
    border-bottom: none;
    padding: 0px 0px;
    /*
    -webkit-border-top-left-radius: 2px;
    -moz-border-top-left-radius: 2px;
    border-top-left-radius: 2px;
    -webkit-border-top-right-radius: 2px;
    -moz-border-top-right-radius: 2px;
    border-top-right-radius: 2px;
    */
    height: 5px; 
    background-image: url(images/footer_bg2.png); 
    background-repeat: repeat-x;
}
#to-top a {
    color: white;
    font-weight: bold;
}
}


/* Drop Down*/
.primarynav {float:center; clear:right; margin: 0px 0 0 0px; }
.primarynav .topli {  }


.dropdownarrow {
	width: 35px;
	background-color:#ff0000; 
	height: 19px; 
	display:none; 
	position:absolute; 
    background: url(./synapse-cms/themes/images/interface/modal_arrow.png) 0 0 no-repeat;
	z-index: 100000; 
	margin: 28px 0 0 50px;
}

.dropdown {
	position:absolute; 
	background:#FFF; 
	border: 2px solid #000000; 
	width: 426px; 
	padding: 16px;
	
	margin:-9999px 0 0 0;
	 -webkit-border-radius: 8px;
	   -khtml-border-radius: 8px;
	     -moz-border-radius: 8px;
	          border-radius: 8px;
	-webkit-box-shadow: 0 0 8px rgba(0,0,0,.36);
	   -moz-box-shadow: 0 0 8px rgba(0,0,0,.36);
		    box-shadow: 0 0 8px rgba(0,0,0,.36);
}

.primarynav .dropdown {
	/*left: 100px;*/
	left: 30%;
	top:100px;
}
.primarynav .dropdownarrow {
	left:-16px;
}

.globalnav .dropdown {
	margin-left: -15px !important;
}

.hover .dropdownarrow {
	display:block;
}

.topli.hover {
	z-index:9000;
}

.hover .dropdown {
	margin-top:45px;
	z-index:9000;
}

.hover .topa {color:#000;}

.globalnav .dropdownarrow {
	margin: -8px 0 0 0 ;
}
	
.globalnav .hover .dropdownarrow {
	margin: -8px 0 0 30px ;
}

.globalnav .hover .dropdown {
	margin-top: 9px;
	margin-left: -30px !important;
}

.dda {
	font-size: 14px; 
	line-height: 18px; 
	padding: 8px 0; 
	color:#868686 !important; 
	display:block; 
	font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, sans-serif; 
	font-weight: 300;
	text-decoration:none;
	}

.dda:hover,

.dda:focus,

.dda:active {
	color:#333 !important;
}

.messagepanel {
	float: center;
	width: 98%;
/*		height: 82px;*/
	padding: 0.4em 0.4em 0.4em 0.4em;
	/* margin: 0.4em;*/
	border: 2px solid black;
	color: black;
	
	background-color: #ebebeb; 
	background-image: url("<?php echo($testpag); ?>/layout/bg.png");
	background-repeat:repeat; 
	
	opacity:0.4;
	filter:alpha(opacity=40); /* For IE8 and earlier */

	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;

}

.smallfont a{
	font-weight: normal; font-family: 'Yanone Kaffeesatz', arial, serif; text-shadow: none; color: gray; font-size: 28px;
}
.smallfont a:hover{
	font-weight: normal; font-family: 'Yanone Kaffeesatz', arial, serif; text-shadow: none; color: black; font-size: 28px; text-decoration:underline;
}

div#content-right {
width: 15em;
padding: 5em 1em;
/*
background-color: #DD4814;
box-shadow: 0 0 5px #333;
*/
/*
border-left: 2px solid black;
border-bottom: 2px solid black;
*/
margin: 0 0 1em 1em;
position:fixed;
top:0;
right:0;
}

aside {
}

aside ul {
list-style-type: none;
padding: 0 0 0 0;
margin-left: 0px;
margin-top: 1em;
/* border-left: 4px solid rgba(0, 128, 64,.1); */
}

aside li {
margin-bottom: 1em;
}

aside a:link {
color: #999;
text-decoration: none;
}

aside a:visited {
color: #111;
}

aside a:hover {
/* background-color: #fff; */
/* color: #00ff00; */
border-bottom-width: 0;
border-bottom: 1px solid #000;
/* border-left: 4px solid background: rgba(0,250,64,.1); */
}

/*
@media screen and (max-width: 1020px) {
div.aside_expand { display : none; }
}
*/

[class^="icon-"],
[class*=" icon-"] {
  display: inline-block;
  width: 14px;
  height: 14px;
  margin-top: 1px;
  *margin-right: .3em;
  line-height: 14px;
  vertical-align: text-top;
  background-image: url("/synapse-cms/themes/images/interface/glyphicons-halflings.png");
  background-position: 14px 14px;
  background-repeat: no-repeat;
}

@media screen and (max-width: 1020px) {
div.aside_expand { display : none; }
}


/* search form
#search{ position:left; width:236px; height:36px;
	margin: 0 auto;
	padding-top: 4;
	padding-right: 500px;
}
#search input{ float:left; background:url(<?php echo($testpag);?>/images/bg/bg-search.png) repeat-x top; width:220px; padding:8px 8px 7px 8px; font-family:Georgia, Times New Roman; font-size:12px; font-style:italic; color:#666; line-height:12px; border:2px solid #000; }
#search input.btn{ background:none; border:none; margin:20px 0px 0px -30px; padding:0px; width:auto; }
*/

#search {margin-right:10px; margin-bottom:20px; position:relative;}
#search input {background:rgba(246,246,246,.5); border:1px solid rgba(146,146,146,.5); border-radius:3px; box-shadow:inset 1px 1px 3px rgba(0,0,0,.1); line-height:20px; height:20px; width:160px; padding:5px 26px 5px 5px; outline:none;}
#search input:active,#search input:focus {background:rgb(255,255,255);}
#search button {background:url(images/search.png) no-repeat 4px 6px; border:none; text-indent:-999px; font-size:0; width:auto; height:28px; display:block; overflow:hidden; position:absolute; top:2px; right:2px; cursor:pointer;}

.msgarea {margin-right:10px; margin-bottom:20px; position:relative;}
.msgarea {background:rgba(246,246,246,.5); border:1px solid rgba(146,146,146,.5); border-radius:3px; box-shadow:inset 1px 1px 3px rgba(0,0,0,.1); line-height:20px; height:20px; padding:5px 26px 5px 5px; outline:none;}
.msgarea:active,.bginput:focus {background:rgb(255,255,255);}

.bginput {margin-right:10px; margin-bottom:20px; position:relative;}
.bginput {background:rgba(246,246,246,.5); border:1px solid rgba(146,146,146,.5); border-radius:3px; box-shadow:inset 1px 1px 3px rgba(0,0,0,.1); line-height:20px; height:20px; padding:5px 26px 5px 5px; outline:none;}
.bginput:active,.bginput:focus {background:rgb(255,255,255);}

#login_username {width: 128px;}
#login_email {width: 128px;}
#login_password {width: 128px;}
#login_repassword {width: 128px;}

input, select{color:#566e76!important;font-size:11px;font-weight:normal;display:inline-block;background-color:#f7fdff;text-decoration:none;white-space:nowrap;overflow:visible;margin:2px 2px 6px 0;padding:0.1em 0.8em;line-height:1.4;border:1px solid #c0d4db;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
input:hover, select:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid #000000;color: black;font-weight: bold;}
input:visited, select:visited{text-decoration:none;background-color:#e8f9ff;border:1px solid blue;color: black;font-weight: bold;}

#bdelete:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid black;color: black;font-weight: bold;}
#bshare:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid black;color: black;font-weight: bold;}
#bpin:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid yellow;color: black;font-weight: bold;}
#bbookmark:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid blue;color: black;font-weight: bold;}
#bask:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid green;color: black;font-weight: bold;}
#breply:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid red;color: black;font-weight: bold;}
#brecycle:hover{text-decoration:none;background-color:#e8f9ff;border:1px solid brown;color: black;font-weight: bold;}

.comment-buttons {
	filter: alpha(opacity=40); -moz-opacity: 0.4; opacity: 0.4;
}

.comment-buttons:hover {
	filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1;
}
</style>

<link rel="stylesheet" type="text/css" href="./synapse-cms/css/menu_style3.css">

</head>

<body onload="document.getElementById('img1').style.display='none';  document.getElementById('captcha-form').focus();" id="xubuntu" class="item-marketing  ">
<div id="to-bottom"></div>

<div id="fb-root"></div>
        <script type="text/javascript">
            var button;
            var userInfo;
            
            window.fbAsyncInit = function() {
                FB.init({ appId: '590456854357613', //change the appId to your appId
                    status: true,
                    cookie: true,
                    xfbml: true,
                    oauth: true});

               showLoader(true);
               
               function updateButton(response) {
                    button = document.getElementById('fb-auth');
                    userInfo = document.getElementById('user-info');
                    
                    if (response.authResponse) {
                        //user is already logged in and connected
                        FB.api('/me', function(info) {
                            login(response, info);
                        });
                        
                        button.onclick = function() {
                            FB.logout(function(response) {
                                logout(response);
                            });
                        };
                    } else {
                        //user is not connected to your app or logged out
                        button.innerHTML = 'Login';
                        button.onclick = function() {
                            showLoader(true);
                            FB.login(function(response) {
                                if (response.authResponse) {
                                    FB.api('/me', function(info) {
                                        login(response, info);
                                    });        
                                } else {
                                    //user cancelled login or did not grant authorization
                                    showLoader(false);
                                }
                            }, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});         
                        }
                    }
                }
                
                // run once with current status and whenever the status changes
                FB.getLoginStatus(updateButton);
                FB.Event.subscribe('auth.statusChange', updateButton);        
            };
            (function() {
                var e = document.createElement('script'); e.async = true;
                e.src = document.location.protocol
                    + '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
            
            
            function login(response, info){
                if (response.authResponse) {
                    var accessToken = response.authResponse.accessToken;
                    
                    userInfo.innerHTML = '<img src="https://graph.facebook.com/' + info.id + '/picture">' + info.name
                                                                     + "<br /> Your Access Token: " + accessToken;
                    button.innerHTML = 'Logout';
                    showLoader(false);
                    document.getElementById('other').style.display = "block";
                }
            }
        
            function logout(response){
                userInfo.innerHTML = "";
                document.getElementById('debug').innerHTML = "";
                document.getElementById('other').style.display = "none";
                showLoader(false);
            }

            //stream publish method
            function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
                showLoader(true);
                FB.ui(
                {
                    method: 'stream.publish',
                    message: '',
                    attachment: {
                        name: name,
                        caption: '',
                        description: (description),
                        href: hrefLink
                    },
                    action_links: [
                        { text: hrefTitle, href: hrefLink }
                    ],
                    user_prompt_message: userPrompt
                },
                function(response) {
                    showLoader(false);
                });

            }
            function showStream(){
                FB.api('/me', function(response) {
                    //console.log(response.id);
                    streamPublish(response.name, 'I like the articles of Thinkdiff.net', 'hrefTitle', 'http://thinkdiff.net', "Share thinkdiff.net");
                });
            }

            function share(){
                showLoader(true);
                var share = {
                    method: 'stream.share',
                    u: 'http://thinkdiff.net/'
                };

                FB.ui(share, function(response) {
                    showLoader(false);
                    console.log(response);
                });
            }

            function graphStreamPublish(){
                showLoader(true);
                
                FB.api('/me/feed', 'post',
                    {
                        message : "I love thinkdiff.net for facebook app development tutorials",
                        link : 'http://ithinkdiff.net',
                        picture : 'http://thinkdiff.net/iphone/lucky7_ios.jpg',
                        name : 'iOS Apps & Games',
                        description : 'Checkout iOS apps and games from iThinkdiff.net. I found some of them are just awesome!'
                        
                },
                function(response) {
                    showLoader(false);
                    
                    if (!response || response.error) {
                        alert('Error occured');
                    } else {
                        alert('Post ID: ' + response.id);
                    }
                });
            }

            function fqlQuery(){
                showLoader(true);
                
                FB.api('/me', function(response) {
                    showLoader(false);
                    
                    //http://developers.facebook.com/docs/reference/fql/user/
                    var query = FB.Data.query('select name, profile_url, sex, pic_small from user where uid={0}', response.id);
                    query.wait(function(rows) {
                       document.getElementById('debug').innerHTML =
                         'FQL Information: '+ "<br />" +
                         'Your name: ' + rows[0].name + "<br />" +
                         'Your Sex: ' + (rows[0].sex!= undefined ? rows[0].sex : "") + "<br />" +
                         'Your Profile: ' + "<a href='" + rows[0].profile_url + "'>" + rows[0].profile_url + "</a>" + "<br />" +
                         '<img src="' + rows[0].pic_small + '" alt="" />' + "<br />";
                     });
                });
            }

            function setStatus(){
                showLoader(true);
                
                status1 = document.getElementById('status').value;
                FB.api(
                  {
                    method: 'status.set',
                    status: status1
                  },
                  function(response) {
                    if (response == 0){
                        alert('Your facebook status not updated. Give Status Update Permission.');
                    }
                    else{
                        alert('Your facebook status updated');
                    }
                    showLoader(false);
                  }
                );
            }
            
            function showLoader(status){
                if (status)
                    document.getElementById('loader').style.display = 'block';
                else
                    document.getElementById('loader').style.display = 'none';
            }
            
        </script>


<div id="logo">
</div>

<div id="wpcontent" class="group">
<div id="top-bar" align="center">
	<div class="logo">
	   		<div id="beta"><h1><a href="./index.php"><script type="text/javascript"> if (language=="en") document.write("Welcome to Blogino !"); else document.write("Vítaj na Blogine !");</script></a></h1>
			<h3><?php echo($obj->synapse_slogan); ?></h3>
			</div>
    </div>
	<div style="position:absolute;top:0;bottom: 0; margin-top:80px;margin-bottom:auto;height:200px;margin-left:0px;color:#fff; width: 80px;">	
		<div style="padding-top:10px; float:right; width: 30px; ">
		<a href="index.php" onclick="createCookie('language','en', 1);"><img src="./synapse-cms/themes/images/flags/gbp0.gif"></a>
		</div>
		<div style="padding-top:10px; float:right; width: 30px;">
		<a href="index.php" onclick="createCookie('language','sk', 1);"><img src="./synapse-cms/themes/images/flags/czk0.gif"></a>
		</div>
	</div>
</div>
    <div id="menu-bar" align="center">
      <table align="center" border="0" cellpadding="0" cellspacing="0"
        width="100%">
        <tbody>
          <tr>
			  <td onclick="loadURL('index.php');"><a href="index.php" name="task"><img src="./t/yourfriends/home_icon.gif"></a></td>
			<?php if ($_SESSION['loginuser']) { ?>
			<td onclick="loadURL('index.php');"><a href="index.php?page=usersmanagement" name="task"><script type="text/javascript"> if (language=="en") document.write("Find friends"); else document.write("Nájsť priateľov");</script></a></td>
			<td onclick="loadURL('index.php');"><a href="index.php?plugin=audioplayer" name="task"><script type="text/javascript"> if (language=="en") document.write("Listen music"); else document.write("Počúvať hudbu");</script></a></td>
			<td onclick="loadURL('index.php');"><a href="index.php?page=channels" name="task"><script type="text/javascript"> if (language=="en") document.write("Channels list"); else document.write("Zoznam kanálov");</script></a></td>
			<td onclick="loadURL('index.php');"><a href="index.php?page=bookmarks" name="task"><script type="text/javascript"> if (language=="en") document.write("Favourites"); else document.write("Prejsť na záložky");</script></a></td>
			<?php } else { ?>
			<td onclick="loadURL('index.php');"><a href="index.php?page=contacts" name="task"><script type="text/javascript"> if (language=="en") document.write("Contact us"); else document.write("Nahlásiť administratorovi");</script></a></td>
			<?php } ?>
			<td onclick="loadURL('index.php');"><a href="./doc/index.html" name="task"><script type="text/javascript"> if (language=="en") document.write("Link to homepage"); else document.write("Odkaz na Domovské");</script></a></td>
          </tr>
        </tbody>
      </table>
      <!-- ?php $obj->admin_interface(); ? !-->
    </div>
<div id="mainwrap">
	<div id="main">
	<div class="post-205 page type-page status-publish hentry group post-order1" id="post-205">
	
	<div class="post-post">
	<div class="post-entry entry">
	
		<!-- Facebook debug info !-->
		<br />
        <div id="user-info"></div>
        <br />
        <div id="debug"></div>
		
		<div id="other" style="display:none">
            <a href="#" onclick="showStream(); return false;">Publish Wall Post</a> |
            <a href="#" onclick="share(); return false;">Share With Your Friends</a> |
            <a href="#" onclick="graphStreamPublish(); return false;">Publish Stream Using Graph API</a> |
            <a href="#" onclick="fqlQuery(); return false;">FQL Query Example</a>
            
            <br />
            <textarea id="status" cols="50" rows="5">Write your status here and click 'Status Set Using Legacy Api Call'</textarea>
            <br />
            <a href="#" onclick="setStatus(); return false;">Status Set Using Legacy Api Call</a>
        </div>

<?php $obj->admin_interface($_POST); ?>		
<?php
			// This is very IMPORTANT PART, in this part is main core of preview messages..
			// use only after initialize a stage_init.

			$obj->preview_type=3;
			
			include('./synapse-cms/stage_run.php');
?>
<br>
<br>
<div class="entry-content">
<br>
<table style="width: 80%;">
<tr>
<td align="left">
Donate: <b>520700-4203467266/8360</b><br>
Donate Bitcoins: <b>14mXEWw9tgTtRT35RSvLL27XSpyety8x3N</b><br>
</td>
<td align="right">
<a href="./synapse-cms/rss-channel.php"><img src="./synapse-cms/themes/images/rss/rss.png"></a>
<!-- <img src="./t/blogino/images/dbthx1.png"><img src="./t/blogino/images/dbthx2.png"><img src="./t/blogino/images/dbthx3.png"> -->
</td>
</tr>
</table>
<br>
</div> <!-- .entry-content -->
<script type="text/javascript">
  $(window).load(function() {
  var tothetop = '<div id="send-to-top">'
        +'<a href="#wpcontent">Click me to go back to the top of the page</a>'
        +'</div>';
    $(tothetop).appendTo('#wpcontent').hide();
    var timeout = null;
    var contentEnd = $('.entry-content');
    var totop = $('#send-to-top');
    $(window).scroll(function () {
      var scrollTop = $(this).scrollTop();
	  
      if(!timeout) {
        timeout = setTimeout(function() {
          timeout = null;
          // Scroll to top banner
          if((scrollTop + ($(this).height()-50)) >= (contentEnd.offset().top + contentEnd.height())) {
            if(totop.is(':hidden')) { totop.show(200); }
          } else if(totop.is(':visible')) { totop.hide(); }
        }, 250);
      }
    });
    });
  
</script>

					</div>
				</div>
			</div>

				</div>
</div>

<div id="sidebar">
	<h4></h4><div class="menu-graphical-menu-container"><ul id="menu-graphical-menu" class="menu">

<?
if ($_SESSION['loginuser']!=null) {
	if ($obj->isadmin($_SESSION['loginuser'])==1) $te1= "admin " . $_SESSION['loginuser']; else $te1=$_SESSION['loginuser'];
$te2=$obj->getinform($_SESSION['loginuser']);
$abinfo= "You have " . $obj->info_howmany_friendships($_SESSION['loginuser']) . " friends and ". $obj->info_howmany_channel_following($_SESSION['loginuser']) . " channels following.";
$message_display = <<<MESSAGE_DISPLAY
		<div id="img1"><div id="slideload"></div></div>
		<b>
		<div class='expand'>
		<span class="collapsible">
		<li class="current" style="font-size: 20px;"><a href="">Welcome {$_SESSION['loginuser']}</a></li>
		</span>
		</div>
		</nobr>
		</b>
		<br>
MESSAGE_DISPLAY;
////echo ($message_display);
}
?>		
	
<?php
	if ($_SESSION['loginuser']==null) {
		$page = htmlspecialchars($_GET['page']);
		echo("<li"); if ($page=="contacts") echo(" class=\"current\""); echo("><a href=\"index.php?page=contacts\"><b>"); echo("<script type=\"text/javascript\"> if (language==\"en\") document.write(\"Contact us\"); else document.write(\"Kontakty\");</script>");  echo("</b></a></li>");
		echo("<li"); if ($page=="register") echo(" class=\"current\""); echo ("><a href=\"index.php?page=register\"><b>"); echo("<script type=\"text/javascript\"> if (language==\"en\") document.write(\"Register\"); else document.write(\"Registrovať\");</script>");  echo("</b></a></li>");
		echo("<li"); if ($page=="login") echo(" class=\"current\""); echo ("><a href=\"index.php?page=login\"><b>"); echo("<script type=\"text/javascript\"> if (language==\"en\") document.write(\"Login\"); else document.write(\"Prihlásiť\");</script>");  echo("</b></a></li>");
		echo("<li><br /></li><li"); if ($page=="intro") echo(" class=\"current\""); echo ("><a href=\"./doc/t/privacy.php\"><b>"); echo("<script type=\"text/javascript\"> if (language==\"en\") document.write(\"Help\"); else document.write(\"Pomoc\");</script>");  echo("</b></a></li>");
	} else {
		echo($message_display);
		$page = htmlspecialchars($_GET['page']);
		echo("<li"); if ($page=="contacts") echo(" class=\"current\""); echo("><a href=\"index.php?page=contacts\"><b><script type=\"text/javascript\">document.write(synapse_locale_print('ContactUs',language));</script></b></a></li>");
		echo("<li"); if ($page=="upload") echo(" class=\"current\""); echo("><a href=\"index.php?page=upload\"><b><script type=\"text/javascript\">document.write(synapse_locale_print('MediaManager',language));</script></b></a></li>");
		echo("<li"); if ($page=="settings") echo(" class=\"current\""); echo("><a href=\"index.php?page=settings\"><b><script type=\"text/javascript\">document.write(synapse_locale_print('Settings',language));</script></b></a></li>");
		echo("<li"); if ($page=="logout") echo(" class=\"current\""); echo("><a href=\"index.php?page=logout\"><b><script type=\"text/javascript\">document.write(synapse_locale_print('Logout',language));</script></b></a></li>");
	}
?>
</ul>
</div>

<h4>Timeline</h4><div class="menu-sitemap-container"><?php $obj->fill_calendar(0,0,0); ?></div>
<h4>List Channels</h4><?php echo($obj->display_channels()); ?>

<br />
<?php include_once("./synapse-cms/track.php"); ?>

<script type="text/javascript">
/* <![CDATA[ */
	var dropdown = document.getElementById("cat");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "http://xubuntu.org/?cat="+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>

</div>



<div id="wpfooter" class="group">
	<div id="footer-widgets">
		<div class="footer-widget"><h4>Get started</h4><div class="menu-graphical-menu-container"><ul id="menu-graphical-menu-1" class="menu"><li class="gm-get-xubuntu gm-menu menu-item menu-item-type-post_type menu-item-object-page menu-item-18"><a title="Get Xubuntu" href="index.php?page=register">Register</a></li>
<li class="gm-get-support gm-menu menu-item menu-item-type-post_type menu-item-object-page menu-item-17"><a title="Get Help &amp; Support" href="index.php?page=login">Login</a></li>
</ul></div></div>

<div class="footer-widget"><h4>Global Informations</h4><div class="menu-social-media-container"><ul id="menu-social-media" class="menu">
<li id="menu-item-700" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-700"><a href="#">Users <?php echo($obj->howmanyfriends()); ?></a></li>
<li id="menu-item-702" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-702"><a href="#">Channels <?php echo($obj->howmanychannels()); ?></a></li>
</ul></div></div>

<div class="footer-widget"><h4>Users Informations</h4><div class="menu-ubuntu-container"><ul id="menu-ubuntu" class="menu">
	<li id="menu-item-301" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-301"><a href="index.php?plugin=userslist">Registered Users</a></li>
	<li id="menu-item-24" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-24"><a href=""></a></li>
</ul></div></div>

<div class="footer-widget"><h4>This site</h4>			<div class="textwidget">
<p>© 2013 <a href="http://linuxaci.6f.sk/synapse-cms/t/">Synapse-CMS</a> by Lukas Veselovsky, All Rights Reserved.</p>
<p>
<a style="font-family: 'ubuntu'; color: gray;" href="./doc/t/help.php">Help</a>
    · <a href="./doc/t/privacy.php" target="_blank">Privacy</a>
	· <a href="./doc/t/terms.php" target="_blank">Terms</a></p>
</div>
		</div>	

<div class="footer-widget"><h4>
<p>
  <div id="search">
	<form id="searchform" method="post" action="index.php">
		<input type="hidden" name="search_usr" value="##ANY##">
		<input type="text" value="" name="search_input" id="s" size="20" placeholder="Search name or tag" required>
		<button type="submit" name="search_but" value="YES">Search</button>
	</form>
	<div class="textwidget">
  </div>
</p>
</h4>
</div>
</div>
		
</div>
</div>

</div><!-- #wpcontent -->

<center>
<br>
<br>
</center>

<div id="to-top"></div>

<script type="text/javascript">
<!--
var temp=mcrypt.list_algorithms();
var sel=document.main.crypt.childNodes;
for(var i=sel.length-1 ; i>=0 ; i--)
	if(sel[i].tagName == 'OPTION' && temp.indexOf(sel[i].value)==-1)
		sel[i].disabled=true;
temp=mcrypt.list_modes();
sel=document.main.mode.childNodes;
for(var i=sel.length-1 ; i>=0 ; i--)
	if(sel[i].tagName == 'OPTION' && temp.indexOf(sel[i].value)==-1)
		sel[i].disabled=true;

		
var data=<?php echo $data?>;


var setCrypt=function(){
	var cr=document.main.crypt.value;
	var mod=document.main.mode.value;
	
	data.iv=pad(data.iv,mcrypt.get_iv_size(cr,mod));
	
	document.main.key.value=data.key;
	document.main.hex_key.value=bin2hex(data.key);

	mcrypt.Crypt(null,null,null, data.key, document.main.crypt.value, document.main.mode.value);
	
	encrypt();
}

var encrypt=function(){
	document.main.iv.value=data.iv;
	document.main.hex_iv.value=bin2hex(data.iv);
	document.main.m.value=data.m;
	document.main.hex_m.value=bin2hex(data.m);
	data.c=mcrypt.Encrypt(data.m, data.iv);
	document.main.c.value=data.c;
	document.main.hex_c.value=bin2hex(data.c);
}

var decrypt=function(){
	document.main.c.value=data.c;
	document.main.hex_c.value=bin2hex(data.c);
	data.m=mcrypt.Decrypt(data.c, data.iv);
	document.main.m.value=data.m;
	document.main.hex_m.value=bin2hex(data.m);
}	


var hexdigits='0123456789ABCDEF';
var hexLookup=Array(256);
for(var i=0;i<256;i++)
	hexLookup[i]=hexdigits.indexOf(String.fromCharCode(i));
	
var bin2hex=function(str){
	var out='';
	for(var i=0;i<str.length;i++)
		out+=hexdigits[str.charCodeAt(i)>>4]+hexdigits[str.charCodeAt(i)&15]+' ';
	return out;
}

var hex2bin=function(str){
	var out='';
	var part=-1;
	for(var i=0;i<str.length;i++){
		var t=hexLookup[str.charCodeAt(i)]
		if(t>-1){
			if(part>-1){
				out+=String.fromCharCode(part|t);
				part=-1;
			}else
				part=t<<4;
		}
	}
	return out;
}

var pad=function(x,y){
	if(x.length>=y)
		return x.substr(0,y);
	for(var i=y-x.length;i;i--)
		x+=String.fromCharCode(Math.floor(Math.random()*256));
	return x;
}

setCrypt();
-->
</script>

</body></html>
