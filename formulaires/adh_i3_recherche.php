<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *	( tres vilement pompe de inscription3 par cmtmt2003, kent1, BoOz and co
 *	Licence (c) 2007-2012 - Distribue sous licence GNU/GPL v3)
 * D'apres incription3 Version : 3.0.15 SVN (6342), module formulaires/inscription3_recherche.php
 *
 * ----------------------------------------------
 * Recherche des auteurs basee sur les criteres inscription3 et adhclub. 
 * ----------------------------------------------
 * A faire :
 * -------
 * JR-23/03/2013-Traiter 'exporter_liste'.
 * 
 * Fait :
 * ----
 * JR-10/01/2015-adaptation spip 3.0.
 * JR-12/03/2013-Ajout des criteres niveau relatif.
 * JR-11/01/2013-Ajout des criteres adhclub.
 * JR-12/08/2012-Creation du squelette.
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip("inc/adh_import");
include_spip("balise/tipafriend");
include_spip("inc/headers");


/**
 * Chargement des valeurs par defaut des champs du formulaire
 * 
 * @param  string $type_objet[facultatif] objet editorial spip
 * @param int $id_objet[facultatif] identifiant de l'objet
 * @param boolean $adh_i3_rech_ok si au moins 1 critere de recherche saisis.
 * 
 */
function formulaires_adh_i3_recherche_charger_dist($type_objet, $id_objet){

	/*$debug1= "DEBUG adhclub JR : formulaires/adh_i3_recherche formulaires_adh_i3_recherche_charger_dist - Pt01 - ";
	adhclub_log("$debug1.", true);*/
	
	// Recuperation des parametres transmis
	$datas['type_objet'] = $type_objet;
	$datas['id_objet'] = $id_objet;
	
	
	// Recuperation des champs du formulaire
	// ==> lies a adhclub :
	$datas['id_saison'] = _request('id_saison');
	$datas['techbase'] = _request('techbase');
	$datas['encadrant'] = _request('encadrant');
	$datas['niveau'] = _request('niveau');
	$datas['niv_rel'] = _request('niv_rel');
	
	// ==> lies a i3 :
	$datas['ordre'] = _request('ordre');
	$datas['desc'] = _request('desc');
	$datas['case'] = _request('case');
	$datas['valeur'] = _request('valeur');

	$datas['exceptions'] = pipeline('i3_exceptions_des_champs_auteurs_elargis',array());

	// Raz des criteres si demande affichage tous les adherents
	if(_request('afficher_tous')){
		// ==> lies a adhclub :
		set_request('id_saison','');
		set_request('techbase','');
		set_request('encadrant','');
		set_request('niveau','');
		set_request('niv_rel','');
		
		// ==> lies a i3 :
		set_request('valeur','');
		set_request('case','');
	}

	/*$debug1= "DEBUG adhclub JR : formulaires/adh_i3_recherche formulaires_adh_i3_recherche_charger_dist - Pt99 - ";
	adhclub_log("$debug1.", true);
	$debug1= "id_saison=" . _request('id_saison');
	adhclub_log("$debug1.", true);*/
	
	return $datas;
}

/**
 * Verification du formulaire
 * @return
 */
function formulaires_adh_i3_recherche_verifier_dist($type_objet, $id_objet){
	global $visiteur_session;
	global $email_env;

	if(_request('mailer_liste')){
		
		$auteurs_checked = _request('check_aut');
		if(is_array($auteurs_checked)){
			//include_spip('inc/autoriser');
			foreach($auteurs_checked as $key=>$val){
				$email_envoi = sql_fetsel('nom_famille, prenom, email','spip_auteurs','id_auteur='.intval($val));
				// Recherche email_envoi ou email webmaster pour détecter les emails inactifs
				$email_env = adhclub_imp_EMAIL_ENVOI(intval($val));

				/*$debug1= "DEBUG adhclub JR : formulaires_adh_i3_recherche - formulaires_adh_i3_recherche_verifier - Pt06 - ";
				adhclub_log("$debug1.", "adhclub");*/
				
				if($email_envoi['email'] == $email_env['tmp']){
					$erreurs['check_aut'.$val] = 
						array('nom' => $email_envoi['nom_famille'],
								'prenom' => $email_envoi['prenom'],
								'email' => $email_envoi['email']);
				}
			}
			if(count($erreurs)>0){
				foreach($erreurs as $erreur=>$infos){
					$infos_erreurs = "<p>"._T('adhclub:erreur_email',$infos)."</p>";
				}
				$erreurs['message_erreur'] = "<p>"._T('adhclub:erreur_envoi_email')."</p>";
				$erreurs['message_erreur'] .= $infos_erreurs;
			}
		}else{
			$erreurs['message_erreur'] = _T('adhclub:no_user_selected');
		}
	}
	
    return $erreurs;
}

/**
 * Traitement du formulaire
 * @return $retour
 */
function formulaires_adh_i3_recherche_traiter_dist($type_objet, $id_objet){
	global $email_env;
	
	$retour = array();
	if(_request('exporter_liste')){

		// Recuperation des parametres
		$criteres = '';
		$criteres = $criteres . _request('case');
		$criteres = $criteres . '|' . _request('valeur');
		$criteres = $criteres . '|' . _request('id_saison');
		$criteres = $criteres . '|' . _request('techbase');
		$criteres = $criteres . '|' . _request('encadrant');
		$criteres = $criteres . '|' . _request('niveau');
		$criteres = $criteres . '|' . _request('niv_rel');
		
		/*$debug1= "DEBUG adhclub JR : formulaires_adh_i3_recherche - formulaires_adh_i3_recherche_traiter - Pt05 - ";
		adhclub_log("$debug1.", true);
		adhclub_log("criteres= $criteres.", true);
		adhclub_log("$debug1 FIN.", true);*/
		
		$retour['redirect'] = generer_url_ecrire("adh_auteurs_export","criteres=$criteres&retour=".urlencode(self()));
					
	}
	
	
	if(_request('mailer_liste')){
		$auteurs_checked = _request('check_aut');
		$destinataires='';
		$nb_auteurs = 0;
		if(is_array($auteurs_checked)){
			foreach($auteurs_checked as $key=>$val){
				$email_envoi = sql_getfetsel('email','spip_auteurs','id_auteur='.intval($val));
				$destinataires .= $email_envoi . ';';

				/*$debug1= "DEBUG adhclub JR : formulaires_adh_i3_recherche - formulaires_adh_i3_recherche_traiter - Pt08 - ";
				adhclub_log("$debug1.", true);
				adhclub_log("email_envoi=$email_envoi");
				adhclub_log("destinataires=$destinataires.");
				adhclub_log("$debug1. FIN", true);*/
				
				++$nb_auteurs;
			}

			$contexte_mail = array(
					'objet' => $type_objet, // type d'objet spip
					'id_objet' => $id_objet, // ID de l'objet
					'lang' => '', // langue (opt)
					'squelette' => 'mini', // type de squelette ou nom du squelette (opt)
					'url' => '', // URL a utiliser (opt)
					'mex' => $email_env['env'], // mail exped (opt)
					'nex' => $email_env['env'], // nom exped (opt)
					'mdes' => $destinataires // mail(s) destinataire(s) (opt)
					);

			/*$debug1= "DEBUG adhclub JR : formulaires_adh_i3_recherche - formulaires_adh_i3_recherche_traiter - Pt10 - ";
			adhclub_log("$debug1.");
			$debug1="objet=" . $contexte_mail['objet'];
			adhclub_log("$debug1.");
			$debug1="id_objet=" . $contexte_mail['id_objet'];
			adhclub_log("$debug1.");
			$debug1="mex=" . $contexte_mail['mex'];
			adhclub_log("$debug1.");
			$debug1="mdes=" . $contexte_mail['mdes'];
			adhclub_log("$debug1.");*/

			//echo recuperer_fond('modeles/tipafriend_typo', $contexte_mail);
			//recuperer_fond('modeles/tipafriend_typo', $contexte_mail);
				
		}else{
			// Rien a faire
		}
		if($nb_auteurs > 1)
			$retour['message_ok'] = _T('adhclub:mailer_message_users_nb',array('nb'=>$nb_auteurs));
		else
			$retour['message_ok'] = _T('adhclub:mailer_message_users_un');
	}

	
	
    return $retour;
}
?>
