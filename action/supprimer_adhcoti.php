<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_adhcoti_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();
	
	if ($id_coti = intval($arg)
	 AND autoriser('supprimer','adhcoti',$id_coti)) {
	 	include_spip('action/editer_adhcoti');
	 	adhclub_supprime_adhcoti($id_coti);
	}
}

?>
