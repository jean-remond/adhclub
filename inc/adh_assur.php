<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Liste des assurances affectees au visiteur, au format '1,2,3,...' (id_assur).
 * Cette fonction est appelee a chaque hit et peut etre completee (pipeline)
 *
 * @param string $assurs '1,2,3'
 * @param int $id_auteur
 * @return string '1,2,3'
 */
function adhclub_liste_assurs_autorises($assurs='', $id_auteur=NULL) {
	$id = NULL;
	if (!is_null($id_auteur))
		$id = $id_auteur;
	elseif (isset($GLOBALS['visiteur_session']['id_auteur']) && $GLOBALS['visiteur_session']['id_auteur'])
		$id = $GLOBALS['visiteur_session']['id_auteur'];
	if (!is_null($id)) {
		$new = adhclub_assurs_de_1auteur($id);
		if ($assurs AND $new) {
			$assurs = array_unique(array_merge(split(',',$assurs),$new));
			sort($assurs);
			$assurs = join(',', $assurs);
		} else if ($new) {
			$assurs = join(',', $new);
		}
	}
	return $assurs;
}


/**
 * Lister les assurances affectees a un auteur
 *
 * @param int $id_auteur
 * @return array $liste_assurs
 * adhclub_assurs_de_1auteur
 */
function adhclub_assurs_de_1auteur($id_auteur){
	static $liste_assurs = array();
	if (!isset($liste_assurs[$id_auteur])){
		include_spip('base/abstract_sql');
		$liste_assurs[$id_auteur] = sql_allfetsel("id_assur","spip_adhassurs_auteurs","id_auteur=".intval($id_auteur));
	
		//echo "<br />.debug JR : inc/adh_assur-adhclub_assurs_de_1auteur-Pt05.<br />";
		//$field=$liste_assurs[$id_auteur];
		//$field2=$field[0];
		//$field3=$field2['id_assur'];
		//echo "liste_assurs(id_auteur)= $field3.<br />";
		
		$liste_assurs[$id_auteur] = array_map('reset',$liste_assurs[$id_auteur]);
	
		//echo "<br />.debug JR : inc/adh_assur-adhclub_assurs_de_1auteur-Pt10.<br />";
		//$field=$liste_assurs[$id_auteur];
		//$field2=$field[0];
		//$field3=$field2['id_assur'];
		//echo "liste_assurs(id_auteur)= $field3.<br />";
		
	}
	return $liste_assurs[$id_auteur];
}

/**
 * Verifier si un auteur appartient a une assurance.
 * utilise la fonction precedente qui met en cache son resultat
 * on optimise en fonction de l'hypothese que le nombre d'assurances est toujours reduit
 *
 * @param int $id_assurs
 * @param int $id_auteur
 * @return boolean TRUE FALSE
 * adhclub_test_assur_de_auteur
 */
function adhclub_test_assur_de_auteur($id_assur,$id_auteur){
	return in_array($id_assur,adhclub_assurs_de_1auteur($id_auteur));
}

/**
 * Recherche une assurance et verification si affectee a auteur.
 *
 *	Recherche de assurs a partir du titre
 *	Verification si saison courante
 *	Recherche si assurance affectee a auteur
 *
 * @param int $id_auteur
 * @param string $assurtitre
 * 	-> titre de l'assurance
 * @return integer $auteur_assur
 * 	-> si affectation trouvee : true,
 * 	-> si rien trouve : false.
 *  -> si assurance trouvee : id_assur
 */
function adhclub_test_assurtitre_de_auteur($id_auteur, $assurtitre){
	
	$auteur_assur=array();
	include_spip('base/abstract_sql');

	// Recherche de l'assurance via son titre (adhassurs.titre).
	$adhwhere = "titre = ".sql_quote(trim($assurtitre));
	$arg = sql_fetsel( "id_assur", "spip_adhassurs", $adhwhere);
	
	//echo "<br />.debug JR : inc/adh_assur-adhclub_test_assurtitre_de_auteur-Pt15.<br />";
	//$field=$arg['id_assur'];
	//echo "arg(id_assur)= $field.<br />";
	
	// si id_assur n'est pas un nombre, l'assurance est inconnue.
	if (!$id_assur = intval($arg['id_assur'])) return false;

	// Recherche si auteur est affecte a assurance.
	$auteur_assur = adhclub_test_assur_de_auteur($id_assur,$id_auteur);
	
	//echo "<br />.debug JR : inc/adh_assur-adhclub_test_assurtitre_de_auteur-Pt17.<br />";
	//if ($auteur_assur){
		//echo "auteur_assur= TRUE.<br />";
	//}else{
		//echo "id_assur= $id_assur.<br />";
	//}
	//echo "<br />.debug JR : fin de inc/adh_assur-adhclub_test_assurtitre_de_auteur-Pt17.<br />";
	
	if ($auteur_assur){
		// Si affectation trouvee ==> retour true
		return auteur_assur;
	}else{
		// Si Assurance trouvee ==> retour id_assur
		return $id_assur;
	}
	
}

/**
 * liste des auteurs contenus dans une assurance
 *
 * @param int $id_assur
 * @return array $liste_auteurs
 */
function adhclub_auteurs_ds_1assur($id_assur) {
	$liste_auteurs=array();
	include_spip('base/abstract_sql');
	$liste_auteurs = sql_allfetsel("id_auteur","spip_adhassurs_auteurs","id_assur=".intval($id_assur));
	$liste_auteurs = array_map('reset',$liste_auteurs);
	return $liste_auteurs;
}

?>
