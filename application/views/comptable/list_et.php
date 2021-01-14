

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Page de liste des étudiants identifiés</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-users fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page de liste des étudiants identifiés</a></li>
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
                    <h3 class="display-5">Liste des étudiants identifiée <span class="text-info">Année académique <?= $data['annee_academ'] ?></span></h3>
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
                                <th width="5%">Paiements</th>
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
                                <th width="5%">Paiements</th>
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
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-block btn-outline-info"
                                           href="<?= base_url( 'comptable/paiements_et?mat_et=' . $et->mat_et); ?>">Paiements</a>
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
