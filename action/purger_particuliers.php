<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Action de purge des particuliers
 * 
 * Ne supprime rien de la base mais met les particuliers comme exportés
 */
function action_purger_particuliers_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	/**
	 * On note les particuliers comme exportés
	 */
	sql_updateq("spip_particuliers",array("exporte" => "1","maj" => date("Y-m-d G:i:s")),array());
	
	/**
	 * Invalider le cache
	 */
	include_spip('inc/invalideur');
	suivre_invalideur("id='particulier/tous'");	
}

?>
