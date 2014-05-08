<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_purger_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	//$valeur = explode(":",$arg);
	spip_log("Purge des $arg","gasap");	
	sql_updateq("spip_".$arg."s",Array("exporte" => "1","maj" => date("Y-m-d G:i:s")),Array());

	
}

?>
