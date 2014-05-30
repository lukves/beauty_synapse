
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo($obj->synapse_title); ?></title>
</head>

<?php
$entry = <<<DISPLAY_MESSAGE
    <p></p>
	<img src="question-mark.png" />
	<p></p>
	<p></p>
<p><b>HOWTO SEND MESSAGE FROM YOUR SITE TO YOUR BOARD</b></p>
<p><a href="info-share.txt">link to example of -share message-</a></p>
<p></p>
<p></p>
<P><B>HOWTO POST MESSAGE FROM YOUR WEB PAGE TO OUR SOCIAL NETWORK?</B></P>
<p></p>
<p></p>
<form NAME="formular" action="http://www.linuxaci.6f.sk/synapse-cms/post-message.php" method="post" onsubmit="">
<p><input type="hidden" name="synapse-title" value="Message from Linuxaci.6f.sk test page"></p>
<p><input type="hidden" name="synapse-sendto" value="lukves"></p>
<p><textarea class="msgarea" name="synapse-bodytext"></textarea></p>
<p><input id="bcreate" type="submit" value="Send Message" /></p>
</form>
<p></p>
<p><a href="info-postmessage.txt">link to example of -post message-</a></p>
<p></p>
<p></p>
<P><B>HOWTO -BE FRIENDS- FROM YOUR WEB PAGE TO OUR SOCIAL NETWORK?</B></P>
<p></p>
<p></p>
<form NAME="formular" action="http://www.linuxaci.6f.sk/synapse-cms/be-friends.php" method="post" onsubmit="">
<p><input type="hidden" name="synapse-title" value="friendship"></p>
<p><input type="hidden" name="synapse-sendto" value="lukves"></p>
<p><input type="hidden" name="synapse-bodytext" value="I want be Your friend!"></p>
<p><input id="bcreate" type="submit" value="Be Friends" /></p>
</form>
<p></p>
<p><a href="info-befriends.txt">link to example of -be friends-</a></p>
<p></p>
<p></p>
DISPLAY_MESSAGE;

echo $entry;

?>