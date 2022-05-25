<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Alcopa Auction, premier opérateur de ventes aux enchères d'automobiles d'occasion
    </title>
    <meta name="description" content="    Alcopa Auction vous propose la vente aux enchères de voitures d'occasion de tous types. Retrouvez nos véhicules en ligne et dans 7 salles de vente en France.
    ">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#0075ca">
    <meta property="og:url" content="https://localhost/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="    Alcopa Auction, premier opérateur de ventes aux enchères d'automobiles d'occasion
    " />
    <meta property="og:description" content="    Alcopa Auction vous propose la vente aux enchères de voitures d'occasion de tous types. Retrouvez nos véhicules en ligne et dans 7 salles de vente en France.
    " />
    <meta property="og:image" content="/build/img/logo-blue.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="build/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="build/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="build/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="build/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="build/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="build/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="build/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="build/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="build/img/favicon/apple-icon-180x180.png">
    <link rel="apple-touch-icon" href="build/img/favicon/apple-icon-precomposed.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="build/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="build/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="build/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="build/img/favicon/favicon-16x16.png">
    <link rel="shortcut icon" type="image/png" href="build/img/logo-icon-64-favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('build/css/alcopa.78ae560e.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
</head>
<body>

<div class="js-header z(2)">
<div class="hamburger d-block d-lg-none no-print z(3)">
  <div class="container">
    <div class="row">
      <div class="col-2 col-sm-3">
        <div class="container">
          <div class="row">
            <button id="hamburger">
              <span class="bar topBar"></span>
              <span class="bar middleBar"></span>
              <span class="bar bottomBar"></span>
            </button>
          </div>
        </div>
      </div>
      <div class="col-10 col-sm-6 text-center">
        <h1 class="h2 logo">
          <a href="{{ route('welcome') }}">
            <img class="no-print" src="{{ asset('build/img/logo.png') }}">
          </a>
        </h1>
      </div>
    </div>
    <div class="row d-block d-md-none" style="border-top: 1pt solid #87BEEF;">
      <div class="col-sm-auto col-auto mx-auto text-center">
        <a class="btn btn-orange btn-sm m(4)" href="vendez-votre-voiture-aux-encheres.htm">
          <img src="build/img/c2b_hummer.png" style="height: 1.1em; margin: 2px">Vendez votre voiture aux enchères
        </a>
      </div>
    </div>
  </div>
</div>
    </div>
    <div class="mmenu-pageWrapper">
      <!--<div id="fb-root"></div>-->
      <header class="header">
        <div class="container header-sub">
  <div class="row">
    <div class="col-md-6">
      <h1 class="h2 logo">
	<a href="{{ route('welcome') }}">
		<img class="no-print" src="{{ asset('build/img/logo.png') }}">
	</a>
</h1>
    </div>
    <div class="col-md-6">
      <div class="row">
                  <div class="col-12 text-right pr-3">
            <button id="openLoginModal" class="btn btn-orange font-weight-bold">
              Mon compte
            </button>
          </div>
              </div>
    </div>
  </div>
</div>
<div class="menu">
  <div class="container">
    <div class="row">
      <nav class="col-md-12">
        <ul class="hmenu">
            <li class="primary_nav  align-baseline rounded bg-orange px-1 pb-0 ">
          <a href="vendez-votre-voiture-aux-encheres.htm">
        Vendez votre voiture aux enchères
              </a>
          </li>
          @foreach($menus as $menu)
          <li class="primary_nav ">
          <span>{{ $menu->title }}</span>
              <ul>
                @foreach($menu->subMenus as $subMenu)
                  <li class="sub_nav">
                      <a  href="{{ route('page.detail',[$subMenu->slug]) }}">
                        {{ $subMenu->title }}
                      </a>
                      <ul>
                        @if(isset($subMenu->subMenus))
                        @foreach($subMenu->subMenus as $subSubMenu)
                        <li>
                            <a href="{{ route('page.detail',[$subSubMenu->slug]) }}">
                                  {{ $subSubMenu->title }}
                            </a>
                        </li>
                        @endforeach
                        @endif
                      </ul>
                  </li>
                @endforeach
              </ul>
          </li>
          @endforeach
          <li class="primary_nav ">
            <a href="/contact">Contact</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
      </header>
      <div class="content fixed-margin-c2b">
        <div class="js-notifications">

        </div>
        <div class="page lh-27">
            @yield('content')
        </div>
      </div>
      <div class="footer">
        <a href="{{ route('welcome') }}" class="scrollup">
  <i class="fa fa-chevron-up"></i>
</a>
<div class="clearfix mt-10">&nbsp;</div>
<footer class="noprint">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="float-xl-right col-xl-9 col-sm-12 p-0">
          <div class="row">
            <div class="col-lg-10 p-0 d-md-block d-none">
              <ul class="footer-links p-0 m-0">
                <li class="link m-0 p-0">
                  <a class="pipe-after m-0 p-0" href="https://www.alcopa-auction.fr/cgv.htm">CGV</a>
                </li>
                <li class="link">
                  <a class="pipe-after" href="https://www.alcopa-auction.fr/politique-confidentialite.htm">Politique de confidentialité</a>
                </li>
                <li class="link">
                  <a class="pipe-after" href="https://www.alcopa-auction.fr/mentions.htm">Mentions légales</a>
                </li>
                <li class="link">
                  <a class="pipe-after" href="https://www.alcopa-auction.fr/cookie.htm">Cookie</a>
                </li>
                <li class="link">
                  <a class="last-link" href="https://www.alcopa-auction.fr/service-client-sav.htm">Service client-SAV</a>
                </li>
                <li>
                  <a target="_blank" class="network-icon" href="https://www.facebook.com/alcopaauction">
                    <i class="fa fa-facebook-official"></i>
                  </a>
                </li>
                <li>
                  <a target="_blank" class="network-icon" href="https://twitter.com/alcopaauction">
                    <i class="fa fa-twitter-square"></i>
                  </a>
                </li>
                <li>
                  <a target="_blank" class="network-icon" href="https://www.instagram.com/alcopa_auction_fr/">
                    <i class="fa fa-instagram"></i>
                  </a>
                </li>
                <li>
                  <a target="_blank" class="network-icon m-0 p-0" href="https://www.youtube.com/user/AlcopaAuction">
                    <i class="fa fa-youtube-square"></i>
                  </a>
                </li>
              </ul>
            </div>

            <div class="col-lg-2 p-0 d-md-block d-none">
              <div class="input-group select-lang">
                <select class="form-control form-control-sm js-lang-switcher" id="js-lang-switcher-desktop">
                  <option selected disabled>Langue</option>
                                      <option value="fr">Français</option>
                                      <option value="en">English</option>
                                      <option value="es">Español</option>
                                      <option value="de">Deutsch</option>
                                      <option value="ro">Româna</option>
                                      <option value="pl">Polski</option>
                                      <option value="ru">Русский</option>
                                      <option value="rs">Srpski</option>
                                      <option value="pt">Português</option>
                                      <option value="lt">Lietuvių</option>
                                      <option value="hu">Magyar</option>
                                      <option value="ua">Українськa</option>
                                      <option value="it">Italiano</option>
                                  </select>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-2 pl-0 d-md-none d-block">
          <div class="mb-2">
            <a class="text-white" href="https://www.alcopa-auction.fr/cgv.htm">
              CGV
            </a>
          </div>
          <div class="mb-2">
            <a class="text-white" href="https://www.alcopa-auction.fr/politique-confidentialite.htm">
              Politique de confidentialité
            </a>
          </div>
          <div class="mb-2">
            <a class="text-white" href="https://www.alcopa-auction.fr/mentions.htm">
              Mentions légales
            </a>
          </div>
          <div class="mb-2">
            <a class="text-white" href="https://www.alcopa-auction.fr/cookie.htm">
              Cookie
            </a>
          </div>
          <div class="mb-2">
            <a class="text-white" href="https://www.alcopa-auction.fr/service-client-sav.htm">
              Service client-SAV
            </a>
          </div>
          <div class="p-0">
            <div class="input-group select-lang float-right mt-2">
              <select class="form-control form-control-sm js-lang-switcher" id="js-lang-switcher-mobile">
                <option selected disabled>Langue</option>
                                  <option value="fr">Français</option>
                                  <option value="en">English</option>
                                  <option value="es">Español</option>
                                  <option value="de">Deutsch</option>
                                  <option value="ro">Româna</option>
                                  <option value="pl">Polski</option>
                                  <option value="ru">Русский</option>
                                  <option value="rs">Srpski</option>
                                  <option value="pt">Português</option>
                                  <option value="lt">Lietuvių</option>
                                  <option value="hu">Magyar</option>
                                  <option value="ua">Українськa</option>
                                  <option value="it">Italiano</option>
                              </select>
            </div>
          </div>
          <div id="network-fa">
            <a target="_blank" class="network-icon text-white" href="https://www.facebook.com/alcopaauction">
              <i class="fa fa-facebook-official"></i>
            </a>

            <a target="_blank" class="network-icon text-white" href="https://twitter.com/alcopaauction">
              <i class="fa fa-twitter-square"></i>
            </a>

            <a target="_blank" class="network-icon text-white" href="https://www.instagram.com/alcopa_auction_fr/">
              <i class="fa fa-instagram"></i>
            </a>

            <a target="_blank" class="network-icon m-0 p-0 text-white" href="https://www.youtube.com/user/AlcopaAuction">
              <i class="fa fa-youtube-square"></i>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-sm-12 m-0 p-0 pt-1 copyrigh">
          © Alcopa Auction 2013-2022
        </div>
      </div>
    </div>
  </div>
</footer>
      </div>
    </div> <!-- mmenu-pageWrapper -->
    
<div class="modal fade" id="modal-leave-site" style="top: 30%;" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Information : vente à l&#039;étranger</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3" id="modal-confirm-leave-site-msg">
          Nous vous informons que cette vente est prévue sur un autre site Alcopa Auction qui possède d&#039;autres conditions générales de ventes. Vous serez redirigé sur cette vente après acception de cette prise d&#039;information.
        </p>
        <btn class="btn btn-sm btn-primary js-confirm-leave-site">
          Valider
        </btn>
        <btn class="btn btn-sm btn-primary js-cancel-leave-site" data-dismiss="modal">
          Annuler
        </btn>
      </div>
    </div>
  </div>
</div>          
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header p-1 border-bottom-0">
        <button type="button" class="close pr-4" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <h5 class="text-center text-secondary">Déjà inscrit ?</h5>
        <h1 class="text-center text-secondary">
          <i class="fa fa-user-o"></i> Connectez-vous
        </h1>
        <form method="post" action="{{ route('attempt.login') }}" id="form_login">
          @csrf
          <div class="text-secondary">
            <div class="mb-2">
              Adresse e-mail
              <input type="email" id="email" name="email" required="required" class="form-control border" placeholder="Email" />
            </div>
            <div class="mb-2">
              Mot de passe
              <input type="password" id="password" name="password" required="required" class="form-control border" placeholder="Mot de passe" />
            </div>
            <div class="mb-2">
              <input type="checkbox" id="remember_me" name="remember_me" checked="checked" value="1" />
              Se souvenir de moi
            </div>
            <div class="mb-2">
              <button type="submit" class="btn btn-orange text-white w-100" id="button_connect">
                Se connecter
              </button>
            </div>
            <div class="clearfix"></div>
            <div class="js-login-message">
            </div>
            </div>
</form>

            <div class="text-center font-italic mb-4" >
              <u>
                <a class="text-secondary" href="https://www.alcopa-auction.fr/mot-de-passe-oublie.htm">
                  Première connexion ? / Mot de passe oublié ?
                </a>
              </u>
            </div>
            <div class="fond_gris">
              <div class="text-center">
                <h2 class="text-center text-secondary mt-4">
                  Nouveau client ?
                </h2>
                <h5 class="text-center text-secondary mb-4">
                  Inscrivez vous !
                </h5>
                          <a id="tag-creation-compte-part" class="d-flex align-items-center btn-orange no-decoration rounded-60 text-white d-block offset-md-3 col-md-6 offset-2 col-8" href="{{ route('register') }}">
                      <i class="fa fa-user-circle-o fa-2x mr-1"></i><span>Créez un compte particulier ou société</span>
                    </a>
                        <a id="tag-creation-compte-pro" class="d-flex align-items-center btn-primary no-decoration rounded-60 text-white d-block mb-4 mt-4 offset-md-3 col-md-6 offset-2 col-8" href="{{ route('register.business') }}">
                    <i class="fa fa-user-circle-o fa-2x mr-1"></i><span>Créez un compte professionnel de l&#039;automobile</span>
                  </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script>

  $(function(){
    
    $('#openLoginModal').on('click',function(){
      console.log('clicked');
      $('#modalLoginForm').modal('show');
    });

  });

</script>

@yield('scripts')
</html>