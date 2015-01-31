<?php
/**
 * Plugin adhclub : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *----------------------------------------------
 * Formulaire d'integration des donnees de la table adhintgs 
 *	vers les tables auteurs et adhcotis_liens.
 *----------------------------------------------
 * @todo-JR-20120216-Verifier l'affichage des erreurs car c'est une liste
 * 
 * Fait :
 * JR-31/01/2015-Adaptation a spip 3.0
 */ 

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');

/**
 * Charger le formulaire 
 *  @param string titre_saison :
 *  	Le 'titre saison' provient de la liste des adherents presents
 *      dans la table 'adhintgs' (dernier enregistrement).
 *      Il est passe en argument d'appel au formulaire.
 *  @return array 
 *  	int id_saison : 
 *  		No de la saison correspondant a 'titre saison' si encours.
 *  	string ref_saisie : 
 *  		Valeur numerique de la derniere reference trouvee 
 *  		pour la saison, incrementee de 1. 
*/
function formulaires_integ_adhintg_charger_dist($titre_saison){
	//// INFO / RAPPEL :
	/* sql_fetsel(...) = Retourne la première ligne d’une selection sql.
		La fonction est identique à sql_fetch(sql_select(...))*/
	/* sql_getfetsel(...) = Retourne l'unique champ demandé dans une requête Select à résultat unique.
		Retourne le premier champ de la première ligne d’une sélection sql.
		La fonction est équivalente à $r = sql_fetsel(...)); return $r ? $r[0] : false; */
	/* '_q()' est remplacé par 'sql_quote()' pour échapper les champs non numeriques dans les syntaxes de requêtes SQL
		intval() est utilisé pour les champs numeriques */
	
    
    // Retrouver la saison dans la table 'adhsaison' et verifier que c'est une saison active.
    $adhwhere = "titre =".trim($titre_saison)." && encours ='oui'";
    $id_saison = sql_getfetsel( "id_saison", "spip_adhsaisons", $adhwhere);
 
    if (!intval($id_saison)) {
        $erreurs['message_erreur'] = _T('adhsaison:info_aucun_adhsaison_integ',array('titre_saison'=>$titre_saison));
        return $erreurs;
        }
    else {
        
        /* Retrouver la derniere reference utilisee pour la saison courante dans la table 'adhcotis_auteurs'.
            - Si reference identifiee, faire +1,
            - Si pas de reference, forcer la valeur par defaut = 1.
        */
        $adhfrom = "spip_adhcotis_liens, spip_adhcotis";
        $adhwhere = array(
        	"id_saison =".intval($id_saison),
        	"objet = 'auteur'",
        	);
        $adhgroupby ="ref_saisie";
        $adhorderby ="ref_saisie desc";
        $adhlimit ="1";
        $ref_saisie = sql_getfetsel( "ref_saisie", $adhfrom, $adhwhere, $adhgroupby, $adhorderby, $adhlimit);
        if (!intval($ref_saisie)) {
            $ref_saisie = 1;
            }
        else {
            $ref_saisie = intval($ref_saisie) + 1;
            }
        
        /* Retourner les valeurs du formulaire.
        */
        $valeurs = array('id_saison'=>intval($id_saison),'ref_saisie'=>$ref_saisie,'id_coti'=>'');
        
        }
        
 	return $valeurs;
}

function integ_adhintg_edit_config(){
	return array();
}

/**
 * Verifier le formulaire 
*/
function formulaires_integ_adhintg_verifier_dist(){
	$erreurs = array();
    
    // Verifier que les champs obligatoires sont bien presents :
    foreach(array('ref_saisie', 'id_coti') as $obligatoire)
        if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';

    if(count($erreurs))
        $erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	
    return $erreurs;

}


/**
 * Traiter le formulaire 
*/
function formulaires_integ_adhintg_traiter_dist($titre_saison, $retour='', $config_fonc='integ_adhintg_edit_config', $row=array(), $hidden=''){

	$ref_saisie = _request('ref_saisie');
	$id_coti = intval(_request('id_coti'));

	$message = "";
	$exec_import = charger_fonction("import_edit",'exec');

// @todo-JR-20120216-Verifier l'affichage des erreurs car c'est une liste
//	Chaque enreg peut etre en erreur !!
//	voir inc/adh_import.adh_import_show_erreurs
	list($id,$err) = $exec_import($ref_saisie, $id_coti);

	if ($err){
		$message .= $err;
	}
	elseif ($retour) {
		//include_spip('inc/headers');
		$retour = parametre_url($retour,'ref_saisie',$id);
		$message .= redirige_formulaire($retour);
	}
	return $message;
}

?>
