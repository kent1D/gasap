<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function gasap_tables_interfaces($tables_interfaces){
	
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
