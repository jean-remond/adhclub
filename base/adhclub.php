<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Déclaration des alias de tables et filtres automatiques de champs
 */
function adhclub_declarer_tables_interfaces($interface){

	//-- Table des tables ----------------------------------------------------
	
	$interface['table_des_tables']['adhassurs']='adhassurs';
	$interface['table_des_tables']['adhcotis']='adhcotis';
	$interface['table_des_tables']['adhnivs']='adhnivs';
	$interface['table_des_tables']['adhsaisons']='adhsaisons';
	$interface['table_des_tables']['adhffessms']='adhffessms';
			
	//-- Table des jointures --------------------------------------------------
	//-- Associer les tables principales a leurs tables de jointures

	$interface['tables_jointures']['spip_auteurs']['id_auteur'] = 'adhassurs_auteurs';
	$interface['tables_jointures']['spip_adhassurs']['id_assur'] = 'adhassurs_auteurs';

	$interface['tables_jointures']['spip_auteurs']['id_auteur'] = 'adhcotis_auteurs';
	$interface['tables_jointures']['spip_adhcotis']['id_cotis'] = 'adhcotis_auteurs';

	$interface['tables_jointures']['spip_auteurs']['id_auteur'] = 'adhnivs_auteurs';
	$interface['tables_jointures']['spip_adhnivs']['id_niveau'] = 'adhnivs_auteurs';

return $interface;
}

/**
 * Déclaration des objets éditoriaux
 */
function adhclub_declarer_tables_objets_sql($tables){

//-- Assurance
$tables['spip_adhassurs'] = array(
	'table_objet'	=> "adhassurs",
	'type'			=> "adhassur",
	'principale'	=> "oui",
    'field' => array(
		"id_assur"		=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre"			=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif"	=> "text",
		"mnt_assur"		=> "float DEFAULT '0' NOT NULL",
		"id_saison"		=> "bigint(21)",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP",
		"statut" => "varchar(20)  DEFAULT 'prepa' NOT NULL",
    ),
    'key' => array(
		"PRIMARY KEY"	=> "id_assur",
		"KEY id_saison" => "id_saison"
    	),
	'titre' 		=> "titre AS titre, '' AS lang",
    'date'			=> "maj",
    'editable'		=> "oui",
	'champs_editables'	=> array(
		"titre", "descriptif", "mnt_assur", "id_saison"
		),
	'icone_objet'			=> "images/adhclub-24.gif",
	'texte_objet'			=> "adhclub:assur_titre",
	'texte_objets'			=> "adhclub:assurs_titre",
	'texte_ajouter'			=> 'adhclub:assur_ajouter',
	'info_aucun_objet'		=> "adhclub:assur_aucun",
	'texte_creer_associer'	=> 'adhclub:assur_creer_associer',
	'info_1_objet'			=> 'adhclub:assur_info_1',
	'info_nb_objets'		=> 'adhclub:assurs_info_nb',
	'url_voir'				=> 'editer_assur',
	'url_edit'				=> 'editer_assur',
	'page'					=> false,
	'statut_images' => array(
		'prepa'=>'puce-preparer-8.png',
		'prop'=>'puce-proposer-8.png',
		'publie'=>'puce-publier-8.png',
		'refuse'=>'puce-refuser-8.png',
		'poubelle'=>'puce-supprimer-8.png',
		),
	'statut_titres' => array(
		'prepa'=>'adhclub:info_statut_prepa',
		'prop'=>'adhclub:info_statut_prop',
		'publie'=>'adhclub:info_statut_publie',
		'refuse'=>'adhclub:info_statut_refuse',
		'poubelle'=>'adhclub:info_statut_poubelle',
		),
	'statut_textes_instituer' => array(
		'prepa'=>'adhclub:texte_statut_prepa',
		'prop'=>'adhclub:texte_statut_prop',
		'publie'=>'adhclub:texte_statut_publie',
		'refuse'=>'adhclub:texte_statut_refuse',
		'poubelle' => 'texte_statut_poubelle',
		),
	'texte_changer_statut' => 'adhclub:assur_texte_changer_statut',
	);
	
//-- Cotisation Club
$tables['spip_adhcotis'] = array(
	'table_objet'	=> "adhcotis",
	'type'			=> "adhcoti",
	'principale'	=> "oui",
    'field'=> array(
		"id_coti"		=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre"			=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"mnt_cotis"		=> "float DEFAULT '0' NOT NULL",
		"id_saison" 	=> "bigint(21)",
		"complement" 	=> "ENUM('non', 'oui') DEFAULT 'non' NOT NULL",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP",
		"statut"		=> "varchar(20)  DEFAULT 'prepa' NOT NULL",
    ),
    'key' => array(
		"PRIMARY KEY" 	=> "id_coti",
		"KEY id_saison" => "id_saison"
    	),
	'titre'			=> "titre AS titre, '' AS lang",
    'date'			=> "maj",
    'editable'		=> "oui",
	'champs_editables'	=> array(
		"titre", "descriptif", "mnt_cotis", "id_saison", "complement"
		),
	'icone_objet'	=> "",
	'texte_objet'	=> "adhclub:coti_titre",
	'texte_objets'	=> "adhclub:cotis_titre",
	'info_aucun_objet'	=> "adhclub:coti_aucun",
	'texte_creer_associer'	=> 'adhclub:coti_creer_associer',
	'info_1_objet'			=> 'adhclub:coti_info_1',
	'info_nb_objets'		=> 'adhclub:cotis_info_nb',
	'url_voir'				=> 'editer_coti',
	'url_edit'				=> 'editer_coti',
	'page'					=> false,
	'statut_images' => array(
		'prepa'=>'puce-preparer-8.png',
		'prop'=>'puce-proposer-8.png',
		'publie'=>'puce-publier-8.png',
		'refuse'=>'puce-refuser-8.png',
		'poubelle'=>'puce-supprimer-8.png',
		),
	'statut_titres' => array(
		'prepa'=>'adhclub:info_statut_prepa',
		'prop'=>'adhclub:info_statut_prop',
		'publie'=>'adhclub:info_statut_publie',
		'refuse'=>'adhclub:info_statut_refuse',
		'poubelle'=>'adhclub:info_statut_poubelle',
		),
	'statut_textes_instituer' => array(
		'prepa'=>'adhclub:texte_statut_prepa',
		'prop'=>'adhclub:texte_statut_prop',
		'publie'=>'adhclub:texte_statut_publie',
		'refuse'=>'adhclub:texte_statut_refuse',
		'poubelle' => 'texte_statut_poubelle',
		),
	'texte_changer_statut' => 'adhclub:coti_texte_changer_statut',
	);
	
//-- Niveau-Brevet
$tables['spip_adhnivs'] = array(
	'table_objet'	=> "adhnivs",
	'type'			=> "adhniv",
	'principale'	=> "oui",
	'field'=> array(
		"id_niveau" 	=> "bigint(21) NOT NULL AUTO_INCREMENT",
		"titre" 		=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif"    => "text",
		"techbase"  	=> "bigint(21) NOT NULL",
		"encadrant" 	=> "bigint(21) NOT NULL",
		"id_trombi"		=> "bigint(21) NOT NULL",
		"rangtrombi"    => "bigint(21) NOT NULL",
		"maj"   		=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP",
		"statut"		=> "varchar(20)  DEFAULT 'prepa' NOT NULL",
	),
    'key' => array(
		"PRIMARY KEY" 	=> "id_niveau",
		"KEY id_trombi" => "id_trombi, rangtrombi",
		"KEY techbase"	=> "techbase",
		"KEY encadrant" => "encadrant"
    	),
	'titre'			=> "titre AS titre, '' AS lang",
    'date'			=> "maj",
    'editable'		=> "oui",
	'champs_editables'	=> array(
		"titre", "descriptif", "techbase", "encadrant", "id_trombi", "rangtrombi"
		),
	'icone_objet'	=> "",
	'texte_objet'	=> "adhclub:niveau_titre",
	'texte_objets'	=> "adhclub:niveaux_titre",
	'info_aucun_objet'	=> "adhclub:niveau_aucun",
	'texte_creer_associer'	=> 'adhclub:niveau_creer_associer',
	'info_1_objet'			=> 'adhclub:niveau_info_1',
	'info_nb_objets'		=> 'adhclub:niveaux_info_nb',
	'url_voir'				=> 'editer_niveau',
	'url_edit'				=> 'editer_niveau',
	'page'					=> false,
	'statut_images' => array(
		'prepa'=>'puce-preparer-8.png',
		'prop'=>'puce-proposer-8.png',
		'publie'=>'puce-publier-8.png',
		'refuse'=>'puce-refuser-8.png',
		'poubelle'=>'puce-supprimer-8.png',
		),
	'statut_titres' => array(
		'prepa'=>'adhclub:info_statut_prepa',
		'prop'=>'adhclub:info_statut_prop',
		'publie'=>'adhclub:info_statut_publie',
		'refuse'=>'adhclub:info_statut_refuse',
		'poubelle'=>'adhclub:info_statut_poubelle',
		),
	'statut_textes_instituer' => array(
		'prepa'=>'adhclub:texte_statut_prepa',
		'prop'=>'adhclub:texte_statut_prop',
		'publie'=>'adhclub:texte_statut_publie',
		'refuse'=>'adhclub:texte_statut_refuse',
		'poubelle' => 'texte_statut_poubelle',
		),
	'texte_changer_statut' => 'adhclub:niveau_texte_changer_statut',
	);
	
//-- Saisons
$tables['spip_adhsaisons'] = array(
	'table_objet'	=> "adhsaisons",
	'type'			=> "adhsaison",
	'principale'	=> "oui",
	'field'=> array(
		"id_saison" 	=> "bigint(21) NOT NULL	AUTO_INCREMENT",
		"titre" 		=> "varchar(35) DEFAULT ' ' NOT NULL",
		"descriptif" 	=> "text",
		"encours" 		=> "ENUM('non', 'oui') DEFAULT 'non' NOT NULL",
		"maj" 			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP",
		"saison_deb"	=> "DATE",
		"statut"		=> "varchar(20)  DEFAULT 'prepa' NOT NULL",
	),
    'key' => array(
		"PRIMARY KEY"	=> "id_saison"
    	),
	'titre'			=> "titre AS titre, '' AS lang",
	'date'			=> "saison_deb",
    'editable'		=> "oui",
	'champs_editables'	=> array(
		"titre", "descriptif", "encours", "saison_deb"
		),
	'icone_objet'	=> "adhsaison-24.png",
	'texte_objet'	=> "adhclub:saison_titre",
	'texte_objets'	=> "adhclub:saisons_titre",
	'info_aucun_objet'	=> "adhclub:saison_aucun",
	'texte_creer_associer'	=> 'adhclub:saison_creer_associer',
	'info_1_objet'			=> 'adhclub:saison_info_1',
	'info_nb_objets'		=> 'adhclub:saisons_info_nb',
	'url_voir'				=> 'editer_adhsaison',
	'url_edit'				=> 'editer_adhsaison',
	'page'					=> false,
	'statut_images' => array(
		'prepa'=>'puce-preparer-8.png',
		'prop'=>'puce-proposer-8.png',
		'publie'=>'puce-publier-8.png',
		'refuse'=>'puce-refuser-8.png',
		'poubelle'=>'puce-supprimer-8.png',
		),
	'statut_titres' => array(
		'prepa'=>'adhclub:info_statut_prepa',
		'prop'=>'adhclub:info_statut_prop',
		'publie'=>'adhclub:info_statut_publie',
		'refuse'=>'adhclub:info_statut_refuse',
		'poubelle'=>'adhclub:info_statut_poubelle',
		),
	'statut_textes_instituer' => array(
		'prepa'=>'adhclub:texte_statut_prepa',
		'prop'=>'adhclub:texte_statut_prop',
		'publie'=>'adhclub:texte_statut_publie',
		'refuse'=>'adhclub:texte_statut_refuse',
		'poubelle' => 'texte_statut_poubelle',
		),
	'texte_changer_statut' => 'adhclub:saison_texte_changer_statut',
	);

//-- Table de travail
//-- Integration donnees FFESSM (format externe)
$tables['spip_adhffessms'] = array(
	'table_objet'	=> "adhffessms",
	'type'			=> "adhffessm",
	'principale'	=> "oui",
    'field'			=> array(
		"souscription"	=> "text(10) NOT NULL",
		"saisie"		=> "text NOT NULL",
		"saison"		=> "int(4) NOT NULL",
		"type"			=> "text NOT NULL",
		"licence"		=> "varchar(11) NOT NULL",
		"civilite"		=> "text NOT NULL",
		"prenom"		=> "text NOT NULL",
		"nom"			=> "text NOT NULL",
		"naissance"		=> "text(10) NOT NULL",
		"adresse1"		=> "text NOT NULL",
		"adresse2"		=> "text NOT NULL",
		"adresse3"		=> "text NOT NULL",
		"cp"			=> "text NOT NULL",
		"ville"			=> "text NOT NULL",
		"pays"			=> "text NOT NULL",
		"email"			=> "tinytext NOT NULL",
		"assurance"		=> "text NOT NULL",
		"statut"		=> "text NOT NULL"
        ),
    'key'			=> array(
		"PRIMARY KEY"	=> "licence"
    	),
    'titre'			=> "licence AS titre, '' AS lang",
    'editable'		=> "non",
	'icone_objet'	=> "",
	'texte_objet'	=> "adhclub:ffessm_titre",
	'textes_objet'	=> "adhclub:ffessms_titre",
	'info_aucun_objet'	=> "adhclub:ffessm_aucun"
);

//-- Relation Assurance / Auteur		
$tables['spip_adhassurs_auteurs'] = array(
	'table_objet'	=> "adhassurs_auteurs",
	'type'			=> "adhassurs_auteur",
	'principale'	=> "non",
	'field'=> array(
		"id_assur"		=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
		),
	'key' => array(
		"PRIMARY KEY" 	=> "id_assur, id_auteur",
		"KEY id_auteur" => "id_auteur"
		),
    'editable'		=> "non",
	);

//-- Relation Cotisation Club / Auteur	
$tables['spip_adhcotis_auteurs'] = array(
	'table_objet'	=> "adhcotis_auteurs",
	'type'			=> "adhcotis_auteur",
	'principale'	=> "non",
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
    	),
    'editable'		=> "non",
    );

//-- Relation Niveau-Brevet / Auteur
$tables['spip_adhnivs_auteurs'] = array(
	'table_objet'	=> "adhnivs_auteurs",
	'type'			=> "adhnivs_auteur",
	'principale'	=> "non",
	'field'=> array(
		"id_niveau" 	=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
		),
    'key' => array(
   		"PRIMARY KEY" 	=> "id_niveau, id_auteur",
		"KEY id_auteur" => "id_auteur"
    	),
    'editable'		=> "non",
    );

return $tables;
}

/**
 * Déclaration des champs extras
 */
function adhclub_declarer_champs_extras($champs = array()){
$champs['spip_auteurs']['certifaspirine'] = array(
	'saisie' => 'input',//Type du champs (voir plugin Saisies)
	'options' => array(
		'nom' => 'certifaspirine', 
		'label' => _T('adhclub:certifaspirine_label'), 
		'explication' => _T('adhclub:certifaspirine_expl'),
		'sql' => "ENUM('non', 'oui') NOT NULL DEFAULT 'non'",
		'defaut' => 'non',// Valeur par défaut
		'restrictions'=>array(	
			'voir' 		=> array('auteur'=>''),//Tout le monde peut voir
			'modifier'	=> array('auteur'=>'webmestre'))),//Seul les webmestre peuvent modifier
	'verifier' => array()
);
$champs['spip_auteurs']['certiflimite'] = array(
	'saisie' => 'input',//Type du champs (voir plugin Saisies)
	'options' => array(
		'nom' => 'certiflimite', 
		'label' => _T('adhclub:certiflimite_label'), 
		'explication' => _T('adhclub:certiflimite_expl'),
		'sql' => "DATE NOT NULL DEFAULT '0000-00-00'",
		'defaut' => '0000-00-00',// Valeur par défaut
		'restrictions'=>array(	
			'voir' 		=> array('auteur'=>''),//Tout le monde peut voir
			'modifier'	=> array('auteur'=>'webmestre'))),//Seul les webmestre peuvent modifier
	'verifier' => array()
);
$champs['spip_auteurs']['certifqualif'] = array(
	'saisie' => 'input',//Type du champs (voir plugin Saisies)
	'options' => array(
		'nom' => 'certifqualif', 
		'label' => _T('adhclub:certifqualif_label'), 
		'explication' => _T('adhclub:certifqualif_expl'),
		'sql' => "ENUM('non', 'oui') NOT NULL DEFAULT 'non'",
		'defaut' => 'non',// Valeur par défaut
		'restrictions'=>array(	
			'voir' 		=> array('auteur'=>''),//Tout le monde peut voir
			'modifier'	=> array('auteur'=>'webmestre'))),//Seul les webmestre peuvent modifier
	'verifier' => array()
);
$champs['spip_auteurs']['email_corr'] = array(
	'saisie' => 'input',//Type du champs (voir plugin Saisies)
	'options' => array(
		'nom' => 'email_corr', 
		'label' => _T('adhclub:email_corr_label'), 
		'sql' => "TEXT NOT NULL DEFAULT ''",
		'defaut' => '',// Valeur par défaut
		'restrictions'=>array(	
			'voir' 		=> array('auteur'=>''),//Tout le monde peut voir
			'modifier'	=> array('auteur'=>'webmestre'))),//Seul les webmestre peuvent modifier
	'verifier' => array()
);

return $champs;	
}

?>