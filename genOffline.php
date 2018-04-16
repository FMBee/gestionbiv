<?php

// $cronFct = TRUE;    //CODE

if (!isset($cronFct)) { // si fonction dailyExec
    header('Location: index.php?uc=administration');
}
// récupération des constantes
require_once 'include/constants.php';
// récupération des fonctions et du gestionaire de la base de données
require_once 'include/fct.inc.php';
require_once 'include/fct.tab.php';
require_once 'include/class.pdodbh.php';

$pdo = Pdodbh::getPdodbh();

// liste des périodes
$datesActuelles = getDates();
$datesN1_1['dateDebut'] = date('Y', strtotime('-1 year')) . '-01-01';
$datesN1_1['dateFin'] = date('Y', strtotime('-1 year')) . '-06-31';
$datesN1_2['dateDebut'] = date('Y', strtotime('-1 year')) . '-07-01';
$datesN1_2['dateFin'] = date('Y', strtotime('-1 year')) . '-12-31';
$datesN_1['dateDebut'] = date('Y') . '-01-01';
$datesN_1['dateFin'] = date('Y') . '-06-31';
$datesN_2['dateDebut'] = date('Y') . '-07-01';
$datesN_2['dateFin'] = date('Y') . '-12-31';
$lesPeriodes = array($datesActuelles, $datesN_1, $datesN_2, $datesN1_1, $datesN1_2);
$labelPeriodes = array("actuelles", date('Y') . "-1", date('Y') . "-2", date('Y', strtotime('-1 year')) . "-1", date('Y', strtotime('-1 year')) . "-2");

// récupérations tables communes
$lesMarches = $pdo->getLesMarches();
$lesMarques = $pdo->getLesMarques();
$expire = $pdo->getConfExpire();
$couleursSell = $pdo->getCouleursSell();


// ====== Fichiers BIV ====== //
$j = 0;
foreach ($lesPeriodes as $unePeriode) {

    $listeMois = getListeMois(substr($unePeriode["dateDebut"], 5, -3), 6);

    $type = "BIV";
    $titre = "actions commerciales";

    // recupérationdes variables
    $lesBIV = $pdo->getLesBIV6Mois($unePeriode["dateDebut"], $unePeriode["dateFin"]);
    $lesMoisBIV = getMoisBIV($lesBIV, $unePeriode["dateDebut"]);

    // génération des liens des pdf de biv
    $liens = NULL;
    $dateMois = DateTime::createFromFormat('Y-m-d', $unePeriode["dateDebut"])->format('Y-m');
    for ($i = 0; $i < 6; $i++) {
        $liens[$i]['mois'] = substr($dateMois, 5);
        $liens[$i]['annee'] = substr($dateMois, 0, 4);
        $dateMois = DateTime::createFromFormat('Y-m-d', $dateMois . "-01")->add(new DateInterval("P1M"))->format('Y-m');
    }
    // récupération des marques des biv
    $i = 0;
    $lesMarquesBiv = NULL;
    foreach ($lesBIV as $unBiv) {
        $lesMarquesBiv[$i] = $pdo->getMarquesBiv($unBiv['numeroBiv'], $unBiv['annee']);
        $i++;
        $unFournisseur = $pdo->getUnFournisseurs($unBiv['fournisseur']);


        ob_start();
        include 'vues/v_header_off.html';
        //corps de page
        include 'vues/v_recapBiv.php';
        //pied de page
        include 'vues/v_footer_off.html';

        $string = ob_get_contents();

        $fichier = BASE_PATH."offline/biv_" . $unBiv['numeroBiv'] . "_" . $unBiv['annee'] . ".html";

        file_put_contents($fichier, $string);
        ob_flush();

    }
    ob_start();
    //récupération en-tête
    include 'vues/v_header_off.html';
    //corps de page
    include 'vues/v_tableau_off.php';
    //pied de page
    include 'vues/v_footer_off.html';

    $string = ob_get_contents();

    //génération du fichier
    if ($labelPeriodes[$j] == "actuelles") {
        $fichier = BASE_PATH.'offline/index.html';
    } else {
        $fichier = BASE_PATH."offline/index" . $labelPeriodes[$j] . ".html";
    }
    file_put_contents($fichier, $string);

    ob_flush();

    $j++;
}

//NEW:
// ====== Prix cessions ====== //

$type = 'CES';
$myfile = 'recap_cessions_agences.xlsx';
$datefile = date('d-m-Y à H:i', filemtime('offline/'.$myfile));

ob_start();
//récupération en-tête
include 'vues/v_header_off.html';
//corps de page
include 'vues/v_recapCession_off.php';
//pied de page
include 'vues/v_footer_off.html';

$string = ob_get_contents();

//génération du fichier
$fichier = BASE_PATH."offline/recap_cessions.html";
file_put_contents($fichier, $string);

ob_flush();
//:NEW


// ====== Fichiers FIN ====== //
$j = 0;
foreach ($lesPeriodes as $unePeriode) {
    
    $listeMois = getListeMois(substr($unePeriode["dateDebut"], 5, -3), 6);
    
    $type = "FIN";
    $titre = "opérations de financement";

    // recupérationdes variables
    $lesBIV = $pdo->getLesBIV6Mois($unePeriode["dateDebut"], $unePeriode["dateFin"], 'annee, numeroBiv', $type);
    $lesMoisBIV = getMoisBIV($lesBIV, $unePeriode["dateDebut"], $type);

    // génération des liens des pdf de biv
    $liens = NULL;
    $dateMois = DateTime::createFromFormat('Y-m-d', $unePeriode["dateDebut"])->format('Y-m');
    for ($i = 0; $i < 6; $i++) {
        $liens[$i]['mois'] = substr($dateMois, 5);
        $liens[$i]['annee'] = substr($dateMois, 0, 4);
        $dateMois = DateTime::createFromFormat('Y-m-d', $dateMois . "-01")->add(new DateInterval("P1M"))->format('Y-m');
    }

    // récupération des marques des biv
    $i = 0;
    $lesMarquesBiv = NULL;
    foreach ($lesBIV as $unBiv) {
        $lesMarquesBiv[$i] = $pdo->getMarquesBiv($unBiv['numeroBiv'], $unBiv['annee'], $type);
        $i++;
        $unFournisseur = $pdo->getUnFournisseurs($unBiv['fournisseur']);
    }
    
    ob_start();
    //récupération en-tête
    include 'vues/v_header_off.html';
    //corps de page
    include 'vues/v_tableau_off.php';
    //pied de page
    include 'vues/v_footer_off.html';

    $string = ob_get_contents();

    //génération du fichier
    if ($labelPeriodes[$j] == "actuelles") {
        $fichier = BASE_PATH.'offline/financements.html';
    } else {
        $fichier = BASE_PATH."offline/financements" . $labelPeriodes[$j] . ".html";
    }
    file_put_contents($fichier, $string);

    ob_flush();
    
    $j++;
}

//gestion des dossiers de biv
$src = "documentsPdf/";
$dest = "offline/documentsPdf/";

//on enlève les fichiers existants
shell_exec('rm -r offline/documentsPdf/*');

// année N-1
$chm1 = $src . date("Y", strtotime('-1 year')) . "-*";
shell_exec("cp -r $chm1 $dest");
// annee N
$chm2 = $src . date("Y") . "-*";
shell_exec("cp -r $chm2 $dest");
// annee N+1
$chm3 = $src . date("Y", strtotime('+1 year')) . "-*";
shell_exec("cp -r $chm3 $dest");

// documents BIV  N-1
$chm1 = $src . "BIV-" . date("Y", strtotime('-1 year')) . "*";
shell_exec("cp -r $chm1 $dest");
// documents BIV  N
$chm2 = $src . "BIV-" . date("Y") . "*";
shell_exec("cp -r $chm2 $dest");
// documents BIV  N+1
$chm3 = $src . "BIV-" . date("Y", strtotime('+1 year')) . "*";
shell_exec("cp -r $chm3 $dest");

// documents de financements
$chmf1 = PDF_PATH . "/FIN-" . date("Y", strtotime('-1 year')) . "*";
$chmf2 = PDF_PATH . "/FIN-" . date("Y") . "*";
$chmf3 = PDF_PATH . "/FIN-" . date("Y", strtotime('+1 year')) . "*";
shell_exec("cp -r $chmf1 $dest");
shell_exec("cp -r $chmf2 $dest");
shell_exec("cp -r $chmf3 $dest");

$chmf1 = PDF_PATH . "/" . date("Y", strtotime('-1 year')) . "/*";
$chmf2 = PDF_PATH . "/" . date("Y") . "/*";
$chmf3 = PDF_PATH . "/" . date("Y", strtotime('+1 year')) . "/*";
$dest1 = BASE_PATH . "/" . $dest . date("Y", strtotime('-1 year')) . "/";
$dest2 = BASE_PATH . "/" . $dest . date("Y") . "/";
$dest3 = BASE_PATH . "/" . $dest . date("Y", strtotime('+1 year')) . "/";
mkdir($dest1);
mkdir($dest2);
mkdir($dest3);
shell_exec("cp -r $chmf1 $dest/". date("Y", strtotime('-1 year')));
shell_exec("cp -r $chmf2 $dest/". date("Y"));
shell_exec("cp -r $chmf3 $dest/". date("Y", strtotime('+1 year')));

exit;
