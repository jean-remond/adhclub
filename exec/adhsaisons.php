<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
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
	echo $commencer_page(_T('adhsaison:titre_adhsaisons'));
	
	echo gros_titre(_T('adhsaison:titre_adhsaison'),'',false);
	echo debut_gauche("adhclub",true);
	
	echo debut_boite_info(true);
	echo propre(_T('adhsaison:info_page_adhsaison'));	
	echo fin_boite_info(true);
	
	$icone = _DIR_PLUGIN_ADHCLUB."prive/themes/spip/images/adhclub-24.png";
	$raccourcis = icone_horizontale(_T('adhclub:adhclub_icone_menu'), generer_url_ecrire("adh_tous"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."prive/themes/spip/images/adhassur-24.png";
	$raccourcis .= icone_horizontale(_T('adhclub:assur_icone_menu'), generer_url_ecrire("adh_assur"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."prive/themes/spip/images/adhcoti-24.png";
	$raccourcis .= icone_horizontale(_T('adhclub:coti_icone_menu'), generer_url_ecrire("adh_coti"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."prive/themes/spip/images/adhniveau-24.png";
	$raccourcis .= icone_horizontale(_T('adhniv:icone_menu_adhniv'), generer_url_ecrire("adh_niveau"), $icone, "", false);
	$icone = _DIR_PLUGIN_ADHCLUB."prive/themes/spip/images/adhclub-24.png";
	$raccourcis .= icone_horizontale(_T('adhclub:ffessm_icone_menu'), generer_url_ecrire("adh_import"), $icone, "", false);
	echo bloc_des_raccourcis($raccourcis);
	
	echo debut_droite("adh_club",true);
	echo coucou;
	
	if (autoriser('administrer','adhsaison'))
		echo "<div>".icone_inline(_T('adhsaison:icone_creer_adhsaison'),
		  generer_url_ecrire("saisons_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."prive/themes/spip/images/adhsaison-24.png",
		  "creer.gif",'right')."</div>";
	echo coucou;
	
	
	echo recuperer_fond('prive/adh_saison',$_GET);
	
	if (autoriser('creer','adhsaison'))
		echo "<div>".icone_inline(_T('adhsaison:icone_creer_adhsaison'),
		  generer_url_ecrire("saisons_edit","new=oui"),
		  _DIR_PLUGIN_ADHCLUB."/prive/themes/spip/images/adhsaison-24.png",
		  "creer.gif",'right')."</div>";

	echo fin_gauche(),fin_page();
}

?>
