

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Page de gestion des étudiants</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-users fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page de gestion des étudiants</a></li>
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
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="display-5">Liste des étudiants identifiés</h3>
                        </div>
                        <div class="col-sm-3">
                            <h3 class="display-5 text-bleu pull-right">Année académique : </h3>
                        </div>
                        <div class="col-sm-3">
                            <form class="form-inline pull-right" method="post" action="<?= site_url($role_ut.'/vue_list_et'); ?>">

                                <div class="form-horizontal form-group-sm">

                                    <?php $array_periodes  = []; foreach ($data['annee_academ'] as $periode) :

                                        $array_periodes[$periode->annee] = $periode->annee;

                                    endforeach; ?>

                                    <?=
                                    form_dropdown('annee', $array_periodes, $data['select'],
                                        [
                                            'class' => 'form-control',
                                            'name' => 'annee',
                                            'id' => 'annee',
                                            'required'
                                        ]
                                    );
                                    ?>
                                </div>

                                <div class="form-horizontal">
                                    <div class="form-group-sm">
                                        <input type="submit" class="btn btn-info btn-lg text-white" name="submit" value="Afficher">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive-sm">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                            <tr class="bg-secondary">
                                <th class="text-center">#</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Postnom</th>
                                <th>Prenom</th>
                                <th>Genre</th>
                                <th>Promotion</th>
                                <th>Année Academ</th>
                                <th width="5%">Détails</th>
                                <th width="5%">Suppresion</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="bg-secondary">
                                <th class="text-center">#</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Postnom</th>
                                <th>Prenom</th>
                                <th>Genre</th>
                                <th>Promotion</th>
                                <th>Année Academ</th>
                                <th width="5%">Détails</th>
                                <th width="5%">Suppresion</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $count = 1; foreach ($data['etudiants'] as $et): ?>
                                <tr class="">
                                    <td class="text-center"><?= $count++; ?></td>
                                    <td class="text-uppercase"><?= $et->mat_et; ?></td>
                                    <td class="text-uppercase"><?= $et->nom; ?></td>
                                    <td class="text-uppercase"><?= $et->postnom; ?></td>
                                    <td class="text-lowercase"><?= $et->prenom; ?></td>
                                    <td class="text-uppercase"><?= $et->genre; ?></td>
                                    <td class="text-uppercase"><?= $et->promotion . " " .$et->code_option; ?></td>
                                    <td class="text-uppercase"><?= $et->annee; ?></td>
                                    <td class="text-center">

                                        <a class="modal btn-rond-sm bg-info" data-toggle="modal" data-target="#afficher_et_<?= $et->id ?>"
                                            
                                           href=""><i class="fa fa-ellipsis-v"></i></a>

                                        <div id="afficher_et_<?= $et->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content md-text">
                                                    <div class="row">
                                                        <div class="form-group col-sm-12 text-center font-weight-bold">
                                                            <br>
                                                            <h2>Détails sur l'étudiant <?= $et->mat_et ?> identifié <?= date('d-m-Y', strtotime($et->date_identif))?></h2>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-sm-4">
                                                            Nom Etudiant :<span class="text-info text-lowercase"><?= $et->nom ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            Postnom Etudiant :<span class="text-info text-lowercase"><?= $et->postnom ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            Prenom Etudiant :<span class="text-info text-lowercase"><?= $et->prenom ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-sm-4">
                                                            Genre :<span class="text-info text-lowercase"><?= $et->genre ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            Date Naiss :<span class="text-info text-lowercase"><?= $et->date_naiss ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            Lieu Naiss :<span class="text-info text-lowercase"><?= $et->lieu_naiss ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-sm-4">
                                                            Téléphone :<span class="text-info text-lowercase"><?= $et->telephone ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-8">
                                                            Adresse :<span class="text-info text-lowercase"><?= $et->adresse ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-sm-4">
                                                            Promotion :<span class="text-info text-lowercase"><?= $et->promotion ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            option :<span class="text-info text-lowercase"><?= $et->code_option ?></span>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            Département :<span class="text-info text-lowercase"><?= $et->departement ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?')" class="btn-rond-sm bg-danger"
                                           href="<?= base_url( 'sga/suppr_et?id=' . $et->id); ?>"><i class="fa fa-remove"></i></a>
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
