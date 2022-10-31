<?php
/**
 * Created by PhpStorm
 * User: codetwista
 * Date: 10/6/2022
 * Time: 5:29 PM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= esc($title) ?> - PD Patients Data Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <?php if ($uri->getSegment(2) === 'map'): ?>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    
        <link rel="stylesheet" type="text/css" href="<?= base_url('css/map.css') ?>" />
        <script type="module" src="<?= base_url('js/index.js') ?>"></script>
    <?php endif ?>
    
    </head>
    <body>
        <header>
            <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
                <div class="navbar-brand pl-2">
                    <a class="navbar-item" href="<?php if (session()->has('profile')) echo base_url(session()->profile) ?>">
                        <!--<img src="https://bulma.io/images/bulma-logo.png" width="112" height="28" alt="logo">-->
                        <span class="has-text-weight-bold">PD Patients Data Management System</span>
                    </a>
                    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>
                <div id="navbarBasicExample" class="navbar-menu">
                    <div class="navbar-end">
                        <?php if (session()->has('profile')): ?>
                        
                        <div class="navbar-item">
                            Hej <?= ucwords(session()->profile) ?>! You're logged in.
                        </div>
                        
                        <?php if ($uri->getSegment(2) != ''): ?>
                        
                        <div class="navbar-item px-1">
                            <a class="button is-info is-light" href="<?= base_url(session()->profile) ?>">
                                <i class="las la-undo ml-0 mr-2"></i>Dashboard
                            </a>
                        </div>
                        <?php endif ?>
                        
                        <?php if (session()->profile === 'researcher'): ?>
                        
                        <div class="navbar-item px-1">
                            <a class="button is-info" href="<?= base_url('researcher/news') ?>">Latest news</a>
                        </div>
                        
                        <?php endif ?>
                        
                        <div class="navbar-item pl-1 pr-0">
                            <a class="button is-danger" href="<?= base_url('logout') ?>">
                                Log out
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="navbar-item">
                            Hej guest!
                        </div>
                        <?php endif ?>
                        
                        <div class="navbar-item">
                            <?php if (current_url() == base_url('register')): ?>
                            
                            <a class="button is-danger is-light" href="<?= base_url('login') ?>">
                                Log in
                            </a>
                            <?php endif ?>
                            
                            <?php if (current_url() == base_url('login')): ?>
                            
                            <a class="button is-danger is-light" href="<?= base_url('register') ?>">
                                Register
                            </a>
                            <?php endif ?>
                            
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="mt-6">
<?= $this->renderSection('content') ?>
        </main>
        <?php if ($uri->getSegment(1) == 'physician' || $uri->getSegment(1) == 'researcher'): ?>
        
        <script src="<?= base_url('js/script.js') ?>"></script>
        <?php endif ?>
        <?php if (current_url() == base_url('researcher/map')): ?>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=<?= getenv('GOOGLE_MAPS_API_KEY') ?>&callback=initMap&v=weekly" defer>
        </script>
        <?php endif ?>
    
    </body>
</html>