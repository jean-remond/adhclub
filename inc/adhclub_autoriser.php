<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 *  JR-10/01/2015-adaptation spip 3.0.
 */

/* pour que le pipeline ne rale pas ! */
function adhclub_autoriser(){}


/**
 * Autorisation a administrer les auteurs
 * 
 * - Si webmaster
 * ==> A faire :
 * - Si session[id_auteur] appartient à 1 niveaux dont techbase ='SEC'  
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_auteur_administrer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}


/**
 * Autorisation pour les assurances
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhassur_voir($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhassur_creer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhassur_modifier($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhassur_retirer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}


/**
 * Autorisation a administrer les assurances
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhassur_administrer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}


/**
 * Autorisation a administrer les cotisations
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhcoti_administrer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}


/**
 * Autorisation a administrer les niveaux
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhniv_administrer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}

/**
 * Autorisation a administrer les saisons
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhsaison_administrer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo' AND !$qui['restreint'])
		return true;
	return false;
}


/**
 * Autorisation a supprimer les saisons
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhsaison_supprimer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo' AND !$qui['restreint']){
		include_spip('base/abstract_sql');
		if (sql_getfetsel("encours","spip_adhsaisons","id_saison=".intval($id))=="non") return true;
	}
	return false;
}


/**
 * Autorisation a affecter les assurances a un auteur
 * si un id_assur passe dans opts, cela concerne plus particulierement le droit d'affecter cette assurance
 *
 * @param unknown_type $faire
 * @param unknown_type $qui
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_auteur_affecterassurs_dist($faire,$quoi,$id,$qui,$opts){
	if (!autoriser('modifier','auteur',$id)) return false;
	if ($qui['statut']=='0minirezo')
		return true;
	# les non admin ne peuvent pas s'administrer eux meme pour eviter les erreurs
	if ($id == $qui['id_auteur']) return false;
    return true;
}


/**
 * Autorisation a affecter les cotisations a un auteur
 * si un id_coti passe dans opts, cela concerne plus particulierement le droit d'affecter cette cotisation
 *
 * @param unknown_type $faire
 * @param unknown_type $qui
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_auteur_affectercotis_dist($faire,$quoi,$id,$qui,$opts){
	if (!autoriser('modifier','auteur',$id)) return false;
	if ($qui['statut']=='0minirezo')
		return true;
	# les non admin ne peuvent pas s'administrer eux meme pour eviter les erreurs
	if ($id == $qui['id_auteur']) return false;
    return true;
}


/**
 * Autorisation a affecter les niveaux a un auteur
 * si un id_niveau passe dans opts, cela concerne plus particulierement le droit d'affecter ce niveau
 *
 * @param unknown_type $faire
 * @param unknown_type $qui
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */ 
function autoriser_auteur_affecterniveaux_dist($faire,$quoi,$id,$qui,$opts){
	if (!autoriser('modifier','auteur',$id)) return false;
	if ($qui['statut']=='0minirezo')
		return true;
	# les non admin ne peuvent pas s'administrer eux meme pour eviter les erreurs
	if ($id == $qui['id_auteur']) return false;
/*	# les non admin ne peuvent affecter que les niveaux dont ils font partie
	include_spip('inc/adh_club');
	if ($opts['id_niveau']
	  AND !adhclub_test_niveau_de_auteur($opts['id_niveau'], $qui['id_auteur']))
	  return false; */
 return true;
}


?>
