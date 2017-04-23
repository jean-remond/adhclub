<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * ----------------------------------------------
 * @todo : JR-01/03/2017-Revoir la methode de suppression.
 * Fait :
 * JR-01/03/2017-Essai pour ecrire le log.
 * JR-10/01/2015-adaptation spip 3.0.
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_adhcoti_dist(){
	$debug1= "DEBUG plugin JR : action/supprimer_adhcoti.php - action_supprimer_adhcoti_dist - Pt01 - <br />";
	spip_log("$debug1.", true);
	spip_log("id_coti= $id_coti", true);
	$arg_log=intval($arg);
	spip_log("arg_log= $arg_log", true);
	spip_log("$debug1 FIN.", true);
	
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();
		
	$debug1= "DEBUG plugin JR : action/supprimer_adhcoti.php - action_supprimer_adhcoti_dist - Pt12 - <br />";
	spip_log("$debug1.", true);
	spip_log("id_coti= $id_coti", true);
	spip_log("args= $args", true);
	spip_log("$debug1 FIN.", true);
	
		if ($id_coti = intval($arg)
	 AND autoriser('supprimer','adhcoti',$id_coti)) {
	 	include_spip('action/editer_adhcoti');
	 	adhclub_supprime_adhcoti($id_coti);
	}
}

?>
