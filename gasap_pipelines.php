<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function gasap_header_prive($flux){
	$css = find_in_path('css/gasap.css');
	$flux .= "\n<link rel='stylesheet' href='$css' type='text/css' />\n";
	return $flux;
}
?>
