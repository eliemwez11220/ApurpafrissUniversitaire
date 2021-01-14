<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function is_required($field, $label){

    return array(

        'field' => $field,
        'label' => $label,
        'rules' => 'required',
        'errors' => [
            'required' => 'Le champ %s est requis',
        ]
    );
}

function is_length($field, $label){

    return array(

        'field' => $field,
        'label' => $label,
        'rules' => 'required|min_length[2]|max_length[30]',
        'errors' => [
            'required' => 'Le champ %s est requis',
            'min_length' => 'Le champ %s doit contenir au minimum deux caractères',
            'max_length' => 'Le champ %s doit contenir au maximum trente caractères',
        ]
    );
}

function is_numerique ($field, $label)
{
    return

        array(
            'field' => $field,
            'label' => $label,
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Le champ %s est requis',
                'numeric' => 'Le %s doit être numérique'
            ]
        );
}

function mot_pass(){

    return array(

        'field' => 'mot_pass',
        'label' => 'Mot de passe',
        'rules' => 'required|min_length[6]|max_length[12]',
        'errors' => [
            'required' => 'Le champ %s est requis',
            'min_length' => 'Le champ %s doit contenir au minimum six caractères',
            'max_length' => 'Le champ %s doit contenir au maximum douze caractères'
        ]
    );
}

function conf_mot_pass () {

    return array(
        'field' => 'conf_mot_pass',
        'label' => 'Confirmation Mot de passe',
        'rules' => 'required|min_length[6]|max_length[12]|matches[mot_pass]',
        'errors' => [
            'required' => 'Le champ %s est requis',
            'min_length' => 'Le champ %s doit contenir au minimum six caractères',
            'max_length' => 'Le champ %s doit contenir au maximum douze caractères',
            'matches' => 'Le champ %s doit correspondre avec le champ Mot de passe'
        ]
    );
}

function nom_ut(){
    return array(
        'field' => 'nom_ut',
        'label' => "Nom utilisateur",
        'rules' => 'required|valid_email|max_length[50]|is_unique[utilisateurs.nom_ut]',
        'errors' =>
            [
                'required' => 'Le champ %s est requis',
                'valid_email' => "Le nom d'utilisateur saisi n'est pas un mail valide",
                'max_length' => 'Le champ %s doit contenir au maximum quincante caractères',
                'is_unique' => "Ce nom d'utilisateur est déjà utilisé"
            ]
    );
}

function mat_et()
{
    return array(
        'field' => 'mat_et',
        'label' => "Matricule",
        'rules' => 'required|is_unique[utilisateurs.mat_et]',
        'errors' =>
            [
                'required' => 'Le champ %s est requis',
                'is_unique' => "Ce matricule est déjà utilisé"
            ]
    );
}

function is_annee(){
    return array(
        'field' => 'annee',
        'label' => "Année academique",
        'rules' => 'is_unique[annee_academ.annee]',
        'errors' =>
            [
                'is_unique' => "Cette année est déjà lancée"
            ]
    );
}

$config = array(

    'auth/connexion' => array(

        is_required('nom_ut', "Nom d'utilisateur"),
        is_required('mot_pass', "Mot de passe"),
    ),
    'auth/enreg' => array(

        nom_ut(),
        mat_et(),
        mot_pass(),
        conf_mot_pass()
    ),

    'admin/ajout_ut' => [

        is_length('nom_comp', 'Nom complet'),
        nom_ut(),
        is_required('role_ut', 'Privilège'),
        mot_pass(),
        conf_mot_pass()
    ],

    'sga/lancer_annee' => array(
       is_annee()
    ),

    'financier/soutirer' => array(
       is_required('num_compte', 'Numéro de compte'),
    ),

    'financier/fixer_frais' => array(
       is_required('type_frais', 'Type de frais'),
       is_required('devise', 'Devise'),
       is_required('id_promotion', 'Promotion'),
       is_required('taux_change', 'Taux de change'),
       is_required('montant_fixe', 'Montant fixé')
    )

);