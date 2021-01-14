

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-money"></i> Page de mes paiements</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-money fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page de mes paiements</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="container-fluid">
            <?php include_once ("application/views/auth/alert.php"); ?>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <br>
            <div class="card border-primary">

                <div class="card-header">
                    <h3 class="display-5 text-center">
                        Liste de mes paiements déjà apurés pour le compte de l'Iss <span class="text-info">Année académique <?= $data['annee_academ']?></span>
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
                            <?php $count = 1; foreach ($data['pay'] as $pay): ?>
                                <tr class="">
                                    <td class="text-center"><?= $count++; ?></td>
                                    <td class="text-uppercase"><?= $pay->mat_et; ?></td>
                                    <td class="text-uppercase"><?= $data['promo']->promotion. " ".$data['promo']->code_option; ?></td>
                                    <td class="text-lowercase"><?= $pay->type_frais; ?></td>
                                    <td class="text-uppercase"><?= $pay->montant_verse." ". $pay->devise; ?></td>
                                    <td class="text-uppercase"><?= $pay->date_paiement; ?></td>
                                    <td class="text-uppercase"><?= $pay->date_apurement; ?></td>
                                    <td class="text-uppercase"><?= $pay->bordereau; ?></td>
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
