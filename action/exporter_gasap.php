<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_exporter_gasap_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	include_spip('inc/autoriser');
	
	spip_log('exports/export_'.$arg,'test.'._LOG_ERREUR);
	if(autoriser('exporter','gasap')){
		header('Content-Type: text/csv;');
		header('Content-Disposition: attachment; filename=particuliers.csv');
		echo recuperer_fond('exports/export_'.$arg);
	}
	die();
}

?>
