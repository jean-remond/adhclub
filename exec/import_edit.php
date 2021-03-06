<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * --------------------------------------------
 * Traiter l'integration de la table adhintgs 
 * --------------------------------------------
 * @todo
 * 
 * Fait :
 * JR-03/05/2017-ref_saisie force a null car perturbant pour les F(liens).
 * JR-31/01/2015-Adaptation a spip 3.0 et tables liens.
 * JR-22/04/2012-Revue pour inscription3 (seule la table auteurs existe).
 * 
 * Pour chaque enregistrement de la table source :
 * - Recherche de l'auteur via son code Licence.
 * - Si l'auteur est nouveau (id_auteur non numerique) :
 * 	==> Creation de auteurs [et auteurs_elargis] sur le modele Inscription2_import
 * - Si auteur trouve (id_auteur numerique), suite recherche ou creation,
 * 	==> Mise a jour des donnees disponibles :
 * 			- Adresse,
 * 			- Cotisation selectionnee,
 * 			- Reference de saisie, etc..
 * Suppression de l'enregistrement traite dans la table source.
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip("inc/adh_import");
include_spip("inc/adh_assur");
include_spip("action/editer_adhassur");

include_spip("inc/adh_coti");
include_spip("action/editer_adhcoti");
include_spip('public/assembler');
include_spip('inc/presentation');

/**
 * Integrer table adhintgs 
 * (action apres la saisie des infos du formulaires integ_adhintg)
 *
 * @param  string $ref_saisie[force a null]
 * @param  int $id_coti[obligatoire]
 * 
 * @return array
 */
function exec_import_edit($ref_saisie = '', $id_coti){

	// JR-03/05/2017-ref_saisie force a null
	$ref_saisie = '';
	
	/*$debug1= "DEBUG adhclub JR : exec/import_edit - exec_import_edit - Pt01 - <br />";
	echo "<br />", $debug1;
	echo "ref_saisie= $ref_saisie.<br />";
	echo "id_coti= $id_coti.<br />";
	echo "FIN ", $debug1;
	*/

	// On doit etre Webmestre pour acceder a cette page
	/*if (!autoriser('webmestre')) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	} */
	
	global $spip_lang_right;
	$assoc_field=array();
	$field_source=array();
	$field_cible_finale=array();

	/** ____________________________________________________________
	 *
	 *  Preparation des listes de champs et de leur correspondance.
	 * _____________________________________________________________
	 */
	
	// Liste de l'ensemble des champs cibles possibles
	$tables = array('spip_auteurs','spip_auteurs_elargis');
	$field_cible_finale = adhclub_imp_table_fields($tables, 'unique');

	// Liste de l'ensemble des champs sources possibles
	$tables = array('spip_adhintgs');
	$field_source = adhclub_imp_table_fields($tables, 'source');

	//adhclub_imp_field_configure($data, $table_fields, $assoc_field);
	
	/** ____________________________________________________________
	 *
	 * Boucle de traitement d'integration des adherents
	 * _____________________________________________________________
	 */
	
	// Lecture table adhintgs ordonnee par licence.
	$adhorderby = "licence";
	$res = sql_select('*', 'spip_adhintgs', '', '', $adhorderby);
	// boucle sur les resultats
	while($rec_intg = sql_fetch($res)){
		
		// Recherche de l'auteur via son code Licence (auteurs.fonctions).
		$adhwhere = "fonction =".sql_quote(trim($rec_intg['licence']));
		$arg = sql_fetsel( "id_auteur", "spip_auteurs", $adhwhere);
		
		/** ____________________________________________________________
		 * 
		 * ==> Creation des tables auteurs [et auteurs_elargis].
		 * _____________________________________________________________
		 */ 
		// si id_auteur n'est pas un nombre, c'est une creation d'adherent,
		if (!$id_auteur = intval($arg['id_auteur'])) {
			
			$id_auteur='new';
			
			$assoc_field =array();
			$assoc_field=adhclub_imp_field_associate($id_auteur, $data, $field_cible_finale, $assoc_field, $field_source);
			
			foreach($assoc_field as $key=>$value)
				$hidden["assoc_field[".adhclub_imp_nettoie_key($key)."]"] = $value;
			
			//echo "<br />.XXX debug JR : exec/import_edit-exec_import_edit-Pt6.<br />";
			//echo "id_auteur= $id_auteur.<br />";
			//$field=$rec_intg['email'];
			//echo "rec_intgs(email)= $field.<br />";
			
			
			// Reformattage des champs
			$rec_creat=adhclub_imp_field_reformate($id_auteur, $assoc_field, $rec_intg);
			
			/*$debug1= "DEBUG adhclub JR : exec/import_edit-exec_import_edit-Pt07 - <br />";
			echo "<br />", $debug1;
			echo "rec_creat= <br />"; var_dump($rec_creat); echo ".<br />";
			echo "FIN ", $debug1;
			*/
			$tables = array('spip_auteurs','spip_auteurs_elargis');
		
			//list($erreurs, $auteur) = adhclub_imp_ajoute_table($rec_creat, $tables, $assoc_field, &$erreur);
			list($arg) = adhclub_imp_ajoute_table($rec_creat, $tables, $assoc_field, $erreur);
			if (!$arg) {
				echo adhclub_imp_show_erreurs($erreur);
				return array(false,_T('adhintg:err_auteur_creation'.$rec_creat['nom_famille']));
			}
		
			/*$debug1= "DEBUG adhclub JR : exec/import_edit-exec_import_edit-Pt09 - <br />";
			echo "<br />", $debug1;
			$field=$auteur['id_auteur'];
			echo "auteur(id_auteur)= $field.<br />";
			$arg['id_auteur']=$auteur['id_auteur'];
			echo "FIN ", $debug1;
			*/
		}
		
		/*$debug1= "DEBUG adhclub JR : exec/import_edit-exec_import_edit-Pt50 - <br />";
		echo "<br />", $debug1;
		echo "Sortie du bloc creation de l'adherent : ";
		$field=$arg['id_auteur'];
		echo "arg= $field.<br />";
		echo "<br />.----------------------------------------------.<br />";
		echo "FIN ", $debug1;
		*/		
		/** ____________________________________________________________
		 * 
		 * ==> Mise a jour des tables auteurs [et auteurs_elargis] et +.
		 * _____________________________________________________________
		 * on poursuit l'integration  par la maj :
		 * - de quelques champs des tables auteurs et auteurs_elargis
		 *		(en cas de nouvel adherent, il y a redite des memes champs)
		 * - des tables complementaires :
		 *		- adhcotis_liens avec la reference de saisie
		 *		- adhassurs_liens
		 */ 
		// si id_auteur n'est pas un nombre, c'est une creation d'adherent,
		if ($id_auteur = intval($arg['id_auteur'])) {
			
			$assoc_field =array();
			$assoc_field=adhclub_imp_field_associate($id_auteur, $data, $field_cible_finale, $assoc_field, $field_source);
			
			foreach($assoc_field as $key=>$value)
				$hidden["assoc_field[".adhclub_imp_nettoie_key($key)."]"] = $value;
			
			/*$debug1= "DEBUG adhclub JR : exec/adh_import - exec_adh_import - Pt61 - <br />";
			echo "<br />", $debug1;
			echo "id_auteur= $id_auteur.<br />";
			echo "rec_intg= <br />"; var_dump($rec_intg); echo ".<br />";
			echo "FIN ", $debug1;
			*/
			// Reformattage des champs
			$rec_maj=adhclub_imp_field_reformate($id_auteur, $assoc_field, $rec_intg);
			
			/*$debug1= "DEBUG adhclub JR : exec/adh_import - exec_adh_import - Pt62 - <br />";
			echo "<br />", $debug1;
			echo "id_auteur= $id_auteur.<br />";
			echo "rec_maj= <br />"; var_dump($rec_maj); echo ".<br />";
			echo "FIN ", $debug1;
			*/
			$tables = array('spip_auteurs','spip_auteurs_elargis');
			// JR-20121019-Pb d'appel via reference.
			//list($erreurs, $auteur)  = adhclub_imp_maj_table($id_auteur, $rec_maj, $tables, $assoc_field, &$erreur);
			list($auteur)  = adhclub_imp_maj_table($id_auteur, $rec_maj, $tables, $assoc_field, $erreur);
			if (!$auteur) {
				echo adhclub_imp_show_erreurs($erreur);
				return array(false,_L("Echec de la mise &aacute; jour de l'adh&eacute;rent "
						.$id_auteur.' '
						.$rec_intg['nom'].' '
						.$rec_intg['prenom']));
			}
			
			/*$debug1= "DEBUG adhclub JR : exec/adh_import-exec_adh_import-Pt63 - <br />";
			echo "<br />", $debug1;
			echo "id_auteur= $id_auteur.<br />";
			$field=$auteur['id_auteur'];
			echo "auteur(id_auteur)= $field.<br />";
			echo "FIN ", $debug1;
			*/
			
			$arg['id_auteur']=$auteur['id_auteur'];
			
		}
		
			/*$debug1= "DEBUG adhclub JR : exec/adh_import-exec_adh_import-Pt70 - <br />";
			echo "<br />", $debug1;
			echo "Sortie du bloc maj de l'adherent : ";
			echo "id_auteur= $id_auteur.<br />";
			echo "FIN ", $debug1;
			echo "<br />.----------------------------------------------.<br />";
			*/
		
		/** ____________________________________________________________
		 *
		 * ==> Mise a jour de la table adhassurs_liens.
		 * _____________________________________________________________
		 * On poursuit l'integration  par la creation de l'assurance :
		 * - A partir des informations du record rec_intgs :
		 *		- assurance = adhassurs.titre
		 */
		
		// Adaptation du titre de l'assurance si 'Aucune' notifiee
		//	==> 'Aucune aaaa' pour recherche dans adhassur.
		if (trim($rec_intg['assurance'])=='Aucune'){
			$rec_intg['assurance'] = trim($rec_intg['assurance']).' '.trim($rec_intg['saison']);
		}

			/*$debug1= "DEBUG adhclub JR : exec/adh_import-exec_adh_import-Pt71 - <br />";
			echo "<br />", $debug1;
			echo "id_auteur= $id_auteur.<br />";
			$field=$rec_intg['assurance'];
			echo "rec_intg(assurance)= $field.<br />";
			echo "FIN ", $debug1;
			*/
		
		// Recherche de l'assurance a partir de son titre.
		$arg = adhclub_test_assurtitre_de_auteur(intval($id_auteur),trim($rec_intg['assurance']));

			/*$debug1= "DEBUG adhclub JR : exec/adh_import-exec_adh_import-Pt72 - <br />";
			echo "<br />", $debug1;
			echo "id_auteur= $id_auteur.<br />";
			if ($arg){
				echo "auteur_assur= TRUE.<br />";
			}else{
				$field=intval($arg);
				echo "id_assur= $field.<br />";
			}
			echo "FIN ", $debug1;
			*/
		
		// si arg TRUE, assurance deja affectee a auteur, raf.
		
		// Si arg False, assurance inconnue, message d'alerte.
		if (!$arg){
			return array(false,_L('adhintg:err_assur_inconnue'.' '.
				$rec_intg['assurance'].' '.
				'adhclub:auteur'.' '. 
				$id_auteur.' '.
				$rec_intg['prenom'].' '.
				$rec_intg['nom']));
		}

		// si arg est un nombre, ceci est une creation de cette assurance (pour le titre) pour auteur.
		if ($id_assur_work = intval($arg)) {
			adhclub_revision_adhassur_objets_lies(intval($arg), $id_auteur, 'auteur', 'add');
		}

		/** ____________________________________________________________
		 * 
		 * ==> Mise a jour de la table adhcotis_liens.
		 * _____________________________________________________________
		 * On poursuit l'integration  par la creation de la cotisation :
		 * - A partir des informations du formulaire
		 *		- id_cotisation
		 *		- Reference de saisie.
		 */ 

		// Recherche si l'auteur est lie a cette cotisation.
		$auteur_coti_ok = adhclub_test_coti_de_auteur(intval($id_coti),intval($id_auteur));
		
			/*$debug1= "DEBUG adhclub JR : exec/adh_import-exec_adh_import-Pt82 - <br />";
			echo "<br />", $debug1;
			echo "id_auteur= $id_auteur.<br />";
			$field=intval($auteur_coti_ok);
			echo "id_coti= $field.<br />";
			echo "FIN ", $debug1;
			*/
		
		// si auteur_coti_ok n'est pas un nombre, c'est une creation de cette cotisation pour l'auteur.
		if (!$auteur_coti_ok) {
			adhclub_revision_adhcoti_objets_lies($id_coti, $id_auteur, 'auteur', 'add', $ref_saisie = '');
		}

		// On supprime l'enregistrement adhintgs que l'on vient de traiter
		$adhwhere = "licence =".sql_quote(trim($rec_intg['licence']));
		sql_delete("spip_adhintgs", $adhwhere);
	}
	
	//$err = action_adhintg_set($id_auteur, $rec_intg);
	//return array($id_auteur,$err);
	
}
?>