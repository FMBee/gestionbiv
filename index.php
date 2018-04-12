<?php
// récupération du nom d'utlisateur et du nom de domaine
require_once 'include/connntlm.php';
// récupération des constantes
require_once 'include/constants.php';
// récupération des fonctions et du gestionaire de la base de données
require_once 'include/fct.inc.php';
require_once 'include/fct.ldap.php';
require_once 'include/class.pdodbh.php';

//création de la session
//session_start();
$_SESSION['admin'] = estAdmin();

$pdo = Pdodbh::getPdodbh();

if (!isset($_REQUEST['uc'])){
    $_REQUEST['uc'] = 'tableau';
}
if ($_REQUEST['uc'] !== 'tableau' && $_REQUEST['uc'] !== 'tableauFin' && $_REQUEST['uc'] !== 'recapBiv'){
    if (!$_SESSION['admin']){
        $_REQUEST['uc'] = 'tableau';
    }
}
$uc  = $_REQUEST['uc'];

// mise en page de l'entête
include ('vues/v_header.php');
//echo $_SESSION['user']." ".$_SESSION['domain'];

// si admin acces a toutes les fonctionalités
switch ($uc){
    case 'tableau':{
        include "controleurs/c_tableau.php";
        break;
    }
    case 'tableauFin':{
        include "controleurs/c_tableauFin.php";
        break;
    }
    case 'formulaireBiv':{
        include "controleurs/c_formulaireBiv.php";
        break;
    }
    case 'administration':{
        include "controleurs/c_administration.php";
        break;
    }
    case 'recapBiv':{
        include "controleurs/c_pageRecap.php";
        break;
    }
    default :{
        include "controleurs/c_tableau.php";
        break;
    }
}
// mise en page du pied de page
include ('vues/v_footer.php');

$pdo->_destruct();
