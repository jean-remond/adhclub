<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/adh_assur');
include_spip('inc/presentation');


// Gestion des assurances
function exec_adh_assur(){
	if (!autoriser('administrer','adhassur',0)) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}

	$commencer_page = charger_fonction('commencer_page','inc');
	echo $commencer_page(_T('adhclub:assurs_page'));
	
	echo gros_titre(_T('adhclub:assurs_page'),'',false);
	echo debut_gauche("adhclub",true);
	
	echo debut_boite_info(true);
	echo propre(_T('adhclub:assurs_page_info'));	
	echo fin_boite_info(true);
	
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_club-24.gif";
	$raccourcis = icone_horizontale(_T('adhclub:adhclub_icone_menu'), generer_url_ecrire("adh_tous"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_saison-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:saison_icone_menu'), generer_url_ecrire("adh_saison"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_coti-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:coti_icone_menu'), generer_url_ecrire("adh_coti"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_niveau-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:niveau_icone_menu'), generer_url_ecrire("adh_niveau"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_club-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:ffessm_icone_menu'), generer_url_ecrire("adh_import"), $icone, "", false);
	echo bloc_des_raccourcis($raccourcis);
	
	echo debut_droite("adh_club",true);
	if (autoriser('modifier','adhassur'))
		echo "<div>".icone_inline(_T('adhclub:creer_assur'),
		  generer_url_ecrire("assurs_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_assur-24.gif",
		  "creer.gif",'right')."</div>";

	echo recuperer_fond('prive/adh_assur',$_GET);
	
	if (autoriser('modifier','adhassur'))
		echo "<div>".icone_inline(_T('adhclub:creer_assur'),
		  generer_url_ecrire("assurs_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_assur-24.gif",
		  "creer.gif",'right')."</div>";

	echo fin_gauche(),fin_page();
}


?>
