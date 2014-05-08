<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_contact_gasap_charger_dist(){
	$valeurs = Array();
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('texte')?$valeurs['texte'] = _request('texte'):$valeurs['texte'] =$valeurs['texte']);
	include_spip('inc/filtres');
	$email = sql_getfetsel("email","spip_gasaps",Array("id_gasap = "._request('id_gasap')));
	
	if(!email_valide($email)){
		return false;
	}
	return $valeurs;
	
}

function formulaires_contact_gasap_verifier_dist(){
	$erreurs = Array();
	
	include_spip('inc/filtres');
	
	if (_request('email') AND !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');
	
	if (count($erreurs))
		$erreurs['message_erreur'] = _T('gasap:votre_saisie_contient_des_erreurs');
	
	return $erreurs;
	
}

function formulaires_contact_gasap_traiter_dist(){
	include_spip("base/abstract_sql");
	$valeurs = Array();
	
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('texte')?$valeurs['texte'] = _request('texte'):$valeurs['texte'] =$valeurs['texte']);
	
	$corps = _T('gasap:message_contact_asso_intro') . "\n" .
_T('gasap:message_contact_asso_nom') . $valeurs['nom'] . "\n" .
_T('gasap:message_contact_asso_adresse') . $valeurs['email'] . "\n" .
_T('gasap:message_contact_asso_message') . $valeurs['texte'];
	
$email = sql_getfetsel("email","spip_gasaps",Array("id_gasap = "._request('id_gasap')));

	$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
	$envoyer_mail($email, _T('gasap:message_contact_asso_sujet'), $corps, $from = "$reply");
	$valeurs['message_ok'] = _T('gasap:votre_message_a_bien_ete_envoye_un_responsable_vas_vous_repondre');
	return $valeurs;
	
}

?>
