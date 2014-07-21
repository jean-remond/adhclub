<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

function formulaires_affecter_adhcotis_charger_dist($id_auteur){

$valeurs = array('coti'=>'','id_auteur'=>$id_auteur,'id'=>$id_auteur);
	include_spip('inc/autoriser');
	if (!autoriser('affecter_adhcotis','auteur',$id_auteur)){
		$valeurs['editable'] = false;
	}
    return $valeurs;
}

function formulaires_affecter_adhcotis_verifier_dist($id_auteur){
	/* Verifier si 1 cotisation est selectionnee */

	$erreurs = array();
	if(!intval(_request('coti'))){
		$erreurs['coti'] .= _T("Choisir 1 cotisation");
	}

	return $erreurs;
}

// ajout d'une cotisation
function formulaires_affecter_adhcotis_traiter_dist($id_auteur){

include_spip('action/editer_adhcoti');
	adhclub_revision_adhcoti_objets_lies(intval(_request('coti')),$id_auteur,'auteur');
	return array('editable'=>true,'message'=>'');
}

?>
