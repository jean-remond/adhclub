<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 * This is a SPIP language file  --  Ceci est un fichier langue de SPIP
 * Encodé UTF-8 sans BOM pour utilisation des caractères accentués
 *
 * Remarque sur le site : http://codes-sources.commentcamarche.net/faq/6-php-general-approche-des-variables
 * 	notez bien l'utilisation de ' ' et non pas " ", 
 * 	la différence viens du faite que " " recherche les variables a l'intérieur 
 * 	mais pas ' ' d'ou une différence notable de vitesse.

 * A faire : 
 * 
 * Fait :
 * JR-10/01/2015-Creation du fichier des libelles dans adhclub.
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'action_icone' => 'Actions',
	'adhclub' => 'Gestion du club',
	'adhclub_titre' => 'Adhérents du Club',
	'adherents_liste' => 'Liste des adh&eacute;rents du club',
	'adherents_videe' => 'La liste des adh&eacute;rents est vide !!',
	'adh_erreurs' => 'Erreurs du fichier d\'entr&eacute;e.',
	'adresse1'=> 'Adresse (1ere ligne)',
	'adresse2'=> 'Adresse (2eme ligne)',
	'adresse3'=> 'Adresse (3eme ligne)',		
	'afficher_tous' => 'Afficher tous les adh&eacute;rents',
	'anniv' => 'Les prochains anniversaires',
	'aucun_anniv' => 'Aucun anniversaire &aacute; souhaiter !',
	'aucun_resultat_recherche' => 'Il n\'y a aucun r&eacute;sultat pour votre recherche.',
	'auteur_ajouter_droits' => 'M\'ajouter les droits d\'acc&egrave;s &agrave; ce niveau',
	'auteur_info_ajouter' => 'Ajouter cet auteur',
	'auteurs' => 'auteur(s)',
	'auteurs_confirmer_ajouter' => '&Ecirc;tes-vous s&ucirc;r de vouloir ajouter cet auteur &agrave; ce niveau ?',
	'auteurs_confirmer_retirer' => '&Ecirc;tes-vous s&ucirc;r de vouloir retirer tous les auteurs de ce niveau ?',
	'auteurs_info_retirer' => 'Retirer tous les auteurs',

	// B
	'bouton_creer_la_zone' => 'Cr&eacute;er la nouvelle zone',
	'bouton_valider_ffessm' => 'Valider les informations FFESSM',

	// C
	'certifaspirine_expl' => 'Indiquez si l\'adh&eacute;rent est allergique &agrave; l\'aspirine.',
	'certifaspirine_label' => 'Contre-indication &agrave; l\'Aspirine ?',
	'certiflimite_expl' => 'Habituellement, le Certificat est valable une ann&eacute;e &agrave; partir de son &eacute;mission.',
	'certiflimite_label' => 'Date du Certificat',
	'certifqualif_expl' => 'Indiquez seulement si des restrictions li&eacute;es &agrave; l\'activit&eacute; du Club existent.',
	'certifqualif_label' => 'Restriction du Certificat',
	'champ_err' => 'La donn&eacute;e en erreur est @cher@',
	'champs_oblig' => 'Champ obligatoire',
	'civilite' => 'Civilit&eacute;',
	'cp' => 'Code postal',
	
	// D
    'demande_photo'=>'D&eacute;p&eacute;chez-vous de lui demander sa photo..',
	'descriptif' => 'Descriptif',
	// E
	'email' => 'email',
	'email_corr_label' => 'Email de correspondance',
	'err_auteur_creation' => 'Echec de la cr&eacute;ation initiale de ',
	'err_auteur_maj' => "Echec de la mise &aacute; jour de l'adh&eacute;rent",
	'err_assur_inconnue' => "L'assurance de l'adh&eacute;rent est inconnue",
	'erreur_email' => 'L\'adh&eacute;rent @nom@ @prenom@ a pour courriel "@email@".',
	'erreur_envoi_email' => 'L\'envoi de courriel a &eacute;chou&eacute;',
	'export_classique' => 'CSV classique (,)',
	'export_excel' => 'CSV pour Excel (;)',
	'export_format' => 'Format du fichier :',
	'export_tabulation' => 'CSV avec tabulations',
	'exporter_user_nb' => 'Exporter les @nb_auteurs@ adh&eacute;rents filtr&eacute;s',
	'exporter_user_select' => 'Exporter la liste des adh&eacute;rents filtr&eacute;s',
	'exporter_message_users_nb' => '@nb@ adh&eacute;rents ont &eacute;t&eacute; export&eacute;s.',
	'exporter_message_users_un' => 'Un adh&eacute;rent a &eacute;t&eacute; export&eacute;.',
	'exporter_message_users_zero' => 'Aucun adh&eacute;rent n\'a &eacute;t&eacute; export&eacute;.',
		
	// F
    'ffessm_aucun' => "Il n'y a pas d'Adh&eacute;rent &agrave; int&eacute;grer dans le site",
	'ffessm_coti' => 'Cotisation &agrave; affecter aux adh&eacute;rents du lot de saisie',
	'ffessm_coti_exp' => 'Une seule cotisation par lot de saisie. Les lots doivent &ecirc;tre homog&egrave;nes.',
	'ffessm_icone_menu' => 'Int&eacute;grer les donn&eacute;es FFESSM',
	'ffessm_liste' => 'Liste de contr&ocirc;le des Adh&eacute;rents avant leur int&eacute;gration dans le site.',
	'ffessm_page' => 'Int&eacute;grer les donn&eacute;es FFESSM',
	'ffessm_page_info' => 'Cette page vous permet d\'int&eacute;grer les donn&eacute;es export&eacute;es du site de la FFESSM',
	'ffessm_titre' => 'Int&eacute;grer les donn&eacute;es FFESSM',
	'ffessm_validation' => 'Validation du lot d\'Adh&each&eacute;rentute;rent(s) pour int&eacute;gration dans le site',
	'ffessms_titre' => 'Donn&eacute;es FFESSM',
	'fiche_adherent' => 'Fiche utilisateur',

	// I
	'icone_menu_adhclub' => 'G&eacute;rer le Club',
	'icone_modifier' => 'Modifier',
	'info_sans_desc' => 'La description est obligatoire',
	'info_sans_encadrant' => "La notion d'encadrement est obligatoire",
	'info_sans_rangtrombi' => 'Le rang dans le trombinoscope est obligatoire',
	'info_sans_techbase' => 'La technique de base est obligatoire',
	'info_sans_titre' => 'Le titre est obligatoire',
	'info_sans_trombi' => 'Le regroupement trombinoscope est obligatoire',
	'info_statut_prepa' => 'Préparation',
	'info_statut_processing' => 'En cours',
	'info_statut_publie' => 'Publié',
	'info_statut_refuse' => 'Annulé',
	'info_statut_poubelle' => 'Poubelle',
	
	// J

	// K

	// L
	'label_desc' => 'Descriptif',
	'label_titre' => 'Titre',
	'legende' => 'Légende',
	'licence' => 'Licence',
		
	// M
	'mailer_envoi' => 'Envoyer le courriel',
	'mailer_message_users_nb' => '@nb@ adh&eacute;rents ont &eacute;t&eacute; mailés.',
	'mailer_message_users_un' => 'Un adh&eacute;rent a été mailé.',
	'mailer_selection' => 'S&eacute;lection des destinataires',
	'mailer_user_select' => 'Mailer aux adh&eacute;rents s&eacute;lectionn&eacute;s',

    // N
	'naissance' => 'Date de naissance',
	'no_user_selected' => 'Vous n\'avez s&eacute;lectionn&eacute; aucun adh&eacute;rent pour envoyer un courriel.',
	'nom' => 'Nom (de famille)',

	// O

    // P
	'page_info_adhclub' => "Vous trouverez ici tous les utilisateurs inscrits sur le site.
		<br/>Par défaut, aucune sélection n'est faite. Si un critère est saisi, la notion de saison active est automatiquement appliquée.",
	'par_encadrant' => 'Encadrant',
	'par_licence' => 'Licence',
	'par_nom' => 'Nom',
	'par_prenom' => 'Pr&eacute;nom',
	'par_saison' => 'Saison',
	'par_techbase' => 'Technique',
	'par_titre' => 'Titre',
	'pays' => 'Pays (Domicile)',
	'prenom' => 'Pr&eacute;nom',

	// R
	'raccourcis' => 'Raccourcis',
	'recherche_utilisateurs_adh' => 'Rechercher les utilisateurs via les crit&egrave;res suivants :',
	'recherche_valeur' => 'Rechercher la valeur :',
	'ref_saisie' => 'R&eacute;f&eacute;rence du lot de saisie',
	'ref_saisie_exp' => 'Pour chaque lot de saisie des dossiers, cr&eacute;er une r&eacute;f&eacute;rence diff&eacute;rente et unique.',
	'rubriques' => 'rubriques',

	// S
	'saisie' => 'Saisie',
	'selectionner_une_assur' => 'S&eacute;lectionner une assurance',
	'selectionner_une_coti' => 'S&eacute;lectionner une cotisation',
	'selectionner_une_saison' => 'S&eacute;lectionner une saison',
	'souscription' => 'Date de souscription',
	'statut' => 'Statut',
	'statut_admin' => 'Admin',
	'statut_auteur' => 'Auteur',
	'statut_autre' => 'Autre',
	'statut_a_confirmer' => 'À confirmer',
	'statut_visiteur' => 'Visiteur',
	'statuts_actifs' => 'Les couleurs des icones correspondent aux statuts suivants : ',
		
	// T
	'texte_statut_prepa' => 'en préparation',
	'texte_statut_processing' => 'en cours',
	'texte_statut_publie' => 'publié',
	'texte_statut_refuse' => 'annulé',
	'titre_config_fonctions' => 'titre_config_fonctions(?)',
	//'titre_page_config' => 'Configuration des accès',
	'trombi_rang' => 'Rang dans le Regroupement',
	'trombi_rang_exp' => 'Le Rang permet de classer les listes de niveaux dans le Regroupement.',
	'toutes' => 'Toutes',
	'type' => 'Type',

	// V
	'ville' => 'Ville (Domicile)',
	//'voir_tous' => 'Voir tous les niveaux',

	// Z
	'ze_fin' => 'Ze fin sans virgule'
);

?>
