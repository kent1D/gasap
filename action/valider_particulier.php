<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_valider_particulier_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$valeur = explode(":",$arg);
	
	sql_updateq("spip_particuliers",Array("statut" => "publie","maj" => date("Y-m-d G:i:s")),Array("id_particulier = ".$valeur[1]));
	
}

?>
