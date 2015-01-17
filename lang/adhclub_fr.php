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
	'adhclub' => 'Gestion du club',
	'adhclub_icone_menu' => 'G&eacute;rer le Club',
	'adhclub_titre' => 'Gestion administrative du Club',
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
	'assurance' => 'Assurance',
	'assur_ajouter' => 'Ajouter une assurance',
	'assur_aucun' => 'Aucune assurance',
	'assur_bouton_ajouter' => 'Ajouter la nouvelle assurance',
	'assur_confirmer_retirer_auteur' => '&Ecirc;tes-vous s&ucirc;r de vouloir retirer cet auteur de cette assurance ?',
	'assur_confirmer_ajouter_saisons' => '&Ecirc;tes-vous s&ucirc;r de vouloir ajouter cette saison &agrave; cet assurance ?',
	'assur_confirmer_retirer_saison' => '&Ecirc;tes-vous s&ucirc;r de vouloir retirer cette saison de cet assurance ?',
	'assur_confirmer_retirer_saisons' => '&Ecirc;tes-vous s&ucirc;r de vouloir retirer toutes les assurances de cette saison ?',
	'assur_creer' => 'Cr&eacute;er une assurance',
	'assur_creer_associer' => 'Créer et associer une assurance',
	'assur_icone_menu' => 'G&eacute;rer les Assurances',
	'assur_icone_supprimer' => 'Supprimer cette assurance',
	'assur_info_1' => '1 assurance',
	'assur_info_ajouter_saisons' => 'Ajouter une saison',
	'assur_info_aucun' => 'Aucune assurance',
	'assur_info_aucun_auteur' => "Aucun auteur pour l'assurance",
	'assur_info_retirer' => "Enlever l'assurance",
	'assur_info_retirer_auteur' => "Enlever l'adh&eacute;rent de l'assurance",
	'assur_info_retirer_saison' => "Enlever l'assurance de la saison",
	'assur_info_retirer_saisons' => "Retirer toutes les saisons d'assurance",
	'assur_modifier' => 'Modifier l\'assurance',
	'assur_saison' => 'Choix de la saison d\'application',
	'assur_saison_aff' => 'Saison d\'application',
	'assur_saison_exp' => 'La saison, une fois choisie, ne peut &eacute;tre modifi&eacute;e que par le Webmaster',
	'assur_texte_changer_statut' => 'Cette assurance est :',
	'assur_titre' => 'Assurance du Club',
	'assur_titre_ajouter' => 'Ajouter une assurance',
	'assur_titre_cadre_modifier' => 'Modifier une assurance',
	'assur_titre_exp' => 'Assurance propos&eacute;e par le Club dans le cadre de ses activit&eacute;s.',
	'assurs' => 'assurance(s)',
    'assurs_acces' => 'S&eacute;lectionnez l\'assurance pour l\'auteur',
	'assurs_info_ajouter' => 'Ajouter une assurance',
	'assurs_info_nb' => '@nb@ assurances',
	'assurs_info_retirer' => "Enlever toutes les assurances de l'auteur",
	'assurs_titre' => 'Assurance(s) propos&eacute;es  aux adh&eacute;rents',
	'assurs_page' => 'Assurances pour les adh&eacute;rents',
	'assurs_page_info' => 'Cette page vous permet de g&eacute;rer les assurances propos&eacute;es par votre club',

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
	'coti_bouton_ajouter' => 'Ajouter la nouvelle cotisation',
	'coti_confirmer_retirer_auteur' => '&Ecirc;tes-vous s&ucirc;r de vouloir retirer cet auteur de cete cotisation ?',
	'coti_aucun' => 'Aucune cotisation',
	'coti_complement' => 'Cotisation compl&eacute;mentaire',
	'coti_creer' => 'Cr&eacute;er une cotisation',
	'coti_creer_associer' => 'Créer et associer une cotisation',
	'coti_icone_menu' => 'G&eacute;rer les Cotisations',
	'coti_icone_supprimer' => 'Supprimer cette cotisation',
	'coti_info_1' => '1 cotisation',
	'coti_info_aucun' => 'Aucune cotisation',
	'coti_info_aucun_auteur' => 'Aucun auteur pour la cotisation',
	'coti_info_page' => "Cette page vous permet de g&eacute;rer les cotisations d'adh&eacute;sion &agrave; votre club",
	'coti_info_retirer_auteur' => "Enlever l'adh&eacute;rent de la cotisation",
	'coti_info_retirer' => 'Enlever la cotisation',
	'coti_mnt' => 'Montant de la cotisation',
	'coti_modifier' => 'Modifier la cotisation',
	'coti_principale' => 'Cotisation principale',
	'coti_qualif' => 'Choix de la qualification',
	'coti_qualif_exp' => 'La qualification permet de qualifier la cotisation',
	'coti_saison' => 'Choix de la saison d\'application',
	'coti_saison_exp' => 'La saison, une fois choisi, ne peut &eacute;tre modifi&eacute;e que par le Webmaster',
	'coti_texte_changer_statut' => 'Cette cotisation est :',
	'coti_titre' => 'Cotisation pour l\'adh&eacute;sion au Club',
	'coti_titre_ajouter' => 'Ajouter une cotisation',
	'coti_titre_cadre_modifier' => 'Modifier une cotisation',
	'coti_titre_exp' => 'Cotisation propos&eacute;e par le Club dans le cadre de ses activit&eacute;s.',
	'cotis' => 'cotisation(s)',
    'cotis_acces' => 'S&eacute;lectionnez la cotisation pour l\'auteur',
	'cotis_info_ajouter' => 'Ajouter une cotisation',
	'cotis_info_nb' => '@nb@ cotisations',
	'cotis_info_retirer' => "Enlever toutes les cotisations de l'auteur",
	'cotis_page' => 'Cotisations au Club',
	'cotis_titre' => 'Cotisations pour l\'adh&eacute;sion au Club',
	'cp' => 'Code postal',
	
	// D
    'demande_photo'=>'D&eacute;p&eacute;chez-vous de lui demander sa photo..',
	'descriptif' => 'Descriptif',
	'descriptif_plugin' => 'Vous trouverez ici tous les utilisateurs inscrits sur le site. Leur statut est indiqué par la couleur de leur icone.',
		
	// E
	'email' => 'email',
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
	'mnt_assur' => 'Montant de l\'assurance',

    // N
	'naissance' => 'Date de naissance',
	'niveau' => 'Niveau',
	'niveau_aucun' => 'Aucun niveau',
    'niveau_aucun2grp' => 'Aucun niveau trouv&eacute; dans ce groupe',
	'niveau_bouton_ajouter' => 'Ajouter la nouvelle qualification',
	'niveau_confirmer_retirer_auteur' => '&Ecirc;tes-vous s&ucirc;r de vouloir retirer cet auteur de ce niveau ?',
	'niveau_confirmer_supprimer' => '&Ecirc;tes-vous s&ucirc;r de vouloir supprimer ce niveau ?',
	'niveau_creer' => 'Cr&eacute;er un niveau',
	'niveau_creer_associer' => 'Créer et associer un niveau',
	'niveau_encadrant' => 'Niveau d\'encadrement',
	'niveau_encadrant_exp' => 'Ce niveau est-il un niveau d\'encadrement, pour la plong&eacute;e ou l\'apn&eacute;e ?',
	'niveau_icone_menu' => 'G&eacute;rer les Niveaux',
	'niveau_icone_supprimer' => 'Supprimer ce niveau',
	'niveau_info_1' => '1 niveau',
	'niveau_info_aucun_auteur' => 'Aucun auteur dans le niveau',
	'niveau_info_aucun' => 'Aucun niveau',
	'niveau_info_page' => 'Cette page vous permet de g&eacute;rer les niveaux de qualification affectables aux adh&eacute;rents de votre club',
	'niveau_info_retirer_auteur' => "Enlever l'adh&eacute;rent du niveau",
	'niveau_info_retirer' => 'Enlever le niveau',
	'niveau_modifier' => 'Modifier le niveau',
	'niveau_rel' => 'Relatif au rang du niveau',
	'niveau_techbase' => 'Technique du niveau',
	'niveau_techbase_exp' => 'Le code de technique permet de g&eacute;rer les inscriptions aux sorties du Club',
	'niveau_texte_changer_statut' => 'Ce niveau est :',
	'niveau_titre' => 'Niveau de qualification',
	'niveau_titre_ajouter' => 'Ajouter un niveau',
	'niveau_titre_cadre_modifier' => 'Modifier un niveau',
	'niveau_trombi' => 'Regroupement pour le trombinoscope',
	'niveau_trombi_exp' => 'Le code de Regroupement permet de classer les diff&eacute;rents niveaux dans les pages du trombinoscope',
    'niveaux_acces' => 'S&eacute;lectionnez le(s) niveau(x) pour l\'auteur',
	'niveaux_info_ajouter' => 'Info Ajouter un niveau',
	'niveaux_info_nb' => '@nb@ niveaux',
	'niveaux_info_retirer' => "Enlever tous les niveaux de l'auteur",
	'niveaux_titre' => 'Niveaux de qualification',
	'niveaux_page' => 'Niveau(x) de qualification pour l\'adh&eacute;rent',
	'no_user_selected' => 'Vous n\'avez s&eacute;lectionn&eacute; aucun adh&eacute;rent pour envoyer un courriel.',
	'nom' => 'Nom (de famille)',

	// O

    // P
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
	'saison' => 'Saison',
	'saison_aucun' => 'Aucune saison',
	'saison_confirmer_supprimer' => '&Ecirc;tes-vous s&ucirc;r de vouloir supprimer cette saison ?',
	'saison_creer' => 'Cr&eacute;er une saison',
	'saison_creer_associer' => 'Créer et associer une saison',
	'saison_deb' => 'D&eacute;but de Saison du Club (jj/mm/aaaa) :',
	'saison_encours' => 'Saison en cours de validit&eacute; ?',
	'saison_encours_exp' => 'Cette saison est-elle celle en cours de validit&eacute; ?',
	'saison_fin' => 'Fin de Saison du Club (jj/mm/aaaa) :',
	'saison_icone_menu' => 'G&eacute;rer les Saisons',
	'saison_icone_supprimer' => 'Supprimer cette saison',
	'saison_info_1' => '1 saison',
	'saison_info_ajouter' => 'Ajouter cette saison',
	'saison_info_page' => "Cette page vous permet de g&eacute;rer les saisons d'exercice de votre club",
	'saison_info_retirer' => 'Enlever la saison',
	'saison_info_aucun' => "Aucune saison n'existe pour le club",
	'saison_info_aucun_integ' => "Aucune saison -@titre_saison@- n'existe pour le club",
	'saison_modifier' => 'Modifier la saison',
	'saison_rech' => 'Choix de la saison de s&eacute;lection',
	'saison_texte_changer_statut' => 'Cette saison est :',
	'saison_titre' => 'Saison du Club',
	'saison_titre_cadre_modifier' => 'Modifier une saison',
	'saison_titre_exp' => 'Le titre de la Saison du Club est libre en structure. Pour une ann&eacute;e scolaire, peut &eacute;tre de la forme 2011-2012.',
	'saisons_info_nb' => '@nb@ saisons',
	'saisons_titre' => 'Saisons du Club',
	'selectionner_un_niveau' => 'S&eacute;lectionner un niveau',
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
