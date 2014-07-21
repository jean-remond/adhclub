<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2012 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('base/create');
/** Fonction d'installation des tables du plugin et mises a jour
 *
 * @param unknown_type $nom_meta_base_version
 * @param unknown_type $version_cible
 */
function adhclub_upgrade($nom_meta_base_version,$version_cible){
		$current_version = 0.0;
		if (	(!isset($GLOBALS['meta'][$nom_meta_base_version]) )
					|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
				if ($current_version==0.0){
					include_spip('base/adhclub');
					include_spip('base/abstract_sql');
					creer_base();
					echo "Adh_Club Install<br/>";
					ecrire_meta($nom_meta_base_version,$current_version=$version_cible);
				}
				if (version_compare($current_version,"0.5","<")){
					// vos requêtes pour mettre à jour les tables du plugin
					ecrire_meta($nom_meta_base_version,$current_version="0.5");
                }
				if (version_compare($current_version,"0.8","<")){
					// vos requêtes pour mettre à jour les tables du plugin
					include_spip('base/abstract_sql');
					sql_alter("TABLE spip_adhcotis ADD complement ENUM('non', 'oui') DEFAULT 'non' NOT NULL	AFTER id_saison");
					ecrire_meta($nom_meta_base_version,$current_version="0.8");
				}
				if (version_compare($current_version,"0.11","<")){
					// vos requêtes pour mettre à jour les tables du plugin
					include_spip('base/abstract_sql');
					sql_alter("TABLE spip_adhsaisons ADD saison_deb	DATE AFTER maj");
					ecrire_meta($nom_meta_base_version,$current_version="0.11");
				}
				if (version_compare($current_version,"0.14","<")){
					ecrire_meta($nom_meta_base_version,$current_version="0.14");
                }
				ecrire_metas();
		}
}
/** Fonction de désinstallation des tables du plugin
 *
 * @param unknown_type $nom_meta_base_version
 */
function adhclub_vider_tables($nom_meta_base_version) {
        // vos requêtes pour effacer les tables du plugin
	sql_drop_table("spip_adhassurs");
	sql_drop_table("spip_adhcotis");
	sql_drop_table("spip_adhnivs");
	sql_drop_table("spip_adhsaisons");
	sql_drop_table("spip_adhffessms");

	sql_drop_table("spip_adhassurs_auteurs");
	sql_drop_table("spip_adhcotis_auteurs");
	sql_drop_table("spip_adhnivs_auteurs");

        effacer_meta($nom_meta_base_version);
        ecrire_metas();
}


?>
