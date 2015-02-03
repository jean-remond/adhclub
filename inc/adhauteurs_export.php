<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2013 Jean Remond
 * -----------------
 * D'apres CSVimport
 * Plug-in d'import csv dans les tables spip et d'export CSV des tables
 *
 * Auteur :
 * Cedric MORIN
 * notre-ville.net
 * © 2005,2009 - Distribue sous licence GNU/GPL
 *
 * ----------------------------------------------
 * Fonctions pour le telechargement des donnees filtrees des auteurs. 
 * ----------------------------------------------
 * @todo-JR-20150202-Valider l'utilite.
 * 
 * Fait :
 * ----
 * JR-22/05/2013-Creation du squelette.
 *
 */

include_spip("base/abstract_sql");
include_spip("inc/charsets");
include_spip("inc/importer_csv");

function adhclub_csv_champ($champ) {
	$champ = preg_replace(',[\s]+,', ' ', $champ);
	$champ = str_replace(',",', '""', $champ);
	return '"'.$champ.'"';
}

function adhclub_csv_ligne($ligne, $delim = ',') {
	return join($delim, array_map('adhclub_csv_champ', $ligne))."\r\n";
}

/* JR-22/05/2013-Non utilise pour le moment
function adhclub_importcharset($texte){
	return importer_csv_importcharset($texte);
}*/

/* JR-22/05/2013-Non utilise pour le moment
function adhclub_show_erreurs($erreur){
	$output = "";
	
	if (count($erreur)>0){
		$output .= "<div class='messages'>";
		
		foreach($erreur as $line=>$desc)
			foreach($desc as $key=>$val)
				$output .=  " Ligne $line :: $val <br />";
				
		$output .=  "</div>\n";
	}
	
	return $output;
}*/

?>
