

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-user-plus"></i> Page d'ajout d'un utilisateur</h1>
            <p>Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-user-plus fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Page d'ajout d'un utilisateur</a></li>
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

        <div class="col-sm-6">
            <div class="card border-primary">

                <div class="card-header">
                    <h3 class="display-5"> <strong>Ajout d'un utilisateur</strong></h3>
                </div>

                <form action="<?= base_url('admin/ajout_ut'); ?>" method="post">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <input type="text" name="nom_comp" class="form-control form-control-sm <?= form_error('nom_comp') ? 'is-invalid' : 'is-valid'; ?>"
                                           placeholder="Nom complet" value="<?= set_value('nom_comp'); ?>" minlength="3" maxlength="45" required>
                                </div>
                                <div class="form-group">

                                    <input type="text" name="nom_ut" class="form-control form-control-sm <?= form_error('nom_ut') ? 'is-invalid' : 'is-valid'; ?>"
                                           placeholder="Nom Utilisateur Ex. nom_ut@iss.cd" value="<?= set_value('nom_ut'); ?>" minlength="3" maxlength="45" required>
                                </div>
                                <div class="form-group">
                                    <select name="role_ut" class="form-control form-control-sm <?= form_error('role_ut') ? 'is-invalid' : 'is-valid'; ?>" required>

                                        <option disabled selected>Attribuer Privilège</option>
                                        <option value="financier">Financier</option>
                                        <option value="comptable">Comptable</option>
                                        <option value="sga">SGA</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <input type="text" name="date_creat" class="form-control form-control-sm is-valid" value="<?= date("d/m/Y",strtotime(date('Y-m-d'))) ?>"
                                           minlength="6" maxlength="12" readonly>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="mot_pass" class="form-control form-control-sm <?= form_error('mot_pass') ? 'is-invalid' : 'is-valid'; ?>" placeholder="Mot de passe"
                                           minlength="6" maxlength="12" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="conf_mot_pass" class="form-control form-control-sm <?= form_error('conf_mot_pass') ? 'is-invalid' : 'is-valid'; ?>" placeholder="Rétaper Mot de passe"
                                           minlength="6" maxlength="12" required>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group container-fluid" align="center">
                                <input type="submit" value="Ajouter l'utilisateur" class="form-control-sm btn btn-primary btn-sm">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>

</main>
