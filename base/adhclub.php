<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 */


if (!defined("_ECRIRE_INC_VERSION")) return;

function adhclub_declarer_tables_objets_sql($tables){

//-- Assurance
$tables['spip_adhassurs'] = array(
    'principale' => "oui",
    'field'=> array(
		"id_assur"		=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre"			=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif"	=> "text",
		"mnt_assur"		=> "float DEFAULT '0' NOT NULL",
		"id_saison"		=> "bigint(21)",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
    	),
    'key' => array(
		"PRIMARY KEY" => "id_assur",
		"KEY id_saison" => "id_saison"
    	),
    'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj"
    );
	
//-- Cotisation Club
$tables['spip_adhcotis'] = array(
    'principale' => "oui",
    'field'=> array(
		"id_coti"		=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre"			=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"mnt_cotis"		=> "float DEFAULT '0' NOT NULL",
		"id_saison" 	=> "bigint(21)",
		"complement" 	=> "ENUM('non', 'oui') DEFAULT 'non' NOT NULL",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
    	),
    'key' => array(
		"PRIMARY KEY" 	=> "id_coti",
		"KEY id_saison" => "id_saison"
    	),
    'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj"
    );
	
//-- Niveau-Brevet
$tables['spip_adhnivs'] = array(
    'principale' => "oui",
    'field'=> array(
		"id_niveau" 	=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre" 		=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif"    => "text",
		"techbase"  	=> "bigint(21) NOT NULL",
		"encadrant" 	=> "bigint(21) NOT NULL",
		"id_trombi"		=> "bigint(21) NOT NULL",
		"rangtrombi"    => "bigint(21) NOT NULL",
		"maj"   		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
    ),
    'key' => array(
		"PRIMARY KEY" 	=> "id_niveau",
		"KEY id_trombi" => "id_trombi, rangtrombi",
		"KEY techbase"	=> "techbase",
		"KEY encadrant" => "encadrant"
    	),
    'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj"
    );
	
//-- Saisons
$tables['spip_adhsaisons'] = array(
    'principale' => "oui",
    'field'=> array(
		"id_saison" 	=> "bigint(21) NOT NULL	AUTO_INCREMENT",
		"titre" 		=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"encours" 		=> "ENUM('non', 'oui') DEFAULT 'non' NOT NULL",
		"maj" 			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP",
		"saison_deb"	=> "DATE"
		),
    'key' => array(
		"PRIMARY KEY"	=> "id_saison"
    	),
    'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj",
	'date'	=> "saison_deb"
    );

//-- Relation Assurance / Auteur		
$tables['spip_adhassurs_auteurs'] = array(
    'principale' => "non",
    'field'=> array(
		"id_assur"		=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
		),
    'key' => array(
    	"PRIMARY KEY" 	=> "id_assur, id_auteur",
		"KEY id_auteur" => "id_auteur"
    	)
    );

//-- Relation Cotisation Club / Auteur	
$tables['spip_adhcotis_auteurs'] = array(
    'principale' => "non",
    'field'=> array(
		"id_coti" 		=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"ref_saisie" 	=> "varchar(10) DEFAULT ' ' NULL",
		"maj" 			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
		),
    'key' => array(
    	"PRIMARY KEY" 	=> "id_coti, id_auteur",
		"KEY id_auteur" => "id_auteur",
        "KEY ref_saisie" => "ref_saisie"
    	)
    );
	
//-- Relation Niveau-Brevet / Auteur
$tables['spip_adhnivs_auteurs'] = array(
    'principale' => "non",
    'field'=> array(
		"id_niveau" 	=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
		),
    'key' => array(
   		"PRIMARY KEY" 	=> "id_niveau, id_auteur",
		"KEY id_auteur" => "id_auteur"
    	)
    );
	
//-- Table de travail
//-- Integration donnees FFESSM (format externe)
$tables['spip_adhffessms'] = array(
    'principale' => "non",
    'field'=> array(
		"souscription" => "text(10) NOT NULL",
		"saisie" => "text NOT NULL",
		"saison" => "int(4) NOT NULL",
		"type" => "text NOT NULL",
		"licence" => "varchar(11) NOT NULL",
		"civilite" => "text NOT NULL",
		"prenom" => "text NOT NULL",
		"nom" => "text NOT NULL",
		"naissance" => "text(10) NOT NULL",
		"adresse1" => "text NOT NULL",
		"adresse2" => "text NOT NULL",
		"adresse3" => "text NOT NULL",
		"cp" => "text NOT NULL",
		"ville" => "text NOT NULL",
		"pays" => "text NOT NULL",
		"email" => "tinytext NOT NULL",
		"assurance" => "text NOT NULL",
		"statut" => "text NOT NULL"
        ),
    'key' => array(
		"PRIMARY KEY" => "licence"
    	),
    'titre' => "licence AS titre, '' AS lang",
    'date'	=> "souscription"
    );
	
    return $tables;
    }

/*function adhclub_declarer_tables_interfaces($interface){

	//-- Table des jointures --------------------------------------------------
	//-- Associer les tables principales a  leurs tables de jointures

	$interface['tables_jointures']['spip_auteurs'][] = 'adhassurs_auteurs';
	$interface['tables_jointures']['spip_adhassurs'][] = 'adhassurs_auteurs';

	$interface['tables_jointures']['spip_auteurs'][] = 'adhcotis_auteurs';
	$interface['tables_jointures']['spip_adhcotis'][] = 'adhcotis_auteurs';

	$interface['tables_jointures']['spip_auteurs'][] = 'adhnivs_auteurs';
	$interface['tables_jointures']['spip_adhnivs'][] = 'adhnivs_auteurs';

	
	//-- Table des tables ----------------------------------------------------
	//-- Definir le nom des nouvelles boucles

		//-- Table des garanties d'assurances
	$interface['table_des_tables']['adhassurs']='adhassurs';
		//-- Table des differentes cotisations
	$interface['table_des_tables']['adhcotis']='adhcotis';
		//-- Table des Niveaux de compÃ©tences sportives
	$interface['table_des_tables']['adhnivs']='adhnivs';
		//-- Table des Saisons de gestion
	$interface['table_des_tables']['adhsaisons']='adhsaisons';

		//-- Table des Donnees FFESSM
	$interface['table_des_tables']['adhffessms']='adhffessms';

		//-- Table des Saisons
	$interface['table_date']['adhsaisons'] = 'maj';
	$interface['table_date']['adhsaisons'] = 'saison_deb';
	

	return $interface;
}
*/

?>
