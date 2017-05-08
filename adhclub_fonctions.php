<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.1
 * Licence GPL (c) 2011-2017 Jean Remond
 * pour les fonctions, variables et constantes nécessaires à l’espace public.
 *
 * @todo : JR-25/04/2017-Terminer le schema de configuration.
 * 
 * Fait
 * JR-01/05/2017-Revue ecriture des logs.
 * JR-25/04/2017-Debut du schema de configuration des parametres a l'installation.
 * JR-21/09/2015-Revue validation activite.
 * JR-26/01/2015-adaptation aux tables liens.
 * JR-10/01/2015-Adaptation spip 3.0.
 * JR-14/03/2013-Ajout critere niveau relatif ds adhclub_auteurs_ds_niveaux.
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * filtre de securisation des squelettes
 * utilise avec [(#REM|adhclub_securise_squelette)]
 * evite divulgation d'info si plugin desactive
 * par erreur fatale
 *
 * @param unknown_type $letexte
 * @return unknown
 */
function adhclub_securise_squelette($letexte){
	return "";
}

/**
 * JR-01/05/2017-Aides au debuggage :
 * Fonction inutile si on active la variable _LOG_FILELINE
 * 
 * cf http://www.spip.net/fr_article5506.html
 *	define('_LOG_FILELINE', true);
 * L'ecriture de log devient :
 * spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
 * 
 * logger les contenus suivant importance ou debug 
 * ADHCLUB_DEBUG definie dans adhclub_options.php.
 *
 * @param string $contenu
 * @param boolean $important
 * @return na
 */
/* function adhclub_log($contenu, $important=false) {
	if ($important
		OR (defined('ADHCLUB_DEBUG') and ADHCLUB_DEBUG)) {
		spip_log("$contenu.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	}else{
		spip_log("$contenu");
	}
} */

/** ===============================================================================
 *  Fonctions de configuration pour l'installation
 *  ===============================================================================
 */
/**
 * adhclub_configuration()
 * teste et configure certaines options de spip pour adhclub.
 * penser à incrementer la valeur de schema dans paquet.xml et celle de $maj
 * 		dans adhclub_administrations.php en cas de mise à jour des mots cles.
 */


function adhclub_configuration(){
	include_spip('inc/config');

	// activer l'utilsation des mots clefs
	$articles_mots = lire_config('articles_mots');
	if($articles_mots == 'non')
		ecrire_meta('articles_mots','oui');
}


/**
 * Description du schema de groupes de mots et mots cles proposes de base
 */
function adhclub_schema_mc(){
	$schema = array(
		'groupes' => array(
			array(  // creation du groupe Niveau_Encadrement
				'titre'=>'Niveau_Encadrement',
				'descriptif'=>'Defini les types de niveaux (encadrement, adherent, etc...',
				'tables_liees'=>'adhnivs',
				'unseul'=>'oui',
				'obligatoire'=>'oui',
				'minirezo'=>'oui',
				'comite'=>'non',
				'forum'=>'non'
			),
			array(  // creation du groupe Niveau_Technique
				'titre'=>'Niveau_Technique',
				'descriptif'=>'Defini les techniques pour chaque niveau (Plongee, Apnee, etc...',
				'tables_liees'=>'adhnivs',
				'unseul'=>'oui',
				'obligatoire'=>'oui',
				'minirezo'=>'oui',
				'comite'=>'non',
				'forum'=>'non'
			),
			array(  // creation du groupe Niveau_Trombi
				'titre'=>'Niveau_Trombi',
				'descriptif'=>'Qualification des adh&ecute;rents et crit&egrave;re de s&ecute;lection pour les articles constituants la structure du trombinoscope.
Les mots-clés génériques (7 caractères) sont réservés pour la qualification des articles supports du Trombinoscope, surtout pour les comités directeurs.',
				'tables_liees'=>'articles,adhnivs',
				'unseul'=>'oui',
				'obligatoire'=>'oui',
				'minirezo'=>'oui',
				'comite'=>'non',
				'forum'=>'non'
			),
		),
		'mots'=> array(
			// Niveau_Encadrement
			array(
				'titre'=>'ADH',
				'descriptif'=>'Niveaux adhérents',
				'type'=>'Niveau_Encadrement'
			),
			array(
				'titre'=>'COM',
				'descriptif'=>'Comité, hors comité directeur',
				'type'=>'Niveau_Encadrement'
			),
			array(
				'titre'=>'DIR',
				'descriptif'=>'Appartenance au bureau directeur',
				'type'=>'Niveau_Encadrement'
			),
			array(
				'titre'=>'ENC',
				'descriptif'=>'Brevets d&rsquo;encadrement',
				'type'=>'Niveau_Encadrement'
			),
			//Niveau_Technique
			array(
				'titre'=>'APN',
				'descriptif'=>'Apnée',
				'type'=>'Niveau_Technique'
			),
			array(
				'titre'=>'CDH',
				'descriptif'=>'Structure des Adjoints Hors Comité',
				'type'=>'Niveau_Technique'
			),
			array(
				'titre'=>'CDI',
				'descriptif'=>'Structure du comité directeur',
				'type'=>'Niveau_Technique'
			),
			array(
				'titre'=>'PLG',
				'descriptif'=>'Plongée scaphandre',
				'type'=>'Niveau_Technique'
			),
			// Niveau_Trombi
			array(
				'titre'=>'APN_ADH_DEB',
				'descriptif'=>'Les apnéistes débutants',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'APN_ENC_C2',
				'descriptif'=>'Initiateur Entraineur Fédéral IE2',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'CD1_DIR',
				'descriptif'=>'Direction du Club',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'CD1_SEC',
				'descriptif'=>'Secrétaires du Club',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'CD2_COM_APN',
				'descriptif'=>'Commission APNEE',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'CD2_COM_PLG',
				'descriptif'=>'Commission PLONGEE Bouteille',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'PLG_ADH_N2',
				'descriptif'=>'Adhérents en Plongée scaphandre',
				'type'=>'Niveau_Trombi'
			),
			array(
				'titre'=>'PLG_ENC_E3',
				'descriptif'=>'E3 : Les Plongeurs Moniteurs fédéraux',
				'type'=>'Niveau_Trombi'
			),
		)
	);

	return $schema;
}

// Fonction de mise a jour du schema
/**function update_groupe_mots(){
	include_spip('action/editer_objet');

	// chargement du array des groupe et mots
	$schema = adhclub_schema_mc();

	// en quelle version de adhclub est on ?
	// si on a une meta escal_base_version, c'est qu'on est sur une version avec instalation auto
	$meta = lire_config('escal_base_version');

	// si la meta est présente
	if($meta!=''){
		// Maj des groupes
		for ($i= 0 , $nbr_grp = count($schema['groupes']) ; $i < $nbr_grp ; ++$i){
			// test si le groupe existe
			$grp_titre = $schema['groupes'][$i]['titre'];
			$id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
			// si pas d'id retournée on inssère
			if($id_grp!=''){
				//echo "Update le groupe existe déja : ".$id_grp."=> ".$grp_titre."\n";
				sql_updateq('spip_groupes_mots', $schema['groupes'][$i], "id_groupe='$id_grp'");
			}//sinon on met a jour
			else{
				//echo "Insert Le groupe n'éxiste pas => ".$grp_titre."\n";
				$id = sql_insertq('spip_groupes_mots',$schema['groupes'][$i]);
			}

		}

		//Maj des mots : on boucle sur le tableau mots
		for ($i= 0 , $nbr_mot = count($schema['mots']) ; $i < $nbr_mot ; ++$i){
			// test la présence du mot sur le champ titre
			$titre = $schema['mots'][$i]['titre'];
			$id_mot = sql_getfetsel("id_mot","spip_mots","titre='$titre'");
			// le titre du mot est déjà présent
			if($id_mot!=''){
				// echo "Update le mot clef existe déja : ".$id_mot."=> ".$titre."\n";
				$test = sql_updateq('spip_mots', $schema['mots'][$i], "titre='$titre'");
				objet_modifier('mot',$id_mot,$schema['mots'][$i]);
			}else{
				// echo "Insert Le mot clef n'éxiste pas => ".$titre."\n";
				// on extrait du array le groupe dont dépend le mot
				$grp_titre = $schema['mots'][$i]['type'];
				$id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
				$id_mot = objet_inserer('mot',$id_grp);
				objet_modifier('mot',$id_mot,$schema['mots'][$i]);
			}
		}
	}//si pas de meta_base on est sur une install plus ancienne
	else{
		// on verra plus tard ;-)
	}
} */


/*
 * function install_groupe_mot
 * installe les groupes de mots techniques et leurs mots clefs
 */
/**function install_groupe_mots() {
	include_spip('action/editer_objet');
	// chargement du array des groupe et mots
	$schema = shema_escal();
	// installation des groupes
	for ($i= 0 , $nbr_mot = count($schema['groupes']) ; $i < $nbr_mot ; ++$i){
		$id = sql_insertq('spip_groupes_mots',$schema['groupes'][$i]);
	}

	// installation des mots
	for ($i= 0 , $nbr_mot = count($schema['mots']) ; $i < $nbr_mot ; ++$i){
		// on extrait du array le groupe dont dépend le mot
		$grp_titre = $schema['mots'][$i]['type'];
		$id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
		if($id_grp!=''){
			$id_mot = objet_inserer('mot',$id_grp);
			objet_modifier('mot',$id_mot,$schema['mots'][$i]);
		}
	}

} */

// Fonction de désinstalation des groupes et mots de Escal
/**function uninstal_escal(){
	// chargement du array des groupe et mots
	$schema = shema_escal();
	$id_grp = array();
	// recuperer les id des groupes
	for ($i= 0 , $nbr_mot = count($schema['groupes']) ; $i < $nbr_mot ; ++$i){
		$grp_titre = $schema['groupes'][$i]['titre'];
		$id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
		// désinstaller les mots correspondant a ce groupe
		sql_delete("spip_mots","id_groupe='$id_grp'");
		sql_delete("spip_groupes_mots","id_groupe='$id_grp'");
	}
} */


/** ===============================================================================
 *  Fonctions de gestion courante dynamique
 *  ===============================================================================
 */
/**
 * Filtre pour tester l'appartenance 1 auteur a 1 assurance
 *
 * @param int $id_assur
 * @param int $id_auteur
 * @return boolean 
 */
function adhclub_acces_assur($id_assur,$id_auteur=null){
	static $liste_assurs = array();
	if (is_null($id_auteur)) $id_auteur=$GLOBALS['visiteur_session']['id_auteur'];
	if (!isset($liste_assurs[$id_auteur])){
		if ($GLOBALS['adhclub_assurs_autorises']
		  AND ($id_auteur==$GLOBALS['visiteur_session']['id_auteur']))
			$liste_assurs[$id_auteur] = explode(',',$GLOBALS['adhclub_assurs_autorises']);
		elseif (!is_null($id_auteur)){
			include_spip('inc/adh_assur');
			$liste_assurs[$id_auteur] = explode(',',adhclub_liste_assurs_autorises('',$id_auteur));
		}
	}

	return in_array($id_assur,$liste_assurs[$id_auteur]);
}


/**
 * Filtre pour tester l'appartenance 1 auteur a 1 cotisation
 *
 * @param int $id_coti
 * @param int $id_auteur
 * @return boolean 
 */
function adhclub_acces_coti($id_coti,$id_auteur=null){
	static $liste_cotis = array();
	if (is_null($id_auteur)) $id_auteur=$GLOBALS['visiteur_session']['id_auteur'];
	if (!isset($liste_cotis[$id_auteur])){
		if ($GLOBALS['adhclub_cotis_autorises']
		  AND ($id_auteur==$GLOBALS['visiteur_session']['id_auteur']))
			$liste_cotis[$id_auteur] = explode(',',$GLOBALS['adhclub_cotis_autorises']);
		elseif (!is_null($id_auteur)){
			include_spip('inc/adh_coti');
			$liste_cotis[$id_auteur] = explode(',',adhclub_liste_cotis_autorises('',$id_auteur));
		}
	}

	return in_array($id_coti,$liste_cotis[$id_auteur]);
}


/**
 * Filtre pour tester l'appartenance 1 auteur a 1 niveau
 *
 * @param int $id_niveau
 * @param int $id_auteur
 */
function adhclub_acces_niveau($id_niveau,$id_auteur=null){
	static $liste_niveaux = array();
	if (is_null($id_auteur)) $id_auteur=$GLOBALS['visiteur_session']['id_auteur'];
	if (!isset($liste_niveaux[$id_auteur])){
		if ($GLOBALS['adhclub_niveaux_autorises']
		  AND ($id_auteur==$GLOBALS['visiteur_session']['id_auteur']))
			$liste_niveaux[$id_auteur] = explode(',',$GLOBALS['adhclub_niveaux_autorises']);
		elseif (!is_null($id_auteur)){
			include_spip('inc/adh_niveau');
			$liste_niveaux[$id_auteur] = explode(',',adhclub_liste_niveaux_autorises('',$id_auteur));
		}
	}

	return in_array($id_niveau,$liste_niveaux[$id_auteur]);
}


/**
 *  Filtre de validation de l'activite de l'adherent
 *
 * @param int $id_auteur
 * @return boolean $aut_actif
 */
function filtre_adh_actif($id_auteur){

	$donnees_cot_sais=array();

	// Lecture la Table spip_adhsaisons pour verifier si la saison est encours.
	$adhselect = array("sa.encours as encours");
	$adhfrom = array( "spip_adhcotis_liens ca",
			"spip_adhcotis co",
			"spip_adhsaisons sa");
	$adhwhere = array("ca.id_objet = " . intval($id_auteur),
			"ca.objet = 'auteur'",
			"ca.id_coti = co.id_coti",
			"co.id_saison = sa.id_saison");
	$adhgroupby = array();
	$adhorderby = array();
	$adhlimit ="";

	$reponse_cot_sais = sql_allfetsel( $adhselect, $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);

	$aut_actif = "non"; // valeur par defaut.
	
	if ($reponse_cot_sais) {
		foreach($reponse_cot_sais as $donnees_cot_sais){

			// La saison est active ?
			if($donnees_cot_sais['encours'] == "oui"){
				$aut_actif = "oui";
				break;
			}
		}
	}
	/*$debug1= "DEBUG adhclub JR - Pt80 - ";
	spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("adhfrom= implode(', ',$adhfrom).", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("adhwhere= implode(' AND ',$adhwhere).", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	//spip_log("reponse_cot_sais= implode(', ',$reponse_cot_sais).", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("aut_actif= $aut_actif", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	*/
	
return $aut_actif;
}


/**
 * liste des cotisations contenus dans une saison
 *
 * Si id_saison NULL, liste pour les saisons encours,
 *
 * @param int $id_saison
 * @return array $liste_cotis (1,2,3,etc..)
 */
function adhclub_coti_ds_saisons($id_saison=NULL) {
	include_spip('base/abstract_sql');
	
	if (intval($id_saison)){
		// liste des cotisations pour 1 saison.
		$liste_cotis = sql_allfetsel("id_coti","spip_adhcotis","id_saison=".intval($id_saison));
	}else{
		// Liste des cotisations pour toutes les saisons encours.
		$adhselect = array("co.id_coti as id_coti");
		$adhfrom = array( "spip_adhcotis co",
				"spip_adhsaisons sa");
		$adhwhere = array("sa.encours='oui'",
				"sa.id_saison = co.id_saison");
		$adhgroupby = array();
		$adhorderby = array();
		$adhlimit ="";
		$liste_cotis = sql_allfetsel($adhselect, $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
	}

	if (is_array($liste_cotis)) {
		$liste_cotis = array_map('reset',$liste_cotis);
		return $liste_cotis;
			}
	return array();
}


/**
 * Parametrage requete SQL des auteurs contenus dans une ou plusieurs saisons.
 *
 * Si id_saison NULL, liste pour les saissons encours,
 * Si id_saison numerique, liste pour la saison concenrnee.
 *
 * @param int $id_saison
 * @param array $adhselect
 * @param array $adhfrom
 * @param array $adhwhere
 * @param array $adhgroupby
 * @param array $adhorderby
 * @param string $adhlimit
 * @param string $sql_auteurs Requete sql de filtrage precedante.
 * @return string $sql_sa_auteurs Requete sql de filtrage.
 */
function adhclub_auteurs_ds_saisons($id_saison=NULL, &$adhselect, &$adhfrom, 
		&$adhwhere, &$adhgroupby, &$adhorderby, &$adhlimit){

	// Parametrage de la Requete de recherche des cotisations 
	$adhfrom = array_merge($adhfrom,
		array( "spip_adhcotis co",
				"spip_adhsaisons sa"));
	
	if ($id_saison == 99999){
		// Liste des cotisations pour toutes les saisons encours.
		$adhwhere = array_merge($adhwhere,
			array("sa.encours='oui'",
				"sa.id_saison = co.id_saison"));
	}else{
		// liste des cotisations pour 1 saison.
		$adhwhere = array_merge($adhwhere,
			array("sa.id_saison=".intval($id_saison),
				"sa.id_saison = co.id_saison"));
	}
	
	// Parametrage complementaire de la requete pour rechercher les auteurs des cotisations
	$adhselect = array("DISTINCT ca.id_objet as id_auteur");
	$adhfrom = array_merge($adhfrom, array("spip_adhcotis_liens ca"));
	$adhwhere = array_merge($adhwhere, 
			array(	"ca.objet='auteur'",
					"co.id_coti=ca.id_coti"));
	$adhgroupby = array_merge($adhgroupby, array("ca.id_objet"));
	
}


/**
 * Complementation pour les criteres Niveaux, Technique ou Encadrements 
 * des parametres de la requete SQL pour obtenir la Liste des auteurs 
 *
 *  Si pas de critere Technique et/ou Encadrement specifie, alors ce sont tous
 *    les auteurs precedamments filtres et qui sont contenus dans tous les niveaux 
 *    qui sont listes.
 *    
 * @param int $id_mot_tech Id du mot technique choisi
 * @param int $id_mot_enc Id du mot encadrant choisi
 * @param int $id_niveau Id du niveau choisi
 * @param int $niv_rel Choix relatif au niveau (< = >)
 * @param array $adhselect
 * @param array $adhfrom
 * @param array $adhwhere
 * @param array $adhgroupby
 * @param array $adhorderby
 * @param string $adhlimit
 * @param string $sql_auteurs Requete sql de filtrage precedante.
 * @return string $sql-nv_auteurs Requete sql de filtrage.
 */
function adhclub_auteurs_ds_niveaux($id_mot_tech=NULL, $id_mot_enc=NULL, $id_niveau=NULL, $niv_rel=NULL, 
		&$adhselect, &$adhfrom, &$adhwhere, &$adhgroupby, &$adhorderby, &$adhlimit){

	// Complementation de Parametrage de la Requete de recherche des auteurs  
	//	via les Tables spip_adhnivs et spip_adhnivs_liens suivant les criteres.
	$adhfrom = array_merge($adhfrom,
			array(	"spip_adhnivs nv",
					"spip_adhnivs_liens na"));

	$adhwhere = array_merge($adhwhere,
			array(	"na.objet = 'auteur'",
					"na.id_niveau = nv.id_niveau"));
	if (intval($id_mot_tech)){
		$adhwhere = array_merge($adhwhere,
				array("nv.techbase = ".intval($id_mot_tech)));
	}
	if (intval($id_mot_enc)){
		$adhwhere = array_merge($adhwhere,
				array("nv.encadrant = ".intval($id_mot_enc)));
	}
	if (intval($id_niveau)){
		if ($niv_rel==NULL or $niv_rel=='egal'){
			$adhwhere = array_merge($adhwhere,
					array("nv.id_niveau = ".intval($id_niveau)));
		}else{
			$rangtrombi = sql_getfetsel("rangtrombi", "spip_adhnivs", "id_niveau=" . intval($id_niveau));
			if ($niv_rel=='supegal')
				$adhwhere = array_merge($adhwhere,
						array("nv.rangtrombi >= ".intval($rangtrombi)));
			if ($niv_rel=='infegal')
				$adhwhere = array_merge($adhwhere,
						array("nv.rangtrombi <= ".intval($rangtrombi)));
		}
	}
	
	/*$debug1= "DEBUG adhclub JR - Pt90 - ";
	spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("adhfrom= implode(', ',$adhfrom).", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("adhwhere= implode(' AND ',$adhwhere).", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	*/
		
}


/**
 * Utilise par 'critere_adh_recherche_dist' pour organiser la recherche des utilisateurs
 * 	en fonction des criteres.
 *
 * Pour chaque critere ou groupe de criteres, la selection des auteurs est faite
 *	en fonction des auteurs deja presents dans la selection du critere precedant.
 * Pour cette raison, c'est i3 qui termine la selection car c'est un plugin
 * 	externe a adhclub.
 * 
 * @return array $sql_adh_auteurs requete de filtrage des auteurs suivant filtrage
 *	si $option=false ou absente => entre parentheses
 * 	si $option=true => array seul.
*/

function adh_recherche($ou, $quoi, $table, $id_saison, $techbase, $encadrant, $niveau, $niv_rel, $option=false){

	$adhselect = array();
	$adhfrom = array();
	$adhwhere = array();
	$adhgroupby = array();
	$adhorderby = array();
	$adhlimit = "";
	
	adhclub_auteurs_ds_saisons($id_saison, 
		$adhselect, $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);

	if (intval($techbase) or intval($encadrant) or intval($niveau)){
		
		adhclub_auteurs_ds_niveaux($techbase, $encadrant, $niveau, $niv_rel, 
			$adhselect, $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
		$adhwhere = array_merge($adhwhere, array("id_auteur = na.id_objet"));
		
	}
	
	// Parametrage du filtrage du critere (i3) si presents
	if($quoi){
		$sql_i3_auteurs = i3_recherche($quoi,$ou,$table);
		$adhwhere = array_merge($adhwhere, array("id_auteur IN ".$sql_i3_auteurs));

	}
	
	/*$debug1= "DEBUG adhclub JR - Pt90 - ";
	spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	$count_auteurs = sql_countsel($adhfrom, $adhwhere, $adhgroupby, $adhlimit);
	spip_log("count_auteurs=$count_auteurs.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	*/
	
	/*$debug1= "DEBUG adhclub JR - Pt91 - ";
	spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres=$criteres.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	$sql_adh_auteurs = sql_get_select($adhselect, $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
	spip_log("sql_adh_auteurs=$sql_adh_auteurs.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("$debug1 FIN.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	*/
	
	/*$debug1= "DEBUG adhclub JR - Pt92 - ";
	spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	$liste_adh_auteurs = sql_allfetsel('ca.id_auteur', $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
	if(is_array($liste_adh_auteurs)){
		foreach($liste_adh_auteurs as $un_adh){
			$debug2 = implode(', ',$un_adh);
			spip_log("$debug2.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
		}
	}
	spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	*/
	
	$sql_adh_auteurs = sql_get_select($adhselect, $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
	if($option){
		return $sql_adh_auteurs;
	}else{
		return "($sql_adh_auteurs)";
	}	
}


/**
 *
 * Critere utilise pour rechercher dans les utilisateurs (page ?exec=adh_adherents)
 * Construction de la clause "where" de la boucle de recherche spip.
 * 
 * Combinaison des criteres pour obtenir la liste commune des id_auteurs ....
 */
function critere_adh_recherche_dist($idb, &$boucles){

	$boucle = &$boucles[$idb];
	$primary = $boucle->primary;
	$id_saison = '@$Pile[0]["id_saison"]';
	$techbase = '@$Pile[0]["techbase"]';
	$encadrant = '@$Pile[0]["encadrant"]';
	$niveau = '@$Pile[0]["niveau"]';
	$niv_rel = '@$Pile[0]["niv_rel"]';
	$ou = '@$Pile[0]["case"]';
	$quoi = '@$Pile[0]["valeur"]';
	$table = $boucle->type_requete;
	$boucle->hash .= "
	\$auteurs = adh_recherche($ou, $quoi, $table, $id_saison, $techbase, $encadrant, $niveau, $niv_rel);
	";
	$boucle->where[] = array("'IN'","'$boucle->id_table." . "$primary'",'$auteurs');
}


/**
 * Filtre de Conversion de date du format europeen (dd/mm/YYYY)
 *      vers le format americain (Db) (YYYY-mm-dd)
 *
 *	Ok JR 17/11/2011
 *
 * @param int $dateeu
 * @param int $datedb
 */
 function filtre_adhclub_convdate_eu_db($dateeu){
 	$d1 = explode("-", $dateeu);
 	$datedb = date("Y-m-d",mktime(0,0,0, $d1[1], $d1[2], $d1[0]));
 return $datedb;
}


/**
 * Filtre de Conversion de date du format americain (Db) (YYYY-mm-dd)
 *      vers le format europeen (dd/mm/YYYY)
 *
 *	Ok JR 17/11/2011
 *
 * @param int $datedb
 * @param int $dateeu
 */
 function filtre_adhclub_convdate_db_eu($datedb){
 	$d1 = explode("-", $datedb);
 	$dateeu = date("d/m/Y",mktime(0,0,0, $d1[1], $d1[2], $d1[0]));
 return $dateeu;
}


/**
 * Filtre de Conversion de date numerique du format americain (Db) (YYYY-mm-dd)
 *      vers le format europeen (dd/mm/YYYY)
 *
 * @param int $datedb
 * @param int $dateeu
 */
 function adhclub_convdaten_db_eu($date){
	//Parametrage et modification de la date
	$date = preg_replace('!^([0-9]{4})+-([0-9]{2})+-([0-9]{2})$!', '$3/$2/$1', $date); #Modifiation de la date
return $date;
}

?>
