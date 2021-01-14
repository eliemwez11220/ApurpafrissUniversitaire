<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->secure();
        $this->_encrypt = "aazzbbyyccxxddwweevvffuu";
        $this->_annee_actuel = date('Y');
        $this->_annee_academ = $this->_annee_actuel. '-' .($this->_annee_actuel+1);
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

            $this->form_validation->set_rules('nom_ut', "Nom d'Utilisateur", 'required|valid_nom_ut|max_length[50]|is_unique[utilisateurs.nom_ut]',
                [
                    'required' => 'Le champ %s est requis',
                    'valid_nom_ut' => 'Le champ %s doit contenir une adresse mail valide',
                    'max_length' => 'Le champ %s doit contenir au plus cinquante caractères',
                    'is_unique' => 'Ce %s existe déjà'
                ]
            );
        }

        $this->form_validation->set_rules('nvo_mot_pass', 'Nouveau Mot de passe', 'min_length[8]|max_length[12]',
            [
                'min_length' => 'Le champ %s doit contenir au moins huit caractères',
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
            redirect('admin/vue_profil');
        } else {

            $this->get_msg();
            $this->vue_profil();
        }



    }

    function vue_lancer_annee(){

        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $this->data('vue_lancer_annee', compact('data'));
    }

    function lancer_annee(){

        if ($this->form_validation->run()){

            $annee = $this->input->post('annee');
            if ($this->Ci_apurpafriss_model->set_insert('annee_academ', compact('annee'))){
                $this->get_msg("Lancement de l'année confirmé!", 'success');
            } else{
                $this->get_msg("Impossible de lancer l'année");
            }
            redirect('sga');
        } else{
            $this->get_msg();
            $this->vue_lancer_annee();
        }
    }

    function vue_ajout_et(){

        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['promotions'] = $this->Ci_apurpafriss_model->get_result('promotions', []);
        $data['date_naiss_max'] = ((new DateTime())->modify('-18 year'))->format('Y-m-d');
        $data['date_naiss_min'] = ((new DateTime())->modify('-80 year'))->format('Y-m-d');

       $this->data('ajout_et', compact('data'));
    }

    function ajout_et ()
    {
        $nom = $this->input->post('nom');
        $postnom = $this->input->post('postnom');
        $prenom = $this->input->post('prenom');
        $genre = $this->input->post('genre');
        $date_naiss = $this->input->post('date_naiss');
        $lieu_naiss = $this->input->post('lieu_naiss');
        $telephone = $this->input->post('telephone');
        $adresse = $this->input->post('adresse');
        $id_promotion = $this->input->post('id_promotion');
        $mat_et = $this->matricule($nom. $postnom);
        $annee = date('Y'). '-' .(date('Y')+1);
        $date_identif = date('Y-m-d');

        $data_et = compact('nom', 'postnom', 'prenom', 'genre', 'date_naiss', 'lieu_naiss', 'telephone',
            'adresse', 'mat_et');
        $data_identif = compact('mat_et', 'id_promotion', 'annee', 'date_identif');
        if ($this->Ci_apurpafriss_model->set_insert('etudiants', $data_et)){
            if ($this->Ci_apurpafriss_model->set_insert('identifications', $data_identif)){
                $this->get_msg("L'étudiant $nom vient d'être identifié avec succès !", 'success');
                redirect('sga/vue_ajout_et');
            }
        }
        else{

            $this->get_msg("Impossible d'ajouter l'étudiant");
            redirect('sga/vue_ajout_et');
        }
    }
  
    function vue_list_et ()
    {
        //Annee academique
        $annee_academique = ($this->input->post('annee')) ?? $this->_annee_academ;
        $data['select'] = $annee_academique;
        $data['annee_academ'] = $this->Ci_apurpafriss_model->get_result('annee_academ', []);
        //liste etudiants identifies
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        //$data['etudiants'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions','annee_academ'],['mat_et','id_promotion','annee'], [],
            //'identifications.*, etudiants.*, promotions.*,annee_academ.*', 'etudiants.nom', 'ASC');
        $data['etudiants'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions'], ['mat_et', 'id_promotion'],
            ['identifications.annee' => $annee_academique], 'identifications.*, etudiants.*, promotions.*', 'etudiants.nom', 'ASC');
        $data['annee_academ'] = $this->Ci_apurpafriss_model->get_result('annee_academ', []);
        $this->data('list_et', compact('data'));
       
    }

    public function suppr_et(){

        $id = $this->input->get('id');

        if ($this->Ci_apurpafriss_model->set_delete('etudiants', compact('id'))){

            $this->get_msg("L'étudiant a bien été supprimé!", 'success');
        }
        else{

           $this->get_msg("Impossible de supprimer l'étudiant");
        }
        redirect('sga/vue_list_et');
    }

    public function modif_et (){

        $id = $this->input->get('id');
        $mot_pass = sha1( $this->_encrypt . 123456);

        if ($this->Ci_apurpafriss_model->set_update ('utilisateurs', compact('mot_pass'), compact('id'))) {

            $this->get_msg("Le mot de passe a bien été réinitialisé!", 'success');
        }
        else{

           $this->get_msg("Impossible de réinitialiser le mot de passe");
        }
        redirect('admin/vue_list_ut');
    }

}