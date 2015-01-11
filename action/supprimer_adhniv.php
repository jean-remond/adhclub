<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * ----------------------------------------------
 * JR-10/01/2015-adaptation spip 3.0.
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
