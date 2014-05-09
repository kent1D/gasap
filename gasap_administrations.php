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

?>
