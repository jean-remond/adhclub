<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * pour les fonctions, variables et constantes nécessaires 
 * aux mise en œuvre, mise à jour et mise au placard d’un plugin.
 * 
 */

//include_spip('inc/cextras');
include_spip('base/adhclub');
 
function adhclub_upgrade($nom_meta_base_version, $version_cible){

	$maj = array();

/*	$maj['create'] = array_merge(
		$maj['create'], */
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
			)
 		);

	$cextraok = cextras_api_upgrade(adhclub_declarer_champs_extras(), $maj['create']);	

/*	$debug1= "DEBUG adhclub JR : /adhclub_administrations.php - adhclub_upgrade - Pt99 - <br />";
	echo "<br />", $debug1;
	echo "cextraok = <br />"; $cextraok; echo ".<br />";
	echo "maj= <br />"; var_dump($maj); echo ".<br />";
	echo "FIN ", $debug1;
*/
 	$maj['3.0.3'] = array(	
    	array(
    		'maj_tables', array(
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
 		);
 	$maj['3.0.4'] = array(	
    	array(
    		'maj_tables', array(
    			'spip_adhassurs', 
				'spip_adhcotis',
				'spip_adhnivs',
     			)
    		),
 		);
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

	effacer_meta($nom_meta_base_version);
}
?>