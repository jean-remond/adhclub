<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('base/abstract_sql');

function exec_assurs_edit_dist(){
	$new = _request('new');
	$id_assur = intval(_request('id_assur'));
	$row = sql_fetsel('*','spip_adhassurs','id_assur='.intval($id_assur));

	if ((!$new AND !$row)
	  OR ($new AND !autoriser('creer','adhassur')) 
	  OR (!$new AND (!autoriser('modifier', 'adhassur', $id_assur))) 
	  ) {
		include_spip('inc/minipres');
		echo minipres(_T('adhclub:aucune_assur'));
	} 
	else {
		assurs_edit($id_assur, $new, '', $row);
	}
}

function assurs_edit($id_assur, $new, $config_fonc, $row){
	$id_assur = $row['id_assur'];
	$commencer_page = charger_fonction('commencer_page', 'inc');
	pipeline('exec_init',array('args'=>array('exec'=>'assurs_edit','id_assur'=>$id_assur),'data'=>''));

	echo $commencer_page(intval($id_assur)?_T('adhassur:titre_cadre_modifier_adhassur'):_T('adhclub:creer_assur'), "naviguer", "assurs", 0);

	echo debut_gauche("",true);
	echo recuperer_fond("prive/editer/assur_auteurs", $_GET);

	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'assurs_edit','id_assur'=>$id_assur),'data'=>''));
	echo creer_colonne_droite("",true);
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'assurs_edit','id_assur'=>$id_assur),'data'=>''));
	echo debut_droite("",true);
	
	$oups = _request('retour') ? _request('retour') : 
		generer_url_ecrire("adh_assur");

	$contexte = array(
	'icone_retour'=>icone_inline(_T('icone_retour'), $oups, _DIR_PLUGIN_ADHCLUB."img_pack/adh_assur-24.png", "rien.gif",$GLOBALS['spip_lang_left']),
	'redirect'=>_request('retour') ? _request('retour') : generer_url_ecrire('adh_assur'),
	//'titre'=>$titre,
	'new'=>$new?$new:$row['id_assur'],
	'config_fonc'=>$config_fonc,
	);

	$milieu = recuperer_fond("prive/editer/adhassur", $contexte);
	
	echo pipeline('affiche_milieu',array('args'=>array('exec'=>'assurs_edit','id_assur'=>$id_assur),'data'=>$milieu));

	echo fin_gauche(), fin_page();
}

?>
