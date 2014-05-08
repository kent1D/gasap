<?php


if (!defined("_ECRIRE_INC_VERSION")) return;

function gasap_tables_principales($tables_principales){
	
	$spip_gasaps = array(
		"id_gasap"	=> "bigint(21) NOT NULL",
		"nom" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"adresse" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"numero" => "VARCHAR(20) DEFAULT '' NOT NULL",
		"code_postal" => "VARCHAR(20) DEFAULT '' NOT NULL",
		"ville" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"pays" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"telephone" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"fax" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"gsm" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"permanance" => "TEXT DEFAULT '' NOT NULL",
		"remarques" => "TEXT DEFAULT '' NOT NULL",
		"email" => "TEXT DEFAULT '' NOT NULL",
		"nombre_place"	=> "int(2) NOT NULL",
		"complet"	=> "int(1) NOT NULL",
		"lat" => "TEXT DEFAULT '' NOT NULL",
		"lng" => "TEXT DEFAULT '' NOT NULL",
		"maj" => "TIMESTAMP",
		"statut" => "VARCHAR(10) DEFAULT '0' NOT NULL"
	);
	
	$spip_gasaps_key = array(
		"PRIMARY KEY"		=> "id_gasap",
		"KEY statut"		=> "statut"
	);

	$spip_gasaps_join = array(
		"id_gasap"		=> "id_gasap",
		"id_auteur" => "id_auteur"
	);
		
	$tables_principales['spip_gasaps'] = array(
		'field' => &$spip_gasaps,
		'key' => &$spip_gasaps_key,
		'join' => &$spip_gasaps_join
	);
	
	
	$spip_producteurs = array(
		"id_producteur"	=> "bigint(21) NOT NULL",
		"nom" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"prenom" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"adresse" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"numero" => "VARCHAR(20) DEFAULT '' NOT NULL",
		"code_postal" => "VARCHAR(20) DEFAULT '' NOT NULL",
		"ville" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"pays" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"telephone" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"fax" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"gsm" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"permanance" => "TEXT DEFAULT '' NOT NULL",
		"remarques" => "TEXT DEFAULT '' NOT NULL",
		"email" => "TEXT DEFAULT '' NOT NULL",
		"nom_ferme" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"label_bio"	=> "int(1) NOT NULL",
		"biodynamie"	=> "int(1) NOT NULL",
		"type_culture"	=> "TEXT NOT NULL",
		"type_evelvage"	=> "TEXT NOT NULL",
		"transformation"	=> "TEXT NOT NULL",
		"taille_ferme"	=> "bigint(21) NOT NULL",
		"distance_bruxelles"	=> "bigint(21) NOT NULL",
		"stade"	=> "VARCHAR(25) NOT NULL",
		"commentaires"	=> "TEXT NOT NULL",
		"maj" => "TIMESTAMP",
		"statut" => "VARCHAR(10) DEFAULT '0' NOT NULL"
	);
	
	$spip_producteurs_key = array(
		"PRIMARY KEY"		=> "id_producteur",
		"KEY label_bio"		=> "label_bio",
		"KEY biodynamie"		=> "biodynamie",
		"KEY distance_bruxelles"		=> "distance_bruxelles",
		"KEY statut"		=> "statut"
	);

	$spip_producteurs_join = array(
		"id_producteur"		=> "id_producteur",
		"id_auteur" => "id_auteur"
	);
		
	$tables_principales['spip_producteurs'] = array(
		'field' => &$spip_producteurs,
		'key' => &$spip_producteurs_key,
		'join' => &$spip_producteurs_join
	);
	
	$spip_particuliers = array(
		"id_particulier"	=> "bigint(21) NOT NULL",
		"nom" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"prenom" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"adresse" => "VARCHAR(255) DEFAULT '' NOT NULL",
		//"numero" => "VARCHAR(20) DEFAULT '' NOT NULL",
		"code_postal" => "VARCHAR(20) DEFAULT '' NOT NULL",
		"ville" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"commune" => "VARCHAR(255) DEFAULT '' NOT NULL",
		//"pays" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"telephone" => "VARCHAR(255) DEFAULT '' NOT NULL",
		//"fax" => "VARCHAR(255) DEFAULT '' NOT NULL",
		//"gsm" => "VARCHAR(255) DEFAULT '' NOT NULL",
		"email" => "TEXT DEFAULT '' NOT NULL",
		"remarques"	=> "TEXT NOT NULL",
		"personne_de_contacte"	=> "TEXT NOT NULL",
		"composition_menage"	=> "int(1) NOT NULL",
		"maj" => "TIMESTAMP",
		"statut" => "VARCHAR(10) DEFAULT '0' NOT NULL"
		);
	
	$spip_particuliers_key = array(
		"PRIMARY KEY"		=> "id_particulier",
		"KEY statut"		=> "statut"
	);

	$spip_particuliers_join = array(
		"id_particulier"		=> "id_particulier",
		"id_auteur" => "id_auteur"
	);
		
	$tables_principales['spip_particuliers'] = array(
		'field' => &$spip_particuliers,
		'key' => &$spip_particuliers_key,
		'join' => &$spip_particuliers_join
	);
	
	return $tables_principales;

}

?>
