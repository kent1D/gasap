<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_contact_association_charger_dist(){
	$valeurs = Array();
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('texte')?$valeurs['texte'] = _request('texte'):$valeurs['texte'] =$valeurs['texte']);
	return $valeurs;
	
}

function formulaires_contact_association_verifier_dist(){
	$erreurs = Array();
	
	include_spip('inc/filtres');
	
	if (_request('email') AND !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');
	
	if (count($erreurs))
		$erreurs['message_erreur'] = _T('gasap:votre_saisie_contient_des_erreurs');
	
	return $erreurs;
}

function formulaires_contact_association_traiter_dist(){
	include_spip("base/abstract_sql");
	$valeurs = Array();
	
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('texte')?$valeurs['texte'] = _request('texte'):$valeurs['texte'] =$valeurs['texte']);

	$corps = _T('gasap:message_contact_asso_intro') . "\n" .
_T('gasap:message_contact_asso_nom') . $valeurs['nom'] . "\n" .
_T('gasap:message_contact_asso_adresse') . $valeurs['email'] . "\n" .
_T('gasap:message_contact_asso_message') . $valeurs['texte'];

	$reply = $valeurs['email'];
	
	switch (_request('id_contact')){
		case '1':
			$email = "coordinateur@gasap.be";
		break;
		
		case '2':
			$email = "noyau@gasap.be";
		break;

		case '3':
			$email = "aide-creation@gasap.be";
		break;
		
		case '4':
			$email = "comm@gasap.be";
		break;

		case '5':
			$email = "producteur@gasap.be";
		break;
		
		default:
			$email = lire_config('email_webmaster');
		break;
		
	}
	$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
	$envoyer_mail($email, _T('gasap:message_contact_asso_sujet'), $corps, $from = "$reply");
	$valeurs['message_ok'] = _T('gasap:votre_message_a_bien_ete_envoye_un_responsable_vas_vous_repondre');
	return $valeurs;
	
}

?>
