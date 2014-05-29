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
	/**
	 * Si on n'a pas de latitude ni ou de longitude, on lance le géocoder
	 */
	if(!_request('lat') OR !_request('lng')){
		include_spip('inc/distant');
		$adresse = _request('adresse').', '._request('ville');
		$url = 'http://nominatim.openstreetmap.org/search';
		$url = parametre_url(parametre_url(parametre_url(parametre_url($url,'format','json','&'),'limit',1,'&'),'addressdetails',1,'&'),'q',$adresse,'&');
		$geocoder = json_decode(recuperer_page($url),true);
		if(is_array($geocoder) && is_array($geocoder[0])){
			set_request('lat',$geocoder[0]['lat']);
			set_request('lng',$geocoder[0]['lon']);
		}
	}

	$res = formulaires_editer_objet_traiter('gasap',$id_gasap,'','',$retour,$config_fonc,$row,$hidden);
	return $res;
}

?>
