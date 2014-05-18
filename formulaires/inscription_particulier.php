<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_inscription_particulier_charger_dist(){
	$valeurs = array();
	$valeurs["new"] = "oui";
	
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('prenom')?$valeurs['prenom'] = _request('prenom'):$valeurs['prenom'] =$valeurs['prenom']);
	(_request('adresse')?$valeurs['adresse'] = _request('adresse'):$valeurs['adresse'] =$valeurs['adresse']);
	(_request('code_postal')?$valeurs['code_postal'] = _request('code_postal'):$valeurs['code_postal'] =$valeurs['code_postal']);
	(_request('ville')?$valeurs['ville'] = _request('ville'):$valeurs['ville'] =$valeurs['ville']);
	(_request('commune')?$valeurs['commune'] = _request('commune'):$valeurs['commune'] =$valeurs['commune']);
	(_request('telephone')?$valeurs['telephone'] = _request('telephone'):$valeurs['telephone'] =$valeurs['telephone']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('composition_menage')?$valeurs['composition_menage'] = _request('composition_menage'):$valeurs['composition_menage'] =$valeurs['composition_menage']);
	(_request('personne_de_contact')?$valeurs['personne_de_contact'] = _request('personne_de_contact'):$valeurs['personne_de_contact'] =$valeurs['personne_de_contact']);
	(_request('lieu')?$valeurs['lieu'] = _request('lieu'):$valeurs['lieu'] =$valeurs['lieu']);
	(_request('remarques')?$valeurs['remarques'] = _request('remarques'):$valeurs['remarques'] =$valeurs['remarques']);

	return $valeurs;
}

function formulaires_inscription_particulier_verifier_dist(){

	$erreurs = Array();
	include_spip('inc/filtres');

	foreach(array('email','nom','code_postal') as $obligatoire)
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

function formulaires_inscription_particulier_traiter_dist(){
	
	include_spip("base/abstract_sql");
	
	$valeurs = Array();
	
	// On charge les champs qu'on a de toute facon besoin.
	$new = "oui";
	$valeurs['id_particulier'] = _request("id_particulier");
	$valeurs['maj'] = date("Y-m-d G:i:s");
	
	
	/* 
	 * ici on viens charger les différents champs de l'particuliers
	 * du genre :
	 * $valeurs['titre'] = _request("titre");
	 * $valeurs['texte'] = _request("texte");
	 * $valeurs['zorglub'] = _request("zorglub");
	 * ...
	 * 
	 * !Attention!:
	 * On ne 'charge' ici que les element non systeme.
	 * On entend par element systeme  les id_auteur du createur,
	 * la date de creation et de modification de l'particulier, etc...
	 * On ne charge ici que son titre, son texte, etc...
	 * 
	 * */
	
	$valeurs['nom'] = _request('nom');
	$valeurs['prenom'] = _request('prenom');
	$valeurs['adresse'] = _request('adresse');
	$valeurs['code_postal'] = _request('code_postal');
	$valeurs['ville'] = _request('ville');
	$valeurs['commune'] = _request('commune');
	$valeurs['telephone'] = _request('telephone');
	$valeurs['email'] = _request('email');
	$valeurs['composition_menage'] = _request('composition_menage');
	$valeurs['personne_de_contact'] = _request('personne_de_contact');
	$valeurs['remarques'] = _request('remarques');
	$valeurs['statut'] = "en_attente";
	
	$valeurs['id_particulier'] = sql_insertq("spip_particuliers",$valeurs);
	
	//$liaison = sql_insertq("spip_gasaps_particuliers",Array("id_particulier = ".$valeurs['id_particulier'],"id_gasap = "._request('id_particulier')));
	
	if ($valeurs['id_particulier'] ){
		$valeurs['message_ok'] = _T('gasap:votre_inscription_a_reussi_un_organisateur_vas_vous_contacter');
		$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
		$corps = "Inscription d'un particulier.

Coordonnee:
------------
nom: ".$valeurs['nom']."
adresse: ".$valeurs['adresse']."
numero: ".$valeurs['numero']."
code_postal: ".$valeurs['code_postal']."
ville: ".$valeurs['ville']."
pays: ".$valeurs['pays']."
Téléphone: ".$valeurs['telephone']."
Fax : ".$valeurs['fax']."
Gsm : ".$valeurs['gsm']."
E-Mail: ".$valeurs['email']."

Pour plus d'info, l'inscription est reprise dans le partie privée du site.
";
		$envoyer_mail(lire_config('email_webmaster'), "Inscription d'un particulier GASAP", $corps);
	}else{
		
		// ca a foire, on remet new parce l'ajout n'a pas marché
		$valeurs["new"] = _request("new");
		// on dis que ca n'a pas marché
		$valeurs['message_erreur'] = _T('gasap:votre_inscription_a_echoue_veuillez_reeseyer_plus_tard');
		
	}
	
	return $valeurs;
	
}

?>
