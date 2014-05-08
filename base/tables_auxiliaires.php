<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function gasap_tables_auxiliaires($tables_auxiliaires){
	
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

?>
