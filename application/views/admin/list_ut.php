

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Page de gestion des utilisateurs</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-users fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page de gestion des utilisateurs</a></li>
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
                    <h3 class="display-5">Liste des Utilisateurs </h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive-sm">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                            <tr class="bg-secondary">
                                <th class="text-center">#</th>
                                <th>Matricule</th>
                                <th>Nom complet</th>
                                <th>Nom d'utilisateur</th>
                                <th>Privilège</th>
                                <th>Date Création</th>
                                <th width="10%">Réinit. Psw</th>
                                <th width="10%">Suppression</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="bg-secondary">
                                <th class="text-center">#</th>
                                <th>Matricule</th>
                                <th>Nom complet</th>
                                <th>Nom d'utilisateur</th>
                                <th>Privilège</th>
                                <th>Date Création</th>
                                <th width="10%">Réinit. Psw</th>
                                <th width="10%">Suppression</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php $count = 1; foreach ($data['utilisateurs'] as $ut): if ($ut->role_ut != 'admin') : ?>
                                <tr>
                                    <td class="text-center"><?= $count++; ?></td>
                                    <td class="text-uppercase"><?= $ut->mat_et; ?></td>
                                    <td class="text-uppercase"><?= $ut->nom_comp; ?></td>
                                    <td class="text-lowercase"><?= $ut->nom_ut; ?></td>
                                    <td class="text-uppercase"><?= $ut->role_ut; ?></td>
                                    <td><?= utf8_encode(strftime("%d-%m-%Y", strtotime($ut->date_creat))); ?></td>
                                    <td><a onclick="return confirm('Voulez-vous vraiment réinitialiser ?')" class="btn btn-sm btn-block btn-outline-warning" href="<?= base_url( $this->session->role_ut .'/reinit_psw?id=' . $ut->id); ?>">Réinit. Psw</a></td>
                                    <td><a onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')" class="btn btn-sm btn-block btn-outline-danger" href="<?= base_url( $this->session->role_ut .'/suppr_ut?id=' . $ut->id); ?>">Supprimer</a></td>
                                </tr>
                            <?php endif; endforeach; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>

</main>
