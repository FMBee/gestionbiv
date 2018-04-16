<?php

// require_once ('include/fct.adm.php');

if(!isset($_REQUEST['action'])){
    $_REQUEST['action'] = 'affichage';
}
$action = $_REQUEST['action'];

$myfile = 'offline/recap_cessions_agences.xlsx';
$datefile = date('d-m-Y à H:i', filemtime($myfile));

switch ($action) {
    
    case 'affichage':
        
        include 'vues/v_recapCession.php';
        break;
        
    case 'download':

        $result = 'La mise à jour a échoué';
        
        if ( $_FILES['XLS']['error'] === 0) {
            
            if ( move_uploaded_file($_FILES['XLS']['tmp_name'], getcwd(). "/".$myfile) ) {
            
                $result = 'La version a été mise à jour';
            }
        }
        
        include 'vues/v_recapCession.php';
        break;
}
