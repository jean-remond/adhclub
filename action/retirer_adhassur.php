<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * ----------------------------------------------
 * JR-10/01/2015-adaptation spip 3.0.
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_retirer_adhassur_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();
	
	if (preg_match(',^([0-9]+|-1)-([a-z]+)-([0-9]+|-1)$,',$arg,$regs)){
		$id_assur = intval($regs[1]);
		$type = $regs[2];
		$id_objet = intval($regs[3]);
		include_spip('action/editer_adhassur');
		if ($id_objet=='-1')
			adhclub_revision_adhassur_objets_lies($id_assur,array(),$type,'set');
		else
			adhclub_revision_adhassur_objets_lies($id_assur,$id_objet,$type,'del');
	}
}

?>
