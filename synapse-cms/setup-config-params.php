<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Synapse-CMS › Config missing</title>
	<style type="text/css">
		html {
			background: #f9f9f9;
			background: url("/synapse-cms/themes/images/background.gif") repeat;
		}
		body {
			background: #fff;
			color: #333;
			font-family: sans-serif;
			margin: 2em auto;
			padding: 1em 2em;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			border: 1px solid #dfdfdf;
			max-width: 700px;
		}
		h1 {
			border-bottom: 1px solid #dadada;
			clear: both;
			color: #666;
			font: 24px Georgia, "Times New Roman", Times, serif;
			margin: 30px 0 0 0;
			padding: 0;
			padding-bottom: 7px;
		}
		#error-page {
			margin-top: 50px;
		}
		#error-page p {
			font-size: 14px;
			line-height: 1.5;
			margin: 25px 0 20px;
		}
		#error-page code {
			font-family: Consolas, Monaco, monospace;
		}
		ul li {
			margin-bottom: 10px;
			font-size: 14px ;
		}
		a {
			color: #21759B;
			text-decoration: none;
		}
		a:hover {
			color: #D54E21;
		}
		.button {
			display: inline-block;
			text-decoration: none;
			font-size: 14px;
			line-height: 23px;
			height: 24px;
			margin: 0;
			padding: 0 10px 1px;
			cursor: pointer;
			border-width: 1px;
			border-style: solid;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			white-space: nowrap;
			-webkit-box-sizing: border-box;
			-moz-box-sizing:    border-box;
			box-sizing:         border-box;
			background: #f3f3f3;
			background-image: -webkit-gradient(linear, left top, left bottom, from(#fefefe), to(#f4f4f4));
			background-image: -webkit-linear-gradient(top, #fefefe, #f4f4f4);
			background-image:    -moz-linear-gradient(top, #fefefe, #f4f4f4);
			background-image:      -o-linear-gradient(top, #fefefe, #f4f4f4);
			background-image:   linear-gradient(to bottom, #fefefe, #f4f4f4);
			border-color: #bbb;
		 	color: #333;
			text-shadow: 0 1px 0 #fff;
		}

		.button.button-large {
			height: 29px;
			line-height: 28px;
			padding: 0 12px;
		}

		.button:hover,
		.button:focus {
			background: #f3f3f3;
			background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#f3f3f3));
			background-image: -webkit-linear-gradient(top, #fff, #f3f3f3);
			background-image:    -moz-linear-gradient(top, #fff, #f3f3f3);
			background-image:     -ms-linear-gradient(top, #fff, #f3f3f3);
			background-image:      -o-linear-gradient(top, #fff, #f3f3f3);
			background-image:   linear-gradient(to bottom, #fff, #f3f3f3);
			border-color: #999;
			color: #222;
		}

		.button:focus  {
			-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.2);
			box-shadow: 1px 1px 1px rgba(0,0,0,.2);
		}

		.button:active {
			outline: none;
			background: #eee;
			background-image: -webkit-gradient(linear, left top, left bottom, from(#f4f4f4), to(#fefefe));
			background-image: -webkit-linear-gradient(top, #f4f4f4, #fefefe);
			background-image:    -moz-linear-gradient(top, #f4f4f4, #fefefe);
			background-image:     -ms-linear-gradient(top, #f4f4f4, #fefefe);
			background-image:      -o-linear-gradient(top, #f4f4f4, #fefefe);
			background-image:   linear-gradient(to bottom, #f4f4f4, #fefefe);
			border-color: #999;
			color: #333;
			text-shadow: 0 -1px 0 #fff;
			-webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
		 	box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
		}
		
		textarea {
			border: 1px solid #dfdfdf;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			font-family: sans-serif;
			width:  695px;
		}

		
.form-table {
	border-collapse: collapse;
	margin-top: 1em;
	width: 100%;
}

.form-table td {
	margin-bottom: 9px;
	padding: 10px 20px 10px 0;
	border-bottom: 8px solid #fff;
	font-size: 14px;
	vertical-align: top
}

.form-table th {
	font-size: 14px;
	text-align: left;
	padding: 16px 20px 10px 0;
	border-bottom: 8px solid #fff;
	width: 140px;
	vertical-align: top;
}

.form-table code {
	line-height: 18px;
	font-size: 14px;
}

.form-table p {
	margin: 4px 0 0 0;
	font-size: 11px;
}

.form-table input {
	line-height: 20px;
	font-size: 15px;
	padding: 2px;
	border: 1px #dfdfdf solid;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	font-family: sans-serif;
}

.form-table input[type=text],
.form-table input[type=password] {
	width: 206px;
}

.form-table th p {
	font-weight: normal;
}

.form-table.install-success td {
	vertical-align: middle;
	padding: 16px 20px 10px 0;
}

.form-table.install-success td p {
	margin: 0;
	font-size: 14px;
}

.form-table.install-success td code {
	margin: 0;
	font-size: 18px;
}

			</style>
</head>
<body class="error-page">
<h1 id="logo"><a href="">Synapse-CMS</a></h1>
<form method="post" action="setup-config-params.php" name="submit">
	<p>Below you should enter your database connection details. If you&#8217;re not sure about these, contact your host.</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Database Name</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="synapse" /></td>
			<td>The name of the database you want to run Synapse in.</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">User Name</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="username" /></td>
			<td>Your MySQL username</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Password</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="password" /></td>
			<td>&hellip;and your MySQL password.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Database Host</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>You should be able to get this info from your web host, if <code>localhost</code> does not work.</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">Table Prefix</label></th>
			<td><input name="prefix" id="prefix" type="text" value="sy_" size="25" /></td>
			<td>If you want to run multiple Synapse installations in a single database, change this.</td>
		</tr>
	</table>
		<p class="step"><input name="submit" type="submit" value="Submit" class="button button-large" /></p>
</form>

<script>
//function reloadPage()
  //{
  //location.reload(false)
  //history.go(1);
  //location.reload(true);
  //}
  
  function reloadPage(){document.location = "/index.php"}
</script>

<?php 

		if ($_POST['submit']) {
			if ( ($_POST['dbname']) && ($_POST['uname']) && ($_POST['pwd']) && ($_POST['dbhost']) && ($_POST['prefix']) ) {
					$handle = fopen("../config.php",'w+');
					
					fwrite($handle, '<?php ');
					
					fwrite($handle, '$obj->template = "yourfriends"; ');
					fwrite($handle, '$obj->synapse_dir = "./synapse-cms/"; ');
					
					fwrite($handle, '$obj->synapse_title = "Synapse"; ');
					fwrite($handle, '$obj->synapse_slogan = "connect with friends.."; ');

					fwrite($handle, '$obj->publicity = 0; ');
					fwrite($handle, '$obj->reg_type = 0; ');
					fwrite($handle, '$obj->lines = 5; ');
					fwrite($handle, '$obj->lines_vert = 15; ');
									
					fwrite($handle, '$obj->host = "'.$_POST['dbhost'].'"; ' );
					fwrite($handle, '$obj->username = "'.$_POST['uname'].'"; ');
					fwrite($handle, '$obj->password = "'.$_POST['pwd'].'"; ');
					fwrite($handle, '$obj->table = "'.$_POST['dbname'].'"; ');
					
					fwrite($handle, ' ?>');
					
					fclose($handle);
					
					echo ('<a href="/index.php">CONFIGURATION WRITED !!! REFRESH PAGE</a><script>reloadPage();</script>');
			}
		}

?>

</body>
</html>
