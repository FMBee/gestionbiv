<!doctype html>
<html lang="fr">

    <!-- Piwik -->
    <script type="text/javascript">
      var _paq = _paq || [];
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="//10.106.76.115/piwik/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
    <noscript><p><img src="//10.106.76.115/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
    <!-- End Piwik Code -->

    <head>
        <meta charset="utf-8">
        <title>Gestion BIV</title>

        <link rel="stylesheet" type="text/css" href="ressources/bootstrap/css/bootstrap.css" media="screen">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="ressources/lightbox2/css/lightbox.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 well well-sm">
                    <header>
                        <h1>Gestion BIV</h1>
                        <ul class="nav nav-tabs">
                            <?php
                            
                            if($uc == 'tableau'){echo '<li class="active">';}else{echo '<li>';}
                            echo '<a href="index.php">Tableau BIV</a></li>';
                            
                            if($uc == 'tableauFin'){echo '<li class="active">';}else{echo '<li>';}
                            echo '<a href="index.php?uc=tableauFin&action=affichage">Tableau OP Financements</a></li>';
                            
                            if($uc == 'recapCession'){echo '<li class="active">';}else{echo '<li>';}    //NEW
                            echo '<a href="index.php?uc=recapCession&action=affichage">Prix Cessions</a></li>';
                            
                            if ($_SESSION['admin']){
                                if($uc == 'formulaireBiv'){echo '<li class="active">';}else{echo '<li>';}
                                echo '<a href="index.php?uc=formulaireBiv">Nouveau</a></li>';
                                if($uc == 'administration'){echo '<li class="active">';}else{echo '<li>';}
                                echo '<a href="index.php?uc=administration">Page administration</a></li>';
                            }
                            ?>
                        </ul>
                    </header>
