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
	$valeurs['url_page'] = url_absolue(self());
	return $valeurs;
}

function formulaires_contact_gasap_verifier_dist($id_gasap){
	$erreurs = array();
	
	include_spip('inc/filtres');
	
	foreach(array('nom','texte','email') as $champ){
		if(!_request($champ) OR strlen(_request($champ)) <  2){
			$erreurs[$champ] = _T('info_obligatoire');
		}
	}
	
	if (!isset($erreurs['email']) && _request('email') && !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');

	// si nospam est present on traite les spams
	if (!isset($erreurs['texte']) && include_spip('inc/nospam')) {
		include_spip('inc/texte');
		$caracteres = compter_caracteres_utiles(_request('texte'));
		// moins de 10 caracteres sans les liens = spam !
		if ($caracteres < 10){
			$erreurs['texte_message'] = _T('forum_attention_dix_caracteres');
		}
		
		// on analyse le texte
		$infos_texte = analyser_spams(_request('texte'));
		if ($infos_texte['nombre_liens'] > 0) {
			// si un lien a un titre de moins de 3 caracteres = spam !
			if ($infos_texte['caracteres_texte_lien_min'] < 3) {
				$erreurs['texte_message'] = _T('nospam:erreur_spam');
			}
			// si le texte contient plus de trois lien = spam !
			if ($infos_texte['nombre_liens'] >= 3)
				$erreurs['texte_message'] = _T('nospam:erreur_spam');
		}
	}
	if (count($erreurs))
		$erreurs['message_erreur'] = _T('gasap:votre_saisie_contient_des_erreurs');
	
	return $erreurs;
	
}

function formulaires_contact_gasap_traiter_dist($id_gasap){
	$valeurs = $corps = array();
	
	foreach(array('nom','email','texte') as $champ){
		$valeurs[$champ] = _request($champ);
	}
	
	$corps['texte'] = _T('gasap:message_contact_asso_intro',array('url'=>_request('url_page')) . "\n" .
_T('gasap:message_contact_asso_nom') . $valeurs['nom'] . "\n" .
_T('gasap:message_contact_asso_adresse') . $valeurs['email'] . "\n" .
_T('gasap:message_contact_asso_message') . $valeurs['texte']."\n\n";
	
	$destinataire = sql_getfetsel("email","spip_gasaps","id_gasap = ".intval($id_gasap));
	$sujet = _T('gasap:message_contact_asso_sujet');
	$corps['nom_envoyeur'] = $valeurs['nom'];
	$corps['from'] = $reply = $valeurs['email'];
	$corps['repondre_a'] = $reply;
	$corps['bcc'] = array('postmaster@gasap.be');

	$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
	$envoyer_mail($destinataire,$sujet, $corps);
	$valeurs['message_ok'] = _T('gasap:votre_message_a_bien_ete_envoye_un_responsable_va_vous_repondre');
	return $valeurs;
	
}

?>
