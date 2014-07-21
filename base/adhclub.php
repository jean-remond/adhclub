<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 2.1
 * Licence GPL (c) 2011-2013 Jean Remond
 *
 */


if (!defined("_ECRIRE_INC_VERSION")) return;

function adhclub_declarer_tables_interfaces($interface){

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

	//-- Table des dates -----------------------------------------------------
	//-- Specifier les champs "date" des nouvelles tables

		//-- Table des Assurances

		//-- Table des Cotisations Club

		//-- Table des Niveaux de compÃ©tences sportives
	$interface['table_date']['adhnivs'] = 'maj';

		//-- Table jointure Niveaux-Auteurs
	$interface['table_date']['adhnivs_auteurs'] = 'maj';

		//-- Table des Saisons
	$interface['table_date']['adhsaisons'] = 'maj';
	$interface['table_date']['adhsaisons'] = 'saison_deb';
	

	return $interface;
}

function adhclub_declarer_tables_principales($tables_principales){


	//-- Assurance
	$spip_adhassurs = array(
		"id_assur" 	=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre" 	=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"mnt_assur"	=> "float DEFAULT '0' NOT NULL",
		"id_saison" 	=> "bigint(21)",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
	
	$spip_adhassurs_key = array(
		"PRIMARY KEY" => "id_assur",
		"KEY id_saison" => "id_saison");
	
	$tables_principales['spip_adhassurs'] = array(
		'field' => &$spip_adhassurs,
		'key' => &$spip_adhassurs_key);

	//-- Cotisation Club
	$spip_adhcotis = array(
		"id_coti" 	=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre" 	=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"mnt_cotis"	=> "float DEFAULT '0' NOT NULL",
		"id_saison" 	=> "bigint(21)",
		"complement" 	=> "ENUM('non', 'oui') DEFAULT 'non' NOT NULL",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
	
	$spip_adhcotis_key = array(
		"PRIMARY KEY" => "id_coti",
		"KEY id_saison" => "id_saison");
	
	$tables_principales['spip_adhcotis'] = array(
		'field' => &$spip_adhcotis,
		'key' => &$spip_adhcotis_key);

	//-- Niveau-Brevet
	$spip_adhnivs = array(
		"id_niveau" 	=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre" 	=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif"    => "text",
		"techbase"  => "bigint(21) NOT NULL",
		"encadrant" => "bigint(21) NOT NULL",
		"id_trombi"    => "bigint(21) NOT NULL",
		"rangtrombi"    => "bigint(21) NOT NULL",
		"maj"   => "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
	
	$spip_adhnivs_key = array(
		"PRIMARY KEY" => "id_niveau",
		"KEY id_trombi" => "id_trombi, rangtrombi",
		"KEY techbase" => "techbase",
		"KEY encadrant" => "encadrant");
	
	$tables_principales['spip_adhnivs'] = array(
		'field' => &$spip_adhnivs,
		'key' => &$spip_adhnivs_key);

	//-- Saisons
	$spip_adhsaisons = array(
		"id_saison" 	=> "bigint(21) NOT NULL	AUTO_INCREMENT",
		"titre" 	=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"encours" 	=> "ENUM('non', 'oui') DEFAULT 'non' NOT NULL",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP",
		"saison_deb"	=> "DATE");
	
	$spip_adhsaisons_key = array(
		"PRIMARY KEY" => "id_saison");
	
	$tables_principales['spip_adhsaisons'] = array(
		'field' => &$spip_adhsaisons,
		'key' => &$spip_adhsaisons_key);

    //-- Table de travail
	//-- Integration donnees FFESSM
	$spip_adhffessms = array(
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
    "statut" => "text NOT NULL");
 	
	$spip_adhffessms_key = array(
		"PRIMARY KEY" => "licence");
	
	$tables_principales['spip_adhffessms'] = array(
		'field' => &$spip_adhffessms,
		'key' => &$spip_adhffessms_key);


return $tables_principales;
}

function adhclub_declarer_tables_auxiliaires($tables_auxiliaires){
	
	
	//-- Relation Assurance / Auteur		
	$spip_adhassurs_auteurs = array(
		"id_assur" 	=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
	
	$spip_adhassurs_auteurs_key = array(
		"PRIMARY KEY" 	=> "id_assur, id_auteur",
		"KEY id_auteur" => "id_auteur");

	$tables_auxiliaires['spip_adhassurs_auteurs'] = array(
		'field' => &$spip_adhassurs_auteurs,
		'key' => &$spip_adhassurs_auteurs_key);
	
	//-- Relation Cotisation Club / Auteur	
	$spip_adhcotis_auteurs = array(
		"id_coti" 	=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"ref_saisie" 	=> "varchar(10) DEFAULT ' ' NULL",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
	
	$spip_adhcotis_auteurs_key = array(
		"PRIMARY KEY" 	=> "id_coti, id_auteur",
		"KEY id_auteur" => "id_auteur",
        "KEY ref_saisie" => "ref_saisie");

	$tables_auxiliaires['spip_adhcotis_auteurs'] = array(
		'field' => &$spip_adhcotis_auteurs,
		'key' => &$spip_adhcotis_auteurs_key);
	
	//-- Relation Niveau-Brevet / Auteur
	$spip_adhnivs_auteurs = array(
		"id_niveau" 	=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj" 		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
	
	$spip_adhnivs_auteurs_key = array(
		"PRIMARY KEY" 	=> "id_niveau, id_auteur",
		"KEY id_auteur" => "id_auteur");
	
	$tables_auxiliaires['spip_adhnivs_auteurs'] = array(
		'field' => &$spip_adhnivs_auteurs,
		'key' => &$spip_adhnivs_auteurs_key);


	return $tables_auxiliaires;
}

?>
