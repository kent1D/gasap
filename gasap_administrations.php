<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Installation/maj des tables de GASAP
 *
 * @param string $nom_meta_base_version
 * @param string $version_cible
 */
function gasap_upgrade($nom_meta_base_version,$version_cible){
	$maj = array();
	$maj['create'] = array(
		array('maj_tables',array('spip_gasaps,spip_producteurs,spip_particuliers,spip_gasaps_particuliers,spip_producteurs_gasaps'))
	);
	
	$maj['0.2.0'] = array(
		array('gasap_maj_anciens_statuts','')
	);
	$maj['0.3.0'] = array(
		array('gasap_maj_statuts_tronques','')
	);
	$maj['0.4.0'] = array(
		array('gasap_changer_permanance','')
	);
	$maj['0.5.0'] = array(
		array('gasap_changer_type_evelvage','')
	);
	$maj['0.6.0'] = array(
		array('gasap_changer_personne_contacte','')
	);
	// Ajout du champ quartier
	$maj['0.7.0'] = array(
		array('maj_tables',array('spip_particuliers'))
	);
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Desinstallation/suppression des tables GASAP
 *
 * @param string $nom_meta_base_version
 */
function gasap_vider_tables($nom_meta_base_version){
	sql_drop_table("spip_gasaps");
	sql_drop_table("spip_producteurs");
	sql_drop_table("spip_particuliers");
	sql_drop_table("spip_gasaps_particuliers");
	sql_drop_table("spip_producteurs_gasaps");
	effacer_meta($nom_meta_base_version);
}

/**
 *
 * Mettre à jour les anciens statuts vers les nouveaux
 * - ```prepa``` et ```en_attente``` => ```construction```
 * - ```publie``` ou ```valide``` et complet = 0 => ```libre```
 * - ```publie``` ou ```valide``` et complet = 1 => ```complet```
 */
function gasap_maj_anciens_statuts(){
	/**
	 * Tout ce qui est en prepa ou en_attente => construction
	 */
	sql_updateq('spip_gasaps',array('statut'=>'construction'),'statut="prepa"');
	sql_updateq('spip_gasaps',array('statut'=>'construction'),'statut="en_attente"');
	
	/**
	 * Tout ce qui est en publie ou valide et complet = 0 => libre
	 */
	sql_updateq('spip_gasaps',array('statut'=>'libre'),'statut="publie" AND complet=0');
	sql_updateq('spip_gasaps',array('statut'=>'libre'),'statut="valide" AND complet=0');
	
	/**
	 * Tout ce qui est en publie ou valide et complet = 1 => complet
	 */
	sql_updateq('spip_gasaps',array('statut'=>'complet'),'statut="publie" AND complet=1');
	sql_updateq('spip_gasaps',array('statut'=>'complet'),'statut="valide" AND complet=1');
	
	/**
	 * On ne touche pas au statut ```poubelle```
	 * mais on supprime le champ complet de la base
	 */
	sql_alter('TABLE spip_gasaps DROP COLUMN complet');
}

function gasap_maj_statuts_tronques(){
	sql_alter("TABLE spip_gasaps CHANGE `statut` `statut` VARCHAR(15) NOT NULL DEFAULT 'construction'");
	sql_updateq('spip_gasaps',array('statut'=>'construction'),'statut="constructi"');
}

function gasap_changer_permanance(){
	sql_alter("TABLE spip_gasaps CHANGE `permanance` `permanence` TEXT NOT NULL DEFAULT ''");
	sql_alter("TABLE spip_producteurs CHANGE `permanance` `permanence` TEXT NOT NULL DEFAULT ''");
}

function gasap_changer_type_evelvage(){
	sql_alter("TABLE spip_producteurs CHANGE `type_evelvage` `type_elevage` TEXT NOT NULL DEFAULT ''");
}

function gasap_changer_personne_contacte(){
	sql_alter("TABLE spip_particuliers CHANGE `personne_de_contacte` `personne_de_contacte` TEXT NOT NULL DEFAULT ''");
}
?>
