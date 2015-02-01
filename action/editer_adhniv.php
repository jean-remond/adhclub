<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * Actions de l'environnement niveaux.
 * ----------------------------------------------
 * @todo-JR-30/01/2015-Confirmer le besoin. Lie a /formulaire/ ?
 * 
 * Fait:
 * JR-30/01/2015-adaptation spip 3.0.
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * editer un niveau (action apres creation/modif de niveau)
 *
 * @return array
 */
function action_editer_adhniv_dist(){

	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	// si id_niveau egal 'x', il n'y a pas eut de choix 
	//if ('x' == $arg) 
		//return array(false,_L(':adhsaison:selectionner_un_niveau:'));

	// si id_niveau n'est pas un nombre, c'est une creation 
	// mais on verifie qu'on a toutes les donnees qu'il faut.
	if (!$id_niveau = intval($arg)) {
		//$id_niveau = adhclub_action_insert_adhniv();
		if (!$id_niveau = adhclub_action_insert_adhniv())
			return array(false,_L('echec'));
		// ajouter les droits a l'admin si demande, lors de la creation
		if (_request('droits_admin')){
			adhclub_revision_adhniv_objets_lies($id_niveau,$GLOBALS['visiteur_session']['id_auteur'],'auteur');
		}
	}
	
	$err = action_adhniv_set($id_niveau);
	return array($id_niveau,$err);
}

/**
 * mettre a jour un niveau
 *
 * @param int $id_niveau
 * @return string
 */
function action_adhniv_set($id_niveau){
	$err = '';
	
	$c = array();
	foreach (array(
		'titre', 'descriptif', 'techbase', 'encadrant', 'id_trombi', 'rangtrombi'
        ) as $champ)
		$c[$champ] = _request($champ);

	include_spip('inc/modifier');
	adhclub_revision_adhniv($id_niveau, $c);
	//adhclub_revision_adhniv_objets_lies($id_niveau, _request('auteurs'),'auteur','set');

	return $err;
}


/**
 * Mettre a jour les liens objets/niveaux.
 * si niveaux vaut '', associe tous les niveaux a(aux) objets(s).
 * $ids est une liste d'id.
 * $type est le type de l'objet (rubrique, auteur).
 * $operation = add/set/del pour ajouter, affecter uniquement, ou supprimer les objets listes dans ids.
 *
 * @param int/array $niveaux
 * @param int/array $ids
 * @param string $type
 */
function adhclub_revision_adhniv_objets_lies($niveaux,$ids,$type,$operation = 'add'){
	include_spip('inc/autoriser');
	$in = "";
	
		//echo "<br />.XXX debug JR : action/editer_adhniv - adhclub_revision_adhniv_objets_lies - Pt30.<br />";
		//echo "niveaux= <br />"; var_dump($niveaux); echo ".<br />";
		//echo "ids= $ids.<br />";
		//echo "type= $type.<br />";
		//echo "operation= $operation.<br />";
		//echo "action/editer_adhniv - adhclub_revision_adhniv_objets_lies-Pt30.<br />";
		
	if ($niveaux){
		$in = sql_in('id_niveau',$niveaux);
	}
	$liste = sql_allfetsel('id_niveau','spip_adhnivs',$in);
	foreach($liste as $row){
		if ($operation=='del'){
			// on supprime les ids listes
			$adhwhere = array(
				"id_niveau=".intval($row['id_niveau']),
				"objet ='".$type."'",
				sql_in("id_objet",$ids)
				);
			sql_delete("spip_adhnivs_liens",$adhwhere);			
		}
		else {
			if (!$ids) $ids = array();
			elseif (!is_array($ids)) $ids = array($ids);
			// si c'est une affectation exhaustive, supprimer les existants qui ne sont pas dans ids
			// si c'est un ajout, ne rien effacer
			if ($operation=='set'){
				$adhwhere = array(
					"id_niveau=".intval($row['id_niveau']),
					"objet ='".$type."'",
					sql_in("id_objet",$ids,"NOT"),
					);
				sql_delete("spip_adhnivs_liens",$adhwhere);
			}
			$adhwhere = array(
				"id_niveau=".intval($row['id_niveau']),
				"objet ='".$type."'",
				);
			$deja = array_map('reset',sql_allfetsel("id_objet","spip_adhnivs_liens",$adhwhere));
			$add = array_diff($ids,$deja);
			foreach ($add as $id) {
				if (autoriser('affecterniveaux',$type,$id,null,array('id_niveau'=>$row['id_niveau']))){
					$adhvaleur=array(
						'id_niveau'=> $row['id_niveau'],
						'objet'		=> $type,
						'id_objet'	=> intval($id),
					);
					sql_insertq("spip_adhnivs_liens",$adhvaleur);
				}
			}
		}
	}	
}

/**
 * Creer un nouveau niveau
 *
 * @return int
 */
function adhclub_action_insert_adhniv(){
	include_spip('inc/autoriser');
	if (!autoriser('creer','adhniv'))
		return false;
	// nouveau niveau
	$id_niveau = sql_insertq("spip_adhnivs", 
            array(  'titre'=>'Nouvelle', 
                        'descriptif'=>'NOW()', 
                        'techbase'=>'PLG', 
                        'encadrant'=>'ADH', 
                        'id_trombi'=>'0', 
                        'rangtrombi'=>'2', 
                        ));

	if (!$id_niveau){
		adhclub_log("editer_adhniv : adhclub_action_insert_adhniv : impossible d'ajouter un niveau", true);
		return false;
	} 
	return $id_niveau;	
}

/**
 * Enregistre la revision d'un niveau
 *
 * @param int $id_niveau
 * @param array $c
 * @return string
 */
function adhclub_revision_adhniv($id_niveau, $c=false) {

	modifier_contenu('adhniv', $id_niveau,
		array(
			'nonvide' =>    array(	'titre'		=> _T('info_sans_titre') /* ,
                                                'descriptif' => _T('info_sans_desc'),
                                                'techbase' => _T('info_sans_techbase'),
                                                'encadrant' => _T('info_sans_encadrant'),
                                                'id_trombi' => _T('info_sans_trombi'),
                                                'rangtrombi' => _T('info_sans_rangtrombi') */
                                    ),
        ),
		$c);

	return ''; // pas d'erreur
}


/**
 * Supprimer un niveau
 *
 * @param unknown_type $supp_niveau
 * @return unknown
 */
function adhclub_supprime_adhniv($id_niveau){
	$supp_niveau = sql_getfetsel("id_niveau", "spip_adhnivs", "id_niveau=" . intval($id_niveau));
	if (intval($id_niveau) AND 	intval($id_niveau) == intval($supp_niveau)){
		// d'abord les auteurs
		sql_delete("spip_adhnivs_liens", "id_niveau=".intval($id_niveau));
		// puis le niveau
		sql_delete("spip_adhnivs", "id_niveau=".intval($id_niveau));
	}
	$id_niveau = 0;
	return $id_niveau;
}


?>
