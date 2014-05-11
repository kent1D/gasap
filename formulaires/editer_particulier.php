<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/autoriser');

function formulaires_editer_particulier_charger_dist($id_particulier='new', $retour='', $config_fonc='partculiers_edit_config', $row=array(), $hidden=''){
	
	// On vérifie les droits
	if (!autoriser('editer','particulier',$id_particulier))
		return array('editable',false);

	$valeurs = formulaires_editer_objet_charger('particulier',$id_particulier,'','',$retour,$config_fonc,$row,$hidden);

	return $valeurs;
}

// Choix par defaut des options de presentation
function partculiers_edit_config($row)
{
	global $spip_lang;

	$config = $GLOBALS['meta'];
	$config['lignes'] = 8;
	$config['langue'] = $spip_lang;
	return $config;
}

function formulaires_editer_particulier_verifier_dist($id_particulier='new', $retour='', $config_fonc='partculiers_edit_config', $row=array(), $hidden=''){

	$erreurs = array();
	
	return $erreurs;
	
}

function formulaires_editer_particulier_traiter_dist($id_particulier='new', $retour='', $config_fonc='partculiers_edit_config', $row=array(), $hidden=''){

	return formulaires_editer_objet_traiter('particulier',$id_particulier,'','',$retour,$config_fonc,$row,$hidden);;
}

?>
