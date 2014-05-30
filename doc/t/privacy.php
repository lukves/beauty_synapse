
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title><?php echo($obj->synapse_title); ?></title>
</head>

<?php
$entry = <<<DISPLAY_MESSAGE
    <p></p>
    <p><b>Infomácie, ktoré získavame a ich použitie</b></p>
    <p></p>
    <p>
	<i>
    * dozviete sa aké infomácie získavame a ako ich používame<br>
    * bezpečnosť prihlasovacích hesiel<br>
    </i>
	</p>
    <p></p>
    <p><b>Správičky od uživateľov a súkromie medzi uživateľmy</b></p>
    <p></p>
	<p>
    <i>
    * zdieľanie správičiek medzi uživateľmy, komu sa zobrazujú
    aké správičky a ako funguje uživateľova nástenka
    </i>
    </p>
	<p></p>
DISPLAY_MESSAGE;

echo $entry;

?>