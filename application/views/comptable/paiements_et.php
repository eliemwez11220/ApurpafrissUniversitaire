

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-ticket"></i> Page d'apurement de paiement</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-ticket fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page d'apurement de paiement</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="container-fluid">
            <?php include_once ("application/views/auth/alert.php"); ?>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <div class="card border-primary">

                <div class="card-header">
                    <h3 class="display-5 text-center"> <strong>Apurement paiement Etudiant <?= $data['et']->mat_et ?>
                            Promotion : <span class="text-info"><?= $data['promo']->promotion ." ".$data['promo']->code_option ." ". $data['promo']->departement ?></span></strong></h3>
                </div>

                <form action="<?= base_url('comptable/apurer_pay'); ?>" method="post">
                    <div class="card-body font-weight-bold">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="mat_ut">Matricule étudiant</label>
                                    <input type="text" name="mat_et" class="form-control form-control-sm font-weight-bold is-valid"
                                           value="<?= $data['et']->mat_et ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="postnom">Nom et Postnom étudiant</label>
                                    <input type="text" name="postnom" class="form-control form-control-sm font-weight-bold is-valid"
                                           value="<?= $data['et']->nom. " ". $data['et']->postnom ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="annee">Année académique en cours</label>
                                    <input type="text" name="annee" class="form-control form-control-sm font-weight-bold is-valid"
                                          value="<?= $data['annee_academ']; ?>" minlength="3" maxlength="45" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="type_frais">Type frais</label>
                                    <select name="type_frais" class="form-control form-control-sm font-weight-bold <?= form_error('type_frais') ? 'is-invalid' : 'is-valid'; ?>" required>
                                        <option disabled selected>Choisir le type de frais</option>
                                        <?php foreach ($data['fix'] as $fix) : ?>
                                            <option id="<?= $fix->type_frais; ?>" value="<?= $fix->type_frais; ?>" <?= set_select('type_frais', $fix->type_frais); ?>>
                                                <?= $fix->type_frais." | ". $fix->montant_fixe ." ". $fix->devise." | au taux de ". $fix->taux_change ; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="date_paiement">Date paiement</label>
                                <div class="form-group">
                                    <input type="date" name="date_paiement" class="form-control form-control-sm font-weight-bold <?= form_error('date_paiement') ? 'is-invalid' : 'is-valid'; ?> "
                                           value="<?= set_value('date_paiement'); ?>" max="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="date_apurement">Date apurement</label>
                                    <input type="date" name="date_apurement" class="form-control form-control-sm font-weight-bold <?= form_error('date_apurement') ? 'is-invalid' : 'is-valid'; ?>"
                                           value="<?= date('Y-m-d') ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="num_compte">Compte bancaire</label>
                                    <select class="form-control form-control-sm font-weight-bold <?= form_error('num_compte') ? 'is-invalid' : 'is-valid'; ?>" name="num_compte" id="num_compte">
                                        <option disabled selected>Choisir le compte</option>
                                        <?php foreach ($data['comptes'] as $compte) : ?>
                                            <option id="<?= $compte->num_compte; ?>" value="<?= $compte->num_compte; ?>" <?= set_select('num_compte', $compte->num_compte); ?>>
                                                <?= $compte->num_compte. " | ". $compte->devise ; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="montant_verse">Montant versé</label>
                                    <input type="text" name="montant_verse" class="form-control form-control-sm font-weight-bold <?= form_error('montant_verse') ? 'is-invalid' : 'is-valid'; ?> "
                                           value="<?= set_value('montant_verse'); ?>">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="bordereau">Bordereau</label>
                                    <input type="text" name="bordereau" class="form-control form-control-sm font-weight-bold <?= form_error('bordereau') ? 'is-invalid' : 'is-valid'; ?> "
                                           value="<?= set_value('bordereau'); ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group container-fluid" align="center">
                                <input type="submit" value="Apurer paiement" class="form-control-sm btn btn-primary btn-sm">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-12">
            <br>
            <div class="card border-primary">

                <div class="card-header">
                    <h3 class="display-5 text-center">
                        Liste des paiements concernant l'étudiant <span class="text-info text-uppercase"><?= $data['et']->mat_et." ". $data['et']->nom." ". $data['et']->postnom; ?></span>
                    </h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive-sm">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                            <tr class="bg-secondary">
                                <th class="text-center">#</th>
                                <th>Matricule</th>
                                <th>Promotion</th>
                                <th>Frais</th>
                                <th>Montant versé</th>
                                <th>Date paiement</th>
                                <th>Date apurement</th>
                                <th>Bordereau</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="bg-secondary">
                                <th class="text-center">#</th>
                                <th>Matricule</th>
                                <th>Promotion</th>
                                <th>Frais</th>
                                <th>Montant versé</th>
                                <th>Date paiement</th>
                                <th>Date apurement</th>
                                <th>Bordereau</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $count = 1; foreach ($data['etudiants'] as $et): ?>
                                <tr class="">
                                    <td class="text-center"><?= $count++; ?></td>
                                    <td class="text-uppercase"><?= $et->mat_et; ?></td>
                                    <td class="text-uppercase"><?= $data['promo']->promotion. " ".$data['promo']->code_option; ?></td>
                                    <td class="text-lowercase"><?= $et->type_frais; ?></td>
                                    <td class="text-uppercase"><?= $et->montant_verse." ". $et->devise; ?></td>
                                    <td class="text-uppercase"><?= utf8_encode(strftime("%d-%m-%Y", strtotime($et->date_paiement))); ?></td>
                                    <td class="text-uppercase"><?= utf8_encode(strftime("%d-%m-%Y", strtotime($et->date_apurement))); ?></td>
                                    <td class="text-uppercase"><?= $et->bordereau; ?></td>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
