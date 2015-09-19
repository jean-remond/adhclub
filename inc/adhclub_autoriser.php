<?php
/**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 *
 * Licence GPL (c) 2013-2015 Jean Remond
 * --
 * Toutes les autorisations utiles pour le plugin.
 * --
 * @todo : 
 * Fait:
 * JR-31/08/2015-Ajout pour les champs extras du plugin.
 * JR-10/01/2015-adaptation spip 3.0.
 */

/* pour que le pipeline ne rale pas ! */
function adhclub_autoriser(){}


/**
 * Autorisation a voir les auteurs
 * 
 * - Si webmaster (0minirezo) ou redacteur (1comite)
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
// seuls les rédacteurs et admins peuvent voir
function autoriser_auteur_voirextra_certifaspirine_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_certiflimite_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_certifqualif_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_email_corr_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_profession_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_fonction_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_code_postal_pro_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_ville_pro_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_pays_pro_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}
function autoriser_auteur_voirextra_divers_dist() {
	return in_array($qui['statut'], array('0minirezo', '1comite'));
}

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
function autoriser_auteur_creerassurdans($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
// seuls les admins peuvent modifier
function autoriser_auteur_modifierextra_certifaspirine_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_certiflimite_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_certifqualif_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_email_corr_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_profession_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_fonction_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_code_postal_pro_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_ville_pro_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_pays_pro_dist() {
	return in_array($qui['statut'], array('0minirezo'));
}
function autoriser_auteur_modifierextra_divers_dist() {
	return in_array($qui['statut'], array('0minirezo'));
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
function autoriser_adhassur_modifier($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhassur_supprimer($faire,$quoi,$id,$qui,$opts){
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
 * Autorisation a administrer les cotisations
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhcoti_voir($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhcoti_modifier($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhcoti_supprimer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhcoti_retirer($faire,$quoi,$id,$qui,$opts){
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
function autoriser_adhniv_voir($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhniv_modifier($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhniv_supprimer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhniv_retirer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}


/**
 * Autorisation sur les saisons
 *
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 * @return unknown
 */
function autoriser_adhsaison_voir($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhsaison_modifier($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo')
		return true;
	return false;
}
function autoriser_adhsaison_supprimer($faire,$quoi,$id,$qui,$opts){
	if ($qui['statut']=='0minirezo' AND !$qui['restreint']){
		include_spip('base/abstract_sql');
		if (sql_getfetsel("encours","spip_adhsaisons","id_saison=".intval($id))=="non")
			return true;
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
