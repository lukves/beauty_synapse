
<?php include_once('stage_init.php'); ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo($obj->synapse_title); ?></title>

	<link rel="stylesheet" type="text/css" href="./synapse-cms/css/fonts.css"/>

<style type="text/css">

.messagepanel {
	float: center;
	width: 99%;
/*		height: 82px;*/
	padding: 0.2em;
	margin: 0.2em;
/*	border: 1px dotted black; */
	color: black;
	background-color: #ebebeb; 
	background-image: url("themes/stripe_gray-large.gif");
	background-repeat:repeat;
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

/* Message Preview */

.messages {
	CLEAR: left; FONT-SIZE: 0px;  PADDING: 0.0em; MARGIN: 0.0em;
	WIDTH: inherit;
	/* border-bottom: 1px dotted black; */
	/*font-family: verdana, tahoma, arial, helvetica, sans-serif;*/
	font:300 13px/13px Ubuntu, sans-serif;
}
.messages LI {
	
	PADDING-BOTTOM: 5px; PADDING-TOP: 5px;  
	PADDING-LEFT: 5px; PADDING-RIGHT: 5px;
	
	DISPLAY: block;
	
	TEXT-ALIGN: left; TEXT-DECORATION: none;
	/*LIST-STYLE-TYPE: none;*/
	
	COLOR: black; 
	background-color: transparent;
}
/*
.messages LI A {
	
	DISPLAY: block; */
	/* FONT-SIZE: 11px;*/  
/*	COLOR: black; 
	TEXT-ALIGN: left; TEXT-DECORATION: none;
}
*/
.messages LI:hover {
	TEXT-ALIGN: left; TEXT-DECORATION: none;
	
	DISPLAY: block;
	
	color: black;
	background-color: #eeeeee;
	/*
	background: transparent url('themes/images/comment_bg.gif') repeat;
	background-size: 100% 100%;
	*/
	/* background-color: #eef; */
	/* border-bottom: 1px dotted black; */
	/* FONT-SIZE: 11px;*/
	/*PADDING-LEFT: 7px; */
}

</style>

</head>