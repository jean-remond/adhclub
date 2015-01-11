<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *	( très vilement pompé de Quentin Drouet & Cedric MORIN)
 *
 * --------------------------------------------
 * Traiter l'import dans les tables auteurs. 
 * --------------------------------------------
 * JR-10/01/2015-adaptation spip 3.0.
 * JR-2012/04/23-Adaptation a inscription3.
 */

include_spip("base/abstract_sql");
include_spip("inc/charsets");

/**
 * 
 * Liste de l'ensemble des champs possibles
 * 
 * @return si $type='unique' retourne un array des deux tables auteurs,
 *   si $type='source' retourne un array de la table adhffessms,  
 *   sinon ('separe') retourne un array contenant deux arrays distincts des tables auteurs.
 * @param array $tables array des tables (spip_auteurs, spip_auteurs_elargis ou adhffessms)
 * @param string $type[optional] determine la forme du retour
 */
function adhclub_imp_table_fields($tables,$type='unique'){
	$trouver_table = charger_fonction('trouver_table','base');

	$field_cible_finale = array();
	if(is_array($tables)){
		foreach($tables as $table){
			switch($table) {
			case 'spip_auteurs';
				// Tous les champs de spip_auteurs ne sont pas a prendre en compte
				$spip_auteurs['nom'] = 'nom';
				$spip_auteurs['email'] = 'email';
				$spip_auteurs['login'] = 'login';
				$spip_auteurs['source'] = 'source';
				$spip_auteurs['divers'] = 'divers';
				// Les champs Extras de spip_auteurs a prendre en compte
				$spip_auteurs['certiflimite'] = 'certiflimite';
				$spip_auteurs['certifqualif'] = 'certifqualif';
				$spip_auteurs['certifaspirine'] = 'certifaspirine';
				$spip_auteurs['email_corr'] = 'email_corr';
				break;

			case 'spip_auteurs_elargis';
				// Tous les champs sont maintenant dans la table auteurs (i3).
				//$table_desc = $trouver_table($table);
				$table_desc = $trouver_table('spip_auteurs');
				$spip_auteurs_elargis=array_keys(is_array($table_desc['field']) ? $table_desc['field'] : array());
				$spip_auteurs_elargis=array_flip($spip_auteurs_elargis);
				foreach ($spip_auteurs_elargis as $key=>$value) {
					/**
					 * On ne garde que les champs actives
					 */
					if(lire_config('inscription3/'.$key) == 'on'){
						$spip_auteurs_elargis[$key] = $key;
					}else{
						unset($spip_auteurs_elargis[$key]);
					}
				}
				// On ne met pas a disposition le champs id_auteur
				unset($spip_auteurs_elargis['id_auteur']);

			case 'spip_adhffessms';
				// Tous les champs de spip_adhffessms ne sont pas a prendre en compte
				$spip_adhffessms['souscription'] = 'souscription';
				//$spip_aadhffessms['saisie'] = 'saisie';
				$spip_adhffessms['saison'] = 'saison';
				//$spip_adhffessms['type'] = 'type';
				$spip_adhffessms['licence'] = 'licence';
				$spip_adhffessms['civilite'] = 'civilite';
				$spip_adhffessms['prenom'] = 'prenom';
				$spip_adhffessms['nom'] = 'nom';
				$spip_adhffessms['naissance'] = 'naissance';
				$spip_adhffessms['adresse1'] = 'adresse1';
				$spip_adhffessms['adresse2'] = 'adresse2';
				$spip_adhffessms['adresse3'] = 'adresse3';
				$spip_adhffessms['cp'] = 'cp';
				$spip_adhffessms['ville'] = 'ville';
				$spip_adhffessms['pays'] = 'pays';
				$spip_adhffessms['email'] = 'email';																																$spip_aadhffessms['souscription'] = 'souscription';
				$spip_adhffessms['assurance'] = 'assurance';
				//$spip_adhffessms['statut'] = 'statut';
				break;
				
			default;
				echo "In inc/adh_import, F(adhclub_imp_table_fields), ".$table." is unknown";
				break;
			}
		}
	}
	if($type == 'unique'){
		$field_cible_finale = array_merge($spip_auteurs,$spip_auteurs_elargis);
		return $field_cible_finale;
	}elseif($type == 'source'){
		return $spip_adhffessms;
	}else{
		return array($spip_auteurs,$spip_auteurs_elargis);
	}
	return;
}
	

function adhclub_imp_show_erreurs($erreur){
	$output = "";
	if (count($erreur)>0){
		$bouton = bouton_block_depliable(_T('adhclub:adh_erreurs'), false,"adh_erreurs");
		$output .= debut_cadre_enfonce("mot-cle-24.gif", true, "", $bouton);
		$output .= debut_block_depliable(false,"adh_erreurs");

		foreach($erreur as $key=>$val){
			$output .= "<dl>";
			$output .= "<dt>"._T('adhclub:champ_err',array('cher'=>$key));
			$output .=  "<dd>"._T('adhclub:'.$key)." : $val<dd>";
			$output .= "</dl>";
		}

		$output .= fin_block();
		$output .= fin_cadre_enfonce(true);
	}
	return $output;
}



function adhclub_imp_nettoie_key($key){
	return translitteration($key);
}


/**
 * associer les champs pour la correspondance des donnees
 *
 * @param int $id_auteur
 * @param array $field_cible (champs cible)
 * @param array $table_source (champs source)
 * 
 * @return array $assoc
 */ 

 /*
  * En creation (id_auteur=new):
  *  ** ** auteurs ** **
  * 	nom (nom dot prenom)
  *		login (2 premieres lettres du prenom suivi de nom)
  *		statut (defaut config i3)
  *		source ("spip")
  *		divers ("adhclub")
  * ** champs extras **
  *		certiflimite (0000-00-00)
  *		certifqualif ('non')
  *		certifaspirine ('non')
  *
  * ** ** auteurs_elargis ** **
  *		nom_famille (nom)
  *		prenom (prenom)
  *		pays (defaut config i3)
  *		naissance (naissance)
  *		sexe (civilite M=>M, Mlle=>F, Mme=>F)
  *		fonction (licence)
  *		creation (date du jour de creation)
  *
  * En maj (id_auteur=num):
  *  ** ** auteurs ** **
  *		nom_famille (nom)
  *		prenom (prenom)
  *		email (email si existe pas, genere sinon)
  *		divers ("adhclub")
  *		maj  (automatique, raf)
  * ** champs extras **
  *		email_corr (email)
  * 
  * ** ** auteurs_elargis ** **
  *		adresse (adresse1+adresse2+adresse3)
  *		code_postal (cp)
  *		ville (ville)
  *		pays (defaut config i3)
  *
  * Manuellement (absent dans la description d'entree)
  * ** ** auteurs_elargis ** **
  *		telephone (na)
  *		mobile (na)
  *		commentaire (na)
  *		divers (na)
  *		ville_pro (na)
  *		code_postal_pro (na)
  *		pays_pro (na)
  */

 function adhclub_imp_field_associate($id_auteur,$data, $field_cible, $assoc_field, $table_source){
	global $tables_principales;
	$assoc=$assoc_field;
	if (!is_array($assoc)) $assoc = array();
	$csvfield=array_keys($table_source);
	foreach($csvfield as $k=>$v){
		$csvfield[$k] = adhclub_imp_nettoie_key($v);
	}
	$csvfield=array_flip($csvfield);


	// Assoc des cles specifiques
	// --------------------------
	// En creation
	if (!intval($id_auteur)) {
		$assoc['souscription']='creation';
		$assoc['nom']='nom';
		$assoc['prenom']='prenom';
		$assoc['civilite']='sexe';
		$assoc['naissance']='naissance';
		$assoc['licence']='fonction';
	}
	unset($csvfield['souscription']);
	unset($csvfield['nom']);
	unset($csvfield['prenom']);
	unset($csvfield['civilite']);
	unset($csvfield['naissance']);
	unset($csvfield['licence']);

	unset($field_cible['creation']);
	unset($field_cible['nom']);
	unset($field_cible['sexe']);
	unset($field_cible['naissance']);
	unset($field_cible['fonction']);

	// En creation et maj
	$assoc['adresse1']='adresse';
	unset($csvfield['adresse1']);
	unset($csvfield['adresse2']);
	unset($csvfield['adresse3']);
	unset($field_cible['adresse']);

	$assoc['cp']='code_postal';
	unset($csvfield['cp']);
	unset($field_cible['code_postal']);

	// Assoc des cles absentes de la source
	// ------------------------------------
	// En creation
	if (!intval($id_auteur)) {
		$assoc['login']='login';
		$assoc['source'] ='source';
	}
	unset($field_cible['login']);
	unset($field_cible['source']);
	
	// En creation et maj
	$assoc['nom_famille']='nom_famille';
	$assoc['email_corr']='email_corr';
	$assoc['divers'] ='divers';
	unset($field_cible['nom_famille']);
	unset($field_cible['email_corr']);
	unset($field_cible['divers']);
	
	
	//  Les champs Extras de spip_auteurs a prendre en compte
	// ------------------------------------------------------
	// En creation
	if (!intval($id_auteur)) {
		$assoc['certiflimite'] = 'certiflimite';
		$assoc['certifqualif'] = 'certifqualif';
		$assoc['certifaspirine'] = 'certifaspirine';
	}
	unset($field_cible['certiflimite']);
	unset($field_cible['certifqualif']);
	unset($field_cible['certifaspirine']);
	
	// TODO JR-20121030-Filtrer les cles de meme nom a ne pas toucher en maj ?
	//assoc auto des cles qui portent le meme nom
	foreach (array_keys($csvfield) as $csvkey){
		foreach(array_keys($field_cible) as $tablekey){
			if (strcasecmp($csvkey,$tablekey)==0){
				$assoc[$csvkey]=$tablekey;
				unset($csvfield[$csvkey]);
				unset($field_cible[$tablekey]);
				break;
			}
		}
	}
    
	//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_field_associate-Pt02.<br />";
	//echo "assoc= <br />"; var_dump($assoc); echo ".<br />";
	
return $assoc;
}

/**
 * Formattage email fictif provisoire dans $email_tmp.
 * 
 * Recherche meta(email_envoi) si present, 
 * sinon recherche meta(email_webmaster),
 * sinon 'adh_club@adhclub.com'.
 * 
 * Insertion id_auteur avant '@'.
 * 
 * @param int $id_auteur : id de l'auteur si maj ou 'new' si creation d'adherent
 * 
 * @return string $email_tmp : courriel fictif pour l'integrite de spip.
 */
function adhclub_imp_EMAIL_ENVOI($id_auteur) {

	$email_env = array();
	$adhfrom = "spip_meta";
    $adhwhere = "nom ='email_envoi'";
    $adhorderby ="";
    $adhlimit ="0,1";
    $email_env['env'] = sql_getfetsel( "valeur", $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
    
	if(!$email_env['env']){
    	$adhwhere = "nom ='email_webmaster'";
		$email_env['env'] = sql_getfetsel( "valeur", $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
	}
	
	if(!$email_env['env']){
		$email_env['env'] = "adh_club@adhclub.com";
	}

    //echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_EMAIL_ENVOI-Pt04.<br />";
	//echo "adhwhere= $adhwhere.<br />";
	//$field=$email_env['env'];
	//echo "email_env= $field.<br />";

	#$email_env['env']->interdire_scripts = true;

	$patterns = '/@/';
	$replacements = $id_auteur.'@';
	$email_env['tmp'] = preg_replace($patterns, $replacements, $email_env['env']);

	//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_EMAIL_ENVOI-Pt05.<br />";
	//echo "id_auteur= $id_auteur.<br />";
	//$field=$email_env['env'];
	//echo "email_env= $field.<br />";
	//$field=$email_env['tmp'];
	//echo "email_tmp= $field.<br />";
	
	return $email_env;
}


/**
 * Mise en forme d'email pour assurer l'integrite spip_auteurs :
 * 	- auteurs(email) doit etre unique.
 * 
 * Donc l'email pour les membres de la meme fratterie peut etre identique
 * 	dans le extra_champ(email_corr) permettant l'envoi de courriels massifs.
 * Pour le champ  auteurs(email), si besoin, un email fictif va etre cree
 * a partir de meta(email_envoi) ou mata(email_webmaster) complete
 * de id_auteur pour valider les controles.
 * Si creation, id_auteur='new' mais sera surcharge lors de maj qui suit par id_auteur reel.
 *
 * @param int $id_auteur : id de l'auteur si maj ou 'new' si creation d'adherent
 * @param string $email : courriel de correspondance
 * 
 * @return string $email : courriel pour l'integrite de spip.
 */

function adhclub_imp_email($id_auteur, $email){
	
	//	Recherche 1 auteur ayant un email identique
    $adhfrom = "spip_auteurs";
    $adhwhere = "email =".sql_quote($email);
    $adhorderby ="";
    $adhlimit ="0,1";
    $id_auteur_email = sql_getfetsel( "id_auteur", $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
    
    //echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_email-Pt02.<br />";
    //echo "id_auteur= $id_auteur.<br />";
    //echo "id_auteur_email= $id_auteur_email.<br />";
    
    if (intval($id_auteur_email)){
    //	Si email existe : 
    	if(intval($id_auteur_email) != intval($id_auteur)){
    	// C'est email d'un autre
			//	==> Formattage email fictif provisoire dans $email auteur=id_auteur.
			// Utiliser email webmaster si present comme base des email fictifs.
	    	// voir ecrire/public/balises.php ==> F(balise_EMAIL_WEBMASTER_dist)
    		// Sinon email fictif provisoire de la forme 'adh_club_auteur@adhclub.com'.
    		
    		$email_env=adhclub_imp_EMAIL_ENVOI($id_auteur);
			$email=$email_env['tmp'];
    		
			//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_email-Pt03.<br />";
    		//echo "id_auteur= $id_auteur.<br />";
    		//echo "email= $email.<br />";

    	}else{
    		// C'est email de l'auteur
    		// ==> Raf, on conserve email source

			//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_email-Pt04.<br />";
    		//echo "id_auteur= $id_auteur.<br />";
    		//echo "email= $email.<br />";
    	}
    }
    	//	Si existe pas : 
		//	Retour avec $email origine
	
return $email;
}

/**
 * Mise en forme des 3 lignes adresses pour n'en faire qu'1 seule.
 * 
 *
 * @param string $adresse, $adresse2 et $adresse3 : 3 lignes 
 * 
 * @return string $adresse : adresse regroupee.
 */

function adhclub_imp_adresse($adresse, $adresse2, $adresse3){
	
	// adresse (concatenation des 3 lignes)
	if(strlen(trim($adresse))>0){
		$adresse=trim($adresse);
	}
	if(strlen(trim($adresse2))>0){
		if(strlen($adresse)>0){
			$adresse=$adresse.' - '.trim($adresse2);
		}else{
			$adresse=trim($adresse2);
		}
	}
	if(strlen(trim($adresse3)>0)){
		if(strlen($adresse)>0){
			$adresse=$adresse.' - '.trim($adresse3);
				}else{
			$adresse=trim($adresse3);
		}
	}
	
return $adresse;
}

/**
 * remise en forme des champs specifiques associes
 * 		Ceux qui doivent etre importes
 *
 * @param $rec_ffessm{int}
 * @param $id_auteur{array}
 * @param $assoc_field{array}
 * 
 * @return $rec_creat
 */ 

function adhclub_imp_field_reformate($id_auteur, $assoc_field, $rec_ffessm){
	if (!is_array($rec_creat)) $rec_creat = array();
	
	//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_field_reformate-Pt10.<br />";
	//echo "array(rec_ffessm)<br />";
	//var_dump($rec_fessm);
	
	// Traitement des champs en entree (rec_ffessm)
	foreach(array_keys($assoc_field) as $tablekey){
	
		//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_field_reformate-Pt11.<br />";
		//echo "tablekey= $tablekey.<br />";
		//$field=$rec_ffessm[$tablekey];
		//echo "rec_ffessm(tablekey)= $field.<br />";
		
		switch($tablekey) {
		case 'souscription';
			// la date n'est pas dans la forme correcte
			$rec_creat[$tablekey]=substr($rec_ffessm[$tablekey],6,4)
				.'-'.substr($rec_ffessm[$tablekey],3,2)
				.'-'.substr($rec_ffessm[$tablekey],0,2);
			//unset($assoc_field[$tablekey]);
			break;
			
		case 'prenom';
			$patterns = '/ /';
			$replacements = '-';
			$prenom = preg_replace($patterns, $replacements, $rec_ffessm[$tablekey]);
			// TODO voir F() ucfirst($prenom) ??
			$rec_creat[$tablekey] =
				strtoupper(substr($prenom,0,1))
				. strtolower(substr(trim($prenom),1));
			//unset($assoc_field[$tablekey]);
			break;
			
		case 'nom';
			// chargement du nom car ne passera pas dans default
			// C'est le pseudo (Prenom dot Nom)
			$patterns = '/ /';
			$replacements = '.';
			$prenom = preg_replace($patterns, $replacements, $rec_ffessm['prenom']);
			$nom = preg_replace($patterns, $replacements, $rec_ffessm[$tablekey]);
			// TODO voir F() ucfirst($prenom) ??
			$rec_creat[$tablekey]=
				strtoupper(substr($prenom,0,1))
				. strtolower(substr(trim($prenom),1))
				. '.' 
				. strtoupper(substr($nom,0,1))
				. strtolower(substr(trim($nom),1));
			//unset($assoc_field[$tablekey]);
			break;
		
		case 'nom_famille';
			$patterns = '/ /';
			$replacements = '-';
			$rec_creat[$tablekey] = preg_replace($patterns, $replacements, $rec_ffessm['nom']);
			//unset($assoc_field[$tablekey]);
			break;
		
		case 'login';
			// login (2 premieres lettres du prenom suivi de nom simple(1er))==> voir inscription2_definir_login','inc'
			$lengthname=stripos(trim($rec_ffessm['nom']), '/ /');
			if ($lengthname=false){
				$nom=trim($rec_ffessm['nom']);
			}else{
				$nom=substr(trim($rec_ffessm['nom']),0,$lengthname);
			}
				$rec_creat['login']=
				strtolower(substr($rec_ffessm['prenom'],0,2))
				. strtolower(trim($rec_ffessm['nom']));

			//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_field_reformate-Pt221.<br />";
			//$field=$rec_creat['login'];
			//echo "rec_creat(login)= $field.<br />";
			
			//unset($assoc_field[$tablekey]);
			break;
		
		case 'email_corr';
			// email_corr (= email si existe pas, genere virtuellement sinon)
			if($rec_ffessm['email']){
				$rec_creat[$tablekey]=$rec_ffessm['email'];
			}else{
				$rec_creat[$tablekey]=adhclub_imp_email($id_auteur, $rec_ffessm['email']);
			}
			//unset($assoc_field[$tablekey]);
			break;
		
		case 'email';
			// email (= email si existe pas, genere virtuellement sinon)
			if($rec_ffessm['email']){
				$rec_creat[$tablekey]=$rec_ffessm['email'];
			}else{
				$rec_creat[$tablekey]=adhclub_imp_email($id_auteur, $rec_ffessm[$tablekey]);
			}
			//unset($assoc_field[$tablekey]);
			break;

		case 'civilite';
			// sexe (civilite M=>M, Mlle=>F, Mme=>F)
			switch($rec_ffessm[$tablekey]) {
			case 'Mme';
				$rec_creat[$tablekey]='F';
				break;
			case 'Mlle';
				$rec_creat[$tablekey]='F';
				break;
			case 'M';
				$rec_creat[$tablekey]='M';
				break;
				default;
				$rec_creat[$tablekey]=$rec_ffessm[$tablekey];
				break;
			}
			//unset($assoc_field[$tablekey]);
			break;
			
		case 'naissance';
			// la date n'est pas dans la forme correcte
			$rec_creat[$tablekey]=substr($rec_ffessm[$tablekey],6,4)
				.'-'.substr($rec_ffessm[$tablekey],3,2)
				.'-'.substr($rec_ffessm[$tablekey],0,2);
			//unset($assoc_field[$tablekey]);
			break;
			
		case 'adresse1';
			$rec_creat[$tablekey]=adhclub_imp_adresse($rec_ffessm[$tablekey], $rec_ffessm['adresse2'], $rec_ffessm['adresse3']);
			//unset($assoc_field[$tablekey]);
			//unset($assoc_field['adresse2']);
			//unset($assoc_field['adresse3']);
			break;
			
		case 'pays';
			// Le chargement du pays ne doit pas passer dans default
			// TODO JR-20121030-La recherche du pays devrait passer par plugin Pays ISO 3166-1.
			// Solution provisoire
			switch($rec_ffessm[$tablekey]) {
			case 'FRANCE';
				$rec_creat[$tablekey]='314';
				break;
			default;
				$rec_creat[$tablekey]='00';
				break;
			}
			//unset($assoc_field[$tablekey]);
			break;
			
		// Traitement des champs complementaires
		case 'source';
			// source (spip) pour indiquer que c'est 1 fiche interne et non de source externe.
			$rec_creat[$tablekey]='spip';
			//unset($assoc_field[$tablekey]);
			break;
			
		case 'divers';
			// divers (adhclub) pour indiquer que c'est le plugin a touche a la fiche.
			$rec_creat[$tablekey]='adhclub';
			//unset($assoc_field[$tablekey]);
			break;
			
			case 'certiflimite';
			// certiflimite (0000-00-00)
			$rec_creat[$tablekey]='0000-00-00';
			//unset($assoc_field[$tablekey]);
			break;
			
		case 'certifqualif';
			// certifqualif ('')
			$rec_creat['$tablekey']='';
			break;
			
		case 'certifaspirine';
			// certifaspirine ('non')
			$rec_creat['certifaspirine']='';
			break;
			
		// Traitement des champs ordinaires, sans reprise de donnée
		default;
			$rec_creat[$tablekey]=$rec_ffessm[$tablekey];
			break;
		}
	}
	
	return $rec_creat;
}

/**
 * Insertion des donnees adherent dans les tables auteurs et auteurs_elargis
 * 	Avec les controles specifiques.
 * 
 * @param array $data = Enregistrement pour creation
 * @param array $tables = liste des tables a traiter
 * @param array $assoc_field = association des champs enreg > tables
 * @param array &$creaerr = liste des erreurs
 * 
 * @return array $auteur
 */
function adhclub_imp_ajoute_table($data, $tables, $assoc_field, &$creaerr){
	$creaerr = array();
	$assoc = array_flip($assoc_field);
	
	$field_cible = adhclub_imp_table_fields($tables, 'unique');
	
	//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_ajoute_table-Pt5.<br />";
	//$field=$data['nom'];
	//echo "data(nom)= $field.<br />";
	//$field=$assoc_field['nom'];
	//echo "assoc_field(nom)= $field.<br />";
	
	list($auteurs,$auteurs_elargis) = adhclub_imp_table_fields($tables, 'separe');
		
	$auteurs_obligatoires = array('nom','login','email','statut');

	if ($data!=false){
		$count_lignes = 0;
		$verifier = charger_fonction('verifier','inc',true);
		$champs_a_verifier = pipeline('i3_verifications_specifiques');
		
		//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_ajoute_table-Pt7.<br />";
		//echo "field_cible= <br />"; var_dump($field_cible); echo ".<br />";
		//echo "champs_a_verifier= <br />"; var_dump($champs_a_verifier); echo ".<br />";
		
		
			$auteurs_insert = array();
			//$auteurs_elargis_insert = array();
			$check = array_flip($field_cible);
			foreach($check as $key=>$value){

				$kc = adhclub_imp_nettoie_key($key);
				$data[$assoc[$kc]] = trim($data[$assoc[$kc]]);

				if ((isset($value))&&(isset($data[$assoc[$kc]]))){
					// On verifie tout d'abord si le champ dispose d'une fonction de validation
					if(array_key_exists($key,$champs_a_verifier)){
						$type = $champs_a_verifier[$key];
						$type['options']['id_auteur'] = $id_auteur;
						$type['options'] = array_merge($type['options'],$_GET);
						if($val = $verifier($data[$assoc[$kc]],$type['type'],$type['options'])){
							$creaerr[$key] = $val;
						}
					}
					
					// Si pas d'erreur sur ce champ on verifie qu'il soit obligatoire
					if(!isset($creaerr[$key])){
						if(in_array($key,$auteurs)){
							if(in_array($key,$auteurs_obligatoires) && (strlen($data[$assoc[$kc]])==0)){
								$creaerr[$key] = _T("adhclub:champs_oblig",array('champs'=>$key));
							}
							$auteurs_insert[$key] = $data[$assoc[$kc]];
							$auteur[$key] = $data[$assoc[$kc]];
						}
						else{
							//$auteurs_elargis_insert[$key] = $data[$assoc[$kc]];
							$auteurs_insert[$key] = $data[$assoc[$kc]];
							$auteur[$key] = $data[$assoc[$kc]];
						}
					}
					unset($check[$key]);
				}
			}
	
	 		if(count($creaerr,COUNT_RECURSIVE) == 0){
	 			if(count($auteurs_insert)){
					// Verifier les donnees
					// On ajoute la date de MAJ qui correspond a maintenant
					$auteurs_insert['maj'] = date('Y-m-d H:i:s');
					// Le statut est obligatoire ... donc on le rajoute s'il n'est pas dans le fichier
					if(!isset($auteurs_insert['statut'])){
						$auteurs_insert['statut'] = lire_config('inscription3/statut_nouveau')?lire_config('inscription3/statut_nouveau'):'6forum';
					}
					// Le login est obligatoire ... S'il n'est pas present, on le genere a partir du nom et de l'email
					if(!isset($auteurs_insert['login'])){
						$definir_login = charger_fonction('inscription3_definir_login','inc');
						$auteurs_insert['login'] = $definir_login($auteurs_insert['nom'],$auteurs_insert['email']);
					}
	 				if(isset($auteurs_elargis['creation']) && !isset($auteurs_insert['creation'])){
						$auteurs_insert['creation'] = date('Y-m-d H:i:s');
					}
					$auteur['id_auteur'] = sql_insertq('spip_auteurs',$auteurs_insert);
	 			}
			}else{
				unset($auteur);
			}
	
			//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_ajoute_table-Pt9.<br />";
			//$field=$auteurs_insert['nom'];
			//echo "auteurs_insert(nom)= $field.<br />";
			//$field=$auteurs_insert['statut'];
			//echo "auteurs_insert(statut)= $field.<br />";
			//$field=$auteurs_insert['source'];
			//echo "auteurs_insert(source)= $field.<br />";
			
			//$field=$auteurs_elargis_insert['nom_famille'];
			//echo "auteurs_elargis_insert(nom_famille)= $field.<br />";
			//$field=$auteurs_elargis_insert['fonction'];
			//echo "auteurs_elargis_insert(fonction)= $field.<br />";
			//$field=$auteurs_elargis_insert['creation'];
			//echo "auteurs_elargis_insert(creation)= $field.<br />";
			
			//$field=$auteur['id_auteur'];
			//echo "auteur(id_auteur)= $field.<br />";
			
	}
	// JR-20121019-Pb d'appel via reference.
	//return array($creaerr,$auteur);
	return array($auteur);
}

/**
 * Maj des donnees des tables auteurs et auteurs_elargis
 * Tous les champs ne sont pas maj.
 * 
 * @param array $data
 * @param array $tables
 * @param array $assoc_field
 * @param array &$majerr
 * 
 * @return array $auteur
 */
function adhclub_imp_maj_table($id_auteur, $data, $tables, $assoc_field, &$majerr){
	$majerr = array();
	$auteur = array();
	$assoc = array_flip($assoc_field);

	
	//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_maj_table-Pt01.<br />";
	//echo "id_auteur= $id_auteur.<br />";
	
	list($auteurs,$auteurs_elargis) = adhclub_imp_table_fields($tables, 'separe');
	
	//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_maj_table-Pt05.<br />";
	//echo "id_auteur= $id_auteur.<br />";
	//$field=$data['adresse1'];
	//echo "data(adresse1)= $field.<br />";
	//$field=$data['email'];
	//echo "data(email)= $field.<br />";
	//$field=$data['email_corr'];
	//echo "data(email_corr)= $field.<br />";
	
	$auteurs_obligatoires = array('email');

	if ($data!=false){
		$count_lignes = 0;
		$verifier = charger_fonction('verifier','inc',true);
		$champs_a_verifier = pipeline('i3_verifications_specifiques');

		$auteurs_update = array();
		$auteurs_elargis_update = array();
		// on utilise directement la table d'associaton pour les seuls champs a mettre à jour.
		foreach($assoc as $key=>$value){

			$kc = adhclub_imp_nettoie_key($key);
			$data[$assoc[$kc]] = trim($data[$assoc[$kc]]);

			if ((isset($value))&&(isset($data[$assoc[$kc]]))){
				// On verifie tout d'abord si le champ dispose d'une fonction de validation
				if(array_key_exists($key,$champs_a_verifier)){
					$type = $champs_a_verifier[$key];
					$type['options']['id_auteur'] = $id_auteur;
					$type['options'] = array_merge($type['options'],$_GET);
					if($val = $verifier($data[$assoc[$kc]],$type['type'],$type['options'])){
						$majerr[$key] = $val;
					}
				}
		
				// Si pas d'erreur sur ce champ on verifie qu'il soit obligatoire [auteurs seulement]
				if(!isset($majerr[$key])){
					if(in_array($key,$auteurs)){
						if(in_array($key,$auteurs_obligatoires) && (strlen($data[$assoc[$kc]])==0)){
							$majerr[$key] = _T("adhclub:champs_oblig",array('champs'=>$key));
						}
						$auteurs_update[$key] = $data[$assoc[$kc]];
						$auteur[$key] = $data[$assoc[$kc]];
					}else{
						$auteurs_update[$key] = $data[$assoc[$kc]];
						$auteur[$key] = $data[$assoc[$kc]];
					}
				}
				unset($assoc[$key]);
			}
		}
		
		//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_maj_table-Pt14.<br />";
		//echo "id_auteur= $id_auteur.<br />";
		//$field=count($majerr,COUNT_RECURSIVE);
		//echo "count(erreur)= $field.<br />";
		
		if(count($majerr,COUNT_RECURSIVE) == 0){
			if(count($auteurs_update)){
				// Forcer les donnees par défaut
				// On ajoute la date de MAJ qui correspond a maintenant
				$auteurs_update['maj'] = date('Y-m-d H:i:s');
				
				//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_maj_table-Pt15.<br />";
				//echo "id_auteur= $id_auteur.<br />";
				
				sql_updateq('spip_auteurs',$auteurs_update,"id_auteur=". intval($id_auteur));
				$auteur['id_auteur'] = $id_auteur;
			}
		}else{
	
			//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_maj_table-Pt25.<br />";
			//echo "id_auteur= $id_auteur.<br />";
			
			unset($auteur);
		}

		//echo "<br />.XXX debug JR : inc/adh_import adhclub_imp_maj_table-Pt55.<br />";
		//echo "id_auteur= $id_auteur.<br />";
		//$field=$auteur['id_auteur'];
		//echo "auteur(id_auteur)= $field.<br />";

	}

return array($auteur);
}

?>