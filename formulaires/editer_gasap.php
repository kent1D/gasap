<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/autoriser');

function formulaires_editer_gasap_charger_dist($id_gasap='new', $retour='', $config_fonc='gasaps_edit_config', $row=array(), $hidden=''){
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('modifier','gasap',$id_gasap))
		return false;

	$valeurs = formulaires_editer_objet_charger('gasap',$id_gasap,'','',$retour,$config_fonc,$row,$hidden);

	return $valeurs;
}

// Choix par defaut des options de presentation
// http://doc.spip.org/@articles_edit_config
function gasaps_edit_config($row)
{
	global $spip_lang;

	$config = $GLOBALS['meta'];
	$config['lignes'] = 8;
	$config['langue'] = $spip_lang;
	return $config;
}

function formulaires_editer_gasap_verifier_dist($id_gasap='new', $retour='', $config_fonc='gasaps_edit_config', $row=array(), $hidden=''){
	$erreurs = array();
	return $erreurs;
}
function formulaires_editer_gasap_traiter_dist($id_gasap='new', $retour='', $config_fonc='gasaps_edit_config', $row=array(), $hidden=''){
	
	//include_spip('inc/geocoder');
	
	// On vérifie les droits
	if (!autoriser('modifier','gasap',$id_gasap))
		return false;

	/**
	 * TODO : réimplémenter le géocodeur
	 */
	return formulaires_editer_objet_traiter('gasap',$id_gasap,'','',$retour,$config_fonc,$row,$hidden);
}

?>
