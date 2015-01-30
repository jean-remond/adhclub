<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * ----------------------------------------------
 * JR-10/01/2015-adaptation spip 3.0.
*/

function formulaires_affecter_adhassurs_charger_dist($id_auteur){
	$valeurs = array('assur'=>'','id_auteur'=>$id_auteur,'id'=>$id_auteur);
	include_spip('inc/autoriser');
	if (!autoriser('affecter_adhassurs','auteur',$id_auteur)){
		$valeurs['editable'] = false;
	}
	return $valeurs;
}

function formulaires_affecter_adhassurs_verifier_dist($id_auteur){
	/* Verifier si 1 cotisation est selectionnee */

	$erreurs = array();
	if(!intval(_request('assur'))){
		$erreurs['assur'] .= _T("Choisir 1 assurance");
	}

	return $erreurs;
}

function formulaires_affecter_adhassurs_traiter_dist($id_auteur){
	/* ajout d'une assurance */
	include_spip('action/editer_adhassur');
	adhclub_revision_adhassur_objets_lies(intval(_request('assur')),$id_auteur,'auteur');
	return array('editable'=>true,'message'=>'');
}

?>
