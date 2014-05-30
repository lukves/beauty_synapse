<?php

/**
 * Synapse-CMS stage_init
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

    session_start();

    if (strnatcmp(phpversion(),'5.4.11') >= 0) 
    { 
	// equal or newer 
    } 
    else 
    { 
        // not sufficiant 	
	//session_register("refreshid");
	
	session_register("loginuser");
	session_register("pageid");
	session_register("viewpage");
	session_register("zeroview");
    } 
  
  if(!isset($_SESSION["loginuser"])) $_SESSION["loginuser"]=null;
  if(!isset($_SESSION['pageid'])) $_SESSION['pageid']=1;
  //if(!isset($_SESSION['zeroview'])) 
  $_SESSION['zeroview']=0;
  if(!isset($_SESSION['viewpage'])) $_SESSION['viewpage']="##ALLFRIENDS##";
  
  //include_once('plugins.php');
  
  
  // Init Synapse-CMS class
  if (file_exists(dirname(__FILE__).'/synapsecms.php')) include_once(dirname(__FILE__).'/synapsecms.php'); else
  	if (file_exists('./synapse-cms/synapsecms.php')) include_once('./synapse-cms/synapsecms.php'); else
		if (file_exists('synapsecms.php')) include_once('synapsecms.php');

  $obj = new Synapse();
  
  // load config with db parameters :: 1) first find local config after search in synapse folder..
  if (file_exists('config.php')) include("config.php"); else
	if (file_exists(dirname(__FILE__).'/config.php')) include(dirname(__FILE__).'/config.php'); else
		if (file_exists('./synapse-cms/config.php')) include("./synapse-cms/config.php"); else
			if (file_exists('./config.php')) include("./config.php"); else
				if (file_exists('/config.php')) include("/config.php"); else
					if (file_exists('../config.php')) include("../config.php");
	
  $obj->connect_db();

?>

