<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comptable extends CI_Controller
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
            redirect('comptable/vue_profil');
        } else {

            $this->get_msg();
            $this->vue_profil();
        }
    }


    function apurer_pay ()
    {
        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);

        $mat_et = $this->input->post('mat_et');
        $date_paiement = $this->input->post('date_paiement');
        $date_apurement = $this->input->post('date_apurement');
        $bordereau = $this->input->post('bordereau');
        $type_frais = $this->input->post('type_frais');
        $num_compte = $this->input->post('num_compte');
        $annee = $this->input->post('annee');
        $montant_verse = $this->input->post('montant_verse');

        $compte = $this->Ci_apurpafriss_model->get_unique('comptes', ['num_compte' => $num_compte]);

        $data['promo'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions'], ['mat_et', 'id_promotion'],
            ['identifications.annee' => $data['annee_academ'], 'etudiants.mat_et' => $mat_et],
            'etudiants.*, promotions.*', 'etudiants.nom', 'ASC', 'row');

        $data['fix_pro'] = $this->Ci_apurpafriss_model->get_unique('fixations', ['type_frais' => $type_frais, 'id_promotion' => $data['promo']->id_promotion]);

        if ($data['fix_pro']->devise == $compte->devise){

            //succès
            if ($data['fix_pro']->montant_fixe == $montant_verse){
                //succès
                $devise = $data['fix_pro']->devise;
                $data_pay = compact('mat_et', 'date_paiement', 'date_apurement', 'bordereau', 'type_frais', 'num_compte',
                    'annee', 'montant_verse', 'devise');

                if ($this->Ci_apurpafriss_model->set_insert('paiements', $data_pay)){
                    $total_entree = $compte->total_entree + $montant_verse;
                    $solde_courant = $total_entree - $compte->total_sortie;

                    $data_compte = compact('total_entree', 'solde_courant');

                    $this->Ci_apurpafriss_model->set_update('comptes', $data_compte, compact('num_compte'));

                    $agents_db = $this->Ci_apurpafriss_model->get_unique('sous_comptes', ['designation' => "agents"]);
                    $enseignants_db = $this->Ci_apurpafriss_model->get_unique('sous_comptes', ['designation' => "enseignants"]);
                    $etat_db = $this->Ci_apurpafriss_model->get_unique('sous_comptes', ['designation' => "etat"]);
                    $patrimoines_db = $this->Ci_apurpafriss_model->get_unique('sous_comptes', ['designation' => "patrimoines"]);

                    switch ($type_frais){

                        case "Attestation de fréquentation" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.5);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = $enseignants_db->total_entree;
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.5);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Entérinement diplôme" :

                            $agents_total_entree = $agents_db->total_entree;
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = $enseignants_db->total_entree;
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = ($data['fix_pro']->devise == "USD") ? $etat_db->total_entree + (($montant_verse * 1) * $data['fix_pro']->taux_change) : $etat_db->total_entree + ($montant_verse * 1);
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = $patrimoines_db->total_entree;
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Fiche de recherche" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.5);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = $enseignants_db->total_entree;
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.5);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Inscription" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.3) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.3);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = ($data['fix_pro']->devise == "USD") ? $enseignants_db->total_entree + (($montant_verse * 0.2) * $data['fix_pro']->taux_change) : $enseignants_db->total_entree + ($montant_verse * 0.2);
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.5);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Minerval" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.3) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.3);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = ($data['fix_pro']->devise == "USD") ? $enseignants_db->total_entree + (($montant_verse * 0.4) * $data['fix_pro']->taux_change) : $enseignants_db->total_entree + ($montant_verse * 0.4);
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.3) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.3);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Rélévé de côtes" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.5);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = $enseignants_db->total_entree;
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.5);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Session d'examen" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.3) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.3);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = ($data['fix_pro']->devise == "USD") ? $enseignants_db->total_entree + (($montant_verse * 0.3) * $data['fix_pro']->taux_change) : $enseignants_db->total_entree + ($montant_verse * 0.3);
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.4) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.4);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;

                        case "Stage" :

                            $agents_total_entree = ($data['fix_pro']->devise == "USD") ? $agents_db->total_entree + (($montant_verse * 0.2) * $data['fix_pro']->taux_change) : $agents_db->total_entree + ($montant_verse * 0.2);
                            $agents_solde_courant = $agents_total_entree - $agents_db->total_sortie;
                            $enseignants_total_entree = ($data['fix_pro']->devise == "USD") ? $enseignants_db->total_entree + (($montant_verse * 0.5) * $data['fix_pro']->taux_change) : $enseignants_db->total_entree + ($montant_verse * 0.5);
                            $enseignants_solde_courant = $enseignants_total_entree - $enseignants_db->total_sortie;
                            $etat_total_entree = $etat_db->total_entree;
                            $etat_solde_courant = $etat_total_entree - $etat_db->total_sortie;
                            $patrimoines_total_entree = ($data['fix_pro']->devise == "USD") ? $patrimoines_db->total_entree + (($montant_verse * 0.3) * $data['fix_pro']->taux_change) : $patrimoines_db->total_entree + ($montant_verse * 0.3);
                            $patrimoines_solde_courant = $patrimoines_total_entree - $patrimoines_db->total_sortie;

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $agents_total_entree, 'solde_courant' => $agents_solde_courant],
                                ['designation' => "agents"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $enseignants_total_entree, 'solde_courant' => $enseignants_solde_courant],
                                ['designation' => "enseignants"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $etat_total_entree, 'solde_courant' => $etat_solde_courant],
                                ['designation' => "etat"]);
                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_entree' => $patrimoines_total_entree, 'solde_courant' => $patrimoines_solde_courant],
                                ['designation' => "patrimoines"]);
                            break;
                    }

                    $this->get_msg("Paiement apuré avec succès !", 'success');
                }
                else{

                    $this->get_msg("Impossible d'apurer le paiement");
                }
            } else{
                //echec
                $this->get_msg("Montant à verser différent du montant fixé");
            }

        } else{

            //echec
            $this->get_msg("Incompatibilité entre la dévise du compte choisi et celle de type de frais");
        }
        redirect('comptable/paiements_et?mat_et='. $mat_et);
    }

    function vue_list_et ()
    {
        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['etudiants'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions'], ['mat_et', 'id_promotion'],
            ['identifications.annee' => $data['annee_academ']],
            'identifications.*, etudiants.*, promotions.*', 'etudiants.nom', 'ASC');
        $this->data('list_et', compact('data'));
    }

    function paiements_et ()
    {
        $mat_et = $this->input->get('mat_et');
        $data['comptes'] = $this->Ci_apurpafriss_model->get_result('comptes', []);
        $data['date_paiement_min'] = ((new DateTime())->modify('-10 month'))->format('Y-m-d');
        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['et'] = $this->Ci_apurpafriss_model->get_unique('etudiants', ['mat_et' => $mat_et]);
        $data['etudiants'] = $this->Ci_apurpafriss_model->get_join(['paiements', 'etudiants'], ['mat_et'],
            ['paiements.annee' => $data['annee_academ'], 'paiements.mat_et' => $mat_et],
            'paiements.*, etudiants.*', 'paiements.id', 'ASC');
        if(($data['et']) ){
            $data['promo'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions'], ['mat_et', 'id_promotion'],
                ['identifications.annee' => $data['annee_academ'], 'etudiants.mat_et' => $mat_et],
                'etudiants.*, promotions.*', 'etudiants.nom', 'ASC', 'row');
            $data['fix'] = $this->Ci_apurpafriss_model->get_result('fixations', ['annee' => $data['annee_academ'],
                'id_promotion' => $data['promo']->id_promotion], 'type_frais', 'ASC');

            $this->data('paiements_et', compact('data'));
        } else{
            $this->get_msg("Etudiant non existant!");
            redirect('comptable/list_paiements');
        }

    }

    function list_paiements ()
    {
        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $mat_et = $this->session->mat_et;

        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['mat_et' => $mat_et]);

        $data['pay'] = $this->Ci_apurpafriss_model->get_join(['paiements', 'etudiants'], ['mat_et'],
            ['paiements.annee' => $data['annee_academ']], 'paiements.*, etudiants.*', 'paiements.id', 'DESC');

        $data['pay'] = $this->Ci_apurpafriss_model->get_join(['paiements', 'fixations'], ['type_frais'],
            ['paiements.annee' => $data['annee_academ']], 'paiements.*, fixations.*', 'paiements.id', 'DESC');

        $data['paiements'] = $this->Ci_apurpafriss_model->get_join(['paiements', 'etudiants', 'identifications', 'promotions'], ['mat_et', 'mat_et', 'id_promotion'],
            ['identifications.annee' => $data['annee_academ']], 'etudiants.*, promotions.*, identifications.*, paiements.*', 'paiements.id', 'DESC');
        $this->data('list_paiements', compact('data'));
    }
}