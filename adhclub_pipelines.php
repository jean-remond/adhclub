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
		$icone = "img_pack/adhclub_24.gif";
		if (isset($boutons_admin['bando_auteurs'])){
			$menu = "bando_auteurs";
			$icone = "img_pack/adhclub_24.gif";
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
 * Ajouter les boites des niveaux, cotisations et assurances sur la fiche auteur
 *
 * @param string $flux
 * @return string
 */
function adhclub_affiche_enfants($flux) {
    if ($e = trouver_objet_exec($flux['args']['exec'])
    AND $e['type'] == 'auteur'
    AND $e['edition'] == false) {
     
    $id_auteur = $flux['args']['id_auteur'];
     
    $bouton = '';
    if (autoriser('creerassurdans','auteur', $id_rubrique)) {
    $bouton .= icone_verticale(_T('adhclub:icone_creer_chat'), generer_url_ecrire('chat_edit', "id_rubrique=$id_rubrique"), "chat-24.png", "new", 'right')
    . "<br class='nettoyeur' />";
    }
     
    $lister_objets = charger_fonction('lister_objets','inc');	
    $flux['data'] .= $lister_objets('chats', array('titre'=>_T('chat:titre_chats_rubrique') , 'id_rubrique'=>$id_rubrique, 'par'=>'nom'));
    $flux['data'] .= $bouton;
     
    }
    return $flux;
}

?>
