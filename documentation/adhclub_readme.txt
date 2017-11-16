adhclub : Plugin de gestion non comptable d'un Club.

==========================
Gestion des Adherents pour un Club.
==========================
Jean-Gabriel Remond (08/2012)
Révision (01/2015)

Le plugin a ete cree pour satisfaire a la gestion administrative d'un club de Plongee sous-marine.
Il n'y a pas de gestion comptable dans ce plugin.
Au premier plan il s'agit de la gestion des adherents du club, et pour cela, il faut gerer :
- des saisons,
- des cotisations par saison,

Cette structure fonctionnelle utilise le plugin Inscription3 comme base structurelle 
	avec les donnees auteurs.

Mais comme le sport est technique, il a fallu enrichir la gestion avec des fonctions telles que :
- des assurances par saison.
- des niveaux techniques (ou capacites a pratiquer suivant des regles definissant des limites telles 
    que la profondeur des plongees, l'autonomie, etc..)
- des controles sur les autorisations medicales 
	(Certificat medical a jour et valide, restriction possibles, etc..) 
    via des champs extras dans la table auteurs.



Les fonctions autour de l'adherent (ou auteur de spip) :

- Gestion des saisons :
	Les saisons permettent de qualifier les entites Cotisations et Assurances.
	Pour autoriser un adherent a pratiquer son sport favori en toute legalite, 
		il faut, pour la saison encours, une licence active et une assurance de protection.	
	Les saisons sont definies comme actives (encours) ou non.
	Plusieurs saisons (normalement 2 maximum) sont actives au meme moment, lors du debut de la saison 
        (ex septembre) puisque les licences de la saison precedente sont encore valides jusqu'en decembre.
	Il n'y a pas de verrou sur ce point.

- Gestion des cotisations :
	Les cotisations representent a la fois le cout de la license aupres du Club, mais aussi le cout de 
        fonctionnement du club.
	Il peut y avoir autant de cotisations differentes que necessaire.
	Les cotisations sont qualifiees par une saison et il parait plus facile d'introduire cette notion 
		de saison dans le titre de la cotisation (selection plus facile lors de l'affectation a un 
		auteur).
	Bien sur, s'il n'est pas utile de gerer des cotisations pour le club, il suffit de ne pas en 
		declarer.
	Un montant est demande face a chaque cotisation, il peut etre reduit a '0.01' mais est obligatoire (pb a resoudre).

- Gestion des assurances :
	Les assurances representent la garantie, en cas de besoin, que le club n'ai pas besoin de 
		subvenir aux couts lies a  un incident/accident ainsi qu'à la responsabilité civile de l'adhérent.
	Il peut y avoir autant d'assurances differentes que necessaire.
	Les assurances sont qualifiees par une saison et il parait plus facile d'introduire cette notion 
		de saison dans le titre de l'assurance (selection plus facile lors de l'affectation a un 
		auteur).
	Bien sur s'il n'est pas utile de gerer des assurances pour le club, il suffit de ne pas en 
		declarer.
	Un montant est demande face a chaque assurance, il peut etre reduit a '0.01'.
	Une assurance doit etre cree representant la non-assurance au sein du club mais une assurance 
		exterieure.

- Gestion des niveaux :
	Les niveaux techniques permettent de qualifier l'adherent et de retrouver ses prerogatives en 
		regard du sport pratique. Ils permettent aussi d'etablir un trombinoscope des adherents
		 (ex encadrants et plongeurs).
	Dans cette gestion, nous avons introduit aussi la structure du bureau directeur et des 
		qualifications de type permis (ex mer, voiture genre E permettant de tracter un bateau, etc..).


==========================
Installation :
==========================

Comme tous les plugins en suivant la [procédure habituelle->http://www.spip.net/fr_article3396.html].

Le plugin adhclub est developpe a l'origine pour spip 2.1.17.
En 2015, il est revu pour spip 3.0.xx.
Les plugins utilises :
- "couteau_suisse"
- "champs_extras"
- "champs_extras (interface)"
- "champs_extras (import_export)"
- "facteur"
- "inscription3"
- "saisies"
- "spip_bonux-3"
- "verifier"
- "yaml"


==========================
Les fonctions en detail :
==========================

- Gestion des niveaux :
==========================
Pour utiliser la gestion des niveaux, il faut au prealable creer 3 groupes de mots cle :
	-- Groupe "Niveau_Encadrement" : 
	> Un seul mot a la fois
	> Groupe important
	> Administrateurs
	Defini les types de niveaux a definir : 
		- 'ADH' pour les niveaux adherents,
		- 'COM' pour le Comite du club, hors comite directeur,
		- 'DIR' pour la direction du club,
		- 'ENC' pour des brevets d'encadrement,
		- 'MER' pour les permis bateau,
		- 'SEC' pour le Secretariat, associe au comite directeur,
		- 'TER' pour les permis terrestres,
		- 'TRS' pour la Tresorerie, associe au comite directeur,
		- etc..

	-- Groupe "Niveau_Technique" : 
	> Un seul mot a la fois
	> Groupe important
	> Administrateurs
	Defini la technique a la base du niveau. Correspond peu ou prou aux commissions du club :
		- 'APN' pour l'Apnee,
		- 'BIO' pour la Biologie,
		- 'CD1' pour la structure du bureau directeur,
		- 'CD2' pour la structure du comite directeur,
		- 'CD3' pour la structure des autres membres du comite,
		- 'CDH' pour la structure des adjoints Hors comite,
		- 'DIV' pour les Autres membres du Comite,
		- 'MAT' pour le Materiel,
		- 'MED' pour le Medical,
		- 'MIT' pour le Materiel Informatique,
		- 'PHO' pour la Photo,
		- 'PLG' pour la Plongee scaphandre,
		- etc..

	-- Groupe "Niveau_Trombi" : 
	> Articles
	> Un seul mot a la fois
	> Groupe important
	> Administrateurs
	Defini dans quelle page du trombinoscope ce niveau doit apparaitre. 
        Ce Niveau-trombi sera qualifie d'un rang (ou ordre) dans lequel doivent etre affiches les 
        niveaux d'un meme groupe dans la gestion des niveaux.
	Qualification des adherents et critere de selection pour les articles constituants la structure 
		du trombinoscope.
		- 'APN_ADH' pour les adherents en Apnee,
		- 'APN_ENC' pour les encadrants en Apnee,
		- 'BIO_ADH' pour les adherents en Biologie,
		- 'BIO_ENC' pour les encadrants en Biologie,
		- 'CD1_DIR' pour les membres du Comite Directeur,
		- 'CD1_SEC' pour les membres du Secretariat,
		- 'CD1_TRS' pour les membres de al Tresorerie,
		- 'CD2_COM' pour les membres des Commissions,
		- 'CD3_DIV' pour les Autres membres du Comite,
		- 'MAT_MER' pour les détenteurs de permis Mer.
		- 'MAT_TER' pour les détenteurs de permis routiers 'E'.
		- 'PHO_ADH' pour les Adherents en Photo,
		- 'PHO_ENC' pour les Encadrants en Photo,
		- 'PLG_ADH' pour les Adherents en Plongee scaphandre,
		- 'PLG_ENC' pour les Encadrants en Plongee scaphandre,


- Gestion du trombinoscope :
==========================

Le formulaire d'affichage est adhclub/public/inclure/adh-rubrique_trombino.html à inclure dans la 
	rubrique "qui va bien".
Attention : cette noisette est développée pour les plugins "escal" et  "polyhierarchie" .

Le trombinoscope est basé sur les données de la table auteurs, complétées par les relations avec les 
	niveaux (adhnivs).

Les différents affichages des rubriques sont pilotés par des mots du groupe "type_rubrique" (escal).
Pour le trombinoscope, 1 seul mot est à créer : "trombino"
	
Une rubrique est crée (Trombinoscope)
Pour des raisons de confidentialité, à l'aide des F(acces restreint), seuls le Bureau et l'encadrement 
	du club sont visibles pour le public.
Les adhérents non encadrant ne sont visibles que par les adhérents signés sur le site (zone adhérents).

Nous avons créé une rubrique par commission active au club.
Pour chaque commission, 2 sous-rubriques : 'encadrants' et 'adhérents'.
Ces sous-rubriques sont qualifiées par le mot "type_rubrique/trombino" suivant le besoin.

Pour activer l'affichage, un article 'publié' affecté du mot 'Niveau_trombi' qui convient permet 
	la recherche et l'affichage des adhérents ayant le niveau qualifié du même regroupement.
L'ordre d'affichage dépend du rang dans le regroupement pour le niveau.

Savoir :
---------------------------
LOGO de l'auteur : Le 09/01/2012 :
Ils sont telecharges sur la fiche de chaque auteur.

Pour charger massivement les logos des auteurs, il faut :
- Nommer la photo ==> 'auton' suivi du n° de l'auteur ';jpg' ou '.png' suivant le type de photo.
- la tailler au format 90X120 px
- placer cette image dans les repertoires /IMG et /local/cache-vignettes/L90xH120.

==> Le logo doit etre utilisable !! A verifier.
---------------------------


==========================
Procedure de gestion des adherents
==========================
Gestion des imports de donnees et maj des fiches adherents :
------------------------------
A valider-JR-11/06/2017
Ajouter dans le Groupe de mots-cle "Squelette_rubrique" les mots-cle suivant
- "adh_ges_ffessm" pour Gestion des importations de donnees depuis la fede.
- "adh_ges_adh" pour Gestion des fiches adherents sur le site public.
Ces mots-cle sont utilise par le squelette dans rubrique.html.
Fin A valider-JR-11/06/2017

Les adherents font l'objet, de par la licence, d'une inscription a la Fédération (ici FFESSM).
Pour cette inscription, il n'y a qu'une possibilite : la saisie sur le site fédéral (!!).

La procedure de debut de saison pour les inscriptions est donc la suivante :

- Diffusion 
    - vers les futurs adherents d'un dossier d'inscription vierge.
    - vers les adherents de la saison precedante, d'un dossier d'inscription pre-rempli 
    	des donnees connues du site.
    Le tout accompagne des modalites d'adhesion (conditions, prix, etc...).

- Avec son dossier d'inscription correctement rempli et les documents nécessaires, 
	l'adherent se rapproche du secretariat pour déposer son dossier en début de saison.

- Le secretariat saisie sur le site de la Federation la fiche adherent ou la met a jour.

- Le secretariat extrait les donnees d'1 lot de saisie depuis le site fédéral vers un fichier CSV 
	(MS actuellement !!).

- Le Webmaster intègre ces donnees sur notre site via CSV_Import dans la table "adhintgs".

- Le secretaire prend en compte ces donnees dans notre site dans la tables "auteurs" 
	par une F(formulaires/integ_adhintg.html).
    
- Saisies complementaires des donnees sur la fiche adherent, telles que telephone, niveaux, 
	lieu naissance, date certificat medical, photo, etc...
    
- Pour les nouveaux adherents, diffusion vers l'adherent de ses codes d'acces au site du club.


==========================
Savoir : Script de creation de la Table adhintgs
Et donc format du fichier CSV d'import des données :
==========================

CREATE TABLE `spip_adhintgs` (
  `Souscription` date NOT NULL,
  `Saisie` text NOT NULL,
  `Saison` int(4) NOT NULL,
  `Type` text NOT NULL,
  `Licence` varchar(11) NOT NULL,
  `Civilite` text NOT NULL,
  `Prenom` text NOT NULL,
  `Nom` text NOT NULL,
  `Date de naissance` date NOT NULL,
  `Adresse 1` int(11) NOT NULL,
  `Adresse 2` text NOT NULL,
  `Adresse 3` text NOT NULL,
  `CP` text NOT NULL,
  `Ville` text NOT NULL,
  `Pays` text NOT NULL,
  `Email` tinytext NOT NULL,
  `Assurance` text NOT NULL,
  `Statut` text NOT NULL,
  PRIMARY KEY (`Licence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table temporaire d''integration';


==========================
La Fonction(adh_import)
==========================

Cette fonction permet de prendre en charge les donnees de la table "adhintgs" chargee 
	prealablement par CVS_Import a partir des donnees extraites du site fédéral.

La fonction realise soit un ajout pour un nouvel adherent, soit une mise a jour d'un 
	adherent existant.

Les criteres de definition d'un adherent existant :
- Le code "adhintgs"."licence" correspond au code "auteurs"."fonction". 
	En effet, ce code "licence" est unique par adherent a FFESSM.
- Par securite, le nom et le prenom seront aussi verifies (?).


- S'il n'y a pas de correspondance de licence c'est une creation d'adherent : 
	==> Creation de la fiche adherent  puis utilisation de la fonction de mise a jour 
		pour completer les donnees :
	- Pour la creation, s'inspirer (vilement) du plugin i2_import.
    - (? a valider) Pour l'email : un champ extra 'email de correspondance' doit etre cree (celui qui servira aux 
    	envois de mailling de groupe ou individuel).
    	L'email principal est utilise par spip comme cle majeur dans la gestion des auteurs. 
    	Dans les cas simples (un seul auteur par email), rad, email principal egal email de correspondance.
    	Dans les cas complexes (fratries avec le meme email, cet email sera l'email de 
    		correspondance pour chacun	et seul le premier adherent enregistre aura cet email comme 
    		email principal.
    		Les autres membres de la famille auront comme email principal un email de la forme
    		'adh_club_123@adhclub.com' où la sequence 123 represente l'Id de l'adherent.
    
    Apres la creation, la F(Maj) de l'auteur est realisee pour permettre l'initialisation des relations 
    	complementaires telles que la cotisation avec la reference de saisie, l'assurance.


- S'il y a correspondance de licence mais pas de correspondance nom-prenom, une anomalie 
	est affichee et la Maj n'est pas realisee. L'enregistrement de la table "adhintgs" 
	n'est pas supprime.
	
	
- S'il y a correspondance de licence et des nom-prenom, c'est une mise à jour : 
- La Maj consiste au remplacement des champs suivants :
    - Adresse (concatenation des colonnes adresse1, adresse2 & adresse3),
    - CP,
    - Ville,
    - Pays (?),
    - email,
    - email de correspondance

- Si la Maj est faite sans erreur, l'enregistrement de la table "adhintgs" est supprime.


