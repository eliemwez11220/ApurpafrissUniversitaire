<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?="ci_apurpafriss|". $this->session->role_ut ?></title>

    <link rel="icon" href="<?= base_url(); ?>assets/img/iss_logo.png">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/main.css">
    <?= link_tag("assets/css/animate.css"); ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/font-awesome/css/font-awesome.css">

</head>

<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">

    <div class="logo" style="background-image: url(<?=base_url();?>assets/img/iss_logo1.png); background-repeat: no-repeat!important; font-family: 'Maiandra GD'!important;">
        <div class="row">
            <div class="col-sm-12 text-center">
                <span class="text-center display-4 font-weight-bold">Gestion des opérations comptables et financières sur l'apurement de paiement des frais académiques ISS/Lubumbashi</span>
            </div>
        </div>
    </div>
    <?php include_once ("application/views/auth/alert2.php"); ?>
    <div class="login-box">

        <form class="login-form" action="<?= base_url('auth/connexion');?>" method="post">

            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>AUTHENTIFICATION</h3>

            <div class="form-group">
                <label class="control-label">Nom d'utilisateur :</label>
                <input name="nom_ut" class="form-control" value="<?= set_value('nom_ut');?>" type="email" placeholder="Nom d'utilisateur" minlength="3" maxlength="30" autofocus required>
            </div>

            <div class="form-group">
                <label class="control-label">Mot de passe :</label>
                <input name="mot_pass" class="form-control" type="password" placeholder="Mot de passe" minlength="6" maxlength="12" required>
            </div>

            <div class="form-group mt-3">
                <p class="semibold-text mb-2 text-center"><a href="#" data-toggle="flip" >CREATION COMPTE ETUDIANT <i class="fa fa-angle-right fa-fw"></i></a></p>
            </div>

            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block">S'AUTHENTIFIER <i class="fa fa-sign-in"></i></button>
            </div>
        </form>

        <form class="forget-form" action="<?= base_url('auth/enreg');?>" method="post">
            <h4 class="login-head"><i class="fa fa-lg fa-fw fa-user-plus"></i>CREATION COMPTE ETUDIANT</h4>

            <div class="form-group">
                <label class="control-label">Nom d'Utilisateur :</label>
                <input name="nom_ut" class="form-control" type="text" placeholder="Ex. etudiant@gmail.com" minlength="3" maxlength="30" autofocus required>
            </div>
            <div class="form-group">
                <label class="control-label">Matricule étudiant :</label>
                <input name="mat_et" class="form-control" type="text" placeholder="Numéro matricule de l'étudiant" required>
            </div>

            <div class="form-group">
                <label class="control-label">Mot de passe :</label>
                <input name="mot_pass" class="form-control" type="password" placeholder="Mot de passe" minlength="6" maxlength="12" required>
            </div>

            <div class="form-group">
                <label for="conf_mot_pass" class="control-label">Confirm. Mot de passe :</label>
                <input name="conf_mot_pass" id="conf_mot_pass" class="form-control" type="password" placeholder="Confirm. Mot de passe" minlength="6" maxlength="12" required>
            </div>

            <div class="form-group mt-3">
                <p class="semibold-text mb-0 text-center"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> AUTHENTIFICATION</a></p>
            </div>

            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block">CREER COMPTE ETUDIANT <i class="fa fa-save"></i></button>
            </div>
        </form>
    </div>
</section>


<script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.min.js"></script>

<script src="<?= base_url('assets/js/alert2.js') ; ?>"></script>

<script type="text/javascript" src="<?= base_url();?>assets/js/main.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/plugins/pace.min.js"></script>
<script src="<?= base_url();?>js/plugins/pace.min.js"></script>
<script type="text/javascript">
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
</body>
</html>