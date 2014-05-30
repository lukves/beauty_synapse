<?php 

/**
 * Synapse-CMS  template MOBI - fork of another my template
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
	<link rel="stylesheet" type="text/css" href="./synapse-cms/css/defaults-pager.css">
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
    height: 2px; 
    background-image: url(<?php echo($testpag); ?>/img/footer_bg3.jpg); 
    background-repeat: repeat-x;
}
#to-top a {
    color: white;
    font-weight: bold;
}
}

.messagepanel {
	float: center;
	width: 50%;
	min-width: 600px;
	padding: 0.4em 0.4em 0.4em 0.4em;
	/* margin: 0.4em;*/
	border: 2px solid black;
	color: black;
	
	background-color: #ebebeb; 
	background-image: url("<?php echo($testpag); ?>/layout/bg.png");
	background-repeat:repeat; 
	
	opacity:0.6;
	filter:alpha(opacity=60); /* For IE8 and earlier */

	/*
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	*/

color:#333;
	text-decoration:none;
	background-color:#fff;
		background-image:linear-gradient(#fff,#d5d8da);
	-ms-filter:"progid:DXImageTransform.Microsoft.gradient(enabled=false)";
	border-color:#e1e8ed
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

<link rel="stylesheet" type="text/css" href="./synapse-cms/css/menu_style4.css">

  <style type="text/css">
body {
	background-image: url(/t/mobi/img/dots.png);
	background-repeat: repeat;
	background-color: #FFFFFF;
	background-attachment:fixed;
	background-position: top left;
	filter: alpha(opacity=90); -moz-opacity: 0.9; opacity: 0.9;
	bottom: 0px;
	left: 0px;
	max-height: 1080px;
	right: 0px;
	top: 0px;
	}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
}
.style3 {color: #B00101; font-weight: bold; }
a:link {
	color: #B00101;
	text-decoration: none;
}
a:visited {
	color: #B00101;
	text-decoration: none;
}
a:hover {
	color: #3C0000;
	text-decoration: none;
}
a:active {
	color: #3C0000;
	text-decoration: none;
}
.style4 {color: #999999}
.style5 {color: #000000}

div.expand span.collapsible { display : none; }
div.expand:hover span.collapsible { display : inline; }

DIV#main {
	/*
	BORDER-TOP: #000000 4px solid;
	background-image: url("");
	background-repeat:repeat;
	background-color: #fff;
	*/
	position: relative;
}

DIV#footer {
	height: 400px;
	
	color: #000;
}

.messages UL {
list-style: none outside none;
    list-style-type: none;
    list-style-image: none;
    list-style-position: outside;
	
	width: 100%;
	max-width: 1280px;
}

.messages LI {
/*	
	margin-top:5px;
	margin-bottom:5px;
*/	
	
	padding-top:10px;
	padding-bottom:10px;
	
	padding-left:10px;
	padding-right:10px;
	
color:#333;
	text-decoration:none;
	background-color:#transparent;
		
	-ms-filter:"progid:DXImageTransform.Microsoft.gradient(enabled=false)";
	border-color:#e1e8ed;
	
	
	border: 1px solid #e1e8ed;
	}

.messages LI:hover {
color:#333;
	text-decoration:none;
	background-color:#fff;
		background-image:linear-gradient(#fff,#d5d8da);
	-ms-filter:"progid:DXImageTransform.Microsoft.gradient(enabled=false)";
	border-color:#e1e8ed
}

.messages LI:active {
color:#333;
	background:#e1e8ed;
	border-color:#ccc;
	box-shadow:inset 0 1px 4px rgba(0,0,0,0.2)
}

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

.topbar {
    /* border-bottom: 1px solid rgba(0, 0, 0, 0.05); */
	border-bottom: 2px solid #e1e8ed;
    position: fixed;
    top: 0px;
	right: 0px;
    left: 0px;  
	z-index: 1000;
	align: center;
	margin: 0 auto;
}

.topbarline {
	position: fixed;
    top: 43px;
	right: 0px;
    left: 0px;  
	z-index: 1000;
	align: center;
	margin: 0 auto;
	
	/* true color footer to topbar */
	background-color:#e1e8ed;
	background-image: url(./t/mobi/img/footer_bg.png);
	background-repeat: repeat-x;
	
	height: 1px;
}

.downbar {
    /* border-bottom: 1px solid rgba(0, 0, 0, 0.05); */
	border-top: 2px solid #e1e8ed;
    position: fixed;
    bottom: 0px;
	right: 0px;
    left: 0px;  
	z-index: 1000;
	align: center;
	margin: 0 auto;
}

.global-nav {
    border-bottom: 1px solid rgba(0, 0, 0, 0.15);
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: rgba(0, 0, 0, 0.15);
    height: 38px;
    position: relative;
    width: 100%;
}
.global-nav-inner {
    background: none repeat scroll 0% 0% rgb(255, 255, 255);
    height: 38px;
    	background-image:linear-gradient(#fff,#d5d8da);
	-ms-filter:"progid:DXImageTransform.Microsoft.gradient(enabled=false)";
	border-color:#e1e8ed
}

.prefpanel {
	width: 140px;
	float: center;
	/* border: 2px solid #dd3300; */
	color: black;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}


/*---------- Wrapper --------------------*/

nav {
	padding-left: 5px;
}

ul {
	text-align: center;
}

ul li {
	font: 13px Verdana, 'Lucida Grande';
	cursor: pointer;
	-webkit-transition: padding .05s linear;
	-moz-transition: padding .05s linear;
	-ms-transition: padding .05s linear;
	-o-transition: padding .05s linear;
	transition: padding .05s linear;
}
ul li.drop {
	position: relative;
}
ul > li {
	display: inline-block;
}
ul li a {
	line-height: 20px;
	/*	
	padding: 0 20px;
	height: 80px;
	color: #777;
	*/
	-webkit-transition: all .1s ease-out;
	-moz-transition: all .1s ease-out;
	-ms-transition: all .1s ease-out;
	-o-transition: all .1s ease-out;
	transition: all .1s ease-out;
}
ul li a:hover {
	color: #eee;
}

.dropOut .triangle {
	width: 0;
	height: 0;
	position: absolute;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-bottom: 8px solid white;
	top: -8px;
	left: 50%;
	margin-left: -8px;
}
.dropdownContain {
	width: 160px;
	position: absolute;
	z-index: 2;
	left: 50%;
	margin-left: -20px; /* half of width */
	top: -400px;
}
.dropOut {
	width: 160px;
	background: white;
	float: left;
	position: relative;
	margin-top: 0px;
	opacity: 0;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: 0 1px 6px rgba(0,0,0,.15);
	-moz-box-shadow: 0 1px 6px rgba(0,0,0,.15);
	box-shadow: 0 1px 6px rgba(0,0,0,.15);
	-webkit-transition: all .1s ease-out;
	-moz-transition: all .1s ease-out;
	-ms-transition: all .1s ease-out;
	-o-transition: all .1s ease-out;
	transition: all .1s ease-out;
}

.dropOut ul {
	float: left;
	padding: 10px 0;
}
.dropOut ul li {
	text-align: left;
	float: left;
	width: 125px;
	padding: 12px 0 10px 15px;
	margin: 0px 10px;
	color: #777;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-transition: background .1s ease-out;
	-moz-transition: background .1s ease-out;
	-ms-transition: background .1s ease-out;
	-o-transition: background .1s ease-out;
	transition: background .1s ease-out;
}

.dropOut ul li:hover {
	background: #f6f6f6;
}

ul li:hover a { color: white; }
ul li:hover .dropdownContain { top: 65px; }
ul li:hover .underline { border-bottom-color: #777; }
ul li:hover .dropOut { opacity: 1; margin-top: 8px; }
</style>


</head>
<body onload="document.getElementById('img1').style.display='none';  document.getElementById('captcha-form').focus();" style="margin-top: 0; padding-top:0;" >
<div align="center">
<div class="topbar" style="max-width: 1280px;">
<div class="global-nav">
<div class="global-nav-inner" style="padding-top: 5px;">

<?php
if ($_SESSION['loginuser']!=null) {
  if ($obj->isadmin($_SESSION['loginuser'])==1) $te1= "admin " . $_SESSION['loginuser']; else $te1=$_SESSION['loginuser'];
$te2=$obj->getinform($_SESSION['loginuser']);
$abinfo= "You have " . $obj->info_howmany_friendships($_SESSION['loginuser']) . " friends and ". $obj->info_howmany_channel_following($_SESSION['loginuser']) . " channels following.";
//$datum = StrFTime("%d/%m/%Y %H:%M:%S", $obj->userlasttime());
$date = StrFTime("%Y-%m-%d %H:%M", $obj->userlasttime());   // "2009-03-04 17:45";
$result = $obj->nicetime($date);
$message_display = <<<MESSAGE_DISPLAY
		<center>
		<!--div class='expand'!-->
MESSAGE_DISPLAY;
		// index.php?page=findfriends 
$message_display .= <<<MESSAGE_DISPLAY
		<div style="float:left;">

		<b>
		<nav>
		<ul>
			<li class="drop">
				<a href="index.php" title="tvoj blog, tvoji priatelia"><img src="/me-sketch.png" style="padding-left: 6px; width: 34px; height: 34px;"></a> 
				<div class="dropdownContain">
					<div class="dropOut">
						<div class="triangle"></div>
						<ul>
							<li>Blogino je socialná sieť ako každá iná. Jej špecifickosť je v tom, že po zaregistrovaní máš automatický vygenerovaný vlastný blog a je určená pre mobilné zariadenia.</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>
		</nav>
		</b>
		</div>
		<div style="float:right;">
		<ul class="menu5">
		<div class="preload17a">
		</div>			
			<li><a  style="font-family: 'Ubuntu';" href="./blog.php?user={$_SESSION['loginuser']}" title="Share your messages with your friends within blog site."><b>Profile</b></a></li>
			<li><a  style="font-family: 'Ubuntu';" href="index.php?page=usersmanagement" title="Find your new friend, or break friendship."><b>My Friends</b></a></li>
			<li><a  style="font-family: 'Ubuntu';" href="index.php?page=upload" title="Upload a photo and share it with your friends."><b>My Photos</b></a></li>
			<li><a  style="font-family: 'Ubuntu';" href="index.php?plugin=audioplayer" title="Upload a music and listen it."><b>My Playlist</b></a></li>
			<li><a  style="font-family: 'Ubuntu';" href="index.php?page=bookmarks" title="Save favourite messages on one place."><b>My Bookmarks</b></a></li>
			<!--<li><a  style="font-family: 'Ubuntu';" href="index.php?page=timeline" title="Preview only title of messages witthout their bodies."><b>My Timeline</b></a></li>-->
			<li><a  style="font-family: 'Ubuntu';" href="index.php?page=messages" title="At this place you can read messages, share it and enjoy with friends with news."><b>Messages</b></a></li>
			<li><a  style="font-family: 'Ubuntu';" href="index.php?page=settings" title="This are your settings."><b>Settings</b></a></li>
			<li class="current"><a  style="font-family: 'Ubuntu';" href="index.php?page=logout" title="Logout from Your account."><b>Logout</b></a></li>
		</ul>
		</div>	
		</center>
MESSAGE_DISPLAY;
} else {
$te1=$obj->synapse_title;
$message_display = <<<MESSAGE_DISPLAY
	<div style="float:left;">
	<b>
		<nav>
		<ul>
			<li class="drop">
				<a href="index.php" title="tvoj blog, tvoji priatelia"><img src="/me-sketch.png" style="padding-left: 6px; width: 34px; height: 34px;"></a> 
				<div class="dropdownContain">
					<div class="dropOut">
						<div class="triangle"></div>
						<ul>
							<li>Blogino je socialná sieť ako každá iná. Jej špecifickosť je v tom, že po zaregistrovaní máš automatický vygenerovaný vlastný blog a je určená pre mobilné zariadenia.</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>
		</nav>
		</b>
	</div>
	<div style="float:right;">
		<ul class="menu5">
		<div class="preload17a">
		</div>			
		<li><a href="index.php?page=register"><b>Register</b></a></li>
		<li><a href="index.php?page=login"><b>Login</b></a></li>
		</ul>
	</div>
MESSAGE_DISPLAY;
}
echo ($message_display);
?>

</div>
</div>
</div>
<div class="topbarline"></div>
</div>

<div id="main" align="center" style="margin-top: -10px;">
<div style="max-width: 1280px; margin-top: 120px;">

<?php $obj->admin_interface($_POST); ?>	

<?php			
			// This is very IMPORTANT PART, in this part is main core of preview messages..
			// use only after initialize a stage_init.

			$obj->preview_type=99;
			
			include('./synapse-cms/stage_run.php');
?>


<br/>
<br/>


<!-- FOOTER !-->
<div id="footer">
	<img id="img1" src="./synapse-cms/themes/images/interface/loading.gif">
<br />
<center>
<a href="index.php?background=background_light.png">Dark background</a> &nbsp &nbsp <a href="index.php?background=background.png">Light background</a>
</center>
<br />
<br />
<form method="post" action=""> 
 <div class="prefpanel">
 		<div class='expand'>
		
		<input type="submit" style="border: 0; background: transparent;" name="task" value="Timeline >" tabindex="202">
		<span class="collapsible">
 <?php
	$time_to_handle_for_next_month_conversion = time();

    // Date Conversions
    
    $interpretted_day = date('d', $time_to_handle_for_next_month_conversion);
    $interpretted_month = date('F', $time_to_handle_for_next_month_conversion);
    $interpretted_month_lowercased = strtolower($interpretted_month);
    $interpretted_year = date('Y', $time_to_handle_for_next_month_conversion);

	var_dump($interpretted_day);
	var_dump($interpretted_month);
	var_dump($interpretted_year);


	switch ($interpretted_month)
	{
		case "January":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-01-{$interpretted_year}&timeline2=30-01-{$interpretted_year}">January {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="January") break;
		case "February":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-02-{$interpretted_year}&timeline2=30-02-{$interpretted_year}">February {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="February") break;
		case "March":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-03-{$interpretted_year}&timeline2=30-03-{$interpretted_year}">March {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="March") break;
		case "April":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-04-{$interpretted_year}&timeline2=30-04-{$interpretted_year}">April {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="April") break;
		case "May":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-05-{$interpretted_year}&timeline2=30-05-{$interpretted_year}">May {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="May") break;
		case "June":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-06-{$interpretted_year}&timeline2=30-06-{$interpretted_year}">June {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="June") break;
		case "July":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-07-{$interpretted_year}&timeline2=30-07-{$interpretted_year}">July {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="July") break;
		case "August":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-08-{$interpretted_year}&timeline2=30-08-{$interpretted_year}">August {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="August") break;
		case "September":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-09-{$interpretted_year}&timeline2=30-09-{$interpretted_year}">September {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="September") break;
		case "October":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-10-{$interpretted_year}&timeline2=30-10-{$interpretted_year}">October {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="October") break;
		case "November":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-11-{$interpretted_year}&timeline2=30-11-{$interpretted_year}">November {$interpretted_year}</a> <br />
DISPLAY;
			if ($interpretted_month=="November") break;
		case "December":
			echo $display_item = <<<DISPLAY
				<a href="index.php?timeline1=01-12-{$interpretted_year}&timeline2=30-12-{$interpretted_year}">December {$interpretted_year}</a> <br />
DISPLAY;
			// if ($interpretted_month=="December") break;
		break;
	}
	
	$interpretted_year=$interpretted_year-1;
	echo $display_item = <<<DISPLAY
		<a href="index.php?timeline1=01-01-{$interpretted_year}&timeline2=30-01-{$interpretted_year}">January {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-02-{$interpretted_year}&timeline2=30-02-{$interpretted_year}">February {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-03-{$interpretted_year}&timeline2=30-03-{$interpretted_year}">March {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-04-{$interpretted_year}&timeline2=30-04-{$interpretted_year}">April {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-05-{$interpretted_year}&timeline2=30-05-{$interpretted_year}">May {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-06-{$interpretted_year}&timeline2=30-06-{$interpretted_year}">June {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-07-{$interpretted_year}&timeline2=30-07-{$interpretted_year}">July {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-08-{$interpretted_year}&timeline2=30-08-{$interpretted_year}">August {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-09-{$interpretted_year}&timeline2=30-09-{$interpretted_year}">September {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-10-{$interpretted_year}&timeline2=30-10-{$interpretted_year}">October {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-11-{$interpretted_year}&timeline2=30-11-{$interpretted_year}">November {$interpretted_year}</a> <br />
		<a href="index.php?timeline1=01-12-{$interpretted_year}&timeline2=30-12-{$interpretted_year}">December {$interpretted_year}</a> <br />
DISPLAY;
  ?>

</span>
	</div>
	</div>
</form>

<br />
<a href="#">Users <?php echo($obj->howmanyfriends()); ?></a><br />
<a href="#">Channels <?php echo($obj->howmanychannels()); ?></a><br />
<br />
<p>
<a style="font-family: 'ubuntu'; color: gray;" href="./doc/t/donate.php">Donate</a>
	· <a href="./doc/t/help.php" target="_blank">Help</a>
    · <a href="./doc/t/privacy.php" target="_blank">Privacy</a>
	· <a href="./doc/t/terms.php" target="_blank">Terms</a></p>
<span class="style4">Blogino vytvoril a spravuje Lukáš Veselovský.<br>
      </span>	
	</td>
	</tr>
  </tbody>
</table>
</div>
</div>
</div>

<?php
if ($obj->preview_footer==2) {
if ($_SESSION['loginuser']!=null) 
	if ($_SESSION['loginuser']) {
?>
<form  NAME="formular" action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="bbstyle(-1,0)">
<div align="center">
<div class="downbar" style="max-width: 1280px;">
<div class="global-nav" style="height: 46px;">
<div class="global-nav-inner" style="height: 46px;">

<?php
$myuser = mysql_real_escape_string($_SESSION['loginuser']);
$message_display = <<<MESSAGE_DISPLAY
	<div style="float:left;">
		Title:
	</div>
	<div style="float:left;">
		<textarea class="myTextEditor" name="msg_title" id="msg_title" maxlength="40" style="height:20px;"></textarea>
	</div>
	<div style="float:left;">
		Message:
	</div>
	<div style="float:left;">
		<textarea class="myTextEditor" name="textak" id="text0" maxlength="250" style="width: 350px; height:20px;" title="[url=HTTP://]URL_NAME[/url] , [img]URL_TO_IMAGE[/img] , [iframe]URL_TO_YOUTUBE_VIDEO[/iframe] , [b][/b] , [i][/i] , [u][/u] , [br][/br]"></textarea>
	</div>
	<div style="float:right;">
	{$obj->fill_formopt("")}
	</div>
	<div style="float:right;">
		<input id="create-message" style="width: 150px;" type="submit" value="Create Message" />
	</div>
MESSAGE_DISPLAY;
echo ($message_display);
?>

</div>
</div>
</div>
</div>
</form>
<?php } 
}
?>

<div id="to-top"></div>
</body>
</html>
