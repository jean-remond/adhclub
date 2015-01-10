adh_club : Plugin de gestion non comptable d'un Club.

==========================
Gestion des Adhérents pour un Club.
==========================
Jean-Gabriel Remond (01/2015) 


==========================
Installation :
==========================
Le plugin adh_club est developpe a l'origine avec spip 2.1.nn.
Il est migre couarnt 01/2015 vers spip 3.0.17.

Les plugins utilises directement :
- "acces_restreint"
- "agenda"
- "calendrier_mini-2.0"
- "champs_extras"
- "champs_extras (interface)"
- "champs_extras (import_export)"
- "couteau_suisse"
- "cvs_import"
- "escal"
- "inscription3"
- "saisies"
- "spip_bonux-3"
- "verifier"
- "yaml"

Les autres plugins utilises sur mon site :
- "a2a
- "crayons"
- "duplicator"
- "galleria"
- "facteur"
- "mailshot"
- "mailsubscribers"
- "newsletter"
- "nivoslider"
- "palette"
- "pays"
- "spip_proprietaire_s3"
- "spipdf"
- "supersized"
 

==========================
Demarrage du plugins pour Dijon-Plongee.
==========================

Bascule de spip version 2.1.19
Le 23/09/2012 : Migration du site pour integrer le plugin adhclub.


1- 10:00 : Sauvegarde des donnees :
	Via spip pour le site principal
	Via phpmyadmin pour la base de donnees
	Via Filezilla pour tout le site (copie complete de tout le site).

2- 13:00 : Preparation de la page d'accueil durant la migration : Texte :
		Le site de DIJON PLONGEE
			>> Logo du club <<
			Est en travaux pour cause de migration vers de nouvelles fonctionnalites.
			Merci de revenir plus tard dans la journee'.
			Toute l'equipe de gestion vous remercie de votre visite
			et souhaite vous revoir tres bientot.

3- 13:53 : Chargement de la nouvelle version :
		"squelettes" depuis workspace (dernieres evolutions) vers "squelette_new"

		"plugins" vers "plugins_new"
			"adhclub" depuis workspace (dernieres evolutions)
			autres depuis site test pour limiter les risques.
			19/04/2012 : "inscription2" remplace par plugin "inscription3". Pour "inscription2", il faut soit 
			desinstaller le plugin apres avoir dumper les donnees, soit modifier la table "auteurs_elargis" pour 
			supprimer la colonne "id".
			19/04/2012 : Pour "inscription3", la recopie des champs de auteurs_elargis vers auteurs ne 
			fonctionne pas correctement. Il va fallor le faire manuellement (voir Reprise des donnees).
			
		"spip" depuis le fichier origine SPIP-v2-1.19 vers "SPIP-v2-1.19"
		
		Rechargement de "lib" avec "jquery-validation-1.9.0" et "h5c1accba-fpdf17".
		
		
4- 14:22 : Mise en place message de travaux via couteau-suisse.

	Votre site sera r&eacute;tabli en fin d'apr&egrave;s-midi.
	Il se cache pour mieux r&eacute;appara&icirc;tre avec des fonctions nouvelles et des corrections.

	Vos gestionnaires de site.
	_ Merci de votre compr&eacute;hension.

	A tr&egrave;s bient&ocirc;t sur nos pages.

	Pour les adh&eacute;rents: le site inscription reste actif.
	(JR).

5- 14:45 : Activation de fichier indextravaux.html
	Renommage du fichier de la racine index.php en index_origine.php
	Renommage du fichier indextravaux.html en index.html.
	Verification de l'afficahage correct.
	==> spip est maintenat isole.

6- 14:50 : Mise en place de la version
	Copie des plugins vers "plugins_bak".
	Copie de squelette vers "squelette_bak";
	Copie version actuelle vers "SPIP-v2-0.10" (Attention au fichier index.html qui doit rester en place).
	Copie de "SPIP-v2-1.19" vers la racine du site (Attention au fichier index.html qui doit rester en place).
	Copie de squelette depuis "squelette.new"
	Copie des plugins depuis "plugins_new" vers "plugins". 
	

7- Activation des plugins

8- 15:05 : Verification du fonctionnement correct du site.

9- 16:10 : Installer les Champs Extras pour adh_club (base/adh_champ_extras a importer via "Interface pour Champs Extras").


Configurer inscription3 :
-----------------------
signature 		M
E-Mail					T
Civilite	F			T
Nom famille	F			T	O
Prenom		F			T	O
Login		F	M			O
Date naiss	F				
Adresse		F	M
CP			F	M
Ville		F	M		T
Pays		F	M
Telephone	F	M
Mobile		F	M
Specialite				T
Pays par defaut : France
Profession	F	M
No Licence	F				O
CP naiss	F				O
Ville naiss	F				O
Pays naiss	F				O

R�glement � valider : coch�
article s�lectionn� pour le r�glement.

Date creation : cochee
Champ ident : login

Texte intro : Celui d'origine spip

10- 16:24 : Reprise des donnees :
-------------------------------

10-1) De auteurs_elargis vers auteurs (reprise suite a inscription3) :
--------------------------------------------------------------
Le 23/04/2012. via phpMyAdmin :

Executee le 23/09/2012 en Oxyd_prod spip 2.1.19.
Validee le 24/07/2012 en Oxyd_test spip 2.1.16.
Validee le 29/06/2012 en Free_essai spip 2.1.15.
==> sans les champs extra qui ne sont pas dans la base de production actuelle.
UPDATE `spip_auteurs` c 
SET `nom_famille`=(SELECT `nom_famille` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`prenom`=(SELECT `prenom` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`adresse`=(SELECT `adresse` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`code_postal`=(SELECT `code_postal` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`ville`=(SELECT `ville` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`telephone`=(SELECT `telephone` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`naissance`=(SELECT `naissance` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`sexe`=(SELECT `sexe` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`pays`=(SELECT `pays` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`mobile`=(SELECT `mobile` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`commentaire`=(SELECT `commentaire` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`fonction`=(SELECT `fonction` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`code_postal_pro`=(SELECT `code_postal_pro` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`ville_pro`=(SELECT `ville_pro` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`pays_pro`=(SELECT `pays_pro` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`creation`=(SELECT `creation` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`)
WHERE EXISTS (SELECT 1 from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`)


Initiale : Validee le 25/04/2012 en Free_test  spip 2.1.13.

UPDATE `spip_auteurs` c 
SET `nom_famille`=(SELECT `nom_famille` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`prenom`=(SELECT `prenom` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`adresse`=(SELECT `adresse` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`code_postal`=(SELECT `code_postal` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`ville`=(SELECT `ville` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`telephone`=(SELECT `telephone` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`naissance`=(SELECT `naissance` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`sexe`=(SELECT `sexe` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`pays`=(SELECT `pays` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`mobile`=(SELECT `mobile` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`commentaire`=(SELECT `commentaire` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`fonction`=(SELECT `fonction` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`code_postal_pro`=(SELECT `code_postal_pro` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`ville_pro`=(SELECT `ville_pro` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`pays_pro`=(SELECT `pays_pro` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`divers`=(SELECT `divers` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`creation`=(SELECT `creation` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`certiflimite`=(SELECT `certiflimite` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`certifqualif`=(SELECT `certifqualif` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`email_corr`=(SELECT `email_corr` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`),
`certifaspirine`=(SELECT `certifaspirine` from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`) 
WHERE EXISTS (SELECT 1 from `spip_auteurs_elargis` s WHERE c.`id_auteur`=s.`id_auteur`)



10-2) Installation et activation du plugin "adh_club".
-----------------------------------------------


10-3) De dp_niveau vers adhnivs :
-------------------------------
Le 21/06/2012. Via phpMyAdmin :

Executee le 23/09/2012 en Oxyd_prod spip 2.1.19 requete directe sur PhpMyAdmin : 1er SELECT seul, puis INSERT..
Validee le 24/07/2012 en Oxyd_test requete directe sur PhpMyAdmin : 1er SELECT seul, puis INSERT.
Validee le 01/07/2012 en Free_essai requete directe sur PhpMyAdmin.

INSERT INTO spip_adhnivs (`titre`, `descriptif`, `techbase`, `encadrant`, `id_trombi`, `rangtrombi`) 
SELECT DISTINCT CONCAT(substr(dp.niveau, 1, 3),"_",substr(dp.niveau, 5, 3),"_",substr(dp.niveau, 9, 3)), 
	dp.niveau, m_tech.id_mot, m_enc.id_mot, m_tro.id_mot, 1  
FROM  dp_niveau dp, spip_mots m_tech,  spip_mots m_enc, spip_mots m_tro
WHERE	m_tech.type='Niveau_Technique'
	AND m_tech.titre=CONVERT(substr(dp.niveau, 1, 3) USING latin1) collate latin1_general_ci
	AND m_enc.type="Niveau_Encadrement"
	AND m_enc.titre = CONVERT(substr(dp.niveau, 5, 3) USING latin1) collate latin1_general_ci
	AND m_tro.type="Niveau_Trombi"	
	AND m_tro.titre = CONVERT(CONCAT(substr(dp.niveau, 1, 3),"_",substr(dp.niveau, 5, 3)) USING latin1) collate latin1_general_ci
ORDER BY dp.niveau;

==> 43 enregistrement(s) insere(s). 

Il faut ensuite adapter les valeurs de 'rangtrombi' suivant le besoin.


10-4) De dp_niveau vers adhnivs_auteurs :
---------------------------------------

Executee le 23/09/2012 en Oxyd_prod requete directe sur PhpMyAdmin : 1er SELECT seul, puis INSERT.
Validee le 24/07/2012 en Oxyd_test requete directe sur PhpMyAdmin : 1er SELECT seul, puis INSERT.
Validee le 01/07/2012 en Free_essai :

INSERT INTO spip_adhnivs_auteurs (id_niveau, id_auteur)
SELECT id_niveau, id_auteur  
FROM `dp_niveau` dp, `spip_auteurs` aut, spip_adhnivs niv
WHERE aut.fonction = CONVERT(dp.fonction USING latin1) collate latin1_general_ci
AND niv.descriptif = CONVERT(dp.niveau USING latin1) collate latin1_general_ci;

==> 306 enregistrement(s) insere(s).

Initiale : Le 11/12/2011 Via phpMyAdmin : 

INSERT INTO spip_adhnivs_auteurs (id_niveau, id_auteur)
SELECT id_niveau, id_auteur  
FROM `dp_niveau` dp, `spip_auteurs` aut, spip_adhnivs niv
WHERE dp.fonction = aut.fonction
AND dp.niveau = niv.titre;


10-5) Creation de la saison "de demarrage" :
------------------------------------------
16:42 : Executee le 23/09/2012 en Oxyd_prod.  via le site prive, menu "auteurs/gestion du club".
Validee le 24/07/2012 en Oxyd_test. via le site prive, menu "auteurs/gestion du club".
Validee le 01/07/2012 en Free_essai. via le site prive, menu "auteurs/gestion du club".
Descriptif = "Permet de raccrocher tous les adherents pour un demarrage progressif des fonctions."
"Encours" coche.

10-6) Creation de la cotisation "de demarrage" : 
----------------------------------------------
16:51 : Executee le 23/09/2012 en Oxyd_prod.  via le site prive, menu "auteurs/gestion du club".
Validee le 24/07/2012 en Oxyd_test. via le site prive, menu "auteurs/gestion du club".
Validee le 01/07/2012 en Free_essai. via le site prive, menu "auteurs/gestion du club".
Le 11/03/2012 en Free_test via DP_Free_jr_site_test_20120310_partiel.sql.
Descriptif = "Permet de raccrocher tous les adhérents pour un démarrage progressif des fonctions."
Montant 1 (obligatoire).
Saison : choisir "de demarrage".

10-7) Dans auteurs :
------------------
16:55 : Execute Le 23/09/2012 en Oxyd_prod via Import Champs Extras (Configuration/Champs Extras.
Validee le 11/03/2012 en Free_test via Import Champs Extras (Configuration/Champs Extras).

Utiliser le contenu de adh_club:base/adh_champ_extra pour creer les champs dans auteurs :
- certifaspirine
- certiflimite
- certifqualif
- email_corr.

10-8) De auteurs_elargis vers adhcotis_auteurs :
---------------------------------------------
17:08 : Executee le 23/09/2012 en Oxyd_prod requete directe sur PhpMyAdmin : 1er SELECT seul, puis INSERT.
Validee le 24/07/2012 en Oxyd_test requete directe sur PhpMyAdmin : 1er SELECT seul, puis INSERT.
Validee le 11/03/2012 en Free_test via phpMyAdmin.

ATTENTION : Verifier la table auteurs_elargis car presence d'id_auteur a zero (sic!) :
Fait sur Oxyd_prod le 23/09/2012.
Refait sur Oxyd_test le 24/07/2012
Fait sur Oxyd le 11/03/2012.

La cotisation creee est celle portant id_coti=1 (La seule pour le demarrage).

INSERT INTO spip_adhcotis_auteurs (id_coti, id_auteur)
SELECT 1, id_auteur  
FROM `spip_auteurs_elargis` aut;

==> 317 enregistrement(s) inséré(s). 

Le trombinoscope est pret a fonctionner a l'equivalent de la version precedente.

	
- Dans le groupe "Squelette_rubrique"
	- "adh_tn_nm_sp" pour Trombinoscope via adhnivs avec description speciale.
	- "adh_tn_nm_nv" pour Trombinoscope via adhnivs avec description niveau.

Le formulaire d'affichage est adh_club/public/adh_trombi_nm.html a inclure dans 
	la rubrique "qui va bien".

11- Le site est operationnel :
----------------------------
20:00 : Le 23/09/2012 : Apres des controles d'usage de bon fonctionnement, le site est reouvert.


12- Gestion des imports de donnees et maj des fiches adherents :
------------------------------
Ajouter dans le Groupe de mots-cle "Squelette_rubrique" les mots-cle suivant
- "adh_ges_ffessm" pour Gestion des importations de donnees depuis la fede.
- "adh_ges_adh" pour Gestion des fiches adherents sur le site public.
Ces mots-cle sont utilises par le squelette dans rubrique.html.


