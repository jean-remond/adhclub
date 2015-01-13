<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/adh_niveau');
include_spip('adhclub_fonctions');
include_spip('inc/presentation');


// Gestion de l'integration des donnees FFESSM
function exec_adh_import(){
	if (!autoriser('administrer','auteur',0)) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}

	$commencer_page = charger_fonction('commencer_page','inc');
	echo $commencer_page(_T('adhclub:ffessm_page'));
	
	echo gros_titre(_T('adhclub:ffessm_titre'),'',false);
	echo debut_gauche("adhclub",true);
	
	echo debut_boite_info(true);
	echo propre(_T('adhclub:ffessm_page_info'));	
	echo fin_boite_info(true);
	
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adhclub_24.gif";
	$raccourcis = icone_horizontale(_T('adhclub:adhclub_icone_menu'), generer_url_ecrire("adh_tous"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_saison_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:saison_icone_menu'), generer_url_ecrire("adh_saison"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_assur_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:assur_icone_menu'), generer_url_ecrire("adh_assur"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_coti_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:coti_icone_menu'), generer_url_ecrire("adh_coti"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_niveau_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:niveau_icone_menu'), generer_url_ecrire("adh_niveau"), $icone, "", false);
	echo bloc_des_raccourcis($raccourcis);
	
	echo debut_droite("adh_club",true);
	echo recuperer_fond('public/adh_ffessm',$_GET);
	/*if (autoriser('modifier','auteur'))
		echo "<div>".icone_inline(_T('adhclub:niveau_creer'),
		  generer_url_ecrire("niveaux_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_niveau_24.gif",
		  "creer.gif",'right')."</div>";*/

	echo fin_gauche(),fin_page();
}


?>
