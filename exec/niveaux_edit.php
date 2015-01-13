<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('base/abstract_sql');

function exec_niveaux_edit_dist(){
	$new = _request('new');
	$id_niveau = intval(_request('id_niveau'));
	$row = sql_fetsel('*','spip_adhnivs','id_niveau='.intval($id_niveau));

	if ((!$new AND !$row)
	  OR ($new AND !autoriser('creer','adhniv')) 
	  OR (!$new AND (!autoriser('modifier', 'adhniv', $id_niveau))) 
	  ) {
		include_spip('inc/minipres');
		echo minipres(_T('adhclub:niveau_aucun'));
	} 
	else {
		niveaux_edit($id_niveau, $new, '', $row);
	}
}

function niveaux_edit($id_niveau, $new, $config_fonc, $row){
	$id_niveau = $row['id_niveau'];
	$commencer_page = charger_fonction('commencer_page', 'inc');
	pipeline('exec_init',array('args'=>array('exec'=>'niveaux_edit','id_niveau'=>$id_niveau),'data'=>''));

	echo $commencer_page(intval($id_niveau)?_T('adhclub:niveau_titre_cadre_modifier'):_T('adhclub:niveau_creer'), "naviguer", "niveaux", 0);

	echo debut_gauche("",true);
	echo recuperer_fond("prive/editer/niveau_auteurs", $_GET);

	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'niveaux_edit','id_niveau'=>$id_niveau),'data'=>''));
	echo creer_colonne_droite("",true);
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'niveaux_edit','id_niveau'=>$id_niveau),'data'=>''));
	echo debut_droite("",true);
	
	$oups = _request('retour') ? _request('retour') : 
		generer_url_ecrire("adh_niveau");

	$contexte = array(
	'icone_retour'=>icone_inline(_T('icone_retour'), $oups, _DIR_PLUGIN_ADHCLUB."img_pack/adh_niveau-24.png", "rien.gif",$GLOBALS['spip_lang_left']),
	'redirect'=>_request('retour') ? _request('retour') : generer_url_ecrire('adh_niveau'),
	//'titre'=>$titre,
	'new'=>$new?$new:$row['id_niveau'],
	'config_fonc'=>$config_fonc,
	);

	$milieu = recuperer_fond("prive/editer/adhniv", $contexte);
	
	echo pipeline('affiche_milieu',array('args'=>array('exec'=>'niveaux_edit','id_niveau'=>$id_niveau),'data'=>$milieu));

	echo fin_gauche(), fin_page();
}

?>
