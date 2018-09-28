<!DOCTYPE html>
<?php $smarty = wp_smarty(); ?>

<html class="no-js" lang="en">
    <head>

        <!-- ### Meta Data ### -->
        <meta charset="utf-8">
        <title>Tempest Grove Live Action Roleplay</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- ### Favicons ### -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
        <meta name="msapplication-TileColor" content="#000000">
        <meta name="theme-color" content="#000000">

        <!-- Fonts: 1. Early Connections (Preconnect) -->
        <link rel="preconnect" href="//fonts.googleapis.com" crossorigin>

        <!-- Fonts: 2. Asset Requests (Preload) -->
        <link rel="preload" as="style" onload="this.rel='stylesheet'" href="//fonts.googleapis.com/css?family=Catamaran:500,700">

        <!-- Vendor CSS: Normalize -->
        <link rel="preload" as="style" onload="this.rel='stylesheet'" href="<?php echo ASSETS_DIR . 'vendor/normalize.css'; ?>">

        <!-- ### Primary CSS ### -->
        <link rel="preload" as="style" onload="this.rel='stylesheet'" href="<?php echo ASSETS_DIR . 'css/style.css'; ?>">
        <link rel="preload" as="style" onload="this.rel='stylesheet'" href="<?php echo ASSETS_DIR . 'css/character-builder.css'; ?>">

        <link rel="preload" as="style" onload="this.rel='stylesheet'" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">



        <?php if(is_home() || is_front_page()){ ?>
            <noscript>
                <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Catamaran:500,700">
                <link rel="stylesheet" href="<?php echo ASSETS_DIR . 'vendor/normalize.css'; ?>">
                <link rel="stylesheet" href="<?php echo ASSETS_DIR . 'css/style.css'; ?>">
            </noscript>
        <?php }else{ ?>
            <!-- Vendor CSS: Slick -->
            <link rel="preload" as="style" onload="this.rel='stylesheet'" href="<?php echo ASSETS_DIR . 'vendor/slick.css'; ?>">

            <noscript>
                <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Catamaran:500,700">
                <link rel="stylesheet" href="<?php echo ASSETS_DIR . 'vendor/normalize.css'; ?>">
                <link rel="stylesheet" href="<?php echo ASSETS_DIR . 'vendor/slick.css'; ?>">
                <link rel="stylesheet" href="<?php echo ASSETS_DIR . 'css/style.css'; ?>">
            </noscript>
        <?php } ?>



        <?php
            $smarty->assign('og_tags', generate_og_tags());
            $smarty->display('includes/open-graph.tpl');
            $smarty->assign('alerts', get_alerts());


            wp_head();
        ?>

    </head>

    <body <?php body_class('has-sidebar-nav'); ?>>
        <?php
            $smarty->display('includes/header.tpl');
