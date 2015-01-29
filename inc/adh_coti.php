<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * 
 * JR-26/01/2015-Adaptation aux tables liens.
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Liste des cotis auxquel appartient le visiteur, au format '1,2,3,...' (id_coti).
 * Cette fonction est appelee a chaque hit et peut etre completee (pipeline)
 *
 * @param string $cotis ('1,2,3,etc..')
 * @param int $id_auteur
 * @return string $cotis ('1,2,3, etc..')
 */
function adhclub_liste_cotis_autorises($cotis='', $id_auteur=NULL) {
	$id = NULL;
	if (!is_null($id_auteur))
		$id = $id_auteur;
	elseif (isset($GLOBALS['visiteur_session']['id_auteur']) && $GLOBALS['visiteur_session']['id_auteur'])
		$id = $GLOBALS['visiteur_session']['id_auteur'];
	if (!is_null($id)) {
		$new = adhclub_cotis_de_1auteur($id);
		if ($cotis AND $new) {
			$cotis = array_unique(array_merge(split(',',$cotis),$new));
			sort($cotis);
			$cotis = join(',', $cotis);
		} else if ($new) {
			$cotis = join(',', $new);
		}
	}
	return $cotis;
}


/**
 * Lister les cotisations auxquel un auteur appartient
 *
 * @param int $id_auteur
 * @return array $liste_cotis
 */
function adhclub_cotis_de_1auteur($id_auteur){
	static $liste_cotis = array();
	if (!isset($liste_cotis[$id_auteur])){
		include_spip('base/abstract_sql');
		$liste_cotis[$id_auteur] = sql_allfetsel("id_coti","spip_adhcotis_liens as ca","ca.objet='auteur' AND ca.id_objet=".intval($id_auteur));
		$liste_cotis[$id_auteur] = array_map('reset',$liste_cotis[$id_auteur]);
	}
	return $liste_cotis[$id_auteur];
}

/**
 * Verifier si un auteur appartient a une cotisation.
 * utilise la fonction precedente qui met en cache son resultat
 * on optimise en fonction de l'hypothese que le nombre de cotisations est toujours reduit
 *
 * @param int $id_coti
 * @param int $id_auteur
 * @return boolean TRUE FALSE (?)
 */
function adhclub_test_coti_de_auteur($id_coti,$id_auteur){
	return in_array($id_coti,adhclub_cotis_de_1auteur($id_auteur));
}


/**
 * liste des auteurs contenus dans une cotisation, au format '1,2,3,...'.
 *
 * @param int $id_coti
 * @return array $liste_auteurs
 */
function adhclub_auteurs_ds_1coti($id_coti) {
	//$liste_auteurs=array();
	include_spip('base/abstract_sql');
	$liste_auteurs = sql_allfetsel("id_auteur","spip_adhcotis_liens as ca","ca.objet='auteur' AND ca.id_coti=".intval($id_coti));

	if (is_array($liste_auteurs)) {
		$liste_auteurs = array_map('reset',$liste_auteurs);
	}

	//$debug1= "adhclub debug JR : inc/adh_coti adhclub_auteurs_ds_1coti - Pt90 - liste_auteurs=";
	//echo $debug1;
	//var_dump($liste_auteurs);
	//$debug1 = $debug1 . $liste_auteurs[0];
	//adhclub_log("$debug1.", true);
		
	return $liste_auteurs;
}

?>
