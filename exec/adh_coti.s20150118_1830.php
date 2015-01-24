<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

//echo "<br />.debug JR.<br />";
//echo "exec/adh_coti Exec-Pt1.<br />";

include_spip('inc/adh_coti');
include_spip('inc/presentation');


// Gestion des cotisations
function exec_adh_coti(){

if (!autoriser('administrer','adhcoti',0)) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}

	$commencer_page = charger_fonction('commencer_page','inc');
	echo $commencer_page(_T('adhcoti:page_adhcotis'));
	
	echo gros_titre(_T('adhcoti:page_adhcotis'),'',false);
	echo debut_gauche("adhclub",true);
	
	echo debut_boite_info(true);
	echo propre(_T('adhcoti:info_page_adhcoti'));	
	echo fin_boite_info(true);
	
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adhclub_24.gif";
	$raccourcis = icone_horizontale(_T('adhclub:icone_menu_adhclub'), generer_url_ecrire("adh_tous"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_saison_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:icone_menu_adhsaison'), generer_url_ecrire("adh_saison"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_assur_24.gif";
	$raccourcis .= icone_horizontale(_T('adhassur:icone_menu_adhassur'), generer_url_ecrire("adh_assur"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_niveau_24.gif";
	$raccourcis .= icone_horizontale(_T('adhniv:icone_menu_adhniv'), generer_url_ecrire("adh_niveau"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adhclub_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:ffessm_icone_menu'), generer_url_ecrire("adh_import"), $icone, "", false);
	echo bloc_des_raccourcis($raccourcis);
	
	echo debut_droite("adh_club",true);
	if (autoriser('modifier','adhcoti'))
		echo "<div>".icone_inline(_T('adhcoti:icone_creer_adhcoti'),
		  generer_url_ecrire("cotis_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_coti_24.gif",
		  "creer.gif",'right')."</div>";

	echo recuperer_fond('prive/adh_coti',$_GET);
	
	if (autoriser('modifier','adhcoti'))
		echo "<div>".icone_inline(_T('adhcoti:icone_creer_adhcoti'),
		  generer_url_ecrire("cotis_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_coti_24.gif",
		  "creer.gif",'right')."</div>";

	echo fin_gauche(),fin_page();
}


?>
