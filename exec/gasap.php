<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');

function exec_gasap_dist(){
	// si pas autorise : message d'erreur
	if (!autoriser('voir', 'gasap')) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}
	// pipeline d'initialisation
	pipeline('exec_init', array('args'=>array('exec'=>'gasap'),'data'=>''));
	// entetes
	
	$commencer_page = charger_fonction('commencer_page', 'inc');
	// titre, partie, sous_partie (pour le menu)
	echo $commencer_page(_T('plugin:titre_gasap'), "editer", "editer");
	
	// titre
	echo gros_titre(_T('plugin:titre_gasap'),'', false);
	
	// colonne gauche
	echo debut_gauche('', true);
	echo pipeline('affiche_gauche', array('args'=>array('exec'=>'gasap'),'data'=>''));
	
	// colonne droite
	echo creer_colonne_droite('', true);
	echo pipeline('affiche_droite', array('args'=>array('exec'=>'gasap'),'data'=>''));
	
	// centre
	echo debut_droite('', true);
	// contenu
	// ...
	echo "afficher ici ce que l'on souhaite !";
	// ...
	// fin contenu
	echo pipeline('affiche_milieu', array('args'=>array('exec'=>'gasap'),'data'=>''));
	echo fin_gauche(), fin_page();
}
?>
