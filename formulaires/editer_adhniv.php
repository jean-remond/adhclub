<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_adhniv_charger_dist($id_niveau='new', $retour='', $config_fonc='niveaux_edit_config', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('adhniv',$id_niveau,0,0,$retour,$config_fonc,$row,$hidden);
	
	return $valeurs;
}

function niveaux_edit_config($row){

	return array();
}

function formulaires_editer_adhniv_verifier_dist($id_niveau='new', $retour='', $config_fonc='niveaux_edit_config', $row=array(), $hidden=''){
	$erreurs = formulaires_editer_objet_verifier('adhniv',$id_niveau,array('titre', 'techbase', 'encadrant', 'id_trombi', 'rangtrombi'));

	return $erreurs;
}

function formulaires_editer_adhniv_traiter_dist($id_niveau='new', $retour='', $config_fonc='niveaux_edit_config', $row=array(), $hidden=''){

	//echo "<br />.debug JR2012.<br />";
	//echo "formulaires/editer_adhniv - formulaires_editer_adhniv_traiter_dist-Pt30.<br />";
	
	
	$message = "";
	$action_editer = charger_fonction("editer_adhniv",'action');
	list($id,$err) = $action_editer();
	if ($err){
		$message .= $err;
	}
	elseif ($retour) {
		include_spip('inc/headers');
		$retour = parametre_url($retour,'id_niveau',$id);
		$message .= redirige_formulaire($retour);
	}
	return $message;
}

?>
