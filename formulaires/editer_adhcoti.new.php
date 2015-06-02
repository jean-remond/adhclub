<?php
 /**
 * Plugin adh_club : Adherent Club pour Spip 3.0
 * Licence GPL (c) 2011-2015 Jean Remond
 * ----------------------------------------------
 * Saisie des cotisations du club associables aux adherents
 * ----------------------------------------------
 * JR-17/01/2015-Adaptation spip 3.0.
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_adhcoti_charger_dist($id_coti='new', $retour='', $config_fonc='cotis_edit_config', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('adhcoti',$id_coti,0,0,$retour,$config_fonc,$row,$hidden);
	
	if (!autoriser("webmestre")) {
		$valeurs['editable'] = false;
	}

	// Preparation des saisies
	$valeurs['saisie_commune'] = editer_adhcoti_saisie_commune();
	
	return $valeurs;
}

function cotis_edit_config(){
	return array();
}


function formulaires_editer_adhcoti_verifier_dist($id_coti='new', $retour='', $config_fonc='cotis_edit_config', $row=array(), $hidden=''){

	$erreurs = formulaires_editer_objet_verifier('adhcoti',$id_coti,array('titre', 'descriptif', 'mnt_cotis', 'id_saison'));
	
	return $erreurs;
}


function formulaires_editer_adhcoti_traiter_dist($id_coti='new', $retour='', $config_fonc='cotis_edit_config', $row=array(), $hidden=''){

	$message = "";
	$action_editer = charger_fonction("editer_adhcoti",'action');
	list($id,$err) = $action_editer();
	if ($err){
		$message .= $err;
	}
	elseif ($retour) {
		include_spip('inc/headers');
		$retour = parametre_url($retour,'id_coti',$id);
		$message .= redirige_formulaire($retour);
	}
	return $message;
}

/**
 * Declaration des saisies du formulaire.
 * 
 * @return array $mes_saisies..
 */
function editer_adhcoti_saisie_commune() {
	$saisie_commune = array(
		array( // le fieldset
			'saisie' => 'fieldset',
			'options' => array(
				'nom' => 'commune'
			),
			'saisies' => array( // les champs dans le fieldset
				array( // titre
					'saisie' => 'input',
					'options' => array(
						'nom' => 'titre',
						'label' => _T('adhcoti:titre_adhcoti'),
						'explication' => _T('adhcoti:titre_exp_adhcoti'),
						'size' => '35',
						'obligatoire' => 'oui'
					),
					'verifier' => array(
						'type' => 'taille',
						'options' => array (
							min => 2, max => 35
						)
					),
				),
				array( // descriptif
					'saisie' => 'textarea',
					'options' => array(
						'nom' => 'descriptif',
						'label' => _T('adhclub:descriptif'),
						'rows' => '3',
						'obligatoire' => 'non'
					),
				),
				array( // Montant cotisation
					'saisie' => 'input',
					'options' => array(
						'nom' => 'mnt_cotis',
						'label' => _T('adhcoti:mnt_adhcoti'),
						'size' => '7',
						'obligatoire' => 'oui'
					),
					'verifier' => array(
						'type' => 'decimal',
						'options' => array (
							min => 0.0
						)
					),
				),
				array( // Cotisation complementaire ?
					'saisie' => 'oui_non',
					'options' => array(
						'nom' => 'complement',
						'label' => _T('adhcoti:complement_adhcoti'),
						'value' => 'non',
						'obligatoire' => 'non',
					),
				),
					array( // activite subaquatique ?
					'saisie' => 'case',
					'options' => array(
						'nom' => 'activclub',
						'label' => _T('adhcoti:activclub_adhcoti'),
						'value' => 'oui',
						'obligatoire' => 'non',
					),
				),
			)
		)
	);
	
return $saisie_commune;
}

?>
