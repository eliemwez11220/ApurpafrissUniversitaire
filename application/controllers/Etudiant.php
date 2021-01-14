<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etudiant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->secure();
        $this->_encrypt = "aazzbbyyccxxddwweevvffuu";
    }

    public function index()
    {
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $this->data($this->session->role_ut, compact('data'));
    }

    function vue_profil(){

        $data['error_anc_mot_pass'] = $this->session->flashdata('error_anc_mot_pass');
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $this->data('vue_profil', compact('data'));
    }

    function profil()
    {
        $photo_ut_db = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut])->photo_ut;
        $nom_comp = $this->input->post('nom_comp');
        $nom_ut = $this->input->post('nom_ut');
        $nvo_mot_pass = $this->input->post('nvo_mot_pass');
        $conf_mot_pass = $this->input->post('conf_mot_pass');
        $anc_mot_pass = sha1($this->_encrypt . $this->input->post('anc_mot_pass'));
        $validate = [];

        if ($nom_ut != $this->session->nom_ut){

            $validate['nom_ut'] = $nom_ut;

            $this->form_validation->set_rules('nom_ut', "Nom d'Utilisateur", 'required|valid_email|max_length[50]|is_unique[utilisateurs.nom_ut]',
                [
                    'required' => 'Le champ %s est requis',
                    'valid_nom_ut' => 'Le champ %s doit contenir une adresse mail valide',
                    'max_length' => 'Le champ %s doit contenir au plus cinquante caractères',
                    'is_unique' => 'Ce %s existe déjà'
                ]
            );
        }

        $this->form_validation->set_rules('nvo_mot_pass', 'Nouveau Mot de passe', 'min_length[6]|max_length[12]',
            [
                'min_length' => 'Le champ %s doit contenir au moins six caractères',
                'max_length' => 'Le champ %s doit contenir au plus douze caractères'
            ]
        );

        $this->form_validation->set_rules('conf_mot_pass', 'Confirmer Mot de passe', 'matches[nvo_mot_pass]',
            [
                'matches' => 'Le champ %s doit correspondre avec le champ Nouveau Mot de passe'
            ]
        );

        $anc_mot_pass_db = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut])->mot_pass;


        $this->form_validation->set_data(array_merge($validate, compact('nvo_mot_pass', 'conf_mot_pass')));

        if ($this->form_validation->run()) {

            if ($anc_mot_pass == $anc_mot_pass_db) {

                $mot_pass = empty($nvo_mot_pass) ? $anc_mot_pass : sha1($this->_encrypt . $nvo_mot_pass);

                $config['upload_path'] ='./assets/img/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2048';
                $config['max_width'] = '2000';
                $config['max_height'] = '2000';

                $this->upload->initialize($config);

                if (! $this->upload->do_upload('photo_ut')){
                    $photo_ut = $photo_ut_db;

                }
                else{
                    $image_data = $this->upload->data('orig_name');
                    $photo_ut = ($photo_ut_db == $image_data) ? $photo_ut_db : $image_data;
                }

                $data_ut = compact('nom_comp', 'nom_ut', 'photo_ut', 'mot_pass');

                if ($this->Ci_apurpafriss_model->set_update('utilisateurs', $data_ut, ['nom_ut' => $this->session->nom_ut])) {

                    $this->session->set_userdata(compact('nom_ut', 'nom_comp', 'role_ut'));
                    $this->get_msg("Cher admin $nom_comp vos informations ont bien été modifiées !", 'success');

                } else {

                    $this->get_msg("Impossible de modifier vos informations personelles !");
                }

            } else {
                $error_anc_mot_pass = TRUE;
                $this->session->set_flashdata(compact('error_anc_mot_pass'));
                $this->get_msg("Le mot de passe en cours, est incorrect!");
            }
            redirect('etudiant/vue_profil');
        } else {

            $this->get_msg();
            $this->vue_profil();
        }
    }

    function paiements_et ()
    {
        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $mat_et = $this->session->mat_et;

        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['mat_et' => $mat_et]);

        $data['pay'] = $this->Ci_apurpafriss_model->get_join(['paiements', 'etudiants', 'utilisateurs'], ['mat_et', 'mat_et'],
            ['paiements.annee' => $data['annee_academ'], 'paiements.mat_et' => $mat_et],
            'paiements.*, etudiants.*, utilisateurs.*', 'paiements.id', 'ASC');

        $data['promo'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions'], ['mat_et', 'id_promotion'],
            ['identifications.annee' => $data['annee_academ'], 'etudiants.mat_et' => $mat_et],
            'etudiants.*, promotions.*', 'etudiants.nom', 'ASC', 'row');

        $data['fix'] = $this->Ci_apurpafriss_model->get_result('fixations', ['annee' => $data['annee_academ'],
            'id_promotion' => $data['promo']->id_promotion], 'type_frais', 'ASC');

        $this->data('paiements_et', compact('data'));
    }
}