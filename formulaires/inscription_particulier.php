<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/autoriser');

function formulaires_inscription_particulier_charger_dist($id_particulier='new', $retour='', $config_fonc='partculiers_edit_config', $row=array(), $hidden=''){
	$valeurs = array();
	
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

function formulaires_inscription_particulier_verifier_dist($id_particulier='new', $retour='', $config_fonc='partculiers_edit_config', $row=array(), $hidden=''){

	$erreurs = Array();
	include_spip('inc/filtres');

	foreach(array('email','nom') as $obligatoire)
		if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	if (_request('email') AND !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');

	if (strlen(_request('bfg_god_mode')) > 0){
		$erreurs['bfg_god_mode'] = "Nikouuuuuz !!";
	}
	
	if (count($erreurs)) {
		$erreurs['message_erreur'] = "Une erreur est pr&eacute;sente dans votre saisie";
	}
	
	// Ici on teste les different champs
	
	return $erreurs;
	
}

function formulaires_inscription_particulier_traiter_dist($id_particulier='new', $retour='', $config_fonc='partculiers_edit_config', $row=array(), $hidden=''){
	
	$res = formulaires_editer_objet_traiter('particulier',$id_particulier,'','',$retour,$config_fonc,$row,$hidden);
	
	//$liaison = sql_insertq("spip_gasaps_particuliers",Array("id_particulier = ".$valeurs['id_particulier'],"id_gasap = "._request('id_particulier')));
	
	if (intval($res['id_particulier']) > 0){
		$valeurs['message_ok'] = _T('gasap:votre_inscription_a_reussi_un_organisateur_va_vous_contacter');
		$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
		$corps = "Inscription d'un particulier.

Coordonnee:
------------
Nom : "._request('nom')."
Téléphone : "._request('telephone')."
Fax : "._request('fax')."
Gsm : "._request('gsm')."
E-Mail: "._request('email')."

Pour plus d'info, l'inscription est reprise dans la partie privée du site.
";
		$envoyer_mail(lire_config('email_webmaster'), "Inscription d'un particulier GASAP", $corps);
		$res['editable'] = false;
	}else{
		
		// ca a foire, on remet new parce l'ajout n'a pas marché
		$valeurs["new"] = _request("new");
		// on dis que ca n'a pas marché
		$valeurs['message_erreur'] = _T('gasap:votre_inscription_a_echoue_veuillez_reeseyer_plus_tard');
		
	}
	
	return $valeurs;
	
}

?>
