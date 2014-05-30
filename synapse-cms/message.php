
<?php 
	//echo(dirname(__FILE__).'/header.php');
	include(dirname(__FILE__).'/header.php'); 
?>

 <title>Synapse-CMS: Link to Message</title>
 </head>

<style type="text/css">
	span {color: #777777;}
	span.desc {color: #BBBBBB;}
	span.example {color: #555555;}
	img.noborder {display: inline; vertical-align: middle; border: 0;}
	a:link {color:#AAAAAA;}
	a:visited {color:#AAAAAA;}
	a:active {color:#AAAAAA;}	
	a:hover {color:#888888;}


textarea, .msgarea
{
	width: 500px;
	height: 150px;
	font-size: 10pt;
}
	
textarea, .bginput
{
	width: 100px;
	font-size: 10pt;
}
.bginput option, .bginput optgroup
{
	font-size: 10pt;
}
.button
{
	font-size: 11px;
}
select
{
	font-size: 11px;
}
option, optgroup
{
	font-size: 11px;
}
.time
{
	color: #333333;
}

.menu {
	CLEAR: left; FONT-SIZE: 0px;  PADDING: 7px; MARGIN: 0.0em;
	WIDTH: 80%;
	/* border-bottom: 1px dotted black; */
	font-family: verdana, tahoma, arial, helvetica, sans-serif;
}
.menu LI {
	LIST-STYLE-TYPE: none;
}
.menu LI A {
	PADDING-RIGHT: 5px; PADDING-LEFT: 5px; PADDING-BOTTOM: 5px; PADDING-TOP: 5px; MARGIN: 0px 0px; 
	DISPLAY: block;  FONT-SIZE: 11px;  
	COLOR: black; 
	TEXT-ALIGN: left; TEXT-DECORATION: none;
  
  border: 1px solid rgba(0,0,0,.12);
  position: relative;
  top: 5px;
  -moz-box-shadow:       0 1px 0px rgba(255,255,255,.4);
  -webkit-box-shadow:    0 1px 0px rgba(255,255,255,.4);
  box-shadow:            0 1px 0px rgba(255,255,255,.4); 
  -moz-border-radius:    3px;
  -webkit-border-radius: 3px;
  border-radius:         3px; 
}

.menu LI A:hover {
	COLOR: black;
	BACKGROUND-COLOR: transparent;
	background: rgba(0,0,0,.1);
	FONT-SIZE: 12px;
}

.themepanel {
	float: right;
	width: 130px;
	padding: 0.1em;
	margin: 0.1em;
/*	border-bottom: 1px dotted black; */
	color: black;
/*	background-color: #ebebeb; */
}

.messagepanel {
  float: center;
  display: inline-block;
  width: 100%;
  font-size: .75em;
  text-shadow: 0 1px 0px rgba(255,255,255,.3);  
  background: rgba(0,0,0,.1);
  border: 1px solid rgba(0,0,0,.12);
  padding: 8px 8px;
  margin: 5px 5px 5px 5px;
  position: relative;
  top: 5px;
  -moz-box-shadow:       0 1px 0px rgba(255,255,255,.4);
  -webkit-box-shadow:    0 1px 0px rgba(255,255,255,.4);
  box-shadow:            0 1px 0px rgba(255,255,255,.4); 
  -moz-border-radius:    3px;
  -webkit-border-radius: 3px;
  border-radius:         3px; 
}

.hehe { font-size: 40px; margin: 0 0 10px 0; color: #000080; }


#menu-bar{
    background-color: #DFDFDF;
    background-image: url("images/menu-background.png");
    background-repeat: repeat-x;
    text-align: center;
}

#menu-bar table {
    height: 25px;
    max-width: 900px;
    width: expression(document.body.clientWidth > 900 ? "900px" : true);
    border-left: 1px solid #B6B6B6;
}

#menu-bar td {
    font-family: Verdana;
    font-size: 11px;
    font-weight: bold;
    text-align: center;
    width: 14%;
    border-right: 1px solid #B6B6B6;
    cursor: pointer;
}

#menu-bar td:hover {
    background-image: url("images/menu-background-highlight.png");
    background-repeat: repeat-x;
    background-color: transparent;
}

#menu-bar a, #menu-bar a:visited {
    display: block;
    color: #606060;
    text-decoration: none;
    margin: 2px 0 0 0;
    border: 0px;
}

#menu-bar a:hover {
    background-color: transparent;
}

.next-prev {
	float: right;
}
.prev-page {
}
.next-page {
}
.back-more {
	text-align: center;
	padding: 10px;
}
.discussion {
	/*padding-left: 20px;*/
	font-size: 1.05em;
}

.nobig {
	font-size: 1em;
}

.nopad {
	padding-left: 16px;
}

.discussion h2 {
	color: #000;
	font-family: Arial;
	font-size: 14px;
	margin: 10px 0;
}
.discussion label {
	display: block;
	color: #000;
}
.discussion .text {
	display: block;
	width: 200px;
	border: 1px solid #7b9ebd;
}
.discussion textarea {
	display: block;
	width: 100%;
	height: 160px;
	border: 1px solid #7b9ebd;
}

.nopad textarea {
	height: 100px;
}

.discussion .toolbar {
    background-color: #7b9ebd;
    padding: 2px;
}

.discussion .toolbar input, .discussion .toolbar button {
    border: none;
}

.discussion .toolbar button {
    height: 18px;
    padding-bottom: 3px;
    margin-right: 2px;
}

.discussion .toolbar span {
    font-size: 12px;
}

.discussion .reply textarea {
	width: 400px;
	height: 100px;
	border: 1px solid #7b9ebd;
}

.discussion .reply .toolbar {
	width: 398px;
	text-align: left;
}

.discussion .button {
	display: block;
	float: left;
	width: 115px;
	height: 24px;
	background: url(/pics/i-button2.gif) no-repeat left top;
	border: 0;
	font-size: 11px;
	font-family: Arial;
	padding: 5px 10px;
	margin: 5px 0;
}

.discussion .reply .button {
	float: right;
}

.discussion .reply form {
    padding-top: 5px;
    height: 160px;
}

#result { border: 1px solid green; width: 300px; margin: 0 0 35px 0; padding: 10px 20px; font-weight: bold; }
#change-image { font-size: 0.8em; }

	/* Clearfix hack I love you */
.clearfix:after {
  content:".";
  display:block;
  height:0;
  clear:both;
  visibility:hidden;
}

.clearfix {display:inline-block;}
/* Hide from IE Mac \*/
.clearfix {display:block;}
/* End hide from IE Mac */

.page_of {
  display: inline-block;
  width: auto;
  font-size: .75em;
  text-shadow: 0 1px 0px rgba(255,255,255,.3);  
  background: rgba(0,0,0,.1);
  border: 1px solid rgba(0,0,0,.12);
  padding: 8px 10px;
  margin: 0 14px 0 0;
  position: relative;
  top: 5px;
  -moz-box-shadow:       0 1px 0px rgba(255,255,255,.4);
  -webkit-box-shadow:    0 1px 0px rgba(255,255,255,.4);
  box-shadow:            0 1px 0px rgba(255,255,255,.4); 
  -moz-border-radius:    3px;
  -webkit-border-radius: 3px;
  border-radius:         3px;   
}

.page_of strong{
  display: inline;
  font-weight: normal;
}



/* ==============================================================
	Twitter
   ============================================================== */

.tweet {
	overflow:			auto;
}
.tweet .avatar {
	float:				left;
	width:				48px;
	height: 			48px;
	margin: 			3px;
	padding:			1px;
	border: 			1px solid #CCC;
	outline: 			#EFEFEF solid 2px
}
.tweet .bubble {
	float:				left;
	position:			relative;
	margin:				7px -1px 0;
}
.tweet .text {
	float:				left;
	border:				1px solid #d7d59a;
	width:				750px;
	background-color:	#FEFDDF;
	margin:				3px 3px 3px 0px;
	padding:			5px 5px 5px 10px;
	-moz-border-radius:	4px;
	-webkit-border-radius: 4px;
	font-size: 			15px;
	font-weight: 		bold;
	font-family: 		"Trebuchet MS";
}
.tweet .text span {
	font-family: 		Verdana; 
	font-size:			10px;
	font-weight: 		normal;
}

</style>
 <body style="background-image: url(); background-color: rgb(200, 200, 200); color: rgb(0, 0, 0);" alink="#ee0000" link="#0000ee" vlink="#551a8b">
	<center>
	<?php
		$crea = htmlspecialchars($_GET['created']);
		
		if(isset($crea)) { $obj->preview_type = 1; echo($obj->get_message($crea)); } else echo("Failed to load message.....");
	?>
	</center>
  </body>

</html>