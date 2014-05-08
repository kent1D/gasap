<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_incompleter_gasap_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$valeur = explode(":",$arg);
	
	sql_updateq("spip_gasaps",Array("complet" => "0","maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$valeur[1]));
	
}

?>
