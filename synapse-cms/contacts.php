<?php $Web = $_SERVER['SERVER_NAME']; ?>

<ol>
<br><li
 class="            note
            reblog                            tumblelog_drumsofautumn                                    without_commentary        ">
<form NAME="formular" action="/synapse-cms/post-message.php" method="post" onsubmit="">
<input type="hidden" name="synapse-title" value="Message to <?php echo($usr); ?> at <?php echo($Web); ?>">
<input type="hidden" name="synapse-sendto" value="<?php echo($usr); ?>">
<textarea class="msgarea" name="synapse-bodytext">Hi <?php echo($usr); ?></textarea>
<input id="bcreate" type="submit" value="Send Message" />
</form>
</li>
<br>
<br>
<br>
<li
 class="            note
            reblog                            tumblelog_drumsofautumn                                    without_commentary        ">
<form NAME="formular" action="/synapse-cms/be-friends.php" method="post" onsubmit="">
<input type="hidden" name="synapse-title" value="friendship with <?php echo($usr); ?> at <?php echo($Web); ?>">
<input type="hidden" name="synapse-sendto" value="<?php echo($usr); ?>">
<input type="hidden" name="synapse-bodytext" value="I want be Your friend!">
<input id="bcreate" type="submit" value="Be Friends" />
</form>
</li>
</ol>
