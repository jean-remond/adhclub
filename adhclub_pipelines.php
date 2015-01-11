<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 * JR-10/01/2015-adaptation spip 3.0.
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Ajouter le bouton de menu gestion Club si on a le droit
 *
 * @param unknown_type $boutons_admin
 * @return unknown
 */
function adhclub_ajouter_boutons($boutons_admin) {

// si on est admin des adherents ET plugin bando non actif => ajout du bouton de gestion
	if (autoriser('administrer','adh_tous')AND
	((function_exists('test_plugin_actif') AND !test_plugin_actif('bando')) OR !function_exists('test_plugin_actif'))) {
		$menu = "auteurs";
		$icone = "img_pack/adh_club-24.gif";
		if (isset($boutons_admin['bando_auteurs'])){
			$menu = "bando_auteurs";
			$icone = "img_pack/adh_club-24.gif";
		}
	  // on voit le bouton dans la barre "auteurs"
		$boutons_admin[$menu]->sousmenu['adh_tous']= new Bouton(
		_DIR_PLUGIN_ADHCLUB.$icone,  // icone
		_T('adhclub:adhclub')	// titre
		);
	}

return $boutons_admin;
}


/**
 * Ajouter les boites des niveaux, cotisations et assurances sur la fiche auteur
 *
 * @param string $flux
 * @return string
 */
function adhclub_affiche_milieu($flux){
	switch($flux['args']['exec']) {
		case 'auteur_infos':
			$id_auteur = $flux['args']['id_auteur'];
			
			$flux['data'] .= 
			recuperer_fond('prive/editer/affecter_adhnivs',array('id_auteur'=>$id_auteur));
			break;
	}
	switch($flux['args']['exec']) {
		case 'auteur_infos':
			$id_auteur = $flux['args']['id_auteur'];
			
			$flux['data'] .= 
			recuperer_fond('prive/editer/affecter_adhcotis',array('id_auteur'=>$id_auteur));
			break;
	}
	switch($flux['args']['exec']) {
		case 'auteur_infos':
			$id_auteur = $flux['args']['id_auteur'];
			
			$flux['data'] .= 
			recuperer_fond('prive/editer/affecter_adhassurs',array('id_auteur'=>$id_auteur));
			break;
	}
	return $flux;
}


/**
 * Permettre l'ajout de champs extras via le plugin Champs Extras 3 
 *
 * @param 
 * @return 
**/
function adhclub_objets_extensibles($objets){
		array_merge($objets, array('niveau' => _T('adhclub:niveaux_pages')));
		array_merge($objets, array('coti' => _T('adhclub:cotis_page')));
		array_merge($objets, array('assur' => _T('adhclub:assurs_page')));
		return $objets;
}

?>
