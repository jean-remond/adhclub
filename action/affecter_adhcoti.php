<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return; 

function action_affecter_adhcoti_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();
	
	if (preg_match(',^([0-9]+|-1)-([a-z]+)-([0-9]+|-1)$,',$arg,$regs)
	  AND $regs[2]=='auteur')	{
		$id_coti = intval($regs[1]);
		$id_auteur = intval($regs[3]);
		include_spip('action/editer_adhcoti');
		if ($id_auteur==-1)
			$id_auteur = array_map('reset',sql_allfetsel('id_auteur','spip_auteurs',"statut!='poub'"));
		adhclub_revision_adhcoti_objets_lies($id_coti=='-1'?'':$id_coti,$id_auteur,'auteur');
	}
}

?>
