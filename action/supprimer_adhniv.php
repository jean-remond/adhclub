<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_adhniv_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();
	
	if ($id_niveau = intval($arg)
	 AND autoriser('supprimer','adhniv',$id_niveau)) {
	 	include_spip('action/editer_adhniv');
	 	adhclub_supprime_adhniv($id_niveau);
	}
}

?>
