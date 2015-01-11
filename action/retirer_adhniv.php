<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_retirer_adhniv_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();

	if (preg_match(',^([0-9]+|-1)-([a-z]+)-([0-9]+|-1)$,',$arg,$regs)){
		$id_niveau = intval($regs[1]);
		$type = $regs[2];
		$id_objet = intval($regs[3]);
		include_spip('action/editer_adhniv');
		if ($id_objet=='-1'){

			//adhclub_log("action/retirer_adhniv action_retirer_adhniv_dist Pt20 : id_niveau=$id_niveau", true);
			//echo "<br />.XXX debug JR : action/retirer_adhniv - action_retirer_adhniv_dist - Pt20.<br />";
			//echo "regs= <br />"; var_dump($regs); echo ".<br />";
			//echo "id_niveau= $id_niveau.<br />";
			//echo "type= $type.<br />";
			//echo "id_objet= $id_objet.<br />";
			//echo "action/retirer_adhniv - action_retirer_adhniv_dist - Pt20.<br />";
			
			adhclub_revision_adhniv_objets_lies($id_niveau,array(),$type,'set');
		}
		else{

			//echo "<br />.debug JR2012.<br />";
			//echo "action/retirer_adhniv - action_retirer_adhniv_dis-Pt20 del.<br />";

			adhclub_revision_adhniv_objets_lies($id_niveau,$id_objet,$type,'del');
		}
	}
}

?>
