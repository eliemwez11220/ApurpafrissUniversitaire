<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
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

    public function vue_ajout_ut(){
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
       $this->data('ajout_ut', compact('data'));
    }

    public function ajout_ut ()
    {

        if ($this->form_validation->run()){

            $nom_comp = $this->input->post('nom_comp');
            $nom_ut = $this->input->post('nom_ut');
            $role_ut = $this->input->post('role_ut');
            $mat_et = $this->mat($nom_comp);
            $date_creat = date('Y-m-d');
            $mot_pass = sha1($this->_encrypt. $this->input->post('mot_pass'));

            $data_ut = compact('nom_comp', 'role_ut', 'date_creat', 'mot_pass', 'nom_ut', 'mat_et');

            if ($this->Ci_apurpafriss_model->set_insert('utilisateurs', $data_ut)){

                $this->get_msg("L'utilisateur $nom_comp a bien été ajouté !", 'success');
                redirect('admin/vue_ajout_ut');
            }
            else{

                $this->get_msg("Impossible d'ajouter l'utilisateur $nom_comp");
                redirect('admin/vue_ajout_ut');
            }
        }
        else {

            $this->get_msg();
            $this->vue_ajout_ut();
        }
    }

    function vue_list_ut ()
    {
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['utilisateurs'] = $this->Ci_apurpafriss_model->get_result('utilisateurs', []);
        $this->data('list_ut', compact('data'));
    }

    function suppr_ut(){

        $id = $this->input->get('id');

        if ($this->Ci_apurpafriss_model->set_delete('utilisateurs', compact('id'))){

            $this->get_msg("L'utilisateur a bien été supprimé!", 'success');
        }
        else{

           $this->get_msg("Impossible de supprimer l'utilisateur");
        }
        redirect('admin/vue_list_ut');
    }

    function reinit_psw (){

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

    function mat($string, $fonction = 'A')
    {

        $length = strlen($string);
        $position = mt_rand(0, $length - 1);
        $random_char_mat = strtoupper($string[$position]);
        while (!in_array($random_char_mat, ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'])) {
            $position = mt_rand(0, $length - 1);
            $random_char_mat = strtoupper($string[$position]);
        }

        $my_rand_mat = rand() % (1000000);
        while (strlen($my_rand_mat) < 4) {
            $my_rand_mat = rand() % (1000000);
        }

        $list_complement = ['-', '1', '3', '-', '5', '7', '9', '-', ''];
        $mat_et = $fonction . $random_char_mat . $my_rand_mat . $list_complement[rand(0, 8)];

        $this->form_validation->set_data(compact('mat_et'));
        $this->form_validation->set_rules('mat_et', 'Génération du Matricule', 'is_unique[utilisateurs.mat_et]',
            ['is_unique' => 'La %s a échouée']);

        return $this->form_validation->run() ? $mat_et : $this->mat($string);
    }

}