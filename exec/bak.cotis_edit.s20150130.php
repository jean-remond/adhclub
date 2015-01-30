<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('base/abstract_sql');

function exec_cotis_edit_dist(){
	$new = _request('new');
	$id_coti = intval(_request('id_coti'));
	$row = sql_fetsel('*','spip_adhcotis','id_coti='.intval($id_coti));

//echo "<br />.debug JR.<br />";
//echo "exec/cotis_edit Exec-Pt1.<br />";

	if ((!$new AND !$row)
	  OR ($new AND !autoriser('creer','adhcoti')) 
	  OR (!$new AND (!autoriser('modifier', 'adhcoti', $id_coti))) 
	  ) {
		include_spip('inc/minipres');
		echo minipres(_T('adhcoti:aucun_adhcoti'));
	} 
	else {
		cotis_edit($id_coti, $new, '', $row);
	}
}

function cotis_edit($id_coti, $new, $config_fonc, $row){
	$id_coti = $row['id_coti'];
	$commencer_page = charger_fonction('commencer_page', 'inc');
	pipeline('exec_init',array('args'=>array('exec'=>'cotis_edit','id_coti'=>$id_coti),'data'=>''));

	echo $commencer_page(intval($id_coti)?_T('adhcoti:titre_cadre_modifier_adhcoti'):_T('adhcoti:icone_creer_adhcoti'), "naviguer", "cotis", 0);

	echo debut_gauche("",true);
	echo recuperer_fond("prive/editer/coti_auteurs", $_GET);

	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'cotis_edit','id_coti'=>$id_coti),'data'=>''));
	echo creer_colonne_droite("",true);
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'cotis_edit','id_coti'=>$id_coti),'data'=>''));
	echo debut_droite("",true);
	
	$oups = _request('retour') ? _request('retour') : 
		generer_url_ecrire("adh_coti");

	$contexte = array(
	'icone_retour'=>icone_inline(_T('icone_retour'), $oups, _DIR_PLUGIN_ADHCLUB."img_pack/adh_coti-24.png", "rien.gif",$GLOBALS['spip_lang_left']),
	'redirect'=>_request('retour') ? _request('retour') : generer_url_ecrire('adh_coti'),
	//'titre'=>$titre,
	'new'=>$new?$new:$row['id_coti'],
	'config_fonc'=>$config_fonc,
	);

	$milieu = recuperer_fond("prive/editer/adhcoti", $contexte);
	
	echo pipeline('affiche_milieu',array('args'=>array('exec'=>'cotis_edit','id_coti'=>$id_coti),'data'=>$milieu));

	echo fin_gauche(), fin_page();
}

?>
