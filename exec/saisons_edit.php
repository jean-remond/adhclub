<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('base/abstract_sql');

function exec_saisons_edit_dist(){
	$new = _request('new');
	$id_saison = intval(_request('id_saison'));
	$row = sql_fetsel('*','spip_adhsaisons','id_saison='.intval($id_saison));

	if ((!$new AND !$row)
	  OR ($new AND !autoriser('creer','adhsaison')) 
	  OR (!$new AND (!autoriser('modifier', 'adhsaison', $id_saison))) 
	  ) {
		include_spip('inc/minipres');
		echo minipres(_T('adhclub:aucun_saison'));
	} 
	else {
		saisons_edit($id_saison, $new, '', $row);
	}
}

function saisons_edit($id_saison, $new, $config_fonc, $row){
	$id_saison = $row['id_saison'];
	$commencer_page = charger_fonction('commencer_page', 'inc');
	pipeline('exec_init',array('args'=>array('exec'=>'saisons_edit','id_saison'=>$id_saison),'data'=>''));

	echo $commencer_page(intval($id_saison)?_T('adhclub:titre_cadre_modifier_saison'):_T('adhclub:creer_saison'), "naviguer", "saisons", 0);

	echo debut_gauche("",true);
	//echo recuperer_fond("prive/editer/saison_assurs", $_GET);
	//echo recuperer_fond("prive/editer/saison_cotis", $_GET);

	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'saisons_edit','id_saison'=>$id_saison),'data'=>''));
	echo creer_colonne_droite("",true);
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'saisons_edit','id_saison'=>$id_saison),'data'=>''));
	echo debut_droite("",true);
	
	$oups = _request('retour') ? _request('retour') : 
		generer_url_ecrire("adh_saison");

	$contexte = array(
	'icone_retour'=>icone_inline(_T('icone_retour'), $oups, _DIR_PLUGIN_ADHCLUB."img_pack/adh_saison-24.png", "rien.gif",$GLOBALS['spip_lang_left']),
	'redirect'=>_request('retour') ? _request('retour') : generer_url_ecrire('adh_saison'),
	//'titre'=>$titre,
	'new'=>$new?$new:$row['id_saison'],
	'config_fonc'=>$config_fonc,
	);

	$milieu = recuperer_fond("prive/editer/adhsaison", $contexte);
	
	echo pipeline('affiche_milieu',array('args'=>array('exec'=>'saisons_edit','id_saison'=>$id_saison),'data'=>$milieu));

	echo fin_gauche(), fin_page();
}

?>
