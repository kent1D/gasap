<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function gasap_upgrade($nom_meta_base_version,$version_cible){
	
	if ($version_cible > $GLOBALS['meta'][$nom_meta_base_version]){
		
		if ($GLOBALS['meta'][$nom_meta_base_version] == ""){
			echo 'gasap install '.$version_cible;
			include_spip('base/create');
			creer_base();
			maj_tables("spip_gasaps");
			maj_tables("spip_producteurs");
			maj_tables("spip_particuliers");
			maj_tables("spip_gasaps_particuliers");
			maj_tables("spip_producteurs_gasaps");
		}else{
			echo 'gasap '.$GLOBALS['meta'][$nom_meta_base_version].' maj from '.$version_cible;
			maj_tables("spip_gasaps");
			maj_tables("spip_producteurs");
			maj_tables("spip_particuliers");
			maj_tables("spip_gasaps_particuliers");
			maj_tables("spip_producteurs_gasaps");
		}
		
	}else{
		echo "gasap @ ".$version_cible;
	}
	ecrire_meta($nom_meta_base_version, $current_version=$version_cible);
	ecrire_metas();
}

function gasap_vider_tables($nom_meta_base_version){
	sql_drop_table("spip_gasaps");
	sql_drop_table("spip_producteurs");
	sql_drop_table("spip_particuliers");
	sql_drop_table("spip_gasaps_particuliers");
	sql_drop_table("spip_producteurs_gasaps");
	effacer_meta('gasapdb_version');
	effacer_meta($nom_meta_base_version);
}

?>
