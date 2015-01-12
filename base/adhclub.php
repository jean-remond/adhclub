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
	'type' => 'adhassur',
    'principale' => 'oui',
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
	'champs_editables' => array(
		"titre", "descriptif", "mnt_assur", "id_saison"
		),
	'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj",
	'champs_versionnes' => array(),
	'rechercher_champs' => array()
	);
	
//-- Cotisation Club
$tables['spip_adhcotis'] = array(
	'type' => 'adhcoti',
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
	'champs_editables' => array(
		"titre", "descriptif", "mnt_cotis", "id_saison", "complement"
		),
	'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj",
	'champs_versionnes' => array(),
	'rechercher_champs' => array()
	);
	
//-- Niveau-Brevet
$tables['spip_adhnivs'] = array(
	'type' => 'adhniv',
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
	'champs_editables' => array(
		"titre", "descriptif", "techbase", "encadrant", "id_trombi", "rangtrombi"
		),
	'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj",
	'champs_versionnes' => array(),
	'rechercher_champs' => array()
	);
	
//-- Saisons
$tables['spip_adhsaisons'] = array(
	'type' => 'adhsaison',
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
	'champs_editables' => array(
		"titre", "descriptif", "encours", "saison_deb"
		),
	'titre' => "titre AS titre, '' AS lang",
    'date'	=> "maj",
	'date'	=> "saison_deb",
	'champs_versionnes' => array(),
	'rechercher_champs' => array()
	);

//-- Table de travail
//-- Integration donnees FFESSM (format externe)
$tables['spip_adhffessms'] = array(
	'type' => 'adhffessm',
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
    'date'	=> "souscription",
	'champs_versionnes' => array(),
	'rechercher_champs' => array()
    );
	
return $tables;
}

/**
 * Déclaration des tables secondaires (liaisons)
 */
function adhclub_declarer_tables_auxiliaires($tables_auxiliaires){
     
//-- Relation Assurance / Auteur		
    $spip_adhassurs_auteurs =  array(
		"id_assur"		=> "bigint(21) NOT NULL",
		"id_auteur" 	=> "bigint(21) NOT NULL",
		"maj"			=> "TIMESTAMP default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"
		);

    $spip_adhassurs_auteurs_cles =  array(
    	"PRIMARY KEY" 	=> "id_assur, id_auteur",
		"KEY id_auteur" => "id_auteur"
    );

	$tables_auxiliaires['spip_adhassurs_auteurs'] = array(
    'field' => &$spip_adhassurs_auteurs,
    'key' => &$spip_adhassurs_auteurs_cles
	);

//-- Relation Cotisation Club / Auteur	
$tables_auxiliaires['spip_adhcotis_auteurs'] = array(
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
$tables_auxiliaires['spip_adhnivs_auteurs'] = array(
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
	
return $tables_auxiliaires;
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