<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 * JR-10/01/2015-adaptation spip 3.0.
 */

include_spip("inc/adhclub_autoriser");
include_spip("inc/presentation");

/**
 * Afficher une liste des utilisateurs
 */
function exec_adh_tous(){

	if (!autoriser('administrer','adhclub',0)) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}

	// Recuperation des champs du formulaire
	// ==> lies a adhclub :
	$contexte['id_saison'] = _request('id_saison');
	$contexte['techbase'] = _request('techbase');
	$contexte['encadrant'] = _request('encadrant');
	$contexte['niveau'] = _request('niveau');
	$contexte['niv_rel'] = _request('niv_rel');
	
	// ==> lies a i3 :
	$contexte['case'] = _request('case');
	$contexte['valeur'] = _request('valeur');
	
	$contexte = array_merge($contexte,$_GET);
	
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adhclub_24.png";
	$commencer_page = charger_fonction('commencer_page', 'inc');
	
	pipeline('exec_init',array('args'=>$_GET,'data'=>''));
	
	echo $commencer_page(_T("adhclub:adhclub"),"adhclub");
	
	echo recuperer_fond('prive/adh_adherents',$contexte);

}

?>