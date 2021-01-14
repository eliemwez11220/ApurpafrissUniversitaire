
<body class="app sidebar-mini rtl">

<header class="app-header"><a class="app-header__logo" href="<?= base_url($this->session->role_ut);?>">apurpafriss</a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

    <ul class="app-nav">
        <li class="app-search">
            <input class="app-search__input" type="search" placeholder="Recherche ...">
            <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>

        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
            <ul class="app-notification dropdown-menu dropdown-menu-right">
                <li class="app-notification__title">Message important </li>
                <div class="app-notification__content">
                    <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                            <div>
                                <p class="app-notification__message">Un message sur l'identification des utilisateurs</p>
                                <p class="app-notification__meta"><?= $this->session->nom_ut;?></p>
                            </div>
                        </a>
                    </li>
                    <div class="app-notification__content">
                        <li>
                            <a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                                <div>
                                    <p class="app-notification__message">Vous serez renseignés sur des nouvelles fonctionnalités</p>
                                    <p class="app-notification__meta"><?= $this->session->nom_ut;?></p>
                                </div>
                            </a>
                        </li>
                    </div>
                </div>
                <li class="app-notification__footer"><a href="#">Voir toutes les notifications</a></li>
            </ul>
        </li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="<?= base_url( $this->session->role_ut );?>"><i class="fa fa-home fa-lg"></i> Accueil</a></li>
                <li><a class="dropdown-item" href="<?= base_url( $this->session->role_ut . '/vue_profil');?>"><i class="fa fa-user fa-lg"></i> Profil Utilisateur</a></li>
                <li><a class="dropdown-item" href="<?= base_url('auth/deconnexion');?>"><i class="fa fa-sign-out fa-lg"></i> Déconnexion</a></li>
            </ul>
        </li>
    </ul>
</header>


<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" width="50" height="50" src="<?= base_url('assets/img/').$data['ut']->photo_ut;?>" alt="<?= $this->session->nom_ut;?>">
        <div>
            <p class="app-sidebar__user-name text-uppercase"><?= $data['ut']->nom_comp;?></p>
            <p class="app-sidebar__user-designation">Vous êtes <?= $this->session->role_ut;?></p>
        </div>
    </div>

    <ul class="app-menu text-capitalize">
        <li><a class="app-menu__item" href="<?= base_url($this->session->role_ut . '/fixations');?>"><i class="app-menu__icon fa fa-money text-primary"></i><span class="app-menu__label">Fixer frais</span></a></li>
        <li><a class="app-menu__item" href="<?= base_url($this->session->role_ut . '/finances');?>"><i class="app-menu__icon fa fa-gears text-primary"></i><span class="app-menu__label">Gérer finances</span></a></li>
        <li><a class="app-menu__item" href="<?= base_url($this->session->role_ut . '/mouvements');?>"><i class="app-menu__icon fa fa-exchange text-primary"></i><span class="app-menu__label">Gérer mouvements</span></a></li>
    </ul>
</aside>
