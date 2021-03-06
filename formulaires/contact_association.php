<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_contact_association_charger_dist(){
	$valeurs = array();
	foreach(array('nom','email','texte','id_contact') as $champ){
		$valeurs[$champ] = _request($champ);
	}
	return $valeurs;
}

function formulaires_contact_association_verifier_dist(){
	$erreurs = array();
	
	foreach(array('nom','texte','email') as $champ){
		if(!_request($champ) OR strlen(_request($champ)) <  2){
			$erreurs[$champ] = _T('info_obligatoire');
		}
	}

		include_spip('inc/filtres');
	if (_request('email') AND !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');
	
	// si nospam est present on traite les spams
	if (!isset($erreurs['texte']) && include_spip('inc/nospam')) {
		include_spip('inc/texte');
		$caracteres = compter_caracteres_utiles(_request('texte'));
		// moins de 10 caracteres sans les liens = spam !
		if ($caracteres < 10){
			$erreurs['texte'] = _T('forum_attention_dix_caracteres');
		}
		
		// on analyse le texte
		$infos_texte = analyser_spams(_request('texte'));
		if ($infos_texte['nombre_liens'] > 0) {
			// si un lien a un titre de moins de 3 caracteres = spam !
			if ($infos_texte['caracteres_texte_lien_min'] < 3) {
				$erreurs['texte'] = _T('nospam:erreur_spam');
			}
			// si le texte contient plus de trois lien = spam !
			if ($infos_texte['nombre_liens'] >= 3)
				$erreurs['texte'] = _T('nospam:erreur_spam');
		}
	}

	if (count($erreurs))
		$erreurs['message_erreur'] = _T('gasap:votre_saisie_contient_des_erreurs');
	
	return $erreurs;
}

function formulaires_contact_association_traiter_dist(){
	include_spip("base/abstract_sql");
	$valeurs = $corps = array();
	
	foreach(array('nom','email','texte','id_contact') as $champ){
		$valeurs[$champ] = _request($champ);
	}

	$sujet = _T('gasap:message_contact_asso_sujet');
	
	$corps['texte'] = _T('gasap:message_contact_asso_intro') . "\n" .
_T('gasap:message_contact_asso_nom') . $valeurs['nom'] . "\n" .
_T('gasap:message_contact_asso_adresse') . $valeurs['email'] . "\n" .
_T('gasap:message_contact_asso_message') . $valeurs['texte'];
	
	switch ($valeurs['id_contact']){
		case '1':
			$destinataires = "coordinateur@gasap.be";
		break;
		
		case '2':
			$destinataires = "noyau@gasap.be";
		break;

		case '3':
			$destinataires = "aide-creation@gasap.be";
		break;
		
		case '4':
			$destinataires = "comm@gasap.be";
		break;

		case '5':
			$destinataires = "producteur@gasap.be";
		break;
		
		default:
			$destinataires = lire_config('email_webmaster');
		break;
	}
	
	$corps['nom_envoyeur'] = $valeurs['nom'];
	$corps['from'] = $reply = $valeurs['email'];
	$corps['repondre_a'] = $reply;
	$corps['bcc'] = array('postmaster@gasap.be');

	$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
	$envoyer_mail($destinataires, $sujet, $corps);
	$valeurs['message_ok'] = _T('gasap:votre_message_a_bien_ete_envoye_un_responsable_va_vous_repondre');
	return $valeurs;
	
}

?>
