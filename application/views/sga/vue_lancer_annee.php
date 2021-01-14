

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-calendar"></i> Page de lancement de l'année</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-calendar fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page de lancement de l'année</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="container-fluid">
            <?php include_once ("application/views/auth/alert.php"); ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Nom d'utilisateur : <?= $data['ut']->nom_ut;?></h3>
                <div class="tile-body text-justify">
                    L'institut superieur de statistique étant une organisation ordonnée de grande renommée, mérite d'être doté des moyens et outils
                    modernes des nouvelles technologies de l'information et de la communication afin de garantir au mieux la gestion de ses divers
                    processus internes.
                </div>
                <div class="tile-body text-justify">
                    Soyez attentifs aux interactions y afferant, car toute manipulation prise en compte, impacte le système entier.
                </div>
                <div class="tile-footer"><a class="btn btn-outline-danger" href="<?= base_url('auth/deconnexion');?>"> <span class="fa fa-sign-out"></span> Déconnexion</a></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title">Lancement de l'année académique</h3>
                </div>
                <div class="tile-body text-justify">
                    <form action="<?= base_url('sga/lancer_annee'); ?>" method="post">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="annee" value="<?=$data['annee_academ']?>"
                                               class="form-control form-control-sm is-valid text-center font-weight-bold text-info" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group container-fluid" align="center">
                                    <input type="submit" value="Lancer année académique" class="form-control-sm btn btn-primary btn-sm">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>