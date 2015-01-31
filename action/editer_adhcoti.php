<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * Actions de l'environnement cotisations.
 * ----------------------------------------------
 * @todo-JR-30/01/2015-Confirmer le besoin. Lie a /formulaire/ ?
 * 
 * Fait:
 * JR-30/01/2015-adaptation spip 3.0.
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * editer une cotisation (action apres creation/modif de cotisation)
 *
 * @return array
 */
function action_editer_adhcoti_dist(){

	$debug1= "DEBUG plugin JR : action/editer_adhcoti.php - action_editer_adhcoti_dist - Pt02 - <br />";
	echo "<br />", $debug1;
	echo "FIN ", $debug1;
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	// si id_coti n'est pas un nombre, c'est une creation 
	// mais on verifie qu'on a toutes les donnees qu'il faut.
	if (!$id_coti = intval($arg)) {
		if (!$id_coti = adhclub_action_insert_adhcoti())
			return array(false,_L('echec'));
	}
	
	$err = action_adhcoti_set($id_coti);
	return array($id_coti,$err);
}

/**
 * mettre a jour une cotisation
 *
 * @param int $id_coti
 * @return string
 */
function action_adhcoti_set($id_coti){
	$err = '';

	$c = array();
	foreach (array(
	'titre', 'descriptif', 'mnt_cotis', 'id_saison'
	) as $champ)
		$c[$champ] = _request($champ);

	foreach (array(
			'complement'
	) as $champ)
		$c[$champ] = _request($champ)=='oui'?'oui':'non';
	
	include_spip('inc/modifier');
	adhclub_revision_adhcoti($id_coti, $c);
	//adhclub_revision_adhcoti_objets_lies($id_coti, _request('auteurs'),'auteur','set');

	return $err;
}


/**
 * Mettre a jour les liens objets/cotisations.
 * si cotis vaut '', associe toutes les cotis a(aux) objets(s).
 * $ids est une liste d'id.
 * $type est le type de l'objet (rubrique, auteur).
 * $operation = add/set/del pour ajouter, affecter uniquement, ou supprimer les objets listes dans ids.
 *
 * @param int/array $cotis
 * @param int/array $ids
 * @param string $type
 */
function adhclub_revision_adhcoti_objets_lies($cotis,$ids,$type,$operation = 'add',$ref_saisie = 'direct'){

            //echo "<br />.debug JR.<br />";
            //echo "action/editer_adhcoti Action-Pt0.<br />";

	include_spip('inc/autoriser');
	$in = "";
	if ($cotis){
		$in = sql_in('id_coti',$cotis);
	}
	$liste = sql_allfetsel('id_coti','spip_adhcotis',$in);
	foreach($liste as $row){
		if ($operation=='del'){

            //echo "<br />.debug JR.<br />";
            //echo "action/editer_adhcoti Action-Pt1.<br />";

			// on supprime les ids listes
			$adhwhere = array(
				"id_coti=".intval($row['id_coti']),
				"objet =".$type,
				sql_in("id_objet",$ids)
				);
			sql_delete("spip_adhcotis_liens",$adhwhere);			

            //echo "<br />.debug JR.<br />";
            //echo "action/editer_adhcoti Action-Pt2.<br />";

		}
		else {

            //echo "<br />.debug JR.<br />";
            //echo "action/editer_adhcoti Action-Pt3.<br />";

			if (!$ids) $ids = array();
			elseif (!is_array($ids)) $ids = array($ids);
			// si c'est une affectation exhaustive, supprimer les existants qui ne sont pas dans ids
			// si c'est un ajout, ne rien effacer
			if ($operation=='set'){
				$adhwhere = array(
					"id_coti=".intval($row['id_coti']),
					"objet =".$type,
					sql_in("id_objet",$ids,"NOT"),
					);
				sql_delete("spip_adhcotis_liens",$adhwhere);
			}
			$adhwhere = array(
				"id_coti=".intval($row['id_coti']),
				"objet =".$type,
				);
			$deja = array_map('reset',sql_allfetsel("id_$type","spip_adhcotis_liens",$adhwhere));
			$add = array_diff($ids,$deja);
			foreach ($add as $id) {
				if (autoriser('affectercotis',$type,$id,null,array('id_coti'=>$row['id_coti']))){
					$adhvaleur=array(
						'id_coti'	=> $row['id_coti'],
						'objet'		=> $type,
						'id_objet'	=> intval($id),
						'ref_saisie'=> $ref_saisie,
					);
					sql_insertq("spip_adhcotis_liens",$adhvaleur);
				}
			}
		}
	}	
}

/**
 * Creer une nouvele cotisation
 *
 * @return int
 */
function adhclub_action_insert_adhcoti(){
	include_spip('inc/autoriser');

	if (!autoriser('creer','adhcoti'))
		return false;
	// nouvelle cotisation
	$adhvaleur=array(
		'titre'=> 'nouvelle',
		'descriptif'=> 'NOW()',
		'mnt_cotis'=> '0.0',
	);
	$id_coti = sql_insertq("spip_adhcotis", $adhvaleur);

	if (!$id_coti){
		adhclub_log("editer_adhcoti : adhclub_action_insert_adhcoti : impossible d'ajouter une cotisation", true);
		return false;
	} 
	return $id_coti;	
}

/**
 * Enregistre la revision d'une cotisation
 *
 * @param int $id_coti
 * @param array $c
 * @return string
 */
function adhclub_revision_adhcoti($id_coti, $c=false) {

	$debug1= "DEBUG plugin JR : action/editer_adhcoti.php - adhclub_revision_adhcoti - Pt02 - <br />";
	echo "<br />", $debug1;
	echo "id_coti= $id_coti.<br />";
		// un tableau (array)
	echo "c= <br />"; var_dump($c); echo ".<br />";
	echo "FIN ", $debug1;
	
	modifier_contenu('adhcoti', $id_coti,
		array(
			'nonvide' => array(	'titre'		=> _T('info_sans_titre'))
		),
		$c);

	return ''; // pas d'erreur
}


/**
 * Supprimer une cotisation
 *
 * @param unknown_type $supp_coti
 * @return unknown
 */
function adhclub_supprime_adhcoti($id_coti){
	$supp_coti = sql_getfetsel("id_coti", "spip_adhcotis", "id_coti=" . intval($id_coti));
	if (intval($id_coti) AND 	intval($id_coti) == intval($supp_coti)){
		// d'abord les auteurs
		sql_delete("spip_adhcotis_liens", "id_coti=".intval($id_coti));
		// puis la cotisation
		sql_delete("spip_adhcotis", "id_coti=".intval($id_coti));
	}
	$id_coti = 0;
	return $id_coti;
}


?>
