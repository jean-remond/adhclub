<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
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

	// adhassur sur les auteurs
	if	(	( $e['type'] == 'auteur'
			AND $e['edition'] == false
			AND $id_auteur = $flux['args']['id_auteur']
			)
		OR 	( $flux['args']['exec'] == "infos_perso"
			AND $id_auteur = $GLOBALS['visiteur_session']['id_auteur']
			)
		){
		// adhassur sur les auteurs
		$texte = recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'adhassur',
			'objet' => $e['type'],
			'id_objet' => $id_auteur,
			#'editable'=>autoriser('associerassurs',$e['type'],$e['id_objet'])?'oui':'non'
			));

		// adhcoti sur les auteurs
		$texte = $texte
			. recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'adhcoti',
			'objet' => $e['type'],
			'id_objet' => $id_auteur,
			#'editable'=>autoriser('associercotis',$e['type'],$e['id_objet'])?'oui':'non'
			));

		// adhniv sur les auteurs
		$texte = $texte
			. recuperer_fond('prive/objets/editer/liens', array(
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
 * Ajouter les boites des niveaux, cotisations et assurances sur la fiche auteur
 *
 * @param string $flux
 * @return string
 */
function adhassur_affiche_enfants($flux) {
    if ($e = trouver_objet_exec($flux['args']['exec'])
    AND $e['type'] == 'auteur'
    AND $e['edition'] == false) {
     
    $id_auteur = $flux['args']['id_auteur'];
     
    $bouton = '';
    if (autoriser('creerassurdans','auteur', $id_auteur)) {
    $bouton .= icone_verticale(_T('adhassur:icone_creer_adhassur'), generer_url_ecrire('editer_adhassur', "id_auteur=$id_auteur"), "adhassur-24.png", "new", 'right')
    ."<br class='nettoyeur' />";
    }
     
    $lister_objets = charger_fonction('lister_objets','inc');	
    $flux['data'] .= $lister_objets('adhassur', array('titre'=>_T('adhassur:titre_auteur_adhassur') , 'id_auteur'=>$id_auteur, 'par'=>'titre'));
    $flux['data'] .= $bouton;
     
    }
    return $flux;
}

?>
