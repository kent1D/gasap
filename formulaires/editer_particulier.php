<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_editer_particulier_charger_dist(){
	
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('editer','particulier',_request("id_particulier"),_request('id_auteur'),Array("new"=>_request("new")))){
		return false;
	}

	$valeurs = Array();
	
	$valeurs["new"] = _request("new");
	
	
	
	if(intval(_request("id_particulier")) > 0){
		$particulier = sql_fetsel("*","spip_particuliers",Array("id_particulier = "._request("id_particulier")));
		
		$valeurs = array_merge($valeurs,$particulier);
		
		if ($valeurs["new"]){
			
			unset($valeurs["id_particulier"]);
			
		}
		
	}
	
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('prenom')?$valeurs['prenom'] = _request('prenom'):$valeurs['prenom'] =$valeurs['prenom']);
	(_request('adresse')?$valeurs['adresse'] = _request('adresse'):$valeurs['adresse'] =$valeurs['adresse']);
	(_request('code_postal')?$valeurs['code_postal'] = _request('code_postal'):$valeurs['code_postal'] =$valeurs['code_postal']);
	(_request('ville')?$valeurs['ville'] = _request('ville'):$valeurs['ville'] =$valeurs['ville']);
	(_request('commune')?$valeurs['commune'] = _request('commune'):$valeurs['commune'] =$valeurs['commune']);
	(_request('telephone')?$valeurs['telephone'] = _request('telephone'):$valeurs['telephone'] =$valeurs['telephone']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('composition_menage')?$valeurs['composition_menage'] = _request('composition_menage'):$valeurs['composition_menage'] =$valeurs['composition_menage']);
	(_request('personne_de_contacte')?$valeurs['personne_de_contacte'] = _request('personne_de_contacte'):$valeurs['personne_de_contacte'] =$valeurs['personne_de_contacte']);
	(_request('remarques')?$valeurs['remarques'] = _request('remarques'):$valeurs['remarques'] =$valeurs['remarques']);
	
	return $valeurs;
	
}

function formulaires_editer_particulier_verifier_dist(){

	$erreurs = Array();
	
	// Ici on teste les different champs
	
	return $erreurs;
	
}

function formulaires_editer_particulier_traiter_dist(){
	
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('editer','particulier',_request("id_particulier"),_request('id_auteur'),Array("new"=>_request("new")))){
		return false;
	}
	
	$valeurs = Array();
	
	// On charge les champs qu'on a de toute facon besoin.
	$new = _request("new");
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
	$valeurs['personne_de_contacte'] = _request('personne_de_contacte');
	$valeurs['remarques'] = _request('remarques');
		
	
	if(!$new & $valeurs['id_particulier'] > 0){
		
		// ici c'est un update
		
		sql_updateq("spip_particuliers",$valeurs,Array("id_particulier = ".$valeurs['id_particulier']));
		$valeurs['message_ok'] = _T('gasap:mise_a_jour_reussie');
		
	}else{
		
		// ici c'est un insert
		
		$valeurs['statut'] = "en_attente";
		$valeurs['id_particulier'] = sql_insertq("spip_particuliers",$valeurs);
		if ($valeurs['id_particulier'] > 0){
			$valeurs['message_ok'] = _T('gasap:ajout_d_un_particulier_reussie');
		}else{
			
			// ca a foire, on remet new parce l'ajout n'a pas marché
			$valeurs["new"] = _request("new");
			// on dis que ca n'a pas marché
			$valeurs['message_erreur'] = _T('gasap:ajout_d_un_particulier_echoue');
			
		}
		
	}
	
	
	
	return $valeurs;
	
}

?>
