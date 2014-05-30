
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo($obj->synapse_title); ?></title>
</head>

<?php
$entry = <<<DISPLAY_MESSAGE
<p></p>
    <p><b>Dôležité upozornenie</b></p>
    <p></p>
    <p>
	<i>
    Prevádzkovatel portálu nenesie žiadnu zodpovednost za:<br />
    * používanie Synapse-CMS PHP frameworku<br />
	* za využívanie portálu a jeho služieb socialnej siete<br />
	</i>
	</p>
	<p></p>
	<p>Prevadzkovatel portálu nenesie zodpovednost za obsah vytvorený uživatelmi.</p>
	<p>Uživatel sa zavezuje dodržiavat všeobecné zásady morálky a etiky v rámci zamerania portálu.</p>
	<p></p>
DISPLAY_MESSAGE;

echo $entry;

?>