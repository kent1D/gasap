<?php

function gasap_header_prive($flux){
	$css = find_in_path('css/gasap.css');
	$flux .= "\n<link rel='stylesheet' href='$css' type='text/css' />\n";
	return $flux;
}
?>
