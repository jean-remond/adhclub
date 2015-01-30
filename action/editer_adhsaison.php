<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * ----------------------------------------------
 * Actions de l'environnement saisons.
 * ----------------------------------------------
 * @todo-JR-30/01/2015-Confirmer le besoin. Lie a /formulaire/ ?
 * 
 * Fait:
 * JR-30/01/2015-adaptation spip 3.0.
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * editer une saison (action apres creation/modif de saison)
 *
 * @return array
 */
function action_editer_adhsaison_dist(){

	$securiser_action = charger_fonction('securiser_action', 'inc');

    $arg = $securiser_action();

	// si id_saison n'est pas un nombre, c'est une creation 
	// mais on verifie qu'on a toutes les donnees qu'il faut.
    if (!$id_saison = intval($arg)) {
		if (!$id_saison = adhclub_action_insert_adhsaison())
			return array(false,_L('echec'));
	}
	
	$err = action_adhsaison_set($id_saison);
	return array($id_saison,$err);
}

/**
 * mettre a jour une saison
 *
 * @param int $id_saison
 * @return string
 */
function action_adhsaison_set($id_saison){
	$err = '';

	$c = array();
    
	foreach (array(
		'titre', 'descriptif', 'saison_deb'
	) as $champ){
            $c[$champ] = _request($champ);
    }

    foreach (array(
    		'encours'
    ) as $champ)
    	$c[$champ] = _request($champ)=='oui'?'oui':'non';


	include_spip('inc/modifier');
	adhclub_revision_adhsaison($id_saison, $c);
	//adhclub_revision_adhsaison_objets_lies($id_saison, _request('assurs'),'adhassur','set');
	//adhclub_revision_adhsaison_objets_lies($id_saison, _request('cotis'),'adhcoti','set');

	return $err;
}


/**
 * Mettre a jour les liens objets/saisons.
 * si saisons vaut '', associe toutes les saisons a(aux) objets(s).
 * $ids est une liste d'id.
 * $type est le type de l'objet (assur, coti).
 * $operation = add/set/del pour ajouter, affecter uniquement, ou supprimer les objets listes dans ids.
 *
 * @param int/array $saisons
 * @param int/array $ids
 * @param string $type
 */
function adhclub_revision_adhsaison_objets_lies($saisons,$ids,$type,$operation = 'add'){
	include_spip('inc/autoriser');
	$in = "";
	if ($saisons){
		$in = sql_in('id_saison',$saisons);
	}
	$liste = sql_allfetsel('id_saison','spip_adhsaisons',$in);
	foreach($liste as $row){
		if ($operation=='del'){
			// on supprime les ids listes
			//sql_delete("spip_{$type}s",array("id_saison=".intval($row['id_saison']),sql_in("id_$type",$ids)));			
			//sql_delete("spip_{$type}s",array("id_saison=".intval($row['id_saison']),sql_in("id_$type",$ids)));			
		}
		else {
			if (!$ids) $ids = array();
			elseif (!is_array($ids)) $ids = array($ids);
			// si c'est une affectation exhaustive, supprimer les existants qui ne sont pas dans ids
			// si c'est un ajout, ne rien effacer
			if ($operation=='set'){
				//sql_delete("spip_adhassurs_{$type}s",array("id_saison=".intval($row['id_saison']),sql_in("id_$type",$ids,"NOT")));
				//sql_delete("spip_adhcotis_{$type}s",array("id_saison=".intval($row['id_saison']),sql_in("id_$type",$ids,"NOT")));
			}
			$deja = array_map('reset',sql_allfetsel("id_$type","spip_{$type}s","id_saison=".intval($row['id_saison'])));
			$add = array_diff($ids,$deja);
			//foreach ($add as $id) {
				//if (autoriser('affectersaisons',$type,$id,null,array('id_saison'=>$row['id_saison'])))
					//sql_insertq("spip_saisons_{$type}s",array('maj'=>'NOW()','id_saison'=>$row['id_saison'],"id_$type"=>intval($id)));
			//}
		}
	}	
}

/** Ok  JR 17/11/2011
 * Creer une nouvelle saison
 *
 * @return int
 */
function adhclub_action_insert_adhsaison(){
	include_spip('inc/autoriser');
	if (!autoriser('creer','adhsaison'))
		return false;
	// nouvelle saison
	$adhvaleur=array(
		'titre'=> 'nouvelle',
		'descriptif'=> 'NOW()',
		'encours'=>'non',
		'saison_deb'=>'0001-01-01',
		'maj'=>'NOW()',
	);
	$id_saison = sql_insertq("spip_adhsaisons",$adhvaleur);

	if (!$id_saison){
		adhclub_log("editer_adhsaison : adhclub_action_insert_adhsaison : impossible d'ajouter une saison", true);
		return false;
	} 
	return $id_saison;	
}

/**
 * Enregistre la revision d'une saison
 *
 * @param int $id_saison
 * @param array $c
 * @return string
 */
function adhclub_revision_adhsaison($id_saison, $c=false) {

	modifier_contenu('adhsaison', $id_saison,
		array(
			'nonvide' => array(	'titre'		=> _T('info_sans_titre')),
		),
		$c);

	return ''; // pas d'erreur
}


/**
 * Supprimer une saison
 *
 *  todo JR-09-11-2011
 *
 * Si pas saison par defaut
 * ==> supprimer relation assur-auteur
 * ==> supprimer assur
 * ==> supprimer relation coti-auteur
 * ==> supprimer coti
 * ==> supprimer saison
 *
 * @param unknown_type $id_saison
 * @param unknown_type $supp_saison
 * @return unknown
 */
function adhclub_supprime_adhsaison($id_saison){
	$supp_saison = sql_getfetsel("id_saison, encours", "spip_adhsaisons", "id_saison=" . intval($id_saison));
	if	(	intval($id_saison)  
    		AND intval($id_saison) == intval($supp_saison[id_saison])
    		AND $supp_saison[encours] == 'non'
    	){
		// d'abord les assurances des auteurs
		sql_delete("spip_adhassurs_liens", "id_saison=".intval($id_saison));
		// puis les assurances
		sql_delete("spip_adhassurs", "id_saison=".intval($id_saison));
		// puis les cotisations des auteurs
		sql_delete("spip_adhcotis_liens", "id_saison=".intval($id_saison));
		// puis les cotisations
		sql_delete("spip_adhcotis", "id_saison=".intval($id_saison));
		// enfin la saison
		sql_delete("spip_adhsaisons", "id_saison=".intval($id_saison));
	}
	$id_saison = 0;
	return $id_saison;
}


?>
