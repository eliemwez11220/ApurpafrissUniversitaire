<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financier extends CI_Controller
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

    function finances(){

        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['c'] = $this->Ci_apurpafriss_model->get_result('comptes', [], 'num_compte', 'ASC');
        $data['sc'] = $this->Ci_apurpafriss_model->get_result('sous_comptes', [], 'designation', 'ASC');
        $this->data('finances', compact('data'));
    }

    function mouvements(){

        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['mouv'] = $this->Ci_apurpafriss_model->get_result('mouvements', ['annee' => $data['annee_academ']], 'id');

        $this->data('mouvements', compact('data'));
    }

    function fixations(){

        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);
        $data['ut'] = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut]);
        $data['fix'] = $this->Ci_apurpafriss_model->get_join(['fixations', 'promotions'], ['id_promotion'], ['fixations.annee' => $data['annee_academ']],
            'fixations.*, promotions.*', 'fixations.type_frais', 'ASC');
        $data['promotions'] = $this->Ci_apurpafriss_model->get_result('promotions', [], 'promotion', 'ASC');
        $this->data('fixations', compact('data'));
    }

    function fixer_frais(){

        if ($this->form_validation->run()){
            $type_frais = $this->input->post('type_frais');
            $id_promotion = $this->input->post('id_promotion');
            $montant_fixe = $this->input->post('montant_fixe');
            $devise = $this->input->post('devise');
            $taux_change = $this->input->post('taux_change');
            $annee = $this->input->post('annee');
            $delai = (($this->input->post('delai') == "") ? date('Y-m-d') : $this->input->post('delai'));

            $data_fix = compact('type_frais', 'id_promotion', 'montant_fixe', 'devise', 'annee', 'delai', 'taux_change');
            if ($this->Ci_apurpafriss_model->set_insert('fixations', $data_fix)){
                $this->get_msg("frais fixé correctement!", 'success');
            } else{
                $this->get_msg("Impossible de fixer le frais");
            }
            redirect('financier/fixations');
        } else{
            $this->get_msg();
            $this->fixations();
        }
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
        $data['promo'] = $this->Ci_apurpafriss_model->get_join(['etudiants', 'identifications', 'promotions'], ['mat_et', 'id_promotion'],
            ['identifications.annee' => $data['annee_academ'], 'etudiants.mat_et' => $mat_et],
            'etudiants.*, promotions.*', 'etudiants.nom', 'ASC', 'row');
        $data['fix'] = $this->Ci_apurpafriss_model->get_result('fixations', ['annee' => $data['annee_academ'],
            'id_promotion' => $data['promo']->id_promotion], 'type_frais', 'ASC');
        $this->data('paiements_et', compact('data'));
    }

    function suppr_frais(){

        $id = $this->input->get('id');

        if ($this->Ci_apurpafriss_model->set_delete('fixations', compact('id'))){

            $this->get_msg("Le frais a bien été supprimé!", 'success');
        }
        else{

           $this->get_msg("Impossible de supprimer le frais");
        }
        redirect('financier/fixations');
    }

    function soutirer(){

        $id = $this->input->get('id');
        $annee_act = date('Y');
        $data['annee_academ'] = $annee_act. '-' .($annee_act+1);

        if ($this->form_validation->run()){

            $sous_compte = $this->input->post('sous_compte');
            $num_compte = $this->input->post('num_compte');
            $montant_soutire = $this->input->post('montant_soutire');
            $motif = $this->input->post('motif');
            $taux = $this->input->post('taux');
            $annee = $data['annee_academ'];
            $date_mouv = date('Y-m-d');

            $data_mouv = compact('sous_compte', 'num_compte', 'montant_soutire', 'motif', 'date_mouv', 'taux', 'annee');

            $compte_db = $this->Ci_apurpafriss_model->get_unique('comptes', ['num_compte' => $num_compte]);
            $sous_compte_db = $this->Ci_apurpafriss_model->get_unique('sous_comptes', ['id' => $id]);

            if ($compte_db->devise == "CDF"){

                if ($montant_soutire < $compte_db->solde_courant){

                    if ($montant_soutire > $sous_compte_db->solde_courant){
                        $this->get_msg("Montant à soutirer supérieur au solde courant!");
                    } elseif ($montant_soutire == $sous_compte_db->solde_courant){
                        $this->get_msg("Vous ne pouvez pas soutirer pour vider le solde de ce sous compte!");
                    } elseif ($montant_soutire < $sous_compte_db->solde_courant){

                        $sous_compte_total_sortie = $sous_compte_db->total_sortie + $montant_soutire;
                        $sous_compte_solde_courant = $sous_compte_db->total_entree - $sous_compte_total_sortie;
                        $compte_total_sortie = ($compte_db->devise == "USD") ? $compte_db->total_sortie + ($montant_soutire / $taux) : $compte_db->total_sortie + $montant_soutire;
                        $compte_solde_courant = $compte_db->total_entree - $compte_total_sortie;

                        if ($this->Ci_apurpafriss_model->set_insert('mouvements', $data_mouv)){

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_sortie' =>$sous_compte_total_sortie, 'solde_courant' => $sous_compte_solde_courant], ['id' => $id]);

                            $this->Ci_apurpafriss_model->set_update('comptes', ['total_sortie' =>$compte_total_sortie, 'solde_courant' => $compte_solde_courant], ['num_compte' => $num_compte]);

                            $this->get_msg("Montant soutiré avec succès!", 'success');
                        }
                    }
                } else{
                    $this->get_msg("Insuffisance du solde courant du compte choisi");
                }
            } else{
                //USD

                $compte_db_solde_courant_usd = $compte_db->solde_courant * $taux;
                if ($montant_soutire < $compte_db_solde_courant_usd){

                    if ($montant_soutire > $sous_compte_db->solde_courant){
                        $this->get_msg("Montant à soutirer supérieur au solde courant!");
                    } elseif ($montant_soutire == $sous_compte_db->solde_courant){
                        $this->get_msg("Vous ne pouvez pas soutirer pour vider le solde de ce sous compte!");
                    } elseif ($montant_soutire < $sous_compte_db->solde_courant){

                        $sous_compte_total_sortie = $sous_compte_db->total_sortie + $montant_soutire;
                        $sous_compte_solde_courant = $sous_compte_db->total_entree - $sous_compte_total_sortie;
                        $compte_total_sortie = ($compte_db->devise == "USD") ? $compte_db->total_sortie + ($montant_soutire / $taux) : $compte_db->total_sortie + $montant_soutire;
                        $compte_solde_courant = $compte_db->total_entree - $compte_total_sortie;

                        if ($this->Ci_apurpafriss_model->set_insert('mouvements', $data_mouv)){

                            $this->Ci_apurpafriss_model->set_update('sous_comptes', ['total_sortie' =>$sous_compte_total_sortie, 'solde_courant' => $sous_compte_solde_courant], ['id' => $id]);

                            $this->Ci_apurpafriss_model->set_update('comptes', ['total_sortie' =>$compte_total_sortie, 'solde_courant' => $compte_solde_courant], ['num_compte' => $num_compte]);

                            $this->get_msg("Montant soutiré avec succès!", 'success');
                        }
                    }
                } else{
                    $this->get_msg("Insuffisance du solde courant du compte choisi");
                }
            }



            redirect('financier/finances');
        } else{

            $this->get_msg();
            $this->finances();
        }

    }

}