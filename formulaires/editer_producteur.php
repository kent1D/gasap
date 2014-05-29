<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_editer_producteur_charger_dist(){
	
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('editer','producteur',_request("id_producteur"),_request('id_auteur'),Array("new"=>_request("new")))){
		return false;
	}

	$valeurs = Array();
	
	$valeurs["new"] = _request("new");
	
	
	
	if(intval(_request("id_producteur")) > 0){
		$producteur = sql_fetsel("*","spip_producteurs",Array("id_producteur = "._request("id_producteur")));
		
		$valeurs = array_merge($valeurs,$producteur);
		
		if ($valeurs["new"]){
			
			unset($valeurs["id_producteur"]);
			
		}
		
	}
	
	(_request('nom')?$valeurs['nom'] = _request('nom'):$valeurs['nom'] =$valeurs['nom']);
	(_request('prenom')?$valeurs['prenom'] = _request('prenom'):$valeurs['prenom'] =$valeurs['prenom']);
	(_request('adresse')?$valeurs['adresse'] = _request('adresse'):$valeurs['adresse'] =$valeurs['adresse']);
	(_request('code_postal')?$valeurs['code_postal'] = _request('code_postal'):$valeurs['code_postal'] =$valeurs['code_postal']);
	(_request('ville')?$valeurs['ville'] = _request('ville'):$valeurs['ville'] =$valeurs['ville']);
	(_request('pays')?$valeurs['pays'] = _request('pays'):$valeurs['pays'] =$valeurs['pays']);
	(_request('telephone')?$valeurs['telephone'] = _request('telephone'):$valeurs['telephone'] =$valeurs['telephone']);
	(_request('gsm')?$valeurs['gsm'] = _request('gsm'):$valeurs['gsm'] =$valeurs['gsm']);
	(_request('email')?$valeurs['email'] = _request('email'):$valeurs['email'] =$valeurs['email']);
	(_request('permanence')?$valeurs['permanence'] = _request('permanence'):$valeurs['permanence'] =$valeurs['permanence']);
	(_request('remarques')?$valeurs['remarques'] = _request('remarques'):$valeurs['remarques'] =$valeurs['remarques']);
	(_request('nom_ferme')?$valeurs['nom_ferme'] = _request('nom_ferme'):$valeurs['nom_ferme'] =$valeurs['nom_ferme']);
	(_request('label_bio')?$valeurs['label_bio'] = _request('label_bio'):$valeurs['label_bio'] =$valeurs['label_bio']);
	(_request('biodynamie')?$valeurs['biodynamie'] = _request('biodynamie'):$valeurs['biodynamie'] =$valeurs['biodynamie']);
	(_request('type_culture')?$valeurs['type_culture'] = _request('type_culture'):$valeurs['type_culture'] =$valeurs['type_culture']);
	(_request('type_elevage')?$valeurs['type_elevage'] = _request('type_elevage'):$valeurs['type_elevage'] =$valeurs['type_elevage']);
	(_request('transformation')?$valeurs['transformation'] = _request('transformation'):$valeurs['transformation'] =$valeurs['transformation']);
	(_request('taille_ferme')?$valeurs['taille_ferme'] = _request('taille_ferme'):$valeurs['taille_ferme'] =$valeurs['taille_ferme']);
	(_request('distance_bruxelles')?$valeurs['distance_bruxelles'] = _request('distance_bruxelles'):$valeurs['distance_bruxelles'] =$valeurs['distance_bruxelles']);
	(_request('stade')?$valeurs['stade'] = _request('stade'):$valeurs['stade'] =$valeurs['stade']);
	(_request('commentaires')?$valeurs['commentaires'] = _request('commentaires'):$valeurs['commentaires'] =$valeurs['commentaires']);
	
	return $valeurs;
	
}

function formulaires_editer_producteur_verifier_dist(){

	$erreurs = Array();
	
	// Ici on teste les different champs
	
	return $erreurs;
	
}

function formulaires_editer_producteur_traiter_dist(){
	
	// On vérifie les droits
	include_spip('inc/autoriser');
	if (!autoriser('editer','producteur',_request("id_producteur"),_request('id_auteur'),Array("new"=>_request("new")))){
		return false;
	}
	
	$valeurs = Array();
	
	// On charge les champs qu'on a de toute facon besoin.
	$new = _request("new");
	$valeurs['id_producteur'] = _request("id_producteur");
	$valeurs['maj'] = date("Y-m-d G:i:s");
	
	
	/* 
	 * ici on viens charger les différents champs de l'producteurs
	 * du genre :
	 * $valeurs['titre'] = _request("titre");
	 * $valeurs['texte'] = _request("texte");
	 * $valeurs['zorglub'] = _request("zorglub");
	 * ...
	 * 
	 * !Attention!:
	 * On ne 'charge' ici que les element non systeme.
	 * On entend par element systeme  les id_auteur du createur,
	 * la date de creation et de modification de l'producteur, etc...
	 * On ne charge ici que son titre, son texte, etc...
	 * 
	 * */
	
	$valeurs['nom'] = _request('nom');
	$valeurs['adresse'] = _request('adresse');
	$valeurs['code_postal'] = _request('code_postal');
	$valeurs['ville'] = _request('ville');
	$valeurs['pays'] = _request('pays');
	$valeurs['telephone'] = _request('telephone');
	$valeurs['gsm'] = _request('gsm');
	$valeurs['email'] = _request('email');
	$valeurs['permanence'] = _request('permanence');
	$valeurs['remarques'] = _request('remarques');
	$valeurs['nom_ferme'] = _request('nom_ferme');
	$valeurs['label_bio'] = _request('label_bio');
	$valeurs['biodynamie'] = _request('biodynamie');
	$valeurs['type_culture'] = _request('type_culture');
	$valeurs['type_elevage'] = _request('type_elevage');
	$valeurs['transformation'] = _request('transformation');
	$valeurs['taille_ferme'] = _request('taille_ferme');
	$valeurs['distance_bruxelles'] = _request('distance_bruxelles');
	$valeurs['stade'] = _request('stade');
	$valeurs['commentaires'] = _request('commentaires');
		
	
	if(!$new & $valeurs['id_producteur'] > 0){
		
		// ici c'est un update
		
		sql_updateq("spip_producteurs",$valeurs,Array("id_producteur = ".$valeurs['id_producteur']));
		$valeurs['message_ok'] = _T('producteur:mise_a_jour_reussie');
		
	}else{
		
		// ici c'est un insert
		
		$valeurs['statut'] = "en_attente";
		$valeurs['id_producteur'] = sql_insertq("spip_producteurs",$valeurs);
		if ($valeurs['id_producteur'] > 0){
			$valeurs['message_ok'] = _T('producteur:ajout_d_un_producteur_reussie');
		}else{
			
			// ca a foire, on remet new parce l'ajout n'a pas marché
			$valeurs["new"] = _request("new");
			// on dis que ca n'a pas marché
			$valeurs['message_erreur'] = _T('producteur:ajout_d_un_producteur_echoue');
			
		}
		
	}
	
	
	
	return $valeurs;
	
}

?>
