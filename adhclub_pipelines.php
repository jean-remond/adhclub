<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 * @todo :
 * Fait :
 * JR-02/05/2017-Revue des autorisations d'associer avec l'auteur
 * JR-10/01/2015-adaptation spip 3.0.
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Ajouter les boites des niveaux, cotisations et assurances sur la fiche auteur
 *
 * @param string $flux
 * @return string
 */
function adhclub_affiche_milieu($flux){
	$texte = "";
	$e = trouver_objet_exec($flux['args']['exec']);

	// afficher les liaisons avec l'auteur
	if	(	( $e['type'] == 'auteur'
			AND $e['edition'] == false
			AND $id_auteur = $flux['args']['id_auteur']
			)
		OR 	( $flux['args']['exec'] == "infos_perso"
			AND $id_auteur = $GLOBALS['visiteur_session']['id_auteur']
			)
		){
		// adhassur sur les auteurs
		$texte .= recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'adhassur',
			'objet' => $e['type'],
			'id_objet' => $id_auteur,
			#'editable'=>autoriser('associerassurs',$e['type'],$e['id_objet'])?'oui':'non'
			));

		// adhcoti sur les auteurs
		$texte .= recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'adhcoti',
			'objet' => $e['type'],
			'id_objet' => $id_auteur,
			'editable'=>autoriser('associercotis',$e['type'],$e['id_objet'])?'oui':'non'
			));

		// adhniv sur les auteurs
		$texte .= recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'adhniv',
			'objet' => $e['type'],
			'id_objet' => $id_auteur,
			#'editable'=>autoriser('associernivs',$e['type'],$e['id_objet'])?'oui':'non'
			));
			
	}
		
	if ($texte) {
		if ($p=strpos($flux['data'],"<!--affiche_milieu-->"))
			$flux['data'] = substr_replace($flux['data'],$texte,$p,0);
		else
			$flux['data'] .= $texte;
	}
	
	return $flux;
}

/**
 * Ajouter les saisons sur les vues cotisations et assurances
 * Après la visualisation de l'objet (genre articles ds 1 rubrique) ??
 *
 * @param string $flux
 * @return string
 */
/* function adhassur_affiche_enfants($flux) {
    if ($e = trouver_objet_exec($flux['args']['exec'])
    AND $e['type'] == 'adhassur'
    AND $e['edition'] == false) {
     
    $id_assur = $flux['args']['id_assur'];
     
    $bouton = '';
    if (autoriser('creersaisondans','adhassur', $id_assur)) {
    $bouton .= icone_verticale(_T('adhsaison:icone_creer_adhsaison'), generer_url_ecrire('editer_adhsaison', "id_assur=$id_assur"), "adhassur-24.png", "new", 'right')
    ."<br class='nettoyeur' />";
    }
     
    $lister_objets = charger_fonction('lister_objets','inc');	
    $flux['data'] .= $lister_objets('adhsaison', array('titre'=>_T('adhsaison:titre_ahdsaison_adhassur') , 'id_assur'=>$id_assur, 'par'=>'titre'));
    $flux['data'] .= $bouton;
	
    }
    
    if ($e = trouver_objet_exec($flux['args']['exec'])
    AND $e['type'] == 'adhcoti'
    AND $e['edition'] == false) {
     
    $id_assur = $flux['args']['id_coti'];
     
    $bouton = '';
    if (autoriser('creersaisondans','adhcoti', $id_coti)) {
    $bouton .= icone_verticale(_T('adhsaison:icone_creer_adhsaison'), generer_url_ecrire('editer_adhsaison', "id_coti=$id_coti"), "adhcoti-24.png", "new", 'right')
    ."<br class='nettoyeur' />";
    }
     
    $lister_objets = charger_fonction('lister_objets','inc');	
    $flux['data'] .= $lister_objets('adhsaison', array('titre'=>_T('adhsaison:titre_ahdsaison_adhassur') , 'id_coti'=>$id_coti, 'par'=>'titre'));
    $flux['data'] .= $bouton;
	
    }
    
    return $flux;
} */

?>
