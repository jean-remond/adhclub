<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2011 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/adh_saison');
include_spip('inc/presentation');


// Gestion des saisons du club
function exec_adh_saison(){
	if (!autoriser('administrer','adhsaison',0)) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}

	$commencer_page = charger_fonction('commencer_page','inc');
	echo $commencer_page(_T('adhclub:saisons_page'));
	
	echo gros_titre(_T('adhclub:saison_titre'),'',false);
	echo debut_gauche("adhclub",true);
	
	echo debut_boite_info(true);
	echo propre(_T('adhclub:info_page_saison'));	
	echo fin_boite_info(true);
	
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_club-24.gif";
	$raccourcis = icone_horizontale(_T('adhclub:adhclub_icone_menu'), generer_url_ecrire("adh_tous"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_assur-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:assur_icone_menu'), generer_url_ecrire("adh_assur"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_coti-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:coti_icone_menu'), generer_url_ecrire("adh_coti"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_niveau-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:niveau_icone_menu'), generer_url_ecrire("adh_niveau"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_club-24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:ffessm_icone_menu'), generer_url_ecrire("adh_import"), $icone, "", false);
	echo bloc_des_raccourcis($raccourcis);
	
	echo debut_droite("adh_club",true);
	if (autoriser('modifier','adhsaison'))
		echo "<div>".icone_inline(_T('adhclub:creer_saison'),
		  generer_url_ecrire("saisons_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_saison-24.gif",
		  "creer.gif",'right')."</div>";

	echo recuperer_fond('prive/adh_saison',$_GET);
	
	if (autoriser('modifier','adhsaison'))
		echo "<div>".icone_inline(_T('adhclub:creer_saison'),
		  generer_url_ecrire("saisons_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_saison-24.gif",
		  "creer.gif",'right')."</div>";

	echo fin_gauche(),fin_page();
}

?>
