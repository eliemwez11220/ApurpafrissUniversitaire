

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
                    <h3 class="display-5"> <strong>Ajout d'un nouvel étudiant</strong></h3>
                </div>

                <form action="<?= base_url('sga/ajout_et'); ?>" method="post">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <input type="text" name="nom" class="form-control form-control-sm <?= form_error('nom') ? 'is-invalid' : 'is-valid'; ?>"
                                           placeholder="Nom étudiant" value="<?= set_value('nom'); ?>" minlength="3" maxlength="45" required>
                                </div>
                                <div class="form-group">

                                    <input type="text" name="postnom" class="form-control form-control-sm <?= form_error('postnom') ? 'is-invalid' : 'is-valid'; ?>"
                                           placeholder="Postnom étudiant" value="<?= set_value('postnom'); ?>" minlength="3" maxlength="45" required>
                                </div>
                                <div class="form-group">

                                    <input type="text" name="prenom" class="form-control form-control-sm <?= form_error('prenom') ? 'is-invalid' : 'is-valid'; ?>"
                                           placeholder="Prenom étudiant" value="<?= set_value('prenom'); ?>" minlength="3" maxlength="45" required>
                                </div>
                                <div class="form-group">
                                    <select name="genre" class="form-control form-control-sm <?= form_error('genre') ? 'is-invalid' : 'is-valid'; ?>" required>

                                        <option disabled selected>Choisir genre</option>
                                        <option value="feminin">Feminin</option>
                                        <option value="masculin">Masculin</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <input type="date" name="date_naiss" class="form-control form-control-sm <?= form_error('date_naiss') ? 'is-invalid' : 'is-valid'; ?> "
                                           value="<?= set_value('date_naiss'); ?>" max="<?=$data['date_naiss_max']?>" min="<?=$data['date_naiss_min']?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="lieu_naiss" class="form-control form-control-sm <?= form_error('lieu_naiss') ? 'is-invalid' : 'is-valid'; ?>" placeholder="Lieu de naissance"
                                           required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="telephone" class="form-control form-control-sm <?= form_error('telephone') ? 'is-invalid' : 'is-valid'; ?>" placeholder="Num téléphone"
                                           minlength="10" maxlength="10" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="adresse" class="form-control form-control-sm <?= form_error('adresse') ? 'is-invalid' : 'is-valid'; ?>" placeholder="Adresse domiciliaire"
                                           required>
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="custom-select form-control <?= form_error('id_promotion') ? 'is-invalid' : 'is-valid'; ?>" name="id_promotion" id="id_promotion">
                                        <option disabled selected>Choisir la promotion</option>
                                        <?php foreach ($data['promotions'] as $promotion) : ?>
                                            <option id="<?= $promotion->id_promotion; ?>" value="<?= $promotion->id_promotion; ?>" <?= set_select('id_promotion', $promotion->id_promotion); ?>>
                                                <?= $promotion->promotion . " | ".  $promotion->departement. " | " . $promotion->code_option ; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group container-fluid" align="center">
                                <input type="submit" value="Ajouter étudiant" class="form-control-sm btn btn-primary btn-sm">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>

</main>
