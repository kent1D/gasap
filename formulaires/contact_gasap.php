<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_contact_gasap_charger_dist($id_gasap){
	$valeurs = array();
	$email = sql_getfetsel("email","spip_gasaps","id_gasap = ".intval($id_gasap));
	
	/**
	 * Si le GASAP n'a pas d'email ou que le paramètre n'est pas un nombre
	 * Le formulaire n'est pas éditable
	 */
	if(!is_numeric($id_gasap) OR !$email){
		$valeurs['editable'] = false;
		return $valeurs;
	}

	foreach(array('nom','email','texte') as $champ){
		$valeurs[$champ] = _request($champ);
	}

	return $valeurs;
}

function formulaires_contact_gasap_verifier_dist($id_gasap){
	$erreurs = array();
	
	include_spip('inc/filtres');
	
	foreach(array('email','texte','email') as $champ){
		if(!_request($champ) OR strlen(_request($champ)) <  2){
			$erreurs[$champ] = _T('info_obligatoire');
		}
	}
	
	if (!isset($erreurs['email']) && _request('email') && !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');

	if (count($erreurs))
		$erreurs['message_erreur'] = _T('gasap:votre_saisie_contient_des_erreurs');
	
	return $erreurs;
	
}

function formulaires_contact_gasap_traiter_dist($id_gasap){
	$valeurs = array();
	
	foreach(array('nom','email','texte') as $champ){
		$valeurs[$champ] = _request($champ);
	}
	
	$corps = _T('gasap:message_contact_asso_intro') . "\n" .
_T('gasap:message_contact_asso_nom') . $valeurs['nom'] . "\n" .
_T('gasap:message_contact_asso_adresse') . $valeurs['email'] . "\n" .
_T('gasap:message_contact_asso_message') . $valeurs['texte'];
	
	$email = sql_getfetsel("email","spip_gasaps","id_gasap = ".intval($id_gasap));

	$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
	$envoyer_mail($email, _T('gasap:message_contact_asso_sujet'), $corps, $from = "$reply");
	$valeurs['message_ok'] = _T('gasap:votre_message_a_bien_ete_envoye_un_responsable_vas_vous_repondre');
	return $valeurs;
	
}

?>
