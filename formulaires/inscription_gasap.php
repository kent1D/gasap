<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('formulaires/editer_gasap');

function formulaires_inscription_gasap_charger_dist($id_gasap='new', $retour='', $config_fonc='gasaps_edit_config', $row=array(), $hidden=''){
	$valeurs = array();

	$valeurs = formulaires_editer_objet_charger('gasap',$id_gasap,'','',$retour,$config_fonc,$row,$hidden);

	return $valeurs;
}

function formulaires_inscription_gasap_verifier_dist($id_gasap='new', $retour='', $config_fonc='gasaps_edit_config', $row=array(), $hidden=''){

	$erreurs = array();

	include_spip('inc/filtres');

	if (_request('email') AND !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');

	if (_request('bfg_god_mode'))
		$erreurs['bfg_god_mode'] = "Nikouuuuuz !!";
	
	if (count($erreurs))
		$erreurs['message_erreur'] = "Une erreur est présente dans votre saisie";

	return $erreurs;
	
}

function formulaires_inscription_gasap_traiter_dist($id_gasap='new', $retour='', $config_fonc='gasaps_edit_config', $row=array(), $hidden=''){
	/**
	 * Si on n'a pas de latitude ni ou de longitude, on lance le géocoder
	 */
	if(!_request('lat') OR !_request('lng')){
		include_spip('inc/distant');
		$adresse = _request('numero').' '._request('adresse').', '._request('ville');
		$url = 'http://nominatim.openstreetmap.org/search';
		$url = parametre_url(parametre_url(parametre_url(parametre_url($url,'format','json','&'),'limit',1,'&'),'addressdetails',1,'&'),'q',$adresse,'&');
		$geocoder = json_decode(recuperer_page($url),true);
		if(is_array($geocoder) && is_array($geocoder[0])){
			set_request('lat',$geocoder[0]['lat']);
			set_request('lng',$geocoder[0]['lon']);
		}
	}
	set_request('statut','valide');
	$res = formulaires_editer_objet_traiter('gasap',$id_gasap,'','',$retour,$config_fonc,$row,$hidden);
	
	if (intval($res['id_gasap']) > 0){
		$valeurs['message_ok'] = _T('gasap:votre_inscription_a_reussi_un_organisateur_vas_vous_contacter');
		$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
		$corps = "Inscription d'un GASAP.

Coordonnee:
------------
nom: "._request('nom')."
adresse: "._request('adresse')."
numero: "._request('numero')."
code_postal: "._request('code_postal')."
ville: "._request('ville')."
pays: "._request('pays')."
Téléphone: "._request('telephone')."
Fax : "._request('fax')."
Gsm : "._request('gsm')."
E-Mail: "._request('email')."

Pour plus d'info, l'inscription est reprise dans le partie privée du site.
";
		$envoyer_mail(lire_config('email_webmaster'), "Inscription d'un GASAP", $corps);
	}else{
		// on dis que ca n'a pas marché
		$valeurs['message_erreur'] = _T('gasap:votre_inscription_a_echoue_veuillez_reeseyer_plus_tard');
	}
	
	return $valeurs;

}

?>