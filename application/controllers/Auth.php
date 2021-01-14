<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->_encrypt = "aazzbbyyccxxddwweevvffuu";
    }

    function index()
    {
        $this->login();
    }

    function login()
    {
        $this->load->view('auth/login');
    }

    function connexion()
    {
        if ($this->form_validation->run()) {

            $nom_ut = $this->input->post('nom_ut');
            $mot_pass = ($this->_encrypt . $this->input->post('mot_pass'));
            $this->save_sess($nom_ut, $mot_pass);

        } else {
            $this->get_msg();
            $this->index();
        }
    }

    function enreg ()
    {

        if ($this->form_validation->run())
        {
            $nom_ut = $this->input->post('nom_ut');
            $mat_et = $this->input->post('mat_et');
            $mot_pass = sha1($this->_encrypt. $this->input->post('mot_pass'));
            $role_ut = 'etudiant';
            $statut = 'online';
            $date_creat = date('Y-m-d');

            $etudiant_exit = $this->Ci_apurpafriss_model->get_unique('etudiants', ['mat_et' => $mat_et]);

            if ($etudiant_exit){
                $nom_comp = $etudiant_exit->nom. " ".$etudiant_exit->postnom. " " .$etudiant_exit->prenom;

                $data_ut = compact('nom_ut', 'mot_pass', 'role_ut', 'date_creat', 'nom_comp', 'mat_et');
                $data_et = compact('statut');
                if ($this->Ci_apurpafriss_model->set_insert('utilisateurs', $data_ut) AND
                    $this->Ci_apurpafriss_model->set_update('etudiants', $data_et, compact('mat_et')))
                {

                    $this->save_sess($nom_ut, $this->_encrypt. $this->input->post('mot_pass'));
                }
                else
                {
                    $this->get_msg('Impossible de créer votre compte');
                    $this->index();
                }
            } else{
                $this->get_msg("Matricule étudiant invalide");
            }
        }
        else
        {
            $this->get_msg();
            $this->index();
        }

    }

    private function save_sess($nom_ut, $mot_pass){

        $exist_ut = $this->Ci_apurpafriss_model->connexion($nom_ut, $mot_pass);

        if ($exist_ut) {

            $session_data = [

                'id' => $exist_ut->id,
                'nom_comp' => $exist_ut->nom_ut,
                'nom_ut' => $exist_ut->nom_ut,
                'role_ut' => $exist_ut->role_ut,
                'mat_et' => $exist_ut->mat_et,
                'date_creat' => date('Y-m-d H:i')
            ];

            $this->session->set_userdata($session_data);

            $this->get_msg("Bienvenue à l'iss, vous êtes connectés entant que $exist_ut->role_ut", 'success');

            $this->secure();

        } else {

            $this->get_msg("Utilisateur introuvable, veuillez conctacter l'administrateur");
            redirect('auth');
        }
    }

    function deconnexion (){

        $this->get_msg("Déconnexion");
        $this->session->unset_userdata(['nom', 'role_ut', 'matricule', 'nom_ut']);
        redirect('auth');
    }

}