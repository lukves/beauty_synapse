	<?php
		// spustam sessions, velmi dolezite
		// ak nie si prihlaseny z predoslej stranky
		if(!isset($_SESSION['loginuser'])) {
		} else {
			$myuser = mysql_real_escape_string($_SESSION['loginuser']); 
	?>


<script type="text/javascript">
/* <![CDATA[ */
function addLoadEvent(func){var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func;}else{window.onload=function(){oldonload();func();}}}
/* ]]> */
</script>
<link rel='stylesheet' id='all-css-0' href='./synapse-cms/plugins/audioplayer/follow-widget.css' type='text/css' media='all' />

<script type='text/javascript'>
/* <![CDATA[ */
var LoggedOutFollow = {"invalid_email":"Your subscription did not succeed, please try again with a valid email address."};
/* ]]> */
</script>
<script type='text/javascript' src='http://s2.wp.com/_static/??/wp-includes/js/jquery/jquery.js,/wp-content/blog-plugins/loggedout-follow/widget.js,/wp-includes/js/comment-reply.js?m=1333391137j'></script>
<link rel='stylesheet' id='all-css-0' href='./synapse-cms/plugins/audioplayer/follow-style.css?m=1341918462g' type='text/css' media='all' />
<!--[if lt IE 8]>
<link rel='stylesheet' id='highlander-comments-ie7-css'  href='http://s0.wp.com/wp-content/mu-plugins/highlander-comments/style-ie7.css?m=1307172283g&#038;ver=20110606' type='text/css' media='all' />
<![endif]-->

<?php
	if ($_GET['mediafile']) if (file_exists($obj->upload_dir.$myuser."/".$_GET['mediafile'])) {
?>

	<div id="bit" class="loggedout-follow-normal">
		<a class="bsub" href="javascript:void(0)"><span id='bsub-text'>Play <?php echo($_GET['mediafile']); ?></span></a>
		<div id="bitsubscribe">
	
	  <h3><label for="loggedout-follow-field">Play <?php echo($_GET['mediafile']); ?></label></h3>
	  <div id="loggedout-follow">
	  <center>
	  <object type="application/x-shockwave-flash" data="./synapse-cms/plugins/audioplayer/zplayer.swf?mp3=<?php echo($obj->upload_dir.$myuser."/".$_GET['mediafile']); ?>&c1=ff0000" width="200" height="20"/><param name="movie" value="./synapse-cms/plugins/audioplayer/zplayer.swf?mp3=<?php echo($obj->upload_dir.$myuser."/".$_GET['mediafile']); ?>&c1=ff0000" /></object>
	  </center>
	  </div>
					<div id='bsub-credit'><a href="#">Powered by ZPlayer</a></div>
		</div><!-- #bitsubscribe -->
	</div><!-- #bit -->
<?php
	} else if ($_GET['mediafile']) if (file_exists($_GET['mediafile'])) {
?>

	<div id="bit" class="loggedout-follow-normal">
		<a class="bsub" href="javascript:void(0)"><span id='bsub-text'>Play <?php echo($_GET['mediafile']); ?></span></a>
		<div id="bitsubscribe">
	
	  <h3><label for="loggedout-follow-field">Play <?php echo($_GET['mediafile']); ?></label></h3>
	  <div id="loggedout-follow">
	  <center>
	  <object type="application/x-shockwave-flash" data="./synapse-cms/plugins/audioplayer/zplayer.swf?mp3=<?php echo($_GET['mediafile']); ?>&c1=ff0000" width="200" height="20"/><param name="movie" value="./synapse-cms/plugins/audioplayer/zplayer.swf?mp3=<?php echo($_GET['mediafile']); ?>&c1=ff0000" /></object>
	  </center>
	  </div>
					<div id='bsub-credit'><a href="#">Powered by ZPlayer</a></div>
		</div><!-- #bitsubscribe -->
	</div><!-- #bit -->
<?php
	}
?>



<?php 
} 
?>
