<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_inscription_gasap_charger_dist(){

	$valeurs = Array();
	
	$valeurs["new"] = "oui";
	
	
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('adresse')?$valeurs['adresse'] = _request('adresse'):$valeurs['adresse'] =$valeurs['adresse']);
	(_request('numero')?$valeurs['numero'] = _request('numero'):$valeurs['numero'] =$valeurs['numero']);
	(_request('code_postal')?$valeurs['code_postal'] = _request('code_postal'):$valeurs['code_postal'] =$valeurs['code_postal']);
	(_request('ville')?$valeurs['ville'] = _request('ville'):$valeurs['ville'] =$valeurs['ville']);
	(_request('pays')?$valeurs['pays'] = _request('pays'):$valeurs['pays'] =$valeurs['pays']);
	(_request('telephone')?$valeurs['telephone'] = _request('telephone'):$valeurs['telephone'] =$valeurs['telephone']);
	(_request('fax')?$valeurs['fax'] = _request('fax'):$valeurs['fax'] =$valeurs['fax']);
	(_request('gsm')?$valeurs['gsm'] = _request('gsm'):$valeurs['gsm'] =$valeurs['gsm']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('permanance')?$valeurs['permanance'] = _request('permanance'):$valeurs['permanance'] =$valeurs['permanance']);
	(_request('remarques')?$valeurs['remarques'] = _request('remarques'):$valeurs['remarques'] =$valeurs['remarques']);
	
	
	return $valeurs;
	
}

function formulaires_inscription_gasap_verifier_dist(){

	$erreurs = Array();
	
	include_spip('inc/filtres');
	
	if (_request('email') AND !email_valide(_request('email')))
		$erreurs['email'] = _T('gasap:ce_mail_n_est_pas_valide');
		
	if (_request('bfg_god_mode')){
		$erreurs['bfg_god_mode'] = "Nikouuuuuz !!";
		
	}
	
	if (count($erreurs)) {
		$erreurs['message_erreur'] = "Une erreur est présente dans votre saisie";
	}
	
	return $erreurs;
	
}

function formulaires_inscription_gasap_traiter_dist(){
	include_spip("base/abstract_sql");
	$valeurs = Array();
	
	// On charge les champs qu'on a de toute facon besoin.
	$new = "oui";
	$valeurs['id_gasap'] = _request("id_gasap");
	$valeurs['maj'] = date("Y-m-d G:i:s");
	
	
	/* 
	 * ici on viens charger les différents champs de l'gasaps
	 * du genre :
	 * $valeurs['titre'] = _request("titre");
	 * $valeurs['texte'] = _request("texte");
	 * $valeurs['zorglub'] = _request("zorglub");
	 * ...
	 * 
	 * !Attention!:
	 * On ne 'charge' ici que les element non systeme.
	 * On entend par element systeme  les id_auteur du createur,
	 * la date de creation et de modification de l'gasap, etc...
	 * On ne charge ici que son titre, son texte, etc...
	 * 
	 * */
	
	$valeurs['nom'] = _request('nom');
	$valeurs['adresse'] = _request('adresse');
	$valeurs['numero'] = _request('numero');
	$valeurs['code_postal'] = _request('code_postal');
	$valeurs['ville'] = _request('ville');
	$valeurs['pays'] = _request('pays');
	$valeurs['telephone'] = _request('telephone');
	$valeurs['fax'] = _request('fax');
	$valeurs['gsm'] = _request('gsm');
	$valeurs['email'] = _request('email');
	$valeurs['permanance'] = _request('permanance');
	$valeurs['remarques'] = _request('remarques');

	$valeurs['statut'] = "valide";
	$valeurs['id_gasap'] = sql_insertq("spip_gasaps",$valeurs);
	
	if ($valeurs['id_gasap'] > 0){
		$valeurs['message_ok'] = _T('gasap:votre_inscription_a_reussi_un_organisateur_vas_vous_contacter');
		$envoyer_mail = charger_fonction('envoyer_mail', 'inc');
		$corps = "Inscription d'un GASAP.

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
include_spip('inc/geocoder');
		$envoyer_mail(lire_config('email_webmaster'), "Inscription d'un GASAP", $corps);
		$coordonnees = getCoordonnees($valeurs["adresse"]." ".$valeurs["numero"].", ".$valeurs["code_postal"]." ".$valeurs["ville"].", ".$valeurs["pays"]);
		spip_log("Update lat lng de ".$valeurs["id_gasap"],"gasap");
		sql_updateq("spip_gasaps",Array("lat" => $coordonnees[2],"lng" => $coordonnees[3],"maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$valeurs["id_gasap"]));
		
	}else{
		
		// ca a foire, on remet new parce l'ajout n'a pas marché
		$valeurs["new"] = _request("new");
		// on dis que ca n'a pas marché
		$valeurs['message_erreur'] = _T('gasap:votre_inscription_a_echoue_veuillez_reeseyer_plus_tard');
		
	}
	
	return $valeurs;
	
}

?>
