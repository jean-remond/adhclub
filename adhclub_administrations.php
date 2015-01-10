<?php
function adhclub_upgrade($nom_meta_base_version, $version_cible){
	 
	$maj = array();
	$maj['create'] = array(
		array('maj_tables', 
			array('spip_adhassurs', 
				'spip_adhcotis',
				'spip_adhnivs',
				'spip_adhsaisons',
				'spip_adhffessms',
				'spip_adhassurs_auteurs',
				'spip_adhcotis_auteurs',
				'spip_adhnivs_auteurs'
			)),
		);
	
/*	$maj['201410292235'] = array(
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
	sql_drop_table("spip_adhassurs");
	sql_drop_table("spip_adhcotis");
	sql_drop_table("spip_adhnivs");
	sql_drop_table("spip_adhsaisons");
	sql_drop_table("spip_adhffessms");
	sql_drop_table("spip_adhassurs_auteurs");
	sql_drop_table("spip_adhcotis_auteurs");
	sql_drop_table("spip_adhnivs_auteurs");
	effacer_meta($nom_meta_base_version);
}
?>