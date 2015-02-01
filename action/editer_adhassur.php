<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * Actions de l'environnement assurances.
 * ----------------------------------------------
 * @todo-JR-30/01/2015-Confirmer le besoin. Lie a /formulaire/ ?
 * 
 * Fait:
 * JR-30/01/2015-adaptation spip 3.0.
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * editer une assurance (action apres creation/modif de assur)
 *
 * @return array
 */
function action_editer_adhassur_dist(){

	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	// si id_assur n'est pas un nombre, c'est une creation 
	// mais on verifie qu'on a toutes les donnees qu'il faut.
	if (!$id_assur = intval($arg)) {
		if (!$id_assur = adhclub_action_insert_adhassur())
			return array(false,_L('echec'));
	}
	
	$err = action_adhassur_set($id_assur);
	return array($id_assur,$err);
}

/**
 * mettre a jour une assurance
 *
 * @param int $id_assur
 * @return string
 */
function action_adhassur_set($id_assur){
	$err = '';

	$c = array();
	foreach (array(
    'titre', 'descriptif', 'mnt_assur', 'id_saison'
	) as $champ)
		$c[$champ] = _request($champ);

	include_spip('inc/modifier');
	adhclub_revision_adhassur($id_assur, $c);
	//adhclub_revision_adhassur_objets_lies($id_assur, _request('auteurs'),'auteur','set');

	return $err;
}


/**
 * Mettre a jour les liens objets/assurs.
 * si assurs vaut '', associe toutes les assurs a(aux) objets(s).
 * $ids est une liste d'id.
 * $type est le type de l'objet (rubrique, auteur).
 * $operation = add/set/del pour ajouter, affecter uniquement, ou supprimer les objets listes dans ids.
 *
 * @param int/array $assurs
 * @param int/array $ids
 * @param string $type
 */
function adhclub_revision_adhassur_objets_lies($assurs,$ids,$type,$operation = 'add'){
	include_spip('inc/autoriser');
	$in = "";
	if ($assurs){
		$in = sql_in('id_assur',$assurs);
	}
	$liste = sql_allfetsel('id_assur','spip_adhassurs',$in);
	foreach($liste as $row){
		if ($operation=='del'){

			// on supprime les ids listes
			$adhwhere = array(
				"id_assur=".intval($row['id_assur']),
				"objet ='".$type."'",
				sql_in("id_objet",$ids)
				);
			sql_delete("spip_adhassurs_liens",$adhwhere);			

		}else {

			if (!$ids) $ids = array();
			elseif (!is_array($ids)) $ids = array($ids);
			// si c'est une affectation exhaustive, supprimer les existants qui ne sont pas dans ids
			// si c'est un ajout, ne rien effacer
			if ($operation=='set'){
				$adhwhere = array(
					"id_assur=".intval($row['id_assur']),
					"objet ='".$type."'",
					sql_in("id_objet",$ids,"NOT"),
					);
				sql_delete("spip_adhassurs_liens",$adhwhere);
			}
			$adhwhere = array(
				"id_assur=".intval($row['id_assur']),
				"objet ='".$type."'",
				);
			$deja = array_map('reset',sql_allfetsel("id_objet","spip_adhassurs_liens",$adhwhere));
			$add = array_diff($ids,$deja);
			foreach ($add as $id) {
				if (autoriser('affecterassurs',$type,$id,null,array('id_assur'=>$row['id_assur']))){
					$adhvaleur=array(
						'id_assur'	=> $row['id_assur'],
						'objet'		=> $type,
						'id_objet'	=> intval($id),
					);
					sql_insertq("spip_adhassurs_liens",$adhvaleur);
				}
			}
		}
	}	
}

/**
 * Creer une nouvelle assurance
 *
 * @return int
 */
function adhclub_action_insert_adhassur(){
	include_spip('inc/autoriser');
	if (!autoriser('creer','adhassur'))
		return false;
	// nouvelle assurance
	$adhvaleur=array(
		'titre'=> 'nouvelle',
		'descriptif'=> 'NOW()',
		'mnt_assur'=> '0.0',
	);
	$id_assur = sql_insertq("spip_adhassurs", $adhvaleur);

	if (!$id_assur){
		adhclub_log("editer_adhassur : adhclub_action_insert_adhassur : impossible d'ajouter une assurance", true);
		return false;
	} 
	return $id_assur;	
}

/**
 * Enregistre la revision d'une assurance
 *
 * @param int $id_assur
 * @param array $c
 * @return string
 */
function adhclub_revision_adhassur($id_assur, $c=false) {

	modifier_contenu('adhassur', $id_assur,
		array(
			'nonvide' => array(	'titre'		=> _T('info_sans_titre')),
		),
		$c);

	return ''; // pas d'erreur
}


/**
 * Supprimer une assurance
 *
 * @param unknown_type $supp_assur
 * @return unknown
 */
function adhclub_supprime_adhassur($id_assur){
	$supp_assur = sql_getfetsel("id_assur", "spip_adhassurs", "id_assur=" . intval($id_assur));
	if (intval($id_assur) AND 	intval($id_assur) == intval($supp_assur)){
		// d'abord les auteurs
		sql_delete("spip_adhassurs_liens", "id_assur=".intval($id_assur));
		// puis l'assurance
		sql_delete("spip_adhassurs", "id_assur=".intval($id_assur));
	}
	$id_assur = 0;
	return $id_assur;
}


?>
