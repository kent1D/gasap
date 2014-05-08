<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_editer_gasap_charger_dist(){
	
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('editer','gasap',_request("id_gasap"),_request('id_auteur'),Array("new"=>_request("new")))){
		return false;
	}

	$valeurs = Array();
	
	$valeurs["new"] = _request("new");
	
	
	
	if(intval(_request("id_gasap")) > 0){
		$gasap = sql_fetsel("*","spip_gasaps",Array("id_gasap = "._request("id_gasap")));
		
		$valeurs = array_merge($valeurs,$gasap);
		
		if ($valeurs["new"]){
			
			unset($valeurs["id_gasap"]);
			
		}
		
	}
	
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
	(_request('statut')?$valeurs['statut'] = _request('statut'):$valeurs['statut'] =$valeurs['statut']);
	
	return $valeurs;
	
}

function formulaires_editer_gasap_verifier_dist(){

	$erreurs = Array();
	
	// Ici on teste les different champs
	
	return $erreurs;
	
}

function formulaires_editer_gasap_traiter_dist(){
	
	include_spip('inc/geocoder');
	
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('editer','gasap',_request("id_gasap"),_request('id_auteur'),Array("new"=>_request("new")))){
		return false;
	}
	include_spip("base/abstract_sql");
	include_spip("inc/utils");
	$valeurs = Array();
	
	// On charge les champs qu'on a de toute facon besoin.
	$new = _request("new");
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
	(_request('statut')?$valeurs['statut'] = _request('statut'):$valeurs['statut'] =$valeurs['statut']);
		
	
	
	if(!$new & $valeurs['id_gasap'] > 0){
		
		// ici c'est un update
		
		sql_updateq("spip_gasaps",$valeurs,Array("id_gasap = ".$valeurs['id_gasap']));
		$valeurs['message_ok'] = _T('gasap:mise_a_jour_reussie');
		$coordonnees = getCoordonnees($valeurs["adresse"]." ".$valeurs["numero"].", ".$valeurs["code_postal"]." ".$valeurs["ville"].", ".$valeurs["pays"]);
		spip_log("Update lat lng de ".$valeurs["id_gasap"],"gasap");
		sql_updateq("spip_gasaps",Array("lat" => $coordonnees[2],"lng" => $coordonnees[3],"maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$valeurs["id_gasap"]));
		
	}else{
		
		// ici c'est un insert
		
		$valeurs['statut'] = "en_attente";
		$valeurs['id_gasap'] = sql_insertq("spip_gasaps",$valeurs);
		
		if ($valeurs['id_gasap'] > 0){
			$valeurs['message_ok'] = _T('gasap:ajout_d_un_gasap_reussie');
			$coordonnees = getCoordonnees($valeurs["adresse"]." ".$valeurs["numero"].", ".$valeurs["code_postal"]." ".$valeurs["ville"].", ".$valeurs["pays"]);
			spip_log("Update lat lng de ".$valeurs["id_gasap"],"gasap");
			sql_updateq("spip_gasaps",Array("lat" => $coordonnees[2],"lng" => $coordonnees[3],"maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$valeurs["id_gasap"]));

		}else{
			
			// ca a foire, on remet new parce l'ajout n'a pas marché
			$valeurs["new"] = _request("new");
			// on dis que ca n'a pas marché
			$valeurs['message_erreur'] = _T('gasap:ajout_d_un_gasap_echoue');
			
		}
		
	}
	
	
	
	return $valeurs;
	
}

?>
