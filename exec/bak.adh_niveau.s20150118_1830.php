<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/adh_niveau');
include_spip('adhclub_fonctions');
include_spip('inc/presentation');


// Gestion des niveaux de qualification
function exec_adh_niveau(){
	if (!autoriser('administrer','adhniv',0)) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}

	$commencer_page = charger_fonction('commencer_page','inc');
	echo $commencer_page(_T('adhniv:page_adhnivs'));
	
	echo gros_titre(_T('adhniv:titre_adhnivs'),'',false);
	echo debut_gauche("adhclub",true);
	
	echo debut_boite_info(true);
	echo propre(_T('adhclub:niveau_info_page'));	
	echo fin_boite_info(true);
	
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adhclub_24.gif";
	$raccourcis = icone_horizontale(_T('adhclub:icone_menu_adhclub'), generer_url_ecrire("adh_tous"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_saison_24.gif";
	$raccourcis .= icone_horizontale(_T('adhclub:icone_menu_adhsaison'), generer_url_ecrire("adh_saison"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_assur_24.gif";
	$raccourcis .= icone_horizontale(_T('adhassur:icone_menu_adhassur'), generer_url_ecrire("adh_assur"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_coti_24.gif";
	$raccourcis .= icone_horizontale(_T('adhcoti:icone_menu_adhcoti'), generer_url_ecrire("adh_coti"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adhclub_24.gif";
	$raccourcis .= icone_horizontale(_T('adhintg:icone_menu_adhintg'), generer_url_ecrire("adh_import"), $icone, "", false);
	echo bloc_des_raccourcis($raccourcis);
	
	echo debut_droite("adh_club",true);
	if (autoriser('modifier','adhniv'))
		echo "<div>".icone_inline(_T('adhniv:icone_creer_adhniv'),
		  generer_url_ecrire("niveaux_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_niveau_24.gif",
		  "creer.gif",'right')."</div>";
	
	echo recuperer_fond('prive/adh_niveau',$_GET);
	
	if (autoriser('modifier','adhniv'))
		echo "<div>".icone_inline(_T('adhniv:icone_creer_adhniv'),
		  generer_url_ecrire("niveaux_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/img_pack/adh_niveau_24.gif",
		  "creer.gif",'right')."</div>";

	echo fin_gauche(),fin_page();
}


?>
