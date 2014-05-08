<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function getCoordonnees($adresse){
    $apiKey = "ABQIAAAASWAcLaI4XRLg2d_ie7srFhR8J9FDO_dn1ZcGjWdzCPjsp6HLQxQVQXEElprJA690GUbrSD9kdviiCg";//Indiquez ici votre clé Google maps !
    $url = "http://maps.google.com/maps/geo?q=".urlencode($adresse)."&output=csv&key=".$apiKey;
    $csv = file($url);
    $donnees = split(",",$csv[0]);
    //return $donnees[2].",".$donnees[3];
    //die(var_dump($url));
    return $donnees;
}

function action_get_coordonees_dist(){
	/*
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$valeur = explode(":",$arg);
	*/
// selection
	include_spip("base/abstract_sql");
	include_spip("inc/utils");
	spip_log("Mise a jour des coordonnees","gasap");
	$resultats = sql_select(Array("id_gasap","adresse","numero","code_postal","ville","pays"),"spip_gasaps",Array("lat = ''"));

	//print_r($resultats);
	//echo sql_count($resultats);

	// boucler sur les resultats
	while ($res = sql_fetch($resultats)) {
		//echo $res["adresse"]." ".$res["numero"].", ".$res["code_postal"]." ".$res["ville"].", ".$res["pays"];
		$coordonnees = getCoordonnees($res["adresse"]." ".$res["numero"].", ".$res["code_postal"]." ".$res["ville"].", ".$res["pays"]);
		//var_dump($coordonnees);
		spip_log("Update lat lng de ".$gasap["id_gasap"]." avec ".print_r($coordonnees,true),"gasap");
		sql_updateq("spip_gasaps",Array("lat" => $coordonnees[2],"lng" => $coordonnees[3],"maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$res["id_gasap"]));
		//echo "</br>";
	}

	/*
	$gasap = sql_select();
	$gasap = sql_select(Array("id_gasap","adresse","numero","code_postal","ville","pays"),"spip_gasaps",Array("lat = ''"));
	die(var_dump($gasap));
	* 
	$coordonnees = getCoordonnees($gasap["adresse"]." ".$gasap["numero"].", ".$gasap["code_postal"]." ".$gasap["ville"].", ".$gasap["pays"]);
	die(var_dump($coordonnees));
	spip_log("Update lat lng de ".$gasap["id_gasap"],"gasap");
	sql_updateq("spip_gasaps",Array("lat" => $coordonnees[2],"lng" => $coordonnees[3],"maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$gasap["id_gasap"]));
	*/
	//sql_updateq("spip_gasaps",Array("complet" => "1","maj" => date("Y-m-d G:i:s")),Array("id_gasap = ".$valeur[1]));
	
}

?>
