<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2011 Jean Remond
 *
 */

function formulaires_affecter_adhnivs_charger_dist($id_auteur){
	$valeurs = array('niveau'=>'','id_auteur'=>$id_auteur,'id'=>$id_auteur);
	include_spip('inc/autoriser');
	if (!autoriser('affecter_adhnivs','auteur',$id_auteur)){
		$valeurs['editable'] = false;
	}
	return $valeurs;
}

function formulaires_affecter_adhnivs_verifier_dist($id_auteur){
	/* Verifier si 1 niveau est selectionne */
	//echo "<br />.XXX debug JR : formulaire/affecter_adhnivs - formulaires_affecter_adhnivs_verifier_dist - Pt20.<br />";
	//$field=_request('niveau');
	//echo "id_niveau= $field.<br />";
	//echo "id_auteur= $id_auteur.<br />";

		$erreurs = array();
	if(!intval(_request('niveau'))){
		$erreurs['niveau'] .= _T("Choisir 1 niveau");
	}
	
	return $erreurs;
}

function formulaires_affecter_adhnivs_traiter_dist($id_auteur){
	/* ajout d'un niveau */
	include_spip('action/editer_adhniv');
	adhclub_revision_adhniv_objets_lies(intval(_request('niveau')),$id_auteur,'auteur');
	return array('editable'=>true,'message'=>'');
}

?>