<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Liste des niveaux auxquel appartient le visiteur, au format '1,2,3,...' (id_inveau).
 * Cette fonction est appelee a chaque hit et peut etre completee (pipeline)
 *
 * @param string $niveaux '1,2,3'
 * @param int $id_auteur
 * @return string '1,2,3'
 */
function adhclub_liste_niveaux_autorises($niveaux='', $id_auteur=NULL) {
	$id = NULL;
	if (!is_null($id_auteur))
		$id = $id_auteur;
	elseif (isset($GLOBALS['visiteur_session']['id_auteur']) && $GLOBALS['visiteur_session']['id_auteur'])
		$id = $GLOBALS['visiteur_session']['id_auteur'];
	if (!is_null($id)) {
		$new = adhclub_nivs_ds_1auteur($id);
		if ($niveaux AND $new) {
			$niveaux = array_unique(array_merge(split(',',$niveaux),$new));
			sort($niveaux);
			$niveaux = join(',', $niveaux);
		} else if ($new) {
			$niveaux = join(',', $new);
		}
	}
	return $niveaux;
}


/**
 * Lister les niveaux auxquel un auteur appartient
 *
 * @param int $id_auteur
 * @return array
 * 
 */
function adhclub_nivs_ds_1auteur($id_auteur){
	static $liste_niveaux = array();
	if (!isset($liste_niveaux[$id_auteur])){
		include_spip('base/abstract_sql');
		$liste_niveaux[$id_auteur] = sql_allfetsel("id_niveau","spip_adhnivs_auteurs","id_auteur=".intval($id_auteur));
		$liste_niveaux[$id_auteur] = array_map('reset',$liste_niveaux[$id_auteur]);
	}
	return $liste_niveaux[$id_auteur];
}

/**
 * Verifier si un auteur appartient a un niveau.
 * utilise la fonction precedente qui met en cache son resultat
 * on optimise en fonction de l'hypothese que le nombre de niveaux est toujours reduit
 *
 * @param int $id_niveau
 * @param int $id_auteur
 * @return unknow boolean ?
 */
function adhclub_test_niveau_de_auteur($id_niveau,$id_auteur){
	return in_array($id_niveau,adhclub_nivs_ds_1auteur($id_auteur));
}


/**
 * liste des auteurs contenus dans un niveau
 *
 * @param int $id_niveau
 * @return array $liste_auteurs
 */
function adhclub_auteurs_ds_1niveau($id_niveau ) {
	$liste_auteurs=array();
	include_spip('base/abstract_sql');
	$liste_auteurs = sql_allfetsel("id_auteur","spip_adhnivs_auteurs","id_niveau = ".intval($id_niveau));
	$liste_auteurs = array_map('reset',$liste_auteurs);
	return $liste_auteurs;
}

?>
