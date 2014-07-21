<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_adhassur_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();
	
	if ($id_assur = intval($arg)
	 AND autoriser('supprimer','adhassur',$id_assur)) {
	 	include_spip('action/editer_adhassur');
	 	adhclub_supprime_adhassur($id_assur);
	}
}

?>
