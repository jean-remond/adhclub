<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2011 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_adhsaison_charger_dist($id_saison='new', $retour='', $config_fonc='saisons_edit_config', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('adhsaison',$id_saison,0,0,$retour,$config_fonc,$row,$hidden);
	
	return $valeurs;
}

function saisons_edit_config(){
	return array();
}

function formulaires_editer_adhsaison_verifier_dist($id_saison='new', $retour='', $config_fonc='saisons_edit_config', $row=array(), $hidden=''){
	$erreurs = formulaires_editer_objet_verifier('adhsaison',$id_saison,array('titre', 'descriptif', 'saison_deb'));

	return $erreurs;

}


function formulaires_editer_adhsaison_traiter_dist($id_saison='new', $retour='', $config_fonc='saisons_edit_config', $row=array(), $hidden=''){

	$message = "";
	$action_editer = charger_fonction("editer_adhsaison",'action');

	list($id,$err) = $action_editer();

	if ($err){
		$message .= $err;
	}
	elseif ($retour) {
		include_spip('inc/headers');
		$retour = parametre_url($retour,'id_saison',$id);
		$message .= redirige_formulaire($retour);
	}
	return $message;
}

?>
