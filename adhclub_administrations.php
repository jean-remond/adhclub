<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.1
 * Licence GPL (c) 2011-2017 Jean Remond
 * pour les fonctions, variables et constantes nécessaires 
 * aux mise en oeuvre, mise à jour et mise au placard d’un plugin.
 *
 * @todo : JR-25/04/2017-Finaliser le schema de configuration
 * 
 * Fait :
 * JR-16/05/2017-V3.2.0-201705041511-Ajout F(configurer) avec valeurs initiales.
 * JR-04/05/2017-V3.1.5-201705041511-Remise au standard des index primaires des liens.
 * JR-25/04/2017-V3.1.1-201703011400-Pre-chargement des mots-cles(non finalise).
 */

//include_spip('inc/cextras');
include_spip('base/adhclub');
 
function adhclub_upgrade($nom_meta_base_version, $version_cible){

	$maj = array();

	include_spip('adhclub_fonctions');
	include_spip('inc/config');
	include_spip('action/editer_objet');
	
	$maj['create'] = array( 
		array(
			'maj_tables',array( 
				'spip_adhassurs', 
				'spip_adhcotis',
				'spip_adhnivs',
				'spip_adhsaisons',
				'spip_adhintgs',
				'spip_adhassurs_liens',
				'spip_adhcotis_liens',
				'spip_adhnivs_liens',
				)
			),
		array('ecrire_config','adhclub/max_adhniv_liste', '20'),
		array('ecrire_config','adhclub/max_adhcoti_liste', '20'),
		array('ecrire_config','adhclub/max_adhassur_liste', '20'),
				
			/*array('install_groupe_mots'),
			 	
		*/	
 		);

	$cextraok = cextras_api_upgrade(adhclub_declarer_champs_extras(), $maj['create']);	

	$maj['201705041511'] = array(
		 array(
			'maj_tables', array(
			'spip_adhassurs_liens',
			'spip_adhcotis_liens',
			'spip_adhnivs_liens',
			)
		),
	);

	/*	$debug1= "DEBUG adhclub JR : /adhclub_administrations.php - adhclub_upgrade - Pt99 - <br />";
	echo "<br />", $debug1;
	echo "cextraok = <br />"; $cextraok; echo ".<br />";
	echo "maj= <br />"; var_dump($maj); echo ".<br />";
	echo "FIN ", $debug1;
	*/
	
 	/*$maj['201703011400'] = array(	
    	array(
    		'maj_tables', array(
    			'spip_adhassurs', 
				'spip_adhcotis',
				'spip_adhnivs',
     			)
    		),
 		);*/
 	/*$maj['201501261530'] = array(	
		array('sql_insertq', 'spip_adhassurs_liens', array(
 			sql_allfetsel('id_assur, id_auteur, "auteur", ""', 'spip_adhassurs_auteurs')
 				)
			),
	   	); */
 	/*$maj['201501261700'] = array(	
		array('sql_insertq', 'spip_adhcotis_liens', array(
 			sql_allfetsel('id_coti, id_auteur, "auteur", ""', 'spip_adhcotis_auteurs')
 				)
			),
		array('sql_insertq', 'spip_adhnivs_liens', array(
 			sql_allfetsel('id_niveau, id_auteur, "auteur", ""', 'spip_adhnivs_auteurs')
 				)
			),
		); */
 	/*$maj['201501311230'] = array(
 		array(sql_drop_table("spip_adhffessms"))
		array('sql_alter', "TABLE spip_adhcotis_liens ADD COLUMN ref_saisie VARCHAR(10) DEFAULT '' NULL"),
  	); */
 	/*$maj['201501312000'] = array(
		$cextraok = cextras_api_upgrade(adhclub_declarer_champs_extras(), $maj['201501312000']),	
 	); */
 	/*$maj['201502021400'] = array(
		$cextraok = cextras_api_upgrade(adhclub_declarer_champs_extras(), $maj['201502021400']),	
 	);*/
 	/*$maj['201502021420'] = array(
		array('sql_alter', "TABLE spip_adhintgs ADD COLUMN categorie TEXT DEFAULT '' NULL"),
  	); */
 	/*$maj['201502031200'] = array(
		array('sql_alter', "TABLE spip_adhcotis ADD COLUMN activclub ENUM('non', 'oui') DEFAULT 'oui' NOT NULL AFTER complement"),
  	); */
 	
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}
 
function adhclub_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_adhassurs_liens");
	sql_drop_table("spip_adhcotis_liens");
	sql_drop_table("spip_adhnivs_liens");
	sql_drop_table("spip_adhassurs");
	sql_drop_table("spip_adhcotis");
	sql_drop_table("spip_adhnivs");
	sql_drop_table("spip_adhsaisons");
	sql_drop_table("spip_adhintgs");

	cextras_api_vider_tables(adhclub_declarer_champs_extras());

	effacer_config('adhclub/max_adhniv_liste');
	effacer_config('adhclub/max_adhcoti_liste');
	effacer_config('adhclub/max_adhassur_liste');
	
	effacer_meta($nom_meta_base_version);
}
?>