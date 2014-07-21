<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

// declarer le pipeline pour le core
//$GLOBALS['spip_pipeline']['adhclub_liste_niveaux_autorises']='';

if (isset($GLOBALS['meta']["adhclub_base_version"])){


    // Pour les niveaux :
    
    // Si on n'est pas connecte, aucune autorisation n'est disponible
	// pas la peine de sortir la grosse artillerie
	if (!isset($GLOBALS['auteur_session']['id_auteur'])){
		$GLOBALS['adhclub_niveaux_autorises'] = '';
	}
	else {
		include_spip('inc/adh_niveau');
		// Pipeline : calculer les niveaux autorisees, sous la forme '1,2,3,...' 
		// TODO : avec un petit cache pour eviter de solliciter la base de donnees
		$GLOBALS['adhclub_niveaux_autorises'] =
			pipeline('adhclub_liste_niveaux_autorises', '');
	}

	// Ajouter un marqueur de cache pour le differencier selon les autorisations
	if (!isset($GLOBALS['marqueur'])) $GLOBALS['marqueur'] = '';
	$GLOBALS['marqueur'] .= ":adhclub_niveaux_autorises="
		.$GLOBALS['adhclub_niveaux_autorises'];

}

?>
