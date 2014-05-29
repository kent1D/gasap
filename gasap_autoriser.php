<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

// fonction pour le pipeline
function gasap_autoriser() {}

/**
 * Creer un nouveau particulier
 * 
 * Interdit dans le privé, cela ne se fait que lors de l'inscription
 * 
 * @return bool false
 */ 
function autoriser_particulier_creer_dist($faire, $type, $id, $qui, $opt){
	if(test_espace_prive())
		return false;
	return true;
}

?>