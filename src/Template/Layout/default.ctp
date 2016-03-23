<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= 'kuLišáci - ' . $this->fetch('title') ?>
    </title>

    <!-- Bootstrap v4 alpha init (http://v4-alpha.getbootstrap.com/) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css"
          integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Bootstrap slider plugin init (https://github.com/seiyria/bootstrap-slider) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.1.3/css/bootstrap-slider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.1.3/bootstrap-slider.min.js"></script>

    <!-- Font Awesome icons init (http://fontawesome.io/get-started/) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('addt.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div class="jumbotron hidden-sm-down">
    <?php echo $this->Html->link($this->Html->image('logo2.png', ['alt' => 'Logo']), [
        'controller' => 'Info',
    ], array('escape' => false)) ?>
    <hr class="m-y-0">
</div>
<nav class="navbar navbar-default navbar-full">
    <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2"
            style="background: #3a84bd; margin-bottom: 0">
        <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-toggleable-sm" id="exCollapsingNavbar2">
        <div class="container nav-center">
            <ul class="nav navbar-nav" style="box-sizing: border-box;">
                <li class="nav-item">
                    <?php echo $this->Html->link(__('INFO'), [
                        'controller' => 'Info',
                    ], array('class' => 'nav-link')) ?></li>
                <li class="nav-item">
                    <?php echo $this->Html->link(__('INTERAKTIVNÍ MAPA'), [
                        'controller' => 'Map',
                    ], array('class' => 'nav-link')) ?></li>
                <li class="nav-item">
                    <?php echo $this->Html->link(__('NOVÝ PŘÍSPĚVEK'), [
                        'controller' => 'Article',
                        'action' => 'newArticle'
                    ], array('class' => 'nav-link')) ?></li>
            </ul>
            <ul class="nav navbar-nav pull-md-right">
                <li class="nav-item nav-login"><?php echo $this->Html->link(__('<i class="fa fa-user"> </i> PŘIHLÁŠENÍ'), [
                        'controller' => 'User',
                    ], array('class' => 'nav-link nav-login', 'escape' => false)) ?></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container div-content">
    <?= $this->fetch('content') ?>
</div>
<footer>
</footer>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"
        integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7"
        crossorigin="anonymous"></script>

</body>
</html>
