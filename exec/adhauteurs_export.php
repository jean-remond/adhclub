<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.1
 * Licence GPL (c) 2011-2017 Jean Remond
 * ----------------------------------------------
 * Telechargement des donnees filtrees des auteurs. 
 * D'apres le plugin csv_import de Cedric MORIN
 * ----------------------------------------------
 * @todo-JR-25/03/2015-Utilisation des F(spip_bonux) existantes. Attention remplissage criteres.
 * 
 * Fait :
 * ----
 * JR-01/05/2017-Revue des logs.
 * JR-25/03/2015-Utilisation des F(spip_bonux) existantes.
 * JR-03/02/2015-Adaptation a Spip 3.0
 * JR-06/08/2013-Ajout des criteres dans fichier exporte.
 * JR-22/05/2013-Creation du squelette.
 *
 */

include_spip("inc/exporter_csv");
//include_spip("inc/adhauteurs_export");
include_spip("inc/presentation");
/**
 * Traitement de l'export des donnees auteurs.
 * 
 * @param  string $criteres de selection des auteurs
 * 
 * @return array $retour nbre auteurs exportes et message de confirmation d'action.
 */
function exec_adhauteurs_export(){
	
	// Preparation affichage des choix type d'export
	$criteres_tot = _request('criteres');
	$criteres = explode( '|', $criteres_tot, 7);

	// Preparation de l'export des criteres (mise en forme dans le fichier out)
	// -- saison --
	if (intval($criteres[2])){
		if ($criteres[2]==99999){
			$export_crit[0] = array("Saison(s)","active(s)");
		}else{
			$lib_criteres = sql_getfetsel('titre', 'spip_adhsaisons',array('id_saison='.intval($criteres[2])));
			$export_crit[0] = array('Saison',$lib_criteres);
		}
	}else{
		$export_crit[0] = array("Toutes","saisons");
	}
	// -- technique --
	IF (intval($criteres[3])){
		$adhwhere=array("type = 'niveau_Technique'");
		$adhwhere=array_merge($adhwhere,
				array("id_mot = ".intval($criteres[3])));
		$lib_criteres = sql_getfetsel('titre', 'spip_mots',$adhwhere);
		$export_crit[1] = array('Techbase',$lib_criteres);
	}else{
		$export_crit[1] = array('Techbase','<<Tous>>');
	}
	// -- encadrement --
	IF (intval($criteres[4])){
		$adhwhere=array("type='Niveau_Encadrement'");
		$adhwhere=array_merge($adhwhere,
				array("id_mot = ".intval($criteres[4])));
		$lib_criteres = sql_getfetsel('titre', 'spip_mots',$adhwhere);
		$export_crit[2] = array('Encadrant',$lib_criteres);
	}else{
		$export_crit[2] = array('Encadrant','<<Tous>>');
	}
	// -- niveau --
	IF (intval($criteres[5])){
		$lib_criteres = sql_getfetsel('titre', 'spip_adhnivs',array('id_niveau ='.intval($criteres[5])));
		$export_crit[3] = array('Niveau',$criteres[6],$lib_criteres);
	}else{
		$export_crit[3] = array('Niveau','<<Tous>>');
	}
	$export_crit[4] = array('Champ',$criteres[0],$criteres[1]);
	
	/*$debug1= "DEBUG adhclub JR : exec/adhauteurs_export - exec_adhauteurs_export - Pt05 - ";
	spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres tot= $criteres_tot.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 0= $criteres[0].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 1= $criteres[1].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 2= $criteres[2].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 3= $criteres[3].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 4= $criteres[4].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 5= $criteres[5].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 6= $criteres[6].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("criteres 7= $criteres[7].", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
	*/
	
	$retour = _request('retour');
	
	$delim = _request('delim');
	if ($delim == 'TAB') $delim = "\t";
	
	if (!$retour)
		$retour = generer_url_ecrire('adh_adherents');
	
	$titre = _T("adhclub:exporter_user_nb",array('nb_auteurs'=>$nb_auteurs));
	
	if (!$delim){
		$icone = _DIR_PLUGIN_ADHCLUB."img_pack/adh_export-24.png";
		//
		// Affichage de la page
		//

		$commencer_page = charger_fonction('commencer_page', 'inc');
		pipeline('exec_init',array('args'=>$_GET,'data'=>''));
	
		echo $commencer_page($titre,"adhclub");
	
		echo debut_gauche('',true);
	
		$raccourcis = recuperer_fond("prive/inclure/adh_menu_tous",$contexte);
		echo bloc_des_raccourcis($raccourcis);
		
		echo pipeline('affiche_gauche',array('args'=>array('exec'=>'adhauteurs_export','sql_adh_auteurs'=>$sql_adh_auteurs),'data'=>''));

		echo creer_colonne_droite("",true);
		echo pipeline('affiche_droite',array('args'=>array('exec'=>'adhauteurs_export','sql_adh_auteurs'=>$sql_adh_auteurs),'data'=>''));
		echo debut_droite("",true);
	
		$milieu = '';
	
		$milieu .= "<div class='entete-formulaire'>";

		// Icones retour
		if ($retour) {
			$milieu .= icone_verticale(_T('icone_retour'), $retour, $icone, "rien.gif",$GLOBALS['spip_lang_left']);
		}
		$milieu .= gros_titre($titre,'', false);
		$milieu .= "</div>";

		$milieu .= "<div class='formulaire_spip'>";
		$action = generer_url_ecrire("adhauteurs_export","criteres=$criteres_tot&retour=$retour");
		$milieu .= "\n<form action='$action' method='post' class='formulaire_editer'><div>".form_hidden($action);
		
		$milieu .= "<ul><li><label for='delim'>"._T("adhclub:export_format")."</label>";
		$milieu .= "<select name='delim' id='delim'>\n";
		$milieu .= "<option value=','>"._T("adhclub:export_classique")."</option>\n";
		$milieu .= "<option value=';'>"._T("adhclub:export_excel")."</option>\n";
		$milieu .= "<option value='TAB'>"._T("adhclub:export_tabulation")."</option>\n";
		$milieu .= "</select></li></ul>";
		
		$milieu .= "<p class='boutons'><input type='submit' class='submit' name='ok' value='"._T('bouton_download')."' /></p>\n";
		$milieu .= "</div></form>";
		$milieu .= "</div>";
	
		echo pipeline('affiche_milieu',array('args'=>array('exec'=>'adhauteurs_export','criteres'=>$criteres_tot,'retour'=>$retour),'data'=>$milieu));
	
		echo fin_gauche(), fin_page();
		exit;
	
	}
	
	// Debut de l'export des donnees
	
	// Recuperation de la requete des adherents suivant filtrage (array de la forme SELECT..)
	$sql_adh_auteurs = adh_recherche(
		$criteres[0], //'case'
		$criteres[1], //valeur
		'spip_auteurs', 
		$criteres[2], //id_saison
		$criteres[3], //techbase
		$criteres[4], //encadrant 
		$criteres[5], //niveau
		$criteres[6], //niv_rel
		true);
	
	if($sql_adh_auteurs) {

		// JR 20/03/2013 - Definir les colonnes a extraire pour $adh_select
		$adhselect_l = array("au.id_auteur", 
				"au.nom_famille", 
				"au.prenom", 
				"au.sexe",
				"au.naissance",
				"au.fonction as licence",
				"au.mobile",
				"au.telephone",
				"au.email",
				"au.certiflimite as date_certif",
				"au.certifaspirine as allergie_aspirine",
				"au.certifqualif as certif_restreint"
				);
		$adhfrom_l = array( "spip_auteurs au");
		
		$adhwhere_l = array( "au.id_auteur IN(". $sql_adh_auteurs .")");
		
	// -- Si la saison est explicite, 
	//    on recherche les données Cotisations et Assurances associees a chaque auteur
	if (intval($criteres[2]
		&& $criteres[2]<>99999)){
		$adhselect_l = array_merge($adhselect_l,
				array(	"co_l.id_coti",
						"co_l.titre as cotisation",
						"co_l.mnt_cotis",
						"as_l.id_assur",
						"as_l.titre as assurance",
						"as_l.mnt_assur")); 
		$adhfrom_l = array_merge($adhfrom_l,
				array(	"spip_adhcotis co_l",
						"spip_adhcotis_liens ca_l",
						"spip_adhassurs as_l",
						"spip_adhassurs_liens aa_l"));
		$adhwhere_l = array_merge($adhwhere_l,
				array(	"au.id_auteur=ca_l.id_objet",
						"ca_l.objet='auteur'",
						"ca_l.id_coti=co_l.id_coti",
						"co_l.id_saison=".intval($criteres[2]),
						"co_l.complement='non'",
						"au.id_auteur=aa_l.id_objet",
						"aa_l.objet='auteur'",
						"aa_l.id_assur=as_l.id_assur",
						"as_l.id_saison=".intval($criteres[2])));
		}
						
		/*$debug1= "DEBUG adhclub JR : exec/adhauteurs_export - Pt25 - ";
		spip_log($debug1, 'adhclub.' . _LOG_INFO_IMPORTANTE);
		$debug2 = sql_get_select($adhselect_l, $adhfrom_l, sql_in('au.id_auteur', $sql_adh_auteurs));
		spip_log("debug2=$debug2.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
		spip_log("adhwhere_l=$adhwhere_l.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
		$debug3 = sql_get_select($adhselect_l, $adhfrom_l, $adhwhere_l);
		spip_log("debug3=$debug3.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
		spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
		*/
		
		if ($export_auteurs = sql_allfetsel($adhselect_l, $adhfrom_l, $adhwhere_l)) {

			foreach ($export_auteurs as $ligne) {
				$list_entete = array();
				$list_valeur = array();
				foreach($ligne as $k=>$v){

					/*$debug1= "DEBUG adhclub JR : exec/adhauteurs_export - Pt35 - ";
					spip_log("$debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
					spip_log("k= $k , v= $v.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
					spip_log("FIN $debug1.", 'adhclub.' . _LOG_INFO_IMPORTANTE);
					*/
			
					$list_entete = array_merge($list_entete,array($k));
					$list_valeur = array_merge($list_valeur,array($v));
				}
				// Ecriture de l'entete des colonnes.	
				if($nb_auteurs==0){

					// JR-2013/08/01-Mise en forme des criteres en tete du fichier exporte.
					// JR-25/03/2015-Utilisation des F(spip_bonux) existantes.
					$output = exporter_csv_ligne(array('CRITERES'),$delim);
					$output .= exporter_csv_ligne(array('-_-_-_-','-_-_-_-_-_-_-_-_-_-_-_-'),$delim);
					$output .= exporter_csv_ligne($export_crit[0],$delim);
					$output .= exporter_csv_ligne($export_crit[1],$delim);
					$output .= exporter_csv_ligne($export_crit[2],$delim);
					$output .= exporter_csv_ligne($export_crit[3],$delim);
					$output .= exporter_csv_ligne($export_crit[4],$delim);
					$output .= exporter_csv_ligne(array('-_-_-_-','-_-_-_-_-_-_-_-_-_-_-_-'),$delim);
										
					// JR-20130801-Entetes de colonnes.
					$output .= exporter_csv_ligne($list_entete,$delim);
				}
				// Ecriture des lignes de donnees.
				$output .= exporter_csv_ligne($list_valeur,$delim);
				++$nb_auteurs;
			}
				
			
			$charset = $GLOBALS['meta']['charset'];
			$file_csv="export_auteurs_".date('Ymd_His');
			
			// @todo-JR-25/03/2015-Utilisation des F(spip_bonux) existantes. Attention remplissage criteres.
			//$filename = inc_exporter_csv($file_csv, ' ', $delim);
			
			$filename = preg_replace(',[^-_\w]+,', '_', translitteration(textebrut(typo($file_csv))));
			
			// Excel ?
			if ($delim == ',') {
				$extension = 'csv';
			}else{
				// Extension 'csv' si delim = ';' (et pas forcément 'xls' !)
				if ($delim == ';') {
					$extension = 'csv';
				}else{ 
					$extension = 'xls';
				}
			}
			
			# Excel n'accepte pas l'utf-8 ni les entites html... on fait quoi?
			include_spip('inc/charsets');
			$output = unicode2charset(charset2unicode($output), 'iso-8859-1');
			$charset = 'iso-8859-1';
		}
			
		Header("Content-Type: text/comma-separated-values; charset=$charset");
		Header("Content-Disposition: attachment; filename=$filename.$extension");
		//Header("Content-Type: text/plain; charset=$charset");
		Header("Content-Length: ".strlen($output));
		echo $output;
		exit;  //*/
	}else{
		include_spip('inc/minipres');
		echo minipres();
	}
}

?>