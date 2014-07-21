<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Lister les saisons auxquel une assurance appartient
 *
 * @param int $id_saison
 * @return array
 */
function adhclub_saisons_de_1assur($id_assur){
	static $liste_saisons = array();
	if (!isset($liste_saisons[$id_assur])){
		include_spip('base/abstract_sql');
		$liste_saisons[$id_assur] = sql_allfetsel("id_saison","spip_adhassurs","id_assur=".intval($id_assur));
		$liste_saisons[$id_assur] = array_map('reset',$liste_assurs[$id_saison]);
	}
	return $liste_assurs[$id_saison];
}

/**
 * Lister les saisons auxquel une cotisation appartient
 *
 * @param int $id_saison
 * @return array
 */
function adhclub_saisons_de_1coti($id_coti){
	static $liste_saisons = array();
	if (!isset($liste_saisons[$id_coti])){
		include_spip('base/abstract_sql');
		$liste_saisons[$id_coti] = sql_allfetsel("id_saison","spip_adhcotis","id_coti=".intval($id_coti));
		$liste_saisons[$id_coti] = array_map('reset',$liste_cotis[$id_saison]);
	}
	return $liste_cotis[$id_saison];
}

/** JR-09/01/2013-Utlisation ??
 * Verifier si une saison appartient a une assurance.
 * utilise la fonction precedente qui met en cache son resultat
 * on optimise en fonction de l'hypothese que le nombre d'assurances est toujours reduit
 *
 * @param unknown_type $assur
 * @param unknown_type $id_saison
 * @return unknown
 */
/*function adhclub_test_appartenance_assur_saison($id_assurs,$id_saison){
	return in_array($id_assur,adhclub_liste_assurs_appartenance_saison($id_saison));
}*/

/** JR-09/01/2013-Utlisation ??
 * Verifier si une saison appartient a une cotisation.
 * utilise la fonction precedente qui met en cache son resultat
 * on optimise en fonction de l'hypothese que le nombre de cotisations est toujours reduit
 *
 * @param int $id_coti
 * @param int $id_saison
 * @return array
 */
/*function adhclub_test_appartenance_coti_saison($id_cotis,$id_saison){
	return in_array($id_coti,adhclub_liste_cotis_appartenance_saison($id_saison));
}*/

/**
 * liste des assurances contenus dans une saison
 *
 * @param int $id_saison
 * @return array $liste_assurs (1,2,3,etc..)
 */
function adhclub_assurs_ds_1saison($id_saison) {
	$liste_assurs=array();
	include_spip('base/abstract_sql');
	$liste_assurs = sql_allfetsel("id_assur","spip_adhassurs","id_saison=".intval($id_saison));
	$liste_assurs = array_map('reset',$liste_assurs);
	return $liste_assurs;
}


?>
