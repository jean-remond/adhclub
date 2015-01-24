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
				'spip_adhffessms',
				'spip_adhassurs_auteurs',
				'spip_adhcotis_auteurs',
				'spip_adhnivs_auteurs',
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
/* 	$maj['201410292235'] = array(	
    	array('maj_tables', array('spip_evinscripteurs', 'spip_evparticipants')),
		array('sql_alter', "TABLE spip_evinscripteurs CHANGE 'statut_inscr' 'statut'"),
		array('sql_updateq', 'spip_evinscripteurs', array('statut'=>'publie')),
	   	array('sql_alter', "TABLE spip_evparticipants DROP seq_palanquee"),
		array('sql_alter', "TABLE spip_evparticipants CHANGE 'ref_palanquee'varchar(10)"),
    	);
*/

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}
 
function adhclub_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_adhassurs_auteurs");
	sql_drop_table("spip_adhcotis_auteurs");
	sql_drop_table("spip_adhnivs_auteurs");
	sql_drop_table("spip_adhassurs");
	sql_drop_table("spip_adhcotis");
	sql_drop_table("spip_adhnivs");
	sql_drop_table("spip_adhsaisons");
	sql_drop_table("spip_adhffessms");

	cextras_api_vider_tables(adhclub_declarer_champs_extras());

	effacer_meta($nom_meta_base_version);
}
?>