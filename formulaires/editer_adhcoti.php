<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_adhcoti_charger_dist($id_coti='new', $retour='', $config_fonc='cotis_edit_config', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('adhcoti',$id_coti,0,0,$retour,$config_fonc,$row,$hidden);
	
	if (!autoriser("webmestre")) {
		$valeurs['editable'] = false;
	}
	
	return $valeurs;
}

function cotis_edit_config(){
	return array();
}


function formulaires_editer_adhcoti_verifier_dist($id_coti='new', $retour='', $config_fonc='cotis_edit_config', $row=array(), $hidden=''){

	//echo "<br />.XXX debug JR2012.<br />";
	//echo "formulaires/editer_adhcoti - formulaires_editer_adhcoti_verifier_dist-Pt20.<br />";
	
	$erreurs = formulaires_editer_objet_verifier('adhcoti',$id_coti,array('titre', 'descriptif', 'mnt_cotis', 'id_saison'));

	//echo "<br />.XXX debug JR2012.<br />";
	//echo "formulaires/editer_adhcoti - formulaires_editer_adhcoti_verifier_dist-Pt21.<br />";
	
	return $erreurs;
}


function formulaires_editer_adhcoti_traiter_dist($id_coti='new', $retour='', $config_fonc='cotis_edit_config', $row=array(), $hidden=''){

	//echo "<br />.XXX debug JR2012.<br />";
	//echo "formulaires/editer_adhcoti - formulaires_editer_adhcoti_traiter_dist-Pt30.<br />";
	
	$message = "";
	$action_editer = charger_fonction("editer_adhcoti",'action');
	list($id,$err) = $action_editer();
	if ($err){
		$message .= $err;
	}
	elseif ($retour) {
		include_spip('inc/headers');
		$retour = parametre_url($retour,'id_coti',$id);
		$message .= redirige_formulaire($retour);
	}
	return $message;
}

?>
