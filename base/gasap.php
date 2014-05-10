<?php
/**
 * Plugin GASAP
 *
 * Auteurs :
 * Sébastien Crowfoot
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * Distribue sous licence GNU/GPL
 *
 * Déclaration des tables pour GASAP
 *
 **/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Insertion dans le pipeline declarer_tables_objets_sql (SPIP)
 *
 * On déclare nos trois nouveaux objets principaux :
 * - gasap : spip_gasaps
 * - producteur : spip_producteurs
 * - particuliers : spip_particuliers
 *
 * @param array $tables
 * 	La description complète des objets SPIP
 * @return array $tables
 * 	La description des objets SPIP modifiée
 */
function gasap_declarer_tables_objets_sql($tables){

	$tables['spip_gasaps'] = array(
		'page'=>'gasap',
		'titre' => 'nom AS titre',
		'principale' => 'oui',
		'field'=> array(
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
			"permanence" => "TEXT DEFAULT '' NOT NULL",
			"remarques" => "TEXT DEFAULT '' NOT NULL",
			"email" => "TEXT DEFAULT '' NOT NULL",
			"nombre_place"	=> "int(2) NOT NULL",
			"lat"	=> "TEXT DEFAULT '' NOT NULL",
			"lng"	=> "TEXT DEFAULT '' NOT NULL",
			"exporte"	=> "int(1) NOT NULL",
			"maj" => "TIMESTAMP",
			"statut" => "VARCHAR(15) DEFAULT 'prepa' NOT NULL"
		),
		'champs_editables' => array(
				'nom','adresse','numero','code_postal','ville','pays',
				'telephone','fax','gsm','permanence','remarques','email',
				'nombre_place','complet','lat','lng'
		),
		'rechercher_champs' => array(
				'nom' => 8, 'adresse' => 3, 'code_postal' => 3, 'ville' => 5, 'pays' => 3,
				'telephone' => 1, 'fax' => 1, 'gsm' => 1, 'permanence'=> 1, 'remarques' => 4, 'email' => 1
		),
		'key' => array(
			"PRIMARY KEY"	=> "id_gasap",
			"KEY statut"	=> "statut"
		),
		'join' => array(
			"id_gasap"=>"id_gasap",
			"id_auteur"=>"id_auteur"
		),
		'statut'=> array(
			array(
				'champ' => 'statut',
				'publie' => '!poubelle',
				'previsu' => 'construction,libre,complet',
				'post_date' => '',
				'exception' => 'statut'
			)
		),
		'statut_titres' => array(
			'construction'=>'gasap:info_gasap_construction',
			'libre'=>'gasap:info_gasap_libre',
			'complet'=>'gasap:info_gasap_complet',
			'poubelle'=>'gasap:info_gasap_supprime'
		),
		'statut_textes_instituer' => 	array(
			'construction' => 'gasap:texte_statut_construction',
			'libre' => 'gasap:texte_statut_libre',
			'complet' => 'gasap:texte_statut_complet',
			'poubelle' => 'texte_statut_poubelle',
		),
		'texte_changer_statut' => 'gasap:texte_gasap_statut'
	);

	$tables['spip_producteurs'] = array(
		'page'=>'producteur',
		'titre' => 'nom AS titre',
		'principale' => 'oui',
		'field'=> array(
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
			"permanence" => "TEXT DEFAULT '' NOT NULL",
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
		),
		'champs_editables' => array(
				'nom','prenom','adresse','numero','code_postal','ville','pays',
				'telephone','fax','gsm','permanence','remarques','email',
				'nom_ferme','label_bio','biodynamie','type_culture','type_evelvage','transformation',
				'taille_ferme','distance_bruxelles','stade','commentaires'
		),
		'rechercher_champs' => array(
				'nom' => 8, 'prenom' => 5, 'adresse' => 3, 'code_postal' => 3, 'ville' => 5, 'pays' => 3,
				'telephone' => 1, 'fax' => 1, 'gsm' => 1, 'permanence'=> 1, 'remarques' => 4, 'email' => 1,
				'nom_ferme' => 8, 'label_bio' => 4, "biodynamie" => 1,'type_culture'=> 3, 'type_evelvage' => 3, 'transformation' => 2,
				'taille_ferme' => 1, 'stade' => 1, 'commentaires' => 3
		),
		'key' => array(
			"PRIMARY KEY"		=> "id_producteur",
			"KEY label_bio"		=> "label_bio",
			"KEY biodynamie"		=> "biodynamie",
			"KEY distance_bruxelles"		=> "distance_bruxelles",
			"KEY statut"		=> "statut"
		),
		'join' => array(
			"id_producteur"	=> "id_producteur",
			"id_auteur" => "id_auteur"
		)
	);

	$tables['spip_particuliers'] = array(
		'page'=>'particulier',
		'titre' => 'nom AS titre',
		'principale' => 'oui',
		'field'=> array(
			"id_particulier"	=> "bigint(21) NOT NULL",
			"nom" => "VARCHAR(255) DEFAULT '' NOT NULL",
			"prenom" => "VARCHAR(255) DEFAULT '' NOT NULL",
			"adresse" => "VARCHAR(255) DEFAULT '' NOT NULL",
			"code_postal" => "VARCHAR(20) DEFAULT '' NOT NULL",
			"ville" => "VARCHAR(255) DEFAULT '' NOT NULL",
			"commune" => "VARCHAR(255) DEFAULT '' NOT NULL",
			"telephone" => "VARCHAR(255) DEFAULT '' NOT NULL",
			"email" => "TEXT DEFAULT '' NOT NULL",
			"remarques"	=> "TEXT NOT NULL",
			"personne_de_contacte"	=> "TEXT NOT NULL",
			"composition_menage"	=> "int(1) NOT NULL",
			"exporte"	=> "int(1) NOT NULL",
			"maj" => "TIMESTAMP",
			"statut" => "VARCHAR(10) DEFAULT '0' NOT NULL"
		),
		'champs_editables' => array(
			'nom',
			'prenom',
			'adresse',
			'code_postal',
			'ville',
			'commune',
			'telephone',
			'email',
			'remarques',
			'personne_de_contacte',
			'composition_menage'
		),
		'rechercher_champs' => array(
			'nom' => 8, 'prenom' => 5, 'adresse' => 3, 'code_postal' => 3, 'ville' => 5, 'commune' => 3,
			'telephone' => 1, 'email' => 1, 'remarques' => 4, 'personne_de_contacte' => 4, 'composition_menage' => 1
		),
		'key' => array(
			"PRIMARY KEY" => "id_particulier",
			"KEY statut" => "statut"
		),
		'join' => array(
			"id_particulier" => "id_particulier",
			"id_auteur" => "id_auteur"
		)
	);

	return $tables;
}

/**
 * Insertion dans le pipeline declarer_tables_auxiliaires (SPIP)
 *
 * Declaration des tables auxiliaires spip_gasaps_particuliers, spip_producteurs_gasaps
 *
 * @param array $tables_auxiliaires
 * 	Un tableau de description des tables auxiliaires
 * @return array $tables_auxiliaires
 * 	Le tableau des tables auxiliaires complété
 */
function gasap_declarer_tables_auxiliaires($tables_auxiliaires){

	$spip_gasaps_particuliers = array(
		"id_gasap"	=> "bigint(21) NOT NULL",
		"id_particulier"	=> "bigint(21) NOT NULL"
	);

	$spip_gasaps_particuliers_key = array(
		"PRIMARY KEY"		=> "id_gasap,id_particulier"
	);

	$tables_auxiliaires['spip_gasaps_particuliers'] = array(
		'field' => &$spip_gasaps_particuliers,
		'key' => &$spip_gasaps_particuliers_key
	);


	$spip_producteurs_gasaps = array(
		"id_producteur"	=> "bigint(21) NOT NULL",
		"id_gasap"	=> "bigint(21) NOT NULL"
	);

	$spip_producteurs_gasaps_key = array(
		"PRIMARY KEY"		=> "id_producteur,id_gasap"
	);

	$tables_auxiliaires['spip_producteurs_gasaps'] = array(
		'field' => &$spip_producteurs_gasaps,
		'key' => &$spip_producteurs_gasaps_key
	);

	return $tables_auxiliaires;
}


function gasap_declarer_tables_interfaces($tables_interfaces){

	$tables_interfaces['table_des_tables']['gasaps'] = 'gasaps';
	$tables_interfaces['table_des_tables']['producteurs'] = 'producteurs';
	$tables_interfaces['table_des_tables']['particuliers'] = 'particuliers';

	$tables_interfaces['tables_jointures']['gasaps'][] = 'producteurs_gasaps';
	$tables_interfaces['tables_jointures']['producteurs'][] = 'producteurs_gasaps';

	$tables_interfaces['tables_jointures']['gasaps'][] = 'gasaps_particuliers';
	$tables_interfaces['tables_jointures']['particuliers'][] = 'gasaps_particuliers';

	return $tables_interfaces;
}

?>
