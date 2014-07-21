<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2012                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

/* D'apres spip 2.1.16 squelette-dist/formulaire
*
*	Pour permettre lors du chargement du formulaire, la recuperation de email_corr de auteur
*		a la place de email.
*
*	JR-17/07/2012-Revue email - email-corr dans php formulaires_ecrire_auteur_charger_dist.
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_ecrire_auteur_charger($id_auteur, $id_article, $mail, $email_corr){
	include_spip('inc/texte');
	$puce = definir_puce();
	$email = $email_corr;
	$valeurs = array(
		'sujet_message_auteur'=>'',
		'texte_message_auteur'=>'',
		'email_message_auteur'=>$GLOBALS['visiteur_session']['email']
	);
	
	// id du formulaire (pour en avoir plusieurs sur une meme page)
	$valeurs['id'] = ($id_auteur ? '_'.$id_auteur : '_ar'.$id_article);
	// passer l'id_auteur au squelette
	$valeurs['id_auteur'] = $id_auteur;
	$valeurs['id_article'] = $id_article;
	
	return $valeurs;
}

?>
