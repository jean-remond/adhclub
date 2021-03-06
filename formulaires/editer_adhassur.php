<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_adhassur_charger_dist($id_assur='new', $retour='', $config_fonc='assurs_edit_config', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('adhassur',$id_assur,0,0,$retour,$config_fonc,$row,$hidden);

	return $valeurs;
}

function assurs_edit_config(){
	return array();
}

function formulaires_editer_adhassur_verifier_dist($id_assur='new', $retour='', $config_fonc='assurs_edit_config', $row=array(), $hidden=''){
	$erreurs = formulaires_editer_objet_verifier('adhassur',$id_assur,array('titre', 'descriptif', 'mnt_assur', 'id_saison'));
	return $erreurs;

}


function formulaires_editer_adhassur_traiter_dist($id_assur='new', $retour='', $config_fonc='assurs_edit_config', $row=array(), $hidden=''){

	$message = "";
	$action_editer = charger_fonction("editer_adhassur",'action');
	list($id,$err) = $action_editer();
	if ($err){
		$message .= $err;
	}
	elseif ($retour) {
		include_spip('inc/headers');
		$retour = parametre_url($retour,'id_assur',$id);
		$message .= redirige_formulaire($retour);
	}
	return $message;
}

?>
