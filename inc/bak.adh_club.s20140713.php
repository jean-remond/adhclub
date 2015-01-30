<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/** 2013/01/10-JR- Utilite ??
 * liste des mots d'un groupe de mots
 *
 * @param text $type => (titre du groupe de mots)
 * @return array
 */
/*function adhclub_liste_contenu_groupe_mots($type) {
	$liste_mots=array();
	include_spip('base/abstract_sql');
	$liste_mots = sql_allfetsel(array('id_mot', 'titre'),"spip_mots","type=".($type));
	$liste_mots = array_map('reset',$liste_mots);
	return $liste_mots;
}*/

?>
