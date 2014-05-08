<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_particulier_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$valeur = explode(":",$arg);
	
	sql_updateq("spip_particuliers",Array("statut" => "poubelle","maj" => date("Y-m-d G:i:s")),Array("id_particulier = ".$valeur[1]));
	
}

?>
