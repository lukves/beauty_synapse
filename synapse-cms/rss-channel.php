<?php
/**
 * Synapse-CMS rss-channel
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
  
  header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
  header('Content-Type: text/xml; charset=utf-8');
  $dat1 = gmdate("D, d M Y H:i:s")." GMT";
$entry_display = <<<MESSAGE_DISPLAY
<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>{$obj->synapse_title}</title>
    <link>http://www.linuxaci.6f.sk/</link>
    <webMaster>lukves@gmail.com (Synapse-CMS admin)</webMaster>
    <category>social network, blog</category>
    <docs>http://www.linuxaci.6f.sk/rss</docs>
    <lastBuildDate>{$dat1}</lastBuildDate>
    <atom:link href="http://www.linuxaci.6f.sk/rss/" rel="self" type="application/rss+xml" />
    <image>
      <url>http://www.linuxaci.6f.sk/me-sketch.png</url>
      <title>{$obj->synapse_title}</title>
      <link>http://www.linuxaci.6f.sk</link>
    </image>
MESSAGE_DISPLAY;

    $obj->switch_data_table();
    $sql = "SELECT * FROM data ORDER BY created DESC LIMIT 2048";
    $res = mysql_query($sql);
    while($rec = mysql_fetch_array($res)) {
		$usr=htmlspecialchars($rec["username"]);
		if ($_GET['user']) {
			if ($_GET['user']==$usr) {
				if (htmlspecialchars($rec['sendto'])=="##ALLUSERS##")	{
					$dat2=gmdate("D, d M Y H:i:s", $rec["created"])." GMT";
					$bd=htmlspecialchars($rec["bodytext"]); 
					$entry_display .= <<<MESSAGE_DISPLAY
						<item>
						<title>{$rec["title"]}</title>
						<link>message.php?created={$rec["created"]}</link>
						<guid>message.php?created={$rec["created"]}</guid>
						<description>{$bd}</description>
						<pubDate>{$dat2}</pubDate>
						</item>
MESSAGE_DISPLAY;
				}
			} 
		} else
		if ($obj->isvisible($rec["username"])==1)
		{
			$dat2=gmdate("D, d M Y H:i:s", $rec["created"])." GMT";
			$bd=htmlspecialchars($rec["bodytext"]); 
				$entry_display .= <<<MESSAGE_DISPLAY
				<item>
				<title>{$rec["title"]}</title>
				<link>message.php?created={$rec["created"]}</link>
				<guid>message.php?created={$rec["created"]}</guid>
				<description>{$bd}</description>
				<pubDate>{$dat2}</pubDate>
				</item>
MESSAGE_DISPLAY;
		}
    }
    $entry_display .= "</channel></rss>";
    echo($entry_display);
?>
