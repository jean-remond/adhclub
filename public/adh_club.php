<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/*	Champs declares pour la recherche */
function adhclub_rechercher_liste_des_champs($tables) {
	$tables['adhnivs']['titre'] = 8;
	$tables['adhnivs']['descriptif'] = 3;
	$tables['adhnivs']['techbase'] = 5;
	$tables['adhnivs']['encadrant'] = 5;
	$tables['adhnivs']['id_trombi'] = 7;
	$tables['adhnivs']['rangtrombi'] = 7;
	$tables['adhnivs']['maj'] = 3;
	return $tables;
}
?>
